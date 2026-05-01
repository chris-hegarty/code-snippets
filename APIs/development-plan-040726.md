
# Plan: Eliminate KIEWIT_KHP_API — Phased Implementation

6 phases you can start today, 1 phase that waits for CoreAPI access. 

The site functions fully after Phase 6 with WP-native subscriptions; Phase 7 layers the nightly feed on top.

## Phase 1 — Term Meta Infrastructure

_Prerequisite for the Settings page rebuild. No API changes._

-Create new file `inc/kiewit-term-meta.php`; require it from `functions.php`
-Register `_kiewit_subscribable` and `_kiewit_locked term` meta fields for the country, baselocation, and district taxonomies using `register_term_meta()`
-Add an admin meta box on the Edit Term screen for both fields (simple checkboxes)
-Add a WP admin dashboard widget with a placeholder "No sync run yet" — it will show live data after Phase 7
-One-time admin task (documented, not coded): manually mark the "All Company" country term with `_kiewit_locked` = true in WP admin after deploying Phase 1

## Phase 2 — Replace Access Control

_Removes 1 API call per page load. Cleanest, lowest-risk change._

In `functions.php`:

1. Rewrite `confirm_can_access()` — remove `$_SESSION['access_granted']` read/check; keep the `is_page(KIEWIT_KHP_ERROR_ID)` bypass; keep `confirm_token_not_expired()` call (that's AAD SSO, nothing to do with KHP API); add a simple `!is_user_logged_in()` → redirect to `/wp-login.php`
2. Gut the body of `authorize_access()` — leave the function defined but empty for now (cleaned up in Phase 6)
3. Do not touch `confirm_token_not_expired()` or `handle_invalid_token()` — they are WP/AAD-native

## Phase 3 — Replace Post Filtering Subscriptions

_Removes 1 API call per page load. Simpler than it looks, `kiewit_tax_query()` already reads ACF._

In `inc/custom-blog-query.php`:

1. Delete the entire `add_action('init', ...)` anonymous hook (L65–95) — `$usertags` is never read outside this block; `kiewit_tax_query()` independently calls `get_all_user_tag_ids()` which already reads ACF
2. Delete `get_user_subscriptions()` function (L31–63) — no longer called by anything
3. Delete `get_user_token()` function from this file — used only by `get_user_subscriptions()`
4. `kiewit_tax_query()` and `get_user_tags()` require zero changes — they already read from ACF
5. The editors/admins bypass (`current_user_can('edit_posts')` → `get_all_terms()`) is already in `get_user_tags()` - preserved.

## Phase 4 — Rebuild Settings Page Data Layer

_The most complex phase. Removes 1 API call per page load (the `set_subscriptions` init hook) and rebuilds the Settings page checkboxes from WP taxonomy terms + term meta. ~2–3 days._

In `inc/custom-user-settings.php`:

### Delete (all API-derived):

- `kie_api_tags()`, 
- `retrieve_kietags()`, 
- `filter_kietags_by_subscribable()`, 
- `kietags_subscribable()`, 
- `kietags_not_subscribable()`
- `set_subscriptions()` + its `add_action` — the init hook that overwrites ACF from API every 5 min.
- `subscribed_from_api()`, 
- `subscribed_countries()`, 
- `subscribed_baselocations()`, 
- `subscribed_districts()`
- `kie_tags_by_tagTypeName()`, 
- `country_kie_tags()`, 
- `district_kie_tags()`, 
- `baselocation_kie_tags()`

### Rewrite — build a single new helper:

#### `kiewit_get_taxonomy_checkboxes($taxonomy, $acf_term_ids)`

- Calls `get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false])`
- Per term: reads `_kiewit_subscribable` term meta; reads `_kiewit_locked` term meta + checks user's `_kiewit_locked_term_ids` user meta; determines `$checked` by comparing term ID against the passed ACF field values
- Returns array in the same format `setup_kietag_inputs()` already expects — so the checkbox rendering and hidden-input pattern is unchanged (AC-16 preserved)

### Keep unchanged: 

- `get_all_user_tag_ids()`, 
- `setup_kietag_inputs()`, 
- `subscribed_*_ids()` ID extractors, 
- `acf_countries()` / `acf_baselocations()` / `acf_districts()`

### Update 

update_acf_countries/baselocations/districts() to accept a `$user_id` parameter (defaults to current user) and term IDs directly — prepares them for the nightly feed in Phase 7

### Update template-parts/pages/content-settings.php: 

replace calls to `country_kie_tags()`, `district_kie_tags()`, `baselocation_kie_tags()` with calls to the new `kiewit_get_taxonomy_checkboxes()` function.

## Phase 5 — Remove Settings Save Outbound Call

_Simple deletion inside `update_term_settings()`_

### In inc/custom-user-settings.php:

1. In `update_term_settings()`: delete the entire try/catch block that POSTs to `/UpdateSubscriberTags/{user_id}`
2. Remove the `unset($_SESSION[...])` lines for API cache keys
3. After the three `update_field()` calls succeed, add `wp_safe_redirect(wp_get_referer()); exit;`
4. Keep: nonce verification, intval() sanitization on $_POST, all three update_field() calls

## Phase 6 — Session & Config Cleanup

_Do this after phases 1–5 are tested and confirmed working._

1. Delete `authorize_access()` function from `functions.php` (now empty)
2. Delete `get_user_token_safe()` from `custom-user-settings.php`
3. Grep the entire theme for remaining $_SESSION['access_granted'], $_SESSION['user_subscriptions'], $_SESSION['kie_api_tags'], $_SESSION['subscriptions_set'] and their _time counterparts — delete all remaining references
4. Grep for `KIEWIT_KHP_API_UR`L` and `KIEWIT_KHP_API_TIMEOUT` — confirm zero results
5. Remove both constants from `wp-config.php` in all environments (dev, staging, production)
6. Add placeholder constants to `wp-config.php`: `KIEWIT_COREAPI_FEED_URL` and `KIEWIT_COREAPI_FEED_SECRET`

## Phase 7 — CoreAPI Nightly Feed

_Blocked until CoreAPI access is restored. ~3–5 days once access is confirmed._

### Before writing a single line of code, get these from the CoreAPI team:

- Azure AD tenant ID, client ID, client secret, and OAuth scope for server-to-server access
- Final endpoint URL (confirm the /coreapi/v1/Employees path)
- Confirm JSON response field names (employeeId vs employee_id, and what field name carries home district/country/base location)
- Confirm what WP user meta field stores the employee ID (so we can match feed records to WP users)

### New file inc/coreapi-feed-import.php:

1. OAuth 2.0 client credentials flow: POST to Azure AD token endpoint using KIEWIT_COREAPI_FEED_SECRET/KIEWIT_COREAPI_FEED_URL constants; cache the resulting token in a WP transient (auto-expires)
2. Register REST endpoint `POST /wp-json/kiewit/v1/coreapi-sync` — permission callback checks `X-Kiewit-Secret` request header against constant; no WordPress user login required (called by Azure).
3. Feed import loop per user record: look up WP user by employee ID meta or email; resolve term slugs to term IDs via get_term_by('slug', ...); call update_field() for three ACF fields; write term IDs to _kiewit_locked_term_ids user meta; skip+log on user not found
4. After loop: save `kiewit_coreapi_last_sync` option with `{timestamp, processed, updated, skipped, errors}`
5. Dashboard widget from Phase 1 now reads and displays this option's live data
6. Register `kiewit_coreapi_nightly_sync` WP-Cron as a fallback (in case the Azure scheduler misses a run)

----------------------------------------

## Relevant Files

- functions.php — confirm_can_access(), authorize_access() (Phases 2, 6)
- inc/custom-blog-query.php — init hook, get_user_subscriptions() (Phase 3)
- inc/custom-user-settings.php — major refactor (Phases 4, 5)
- template-parts/pages/content-settings.php — Settings form template (Phase 4)
- inc/kiewit-term-meta.php — new file (Phase 1)
- inc/coreapi-feed-import.php — new file (Phase 7)
- wp-config.php (all environments, not in repo) — constants removal (Phase 6)

-----------------------------------------

## Verification

- Phase 2: Log out, hit the site → redirects to login. Log in → home page loads. Admin → all content visible (AC-12, AC-14, AC-17)
- Phase 3: Blog/home page still filters posts to user's subscriptions. Admin sees all posts (AC-11, AC-14)
- Phase 4: Settings page renders all three taxonomies with correct checked state; "All Company" shows as disabled; save persists (AC-9, AC-10, AC-15, AC-16)
- Phase 6: Grep confirms zero KIEWIT_KHP_API_URL references. Simulate API outage by removing constants — site loads normally (AC-6, AC-7, AC-8, AC-13)
- Phase 7: Run REST endpoint manually via a tool like Postman; verify ACF fields update for test user; verify locked term IDs populated; verify admin widget shows summary (AC-1–AC-5)

-------------------------------------------

## Decisions

- confirm_token_not_expired() is kept — it's AAD SSO, not KHP API
- `$usertags` global is dead code — `kiewit_tax_query()` already calls `get_all_user_tag_ids()` independently
- Locked terms: Phase 1 handles global locks (term meta); Phase 7 adds per-user locks (user meta from nightly feed)
- update_acf_*() functions are kept and extended (accept user ID param) so Phase 7 can call them.

------------------------------------------

## Order of Work

Phase order flexibility: Phases 2 and 3 are independent of each other and of Phase 1 — either of them could be done first. Phase 4 depends on Phase 1 (term meta must exist before the Settings page can use it).

The key advantage: Phases 1–6 can be built and shipped right now using only Level 1. Level 2 kicks in automatically when Phase 7 (the nightly feed) runs. You don't need to solve both at once.

------------------------------------------

## Further Considerations

1. Testing strategy: Since you're on WP Engine, test each phase on the dev environment before pushing to staging. Query Monitor plugin is already installed — use it to confirm zero outbound HTTP calls after Phase 6.

1. Employee ID in user meta: Before coding Phase 7, confirm which user meta key stores the employee ID for existing users (e.g., employee_id, kiewit_employee_id, or something from the AAD SSO plugin). This is the join key between CoreAPI records and WP users.

--------------------------------------------

## Locked Terms: Two-Level Approach 

The current API marks terms as locked per user — your home district is locked for you, not for everyone. That's a per-user concept.

1. Level 1 — Global term meta (_kiewit_locked on the term): marks terms that are always locked for every user, regardless of who they are. "All Company" is the prime example. Easy to manage in the WP admin.

2. Level 2 — Per-user user meta (_kiewit_locked_term_ids array on the user): stores which term IDs the nightly feed imposed on this specific user — their home district, country, base location. Updated by the nightly feed in Phase 7.

