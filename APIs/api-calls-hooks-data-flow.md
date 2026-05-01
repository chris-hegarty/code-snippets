# APIs, WordPress hooks, and avoiding expensive code

Experienced engineers develop a mental model of the WordPress request lifecycle, and from that model they know which 
hooks are "always on." Here's how to build that mental model.

## The WordPress life cycle (simplified):

Every WordPress request, from the moment PHP starts executing to the moment the response is sent, goes through this sequence:

index.php
└── wp-blog-header.php
├── wp-load.php         (loads wp-config.php, wp-settings.php)
│     └── FIRES: muplugins_loaded, plugins_loaded, setup_theme,
│                after_setup_theme, init, wp_loaded
├── wp()                (parses the URL, sets up the query)
│     └── FIRES: parse_request, send_headers, parse_query, pre_get_posts
└── template-loader.php (determines which template to use)
└── FIRES: template_redirect, get_header, wp_head,
the content hooks, get_footer, wp_footer, shutdown

This sequence runs for every request — home page, single post, archive, admin page, AJAX, REST API, cron. The only things that change are which template gets loaded at the end and which conditional tags (is_home(), is_single(), etc.) evaluate to true.

## Hooks to know by heart

### Tier One: ALWAYS fire, no exceptions

These run on every request, including REST API calls, AJAX (admin-ajax.php), cron (wp-cron.php), and front-end pages:

| Hook               | 	 When                              | 	            Common uses                                                                       |
|:-------------------|:------------------------------------|:-----------------------------------------------------------------------------------------------|
| muplugins_loaded   | 	After must-use plugins load	       | Rarely used directly                                                                           |
| plugins_loaded	    | After all plugins load              | 	Plugin initialization, late dependency loading                                                |
| init               | 	After WP is set up, before headers | The most commonly used hook. Registering post types, taxonomies, shortcodes, starting sessions |
| wp_loaded          | 	After everything is initialized    | 	Less common; used when you need everything loaded                                             |

`init` is the one that gets abused most often. 

If you see expensive code in init with no conditional check, it runs on every AJAX request, every REST API call, every cron job, every page load. 

In the k-network codebase, `set_subscriptions()` is hooked to `init` with priority `2` — meaning it runs extremely 
early on every 
single request.

### Tier 2: Fire on every front-end page load (not REST, not AJAX, not cron)

| Hook            | When                              | Common uses                                                      |
|-----------------|------------------------------------|------------------------------------------------------------------|
| template_redirect| Just before the template file is chosen | You see an HTTP request or redirect here with no session cache |
| wp_head         | Inside <head> tag                  | You see database queries or API calls here                       |
| wp_footer       | Before </body>                     | Same as above                                                    |
| get_header      | When get_header() is called         | Rarely a problem                                                 |
| the_post        | On each post in a loop              | Very common to put expensive work here accidentally               |
| shutdown        | After response is sent              | Safe for logging; anything blocking is wasted                    |

template_redirect is where confirm_can_access() is hooked in this codebase. 

It's the standard place to put redirect logic, which is why it was chosen — but it fires on every front-end request, so putting a blocking HTTP call here is costly.

### Tier 3: Conditional, but often mistaken for always-on

These only fire under specific conditions, but developers sometimes forget the conditions:

| Hook              | Condition                  | Common mistake                                               |
|-------------------|---------------------------|--------------------------------------------------------------|
| pre_get_posts     | Only during WP_Query       | Called multiple times per page if there are multiple queries |
| save_post         | Only when a post is saved  | Usually fine, but can cascade if you trigger another save    |
| wp_login          | Only on successful login   | Fine for one-time work                                       |
| user_register     | Only when a user is created| Fine for setup work                                          |
| wp_ajax_{{action}}| Only for specific AJAX action| But init still runs before it                              |

## How to read an unfamiliar codebase for these issues:

Note: the --include flag doesnt work. Use --type instead, like

```powershell
rg "add_action\s*\(\s*'(init|template_redirect|wp_loaded|wp_head|plugins_loaded)" --type php
```

1. Grep for all registered hooks:
    `rg "add_action|add_filter" --include="*.php" -n`
2. Filter to the dangerous Tier 1 and Tier 2 hooks
    `rg "add_action\s*\(\s*'(init|template_redirect|wp_loaded|wp_head|plugins_loaded)" --include="*.php" -n`

3. Then, for each match, ask three questions:

-Does the hook's callback function make any outbound HTTP call? (Like with `wp-remote-get()`)?
-Does it have a bailout condition when it runs?
-What happens if the bailout fails?

4. Look for wp_remote_get and wp_remote_post separately:
    `rg "add_action\s*\(\s*'(init|template_redirect|wp_loaded|wp_head|plugins_loaded)" --include="*.php" -n`

IMPORTANT: Then for each match, trace upward to find which hook triggered it. 
If the chain leads to `init` or `template_redirect` with no unconditional bail-out, you've found a problem.

### The One-Sentence Summary

The hooks that fire on every request are muplugins_loaded, plugins_loaded, init, and wp_loaded — anything in those is always expensive. The front-end-only hooks that are commonly abused are template_redirect and wp_head. Everything else is conditional. When you see an outbound HTTP call, a database write, or a redirect in any of these hooks, that's the signal to look closer.

--------------------------------------------

## A closer look at "grep"

grep is a command-line tool that searches through files for text matching a pattern. The name stands for "Globally search a Regular Expression and Print." It was invented in the 1970s and is available on every Unix-like system (Mac, Linux). Windows has it too but it's less common natively.

You use it when you want to answer questions like:

"Where in this entire codebase is KIEWIT_KHP_API_URL used?"
"Which files call wp_remote_post?"
"Show me every add_action that hooks into init"
Without grep, you'd have to open every file and read it. With grep, you search the entire codebase in milliseconds.

### What is "rg"?

`rg` is `ripgrep` — a modern, much faster rewrite of grep. It's the tool you saw in the previous examples. For practical purposes it works the same as grep, just faster and with better defaults (it automatically skips node_modules, .git, binary files, etc.). When engineers say "grep for this" they often mean rg in practice.

In this codebase, running:

```php
rg "KIEWIT_KHP_API_URL" --include="*.php"

```

Would instantly show you every PHP file and line number where that constant is referenced. That's how the exploration earlier found all four API call sites so quickly.

### Breaking down a grep command

 `rg "add_action\s*\(\s*'(init|template_redirect|wp_loaded|wp_head|plugins_loaded)" --include="*.php" -n`

 There are three distinct parts: the search pattern, the file filter, and the flags.

 #### Part 1: The search pattern (inside the quotes)

This is a regular expression (regex). Regex is a mini-language for describing text patterns. Think of it as a more powerful version of the wildcards you might use in a filename search (*.php). Here's each piece:

| Piece      |	What it means                        |	Why it's needed               |
| ---------  | ------------------------------------ | ------------------------------ |
| add_action | Literal text — match exactly "add_action" | We're looking for WordPress hook registrations |
| \s*        | Zero or more whitespace characters (spaces, tabs) | Developers sometimes write add_action `(` with a space before the parenthesis |
| \(        | A literal opening parenthesis `(`  | The backslash "escapes" the `(` because in regex, `(` has a special meaning — the backslash says "I mean the actual character" |
| \s*       | Zero or more whitespace again | In case there's a space after the `(` |
| '         | A literal single quote | The hook name is a PHP string, starts with a quote |
| (init|template_redirect|...) | Any one of these strings | The pipe | means "or". This matches if ANY of these hook names appear |

So the whole pattern reads as: "find add_action, then optional spaces, then `(`, then optional spaces, then a quote, then one of these hook names."

In plain English: find every line that registers a callback on one of these dangerous hooks.

#### Part 2: `--inlcude="*.php"`

This tells ripgrep to only search files ending in `.php` . Without this, it would also search `.js`, `.css`, `.json`, `.md`, etc. 
Since we're looking for PHP hook registrations, there's no point searching those.


#### Part 3: -n

This flag means "show line numbers." 
Instead of just showing the matching text, it prefixes each result with the line number in the file, like:
```php
functions.php:360:add_action('template_redirect', 'confirm_can_access');
custom-blog-query.php:422:add_action('pre_get_posts', 'custom_blog_query');
```

That makes it immediately actionable — you know exactly where to go.

## Regular Expressions: The Basics You Actually Need

Regex looks intimidating at first, but 90% of real-world grep usage relies on about 8 concepts. 

Here they are, with examples from this codebase:

1. Literal text: most characters in a regex match themselves exactly:

`rg "KIEWIT_KHP_API_URL"   # finds that exact string`

2. `.` — any single character

`rg "wp_remote_."   # matches wp_remote_g, wp_remote_p, wp_remote_anything`

3. `*` — zero or more of the preceding thing

`rg "timeout.*10"   # matches "timeout" followed by anything, then "10"`

4. `+` — one or more of the preceding thing

`rg "user_[0-9]+"   # matches user_ followed by one or more digits`

5. `\s` — any whitespace (space, tab, newline)

`rg "add_action\s*\("   # add_action, optional spaces, then (`

6. `|` — or (usually needs escaping as `\|` or grouping with `()`) 

`rg "wp_remote_get|wp_remote_post"   # either one`

7. `()` — grouping

`rg "wp_remote_(get|post)"   # same as above, cleaner`

8. `\` — escape the next character (treat it as literal)

`rg "update_field\("   # the \( means literal (, not "start a group"`

## Practical greps to keep handy for WordPress

These are the searches experienced WordPress engineers run reflexively when first looking at a new codebase:

`

# Find all outbound HTTP calls
rg "wp_remote_(get|post|request)" --include="*.php" -n
# Find all hook registrations on dangerous hooks
rg "add_action\s*\(\s*'(init|template_redirect|wp_loaded|wp_head)" --include="*.php" -n
# Find all external URLs/constants
rg "KIEWIT_KHP|azurewebsites|http[s]?://" --include="*.php" -n
# Find all places that write to the database (user meta or ACF)
rg "update_(user_meta|field|option)" --include="*.php" -n
# Find all places that redirect
rg "wp_(safe_)?redirect" --include="*.php" -n
# Find all session reads/writes
rg "\\\$_SESSION" --include="*.php" -n
# Find all places that exit/die (hard stops)
rg "\b(exit|die)\b" --include="*.php" -n

`

Each of these is answering a specific architectural question: "what leaves the server?", "what runs on every request?", "what writes to the database?", "what are the failure exits?"

