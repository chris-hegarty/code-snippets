# API Project Notes

## Current API Architecture: What's Actually Happening

Here is the full picture of what the code does today, step by step, and why it's a problem.

### The external C# API

The constant KIEWIT_KHP_API_URL points to https://api-cc-cus-khp-dev.azurewebsites.net. This is a separate web service — a C# application running on Microsoft Azure — that acts as the gatekeeper and source of truth for user subscriptions. 

Your WordPress theme is a client of this API. Every time something subscription-related needs to happen, WordPress has to stop and make an HTTP request over the internet to that C# service.

There are four places in the theme where this happens:

1. Access control — every single page load

```php
function confirm_can_access() {
	// LOCAL DEV: bypass token/API check for logged-in administrators (AC-12 work)
	if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		return;
	}
	confirm_token_not_expired();
	if ( isset($_SESSION['access_granted'])) {
		if($_SESSION['access_granted'] == true ) {
			return;
		}
	...
		authorize_access();
	}
}
add_action('template_redirect', 'confirm_can_access');
```
`confirm_can_access()` is hooked to template_redirect, which fires on every single page request for every non-admin user. 

It calls `authorize_access()`, which makes a live HTTP GET request to '/api/subscriberapi/UserCanAccess' with a 10-second timeout. 

If the Azure API is slow, every visitor waits up to 10 seconds on every page. If it's down, they get redirected to an error page.


2. Fetching the user's tag/subscription list

custom-user-settings.php:

```php
function kie_api_tags() {
    ...
    $url = KIEWIT_KHP_API_URL . '/api/tagapi/GetAllTagsForSubscriber';
    ...
    $response = wp_remote_post($url, $args);
    ...
    return $data;
}
```

This is called to get the full list of tags (country, base location, district) and whether the user is subscribed to each one. It's cached in $_SESSION for 5 minutes, meaning every 5 minutes (or on a fresh session) there's another live API call.

3. Filtering posts on the home page

```php
function update_term_settings() {
    ...
    update_field('field_5db72fd74af97', $baselocation, 'user_' . $user_id); // ACF
    update_field('field_5db72ff34af98', $country,      'user_' . $user_id); // ACF
    update_field('field_5db7300a4af99', $district,     'user_' . $user_id); // ACF
    // Also tell the external API
    $url = KIEWIT_KHP_API_URL . '/api/tagapi/UpdateSubscriberTags/' . $user_id;
    $response = wp_remote_post($url, $args);
    ...
}
```

When a user saves their settings, WordPress writes to its own ACF fields and calls the external API to sync. Two writes, two systems, both need to be in agreement.

## Dual Source of Truth Problem

Here is the heart of the issue, and how data is flowing today:

![Alt text](/images/current-data-flow.png)

WordPress has ACF fields for subscriptions, but it doesn't trust them. On every page load, it goes back to the C# API to verify access and re-fetch subscriptions. The ACF fields only act as a secondary copy populated by the API response.

Why the New Architecture Is Better
The goal is to flip this model. WordPress becomes the single source of truth, and the external API becomes an optional nightly data feed rather than a live runtime dependency:

![Alt text](/images/proposed-data-flow.png)

Concretely:

- No HTTP calls on page load. Access control is handled by WordPress's own authentication (Azure AD SSO already creates a WordPress user). The authorize_access() call is removed entirely.

- No session-cached API responses. Subscription data lives in ACF fields, read directly from the WordPress database — the same database WordPress is already querying for everything else.

- Subscribe/unsubscribe is pure WordPress. When a user changes their settings, only `update_field()` is called. No outbound HTTP request to the C# API.

- CoreAPI feeds only three fields, nightly. A WP-Cron scheduled job runs once a night, fetches each user's home country, home district, and base location from CoreAPI, and writes those to ACF fields — but only those fields, and only if the user hasn't manually overridden them. The C# API is no longer in the request path at all.

- The practical result: if the Azure API goes down tomorrow, the site keeps working. If it's slow, users don't notice. The infrastructure can be decommissioned without breaking the site.

That's the full picture of what exists and why the new approach is better. When you're ready, I can build out the detailed implementation plan for the changes.

--------------------------------------------------

QUESTION: How would a more experienced engineer spot these problems? More specifically, how do you look at a codebase like this, and map out the existing API data flow, and begin to spot red flags? Again, assume you are teaching an intermediate developer with solid knowledge of the code base, and web development in general, but newer to API work like this.

---------------------------------------------------

Here's the mental process an experienced engineer goes through — using this codebase as the worked example.

### Step 1: Find the entry points, not the middle

Beginners tend to start reading code top-to-bottom, file by file. Experienced engineers start by asking: "where does execution begin?"

For a WordPress theme, the first question is: what hooks are registered? Hooks are the entry points. An experienced engineer would run a quick search for add_action and add_filter across the theme, specifically looking for hooks that fire on every request:

template_redirect — fires on every front-end page load
init — fires on every request, including AJAX and REST
wp_head — fires on every front-end page load
When you find those, you've found the code that can't be avoided. In this codebase:

functions.php
```php
add_action('template_redirect', 'confirm_can_access');
```

custom-blog-query.php
```php
add_action('init', function() {
    if (empty(get_user_token())) {
        return;
    }
    ...
    if (!isset($_SESSION['user_subscriptions']) || empty($_SESSION['user_subscriptions']) || $subs_expired) {
        try {
            $_SESSION['user_subscriptions'] = get_user_subscriptions();
```

custom-user-settings.php
```php
add_action('init', 'set_subscriptions', 2);
```

Three hooks. All fire on every request. Before you've even read the functions themselves, you know these three things run on every page load. 

That immediately raises the question: "are these expensive operations?"

### Step 2: Follow the money — trace what those hooks actually do

Once you know which hooks run on every request, you trace their call chains. 

This isn't about reading every line — it's about pattern-matching on a few key words:

- `wp_remote_get` / `wp_remote_post` — outbound HTTP requests
- `$_SESSION` — session reads/writes
- redirect / exit — side effects that terminate execution
- timeout — the smoking gun for blocking I/O
- In `authorize_access()` :

functions.php

```php
	try{
		$url = KIEWIT_KHP_API_URL . "/api/subscriberapi/UserCanAccess";
		...
		'timeout' => KIEWIT_KHP_API_TIMEOUT
		...
		$response = wp_remote_get($url, $getData);
        ...
		if(is_wp_error($response) || ($response['response']['code'] > 200 ...)) {
			$_SESSION["access_granted"] = false;
            wp_redirect(KIEWIT_KHP_BASE_URL . KIEWIT_KHP_ERROR_URL);
			exit;
		}
```
You see wp_remote_get inside a template_redirect hook. That's a synchronous, blocking HTTP call on every page load. The page literally cannot render until this HTTP call returns. The timeout constant makes it concrete — up to 10 seconds of waiting, per request, per user.

The experienced engineer's reaction here is immediate: "this is a synchronous network call in a request-blocking context. This is a single point of failure for the entire site."

### Step 3: Count the calls and look for the pattern

The next question is: how many times does this happen per page load? Search for KIEWIT_KHP_API_URL across the entire codebase:

- functions.php → subscriberapi/UserCanAccess (access check)

- custom-user-settings.php → tagapi/GetAllTagsForSubscriber (fetch tags)

- custom-user-settings.php → tagapi/UpdateSubscriberTags/{user_id} (save tags)

- custom-blog-query.php → tagapi/GetTermIdsForSubscriber (fetch term IDs)

That's 3 different API calls that can be triggered on a single page load (access check + fetch tags + fetch term IDs). 

A normal home page visit for a regular user fires all three. 

The theme authors tried to mitigate this with session caching, which leads to the next red flag.

### Step 4: Read the caching strategy and ask "what happens when this breaks?"

Session-based caching ($_SESSION) with a manual TTL is a classic intermediate-developer pattern that looks reasonable but has several quiet failure modes. 

Here's the pattern repeated three times in this codebase:

custom-user-settings.php

```php
    $tags_ttl_key = 'kie_api_tags_time';
    $tags_cache_ttl = 5 * MINUTE_IN_SECONDS; // Refresh from API every 5 minutes
    $tags_expired = !isset($_SESSION[$tags_ttl_key]) || (time() - $_SESSION[$tags_ttl_key]) > $tags_cache_ttl;

    if (empty($_SESSION['kie_api_tags']) || $tags_expired) {
        try {
            $tags = kie_api_tags();
            $_SESSION['kie_api_tags'] = $tags;
```

The questions an experienced engineer asks here:

- What if the session doesn't exist? New session = immediate API call. A user opening two tabs simultaneously will trigger two parallel API calls for the same data.

- What if the API is slow on that 5-minute refresh? The user experiences a slow page every 5 minutes, not just on first load.

- What if the API returns an error on refresh? Look at the catch block — it redirects to the error page. So every 5 minutes, if the API hiccups, the user gets kicked out.

- What about server-side session storage at scale? PHP sessions are typically stored as files on disk. On a load-balanced or horizontally scaled server, a user's session on server A doesn't exist on server B. Their subscriptions disappear.

- What is the freshness guarantee? If a user's subscription changes (e.g. they're added to a new district by an admin), they won't see it for up to 5 minutes. That's a stale data window baked in by design.

None of these are bugs that show up in testing. They're failure modes that only appear under real-world conditions.

### Step 5: Look for the "two writes" pattern

This is the most important architectural red flag to train your eye for. Search for every place where data is written, and check whether the same data is written to more than one system. 

In `update_term_settings()`:

custom-user-settings.php

```php
    update_field('field_5db72fd74af97', $baselocation, 'user_' . $user_id);
    update_field('field_5db72ff34af98', $country, 'user_' . $user_id);
    update_field('field_5db7300a4af99', $district, 'user_' . $user_id);

    try {
        ...
        $url = KIEWIT_KHP_API_URL . '/api/tagapi/UpdateSubscriberTags/' . $user_id;
        ...
        $response = wp_remote_post($url, $args);
```

WordPress ACF fields are updated. Then the external API is also updated. This is the dual write pattern, and it's a red flag because:

- What if the ACF write succeeds but the API call fails? WordPress now has data the API doesn't. They're out of sync. Which one is correct?

- What if the API write succeeds but the response is lost (network blip between the API server and WordPress)? WordPress catches the exception and redirects anyway — silently discarding the error.

- There is no rollback. A failed API call doesn't undo the ACF write. There's no transaction spanning both systems.

- Who is the authority? Look at `set_subscriptions()` — on the next page load, it calls `update_acf_countries()`, `update_acf_baselocations()`, `update_acf_districts()`, which re-fetch from the API and overwrite the ACF fields. 

So the API is actually the authority, and ACF is just a local copy. But the write goes to both. 

This means: if you change something in ACF directly (e.g. via the WordPress admin), it will be overwritten on the next page load by whatever the API says.

### Step 6: Ask "what happens when the external service is unavailable?"

This is the resilience test. An experienced engineer mentally traces every code path that depends on an external service and asks: "what is the user experience if this returns a 500, times out, or is unreachable?"

For this codebase, the answer is: the user is redirected to an error page. Three different places do `wp_redirect(KIEWIT_KHP_ERROR_URL)`. 

The entire site becomes an error page if the C# API has any problem. 

This is called a hard dependency — there is no fallback, no graceful degradation.

Compare this to what "good" looks like: 

- data is cached locally in a reliable store (like the WordPress database), 
- the external service updates that cache periodically (nightly cron), 
- and if the external service is unavailable, you simply serve the last known data. The site keeps working; subscriptions are just not updated until the service recovers.

## The Mental Checklist

To summarize the process as a repeatable checklist you can apply to any codebase:

- Find the hooks — what runs on every request? Start there, not at the top of the file.
- Search for wp_remote_* — every outbound HTTP call is a potential blocking operation and failure point. Grep for it immediately.
- Check the context — is that HTTP call inside a request-blocking hook (init, template_redirect)? That's a red flag.
- Count the calls — how many outbound HTTP calls can happen per page load? Multiply by your traffic.
- Read the caching — is it session-based, transient-based, or object cache? What's the TTL? What's the cold-start behavior?
- Look for dual writes — if the same data is written to two systems, ask: which is authoritative? What happens on partial failure?
- Trace the failure path — for every external dependency, follow the catch block and the error condition. Does the site stay usable, degrade gracefully, or fail hard?

These aren't advanced skills — they're a learned habit of reading code with a specific set of questions in mind rather than just trying to understand what the code does. 

Once you start asking "what happens when this is slow?" and "what happens when this fails?", you start seeing these patterns everywhere.

------------------------------

## WP-Cron vs. WP REST API Endpoint: An Overview for Your Nightly Sync

These are two fundamentally different approaches to the same problem: running a scheduled background task (your `kiewit_coreapi_nightly_sync`). 

Let's break each one down.

###  Approach 1: WP-Cron

WP-Cron is WordPress's built-in pseudo-cron system. It's "pseudo" because, unlike a real server-level cron job (Unix/Linux crontab), it doesn't run on a true clock-based schedule. Instead, it runs when someone visits your WordPress site.

Here's what happens under the hood:

A visitor hits any page on your WordPress site.
WordPress checks a list of scheduled events stored in the database (wp_options table, under cron).
If any event is due (or overdue), WordPress fires it on that page load, in the background.

#### How do you register one?

You use two hooks and two functions:

```php
// 1. Register the custom schedule (if "daily" isn't granular enough)
// WordPress already has 'daily' built in, so for a nightly sync you can use that.

// 2. Schedule the event on plugin activation (only runs once)
register_activation_hook( __FILE__, 'kiewit_schedule_nightly_sync' );

function kiewit_schedule_nightly_sync() {
    if ( ! wp_next_scheduled( 'kiewit_coreapi_nightly_sync' ) ) {
        wp_schedule_event( time(), 'daily', 'kiewit_coreapi_nightly_sync' );
    }
}

// 3. Clear the event on plugin deactivation (clean up)
register_deactivation_hook( __FILE__, 'kiewit_clear_nightly_sync' );

function kiewit_clear_nightly_sync() {
    $timestamp = wp_next_scheduled( 'kiewit_coreapi_nightly_sync' );
    wp_unschedule_event( $timestamp, 'kiewit_coreapi_nightly_sync' );
}

// 4. Hook your actual sync logic to the event name
add_action( 'kiewit_coreapi_nightly_sync', 'kiewit_run_core_api_sync' );

function kiewit_run_core_api_sync() {
    // Your sync logic goes here
}
```

Pros

- Pure WordPress — no external infrastructure needed; lives entirely inside your plugin
- Simple to set up — a handful of functions and you're done
- Portable — works on any WordPress host, no Azure or cloud config required
- Admin visibility — plugins like WP Crontrol let you inspect, run, and debug events from the WP Admin

Cons

- Not a real scheduler — it only fires when traffic hits the site. If no one visits at 2 AM, your sync doesn't run until the next page load
- Unreliable on low-traffic sites — particularly problematic for internal/intranet WordPress installs
- Timing is not guaranteed — "daily" means "at least 24 hours apart", not "at exactly midnight"
- Blocked on some hosts — some managed WordPress hosts (WP Engine, Kinsta, etc.) disable or restrict WP-Cron
- Can slow down page loads — the sync runs in the same PHP process as a real visitor's page load

Mitigation: You can disable the pseudo-cron `(define('DISABLE_WP_CRON', true)` in wp-config.php, and set up a real server cron job that calls wp-cron.php directly via curl or WP-CLI. 

This gives you the best of both worlds — WP-Cron's event system with real scheduling.

### Approach 2: WP REST API Endpoint

The WordPress REST API is a built-in framework (since WP 4.7) that lets you define HTTP endpoints on your WordPress site that can be called from anywhere over the web. 

You "expose" an endpoint by registering a custom route that maps a URL to a PHP callback function.

"Exposing" simply means: you register a URL path on your WordPress site that, when called with an HTTP request (GET, POST, etc.), executes your sync logic.

For example, you might expose:

`POST https://yoursite.com/wp-json/kiewit/v1/nightly-sync`

An external system — like an Azure Logic App or Azure Function Timer — then calls that URL on a real schedule (e.g., every night at 2:00 AM UTC exactly).

Application Passwords (built into WordPress 5.6+) work like this:

- In WP Admin → Users → Profile, scroll to "Application Passwords"
- Generate a password for your Azure service
- The caller sends it as HTTP Basic Auth: Authorization: Basic base64(username:app_password)
- Shared Secret works by storing a secret string (in wp-config.php as a constant) and comparing it against a custom header the caller sends.

PROS

- Runs on a real schedule — Azure Logic Apps or Function timers fire at exact times regardless of WordPress traffic
- External control — the scheduler lives outside WordPress; you can change timing, retry logic, add alerts, all without touching WordPress code
- Reliable and predictable — no dependency on web traffic; great for low-traffic or intranet sites
- Fits well in Azure-integrated architectures — if your project is already Azure-centric (Logic Apps, Functions, etc.), this is a natural fit
- Testable on demand — you can trigger the sync manually with a curl command or Postman at any time

CONS

- More moving parts — requires infrastructure outside WordPress (Azure Logic App, Function, or even a simple curl cron on a separate server)
- Security surface — you're exposing a public (or semi-public) HTTP endpoint that must be properly authenticated and protected
- Deployment coordination — changing the endpoint URL or secret requires updating both WordPress and the external scheduler
- No built-in WP Admin UI — there's no native dashboard to see "last ran at X, next run at Y" without building it yourself.

Use WP-Cron if your WordPress site has consistent traffic, you want minimal infrastructure, and approximate daily timing is acceptable.

Use a REST API Endpoint if your project is already Azure-integrated, you need reliable exact-time scheduling, or the site has low/unpredictable traffic.

If requirements explicitly mention Azure Logic Apps / Azure Function timers as the external scheduler, the REST API endpoint approach is likely the better long-term fit for your project. 

WP-Cron is still worth registering as a fallback (belt-and-suspenders), but an Azure-driven trigger gives you far more control, reliability, and observability.