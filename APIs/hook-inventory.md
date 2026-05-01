# Hook Inventory for Kiewit Network

4/7/2026

---------------------------------------------------------------------------------------

## TIER ONE: Hooks that always fire.

- init (the most common one.)

### File: functions.php

```php
kiewit_network_register_session()
```

### File: custom-blog-query.php

```php
session_start()
```

```php
/**
 * Store user tags in session for quick access.
 */
add_action('init', function() {
    if (empty(get_user_token())) {
        return;
    }
    $subs_ttl_key = 'user_subscriptions_time';
    $subs_cache_ttl = 5 * MINUTE_IN_SECONDS; // Refresh from API every 5 minutes
    // Treat missing timestamp as expired so pre-existing sessions refresh
    $subs_expired = !isset($_SESSION[$subs_ttl_key]) || (time() - $_SESSION[$subs_ttl_key]) > $subs_cache_ttl;

    if (!isset($_SESSION['user_subscriptions']) || empty($_SESSION['user_subscriptions']) || $subs_expired) {
        try {
            $_SESSION['user_subscriptions'] = get_user_subscriptions();
            $_SESSION[$subs_ttl_key] = time();
        } catch (Exception $e) {
            error_log('Error fetching subscriptions: ' . $e->getMessage());
            wp_safe_redirect(KIEWIT_KHP_BASE_URL . KIEWIT_KHP_ERROR_URL);
            exit;
        }
    }
    global $usertags;
    $usertags = $_SESSION['user_subscriptions'];

    // Grant all terms to editors/admins
    if (current_user_can('edit_posts')) {
        $usertags = get_all_terms();
    }
});
```

### FILE: custom-user-settings.php

```php
/**
 * Set up user subscriptions using only session for caching (no transient).
 */
function set_subscriptions() {
    // Start session if not already started
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $user_id = get_current_user_id_safe();

    if (!$user_id) {
        return;
    }

    $session_key = 'subscriptions_set';
    $ttl_key = 'subscriptions_set_time';
    $cache_ttl = 5 * MINUTE_IN_SECONDS; // Refresh from API every 5 minutes

    // Use session for per-user, per-session caching with TTL
    // Treat missing timestamp as expired so pre-existing sessions refresh
    $cache_expired = !isset($_SESSION[$ttl_key]) || (time() - $_SESSION[$ttl_key]) > $cache_ttl;
    if (empty($_SESSION[$session_key]) || !$_SESSION[$session_key] || $cache_expired) {
        // Clear stale tag caches so they are re-fetched from the API
        unset($_SESSION['kie_api_tags'], $_SESSION['user_subscriptions']);
        try {
            update_acf_countries();
            update_acf_baselocations();
            update_acf_districts();
            $_SESSION[$session_key] = true;
            $_SESSION[$ttl_key] = time();
        } catch (Exception $e) {
            $_SESSION[$session_key] = false;
            error_log('Caught exception while updating subscriptions: ' . $e->getMessage());
        }
    }
}
add_action('init', 'set_subscriptions', 2);

/**
 * Create custom user roles for theme
 */
function kiewit_add_corporate_communication_role() {
    // Get the Editor role to copy its capabilities
    $editor_role = get_role('editor');
    
    if ($editor_role) {
        // Add the custom role with Editor capabilities
        $capabilities = $editor_role->capabilities;
        
        // Add user management capabilities
        $capabilities['edit_users'] = true;
        $capabilities['list_users'] = true;
        $capabilities['promote_users'] = true;
        $capabilities['create_users'] = true;
        $capabilities['delete_users'] = true;
        $capabilities['remove_users'] = true;
        
        // Add the role
        add_role(
            'corporate_communication',
            'Corporate Communication',
            $capabilities
        );
    }
}
add_action('init', 'kiewit_add_corporate_communication_role');
```

-----------------------------------------------------------------------------------------------------

## TIER TWO - Fire on every front-end page load (not REST, not AJAX, not cron)

- template_redirect
- wp_head
- wp_footer
- get_header
- the_post
- shutdown

- template_redirect 

### File: functions.php
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
		else if($_SESSION['access_granted'] == false) {
                        wp_redirect(KIEWIT_KHP_BASE_URL . KIEWIT_KHP_ERROR_URL);
			exit;
		}
		else {
			authorize_access();
		}
    }
    else {
		authorize_access();
    }
}
add_action('template_redirect', 'confirm_can_access');

```

- wp_head

```php
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function kiewitnetwork_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'kiewitnetwork_pingback_header' );

/**
  * Helper function to publish posts with a status of 'future' and
  * the post_date_gmt is less than the current gmdate().
  *
  * @see https://developer.wordpress.org/reference/hooks/wp_head/
  * @return void
  */

function kiewit_publish_missed_posts() {
    
    if (is_front_page() || is_single()) {
        
        $now = gmdate('Y-m-d H:i:00');
        
        $args = array(
            'numberposts' => -1,
            'post_status' => 'future',
            'post_type' => 'post',
        );
        
        $posts = get_posts( $args );

        if ($posts) {
            foreach( $posts as $post ) {
                if ($post->post_date_gmt < $now ) {
                    wp_publish_post($post->ID);
                }
            }
        }
    }

}
add_action('wp_head', 'kiewit_publish_missed_posts');
```

- wp_footer

None.

- get_header

```php
/**
 * Extract the bearer token from the Authorization header.
 *
 * @param  WP_REST_Request $request  The incoming REST request.
 * @return string|null               The raw JWT string, or null if not present.
 */
function kiewit_get_bearer_token_from_request( $request ) {

    // Try the request header first (works in most environments).
    $auth_header = $request->get_header( 'Authorization' );

    // Fall back to the server variable (some hosts strip the header).
    if ( empty( $auth_header ) && ! empty( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
        $auth_header = sanitize_text_field( wp_unslash( $_SERVER['HTTP_AUTHORIZATION'] ) );
    }

    // Apache with mod_rewrite sometimes uses REDIRECT_HTTP_AUTHORIZATION.
    if ( empty( $auth_header ) && ! empty( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) ) {
        $auth_header = sanitize_text_field( wp_unslash( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) );
    }

    if ( empty( $auth_header ) || stripos( $auth_header, 'Bearer ' ) !== 0 ) {
        return null;
    }

    return trim( substr( $auth_header, 7 ) );
}
```

## Files using wp_remote_(get|post|request)()

```powershell
inc\rest-api-auth.php
53:    $response = wp_remote_get( $jwks_uri, array( 'timeout' => 10 ) );

inc\custom-blog-query.php
49:    $response = wp_remote_post($url, $args);

inc\aad-profile-sync.php
26: * The AAD SSO plugin exchanges an authorization code for tokens via wp_remote_post.

inc\custom-user-settings.php
53:    $response = wp_remote_post($url, $args);
568:        $response = wp_remote_post($url, $args);

functions.php
376:            $response = wp_remote_get($url, $getData);
```

## Tier One Hooks using add_action

```powershell
functions.php
20:add_action('init', 'kiewitnetwork_register_session');
360:add_action('template_redirect', 'confirm_can_access');
530://add_action( 'init', 'restrict_admin_access' );

inc\custom-blog-query.php
9:add_action('init', function() {
69:add_action('init', function() {

inc\custom-user-settings.php
254:add_action('init', 'set_subscriptions', 2);
294:add_action('init', 'set_subscriptions', 2);
615:add_action('init', 'kiewit_add_corporate_communication_role');

inc\template-functions.php
37:add_action( 'wp_head', 'kiewitnetwork_pingback_header' );
137:add_action('wp_head', 'kiewit_publish_missed_posts');
```

