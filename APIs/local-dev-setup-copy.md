# Local Development Environment Setup

This guide walks through setting up a local WordPress development environment for the KiewitNetwork project. Follow every step in order — each one depends on the previous.

**Prerequisites:**
- Access to the WP Engine account (dashboard at my.wpengine.com)
- Access to the Azure DevOps repo (`WPE.KiewitNetwork`)
- [Local by WP Engine](https://localwp.com/) installed
- Git installed and configured

---

## Step 1 — Clone the Repo

```bash
git clone <your-azure-devops-repo-url>
cd WPE.KiewitNetwork
```

The repo contains only `wp-content` — no WordPress core files. Core is managed by WP Engine and will come from the backup in the next step.

---

## Step 2 — Download a Backup from WP Engine

The local site needs a full backup (WordPress core + database + uploads) from the WP Engine dev environment.

1. Log in to [my.wpengine.com](https://my.wpengine.com)
2. Switch to the "Kiewit Network" account, and to the  **knndev** environment.
3. Navigate to **Backup points**
4. Click **Create backup point** to get a fresh snapshot (or use the most recent one)
5. Once available, click **Download zip** next to the backup
6. Save the zip somewhere accessible (e.g. your Downloads folder) — it will be several hundred MB

---

## Step 3 — Import the Backup into Local

1. Open **Local by WP Engine**
2. Click the **+** button (bottom left) → choose **"Import an existing site"**
3. Select the zip file you downloaded
4. When prompted for a site name, enter: `dev-kiewitnetwork`
5. Local will set the local URL to `dev-kiewitnetwork.local` — **leave this as-is**, it matches the project config
6. Accept the default PHP/MySQL settings and complete the import

> Local will fully inflate the backup, create a local database, and configure WordPress. This may take a few minutes.

---

## Step 4 — Create the Directory Junction

This is the key step that links the repo's `wp-content` to your Local site, so edits in VS Code are immediately live.

Replace `<YourUsername>` and the repo path with your actual values in the commands below.

**Option A — PowerShell (run as Administrator)**

Right-click the Start menu → **"Windows PowerShell (Admin)"** or **"Terminal (Admin)"**, then run:

```powershell
Remove-Item -Recurse -Force "C:\Users\<YourUsername>\Local Sites\dev-kiewitnetwork\app\public\wp-content"
New-Item -ItemType Junction -Path "C:\Users\<YourUsername>\Local Sites\dev-kiewitnetwork\app\public\wp-content" -Target "C:\path\to\your\WPE.KiewitNetwork\dev-kiewitnetwork.kiewit.com\wp-content"
```

**Option B — Command Prompt (run as Administrator)**

Search for `cmd` in the Start menu → right-click → **"Run as administrator"**, then run:

```
rmdir /S /Q "C:\Users\<YourUsername>\Local Sites\dev-kiewitnetwork\app\public\wp-content"
mklink /J "C:\Users\<YourUsername>\Local Sites\dev-kiewitnetwork\app\public\wp-content" "C:\path\to\your\WPE.KiewitNetwork\dev-kiewitnetwork.kiewit.com\wp-content"
```

> **Note:** `mklink` is a Command Prompt built-in — it does not work in PowerShell. Use Option A if you are in PowerShell/Terminal.

**To verify the junction was created**, run this in PowerShell:

```powershell
Get-Item "C:\Users\<YourUsername>\Local Sites\dev-kiewitnetwork\app\public\wp-content" | Select-Object Name, Attributes, Target
```

You should see `Attributes` containing `ReparsePoint` and a `Target` pointing to your repo folder.

**What this does:** A directory junction makes Windows treat the Local site's `wp-content` folder as if it were the repo folder. Any file you edit in VS Code is instantly reflected in the running local site — no copying or syncing needed. Changes you make are also immediately tracked by Git.

---

## Step 5 — Edit wp-config.php

**Important: `wp-config.php` is not in the repo and should never be committed.** It lives only in the Local site. You need to make two edits to it.

Open: `C:\Users\<YourUsername>\Local Sites\dev-kiewitnetwork\app\public\wp-config.php`

### Fix 1 — Disable Forced SSL Login

The backup's `wp-config.php` contains WP Engine-specific SSL settings that cause an infinite redirect loop on local. Find these two lines:

```php
define( 'WPE_FORCE_SSL_LOGIN', true );
define( 'FORCE_SSL_LOGIN', true );
```

If they are set to `true`, change both `true` values to `false`:

```php
define( 'WPE_FORCE_SSL_LOGIN', false ); // Disabled for local dev (WPE proxy header not present)
define( 'FORCE_SSL_LOGIN', false ); // Disabled for local dev
```

**Why:** WP Engine's servers add an `HTTP_X_WPE_SSL` header that tells PHP a request is HTTPS. Local doesn't add this header, so PHP thinks every request is HTTP. With `FORCE_SSL_LOGIN` on, WordPress endlessly redirects trying to force HTTPS — resulting in a login loop.

### Fix 2 — Suppress On-Screen Debug Output

Find:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
```

Replace with:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
```

**Why:** Without `WP_DEBUG_DISPLAY = false`, PHP notices print directly onto every page. Setting it to false sends all errors to `wp-content/debug.log` instead, where you can review them without them breaking the UI.

---

## Step 6 — Deactivate All Plugins

**IMPORTANT: Do this before opening the site in a browser.** The database backup contains an active plugin list from the live WP Engine environment. Some of those plugins either don't exist in the repo or may have mismatched folder names, which causes fatal PHP errors on page load.

Right-click the site in Local → **"Open Site Shell"**, then run:

```bash
wp plugin list > ~/plugin-list-before.txt
wp plugin deactivate --all
```

The first command saves a record of what was active on the live site. The second safely clears the active plugin list in the database.

> **WP-CLI** is the WordPress command-line tool. Local includes it automatically. It communicates directly with the database, bypassing PHP entirely — so it works even when the site would otherwise fatal.

---

## Step 7 — Log In and Create a Local Admin Account

**Context: Why two accounts?**

As an employee, you might already have a Subscriber account based on your Kiewit email address.

Because the site personalizes content per logged-in user, you will need a clean Subscriber account to test what employees see.

| Account | Use for |
|---|---|
| `localadmin` / `localadmin@localhost` | All development and wp-admin work |
| Your Kiewit employee account (Subscriber) | Testing the authenticated subscriber experience |

**Next steps**

1. Open `https://dev-kiewitnetwork.local/wp-login.php` in your browser
2. You will see a standard WordPress username/password form (the Azure AD SSO plugin is deactivated)
3. Log in using your **Kiewit employee credentials** (email and password) — your account exists in the database from the backup

> If you get a login loop, clear your browser cookies for `dev-kiewitnetwork.local` and try again. This is a browser cookie conflict, not a server issue.

4. Once logged in, go to **Users → Add New** and create a dedicated local admin account:
   - **Username:** `localadmin` (or your preference)
   - **Email:** `localadmin@localhost` (note: this isn't/doesnt have to be a real email address. Just end it with @localhost).
   - **Role:** Administrator
   - Set any password

5. Log out and log back in as `localadmin`
6. Return to **Users** and set your Kiewit employee account back to **Subscriber** role

--

## Step 8 — Re-activate Plugins

Back in the Local site shell, activate only the plugins needed for development:

```bash
wp plugin activate advanced-custom-fields-pro acf-to-rest-api acf-conditional-taxonomy-rules custom-post-type-ui query-monitor basic-auth
```

**Do not activate:**

| Plugin | Reason |
|---|---|
| `aad-sso-wordpress` | Cannot work locally — Azure AD redirect URIs only registered for kiewit.com domains. |
| `redis-cache` | Requires a Redis server. Activate only if you specifically need to test caching. |
| `wp-native-php-sessions` | Pantheon-specific plugin, not relevant on Local. |

Activate any other plugins only as your specific work requires them.

---

## Step 9 — Verify the Environment

Confirm all of the following before starting development work:

- [ ] `https://dev-kiewitnetwork.local` loads without errors or on-screen PHP notices
- [ ] `https://dev-kiewitnetwork.local/wp-admin/` loads and shows the dashboard
- [ ] `https://dev-kiewitnetwork.local/wp-json/wp/v2/posts` returns JSON (REST API is working)
- [ ] Edit any file in the repo (e.g. add a comment to `functions.php`) → reload the site → verify the change is live (confirms the junction is working)
- [ ] Log in as your Kiewit employee (Subscriber) account → you should be redirected to the error page (expected — the external `subscriberapi` is unreachable locally; this is the behavior AC-12 will fix)

---

## Known Issues and Notes

### Azure AD SSO is intentionally deactivated locally

The `aad-sso-wordpress` plugin handles authentication on the live site. It is deliberately deactivated in local environments because:
- It requires Microsoft OAuth redirects, which are only registered for `kiewit.com` domains
- The active development work (AC-12) is replacing its access control logic with WordPress-native authentication

### The `authorize_access()` / subscriber redirect is expected

When logged in as a Subscriber, you will be redirected to the error page. This is the existing `authorize_access()` function calling the external `subscriberapi` — which is unreachable on localhost. This is not a setup problem; it is the problem AC-12 is solving.

### `wp-config.php` is never committed

All changes made to `wp-config.php` in these instructions are local only. Do not commit `wp-config.php` to the repo. It is (and should remain) in `.gitignore`.

### Plugin folder naming convention

Plugins tracked in this repo use lowercase hyphenated folder names matching their WordPress.org or GitHub slug (e.g. `basic-auth`, not `Basic-Auth-master`). If you ever add a plugin by downloading a GitHub zip, rename the extracted folder to remove the `-master` or `-main` suffix before committing. Otherwise, the mismatch will throw fatal errors.

### Git branch naming

Per the project README, branches follow this convention:

```
{instancename}/{type}/{devops-task-id}
```

For example: `dev-kiewitnetwork/feature/12345`

---

## Troubleshooting

**Login loop (redirected back to login page repeatedly)**
- Clear browser cookies for `dev-kiewitnetwork.local` and try again in a fresh browser window or incognito
- Verify `FORCE_SSL_LOGIN` and `WPE_FORCE_SSL_LOGIN` are both `false` in `wp-config.php`

**Fatal error: Class "AADSSO_Settings" not found**
- The `aad-sso-wordpress` plugin is active. Deactivate it: `wp plugin deactivate aad-sso-wordpress`

**Fatal error on page load referencing a plugin file**
- A plugin is active in the database but its folder is missing or misnamed
- Run `wp plugin deactivate --all` then re-activate only from the list in Step 8

**wp-admin redirects to homepage**
- Your account may not have Administrator role. Fix via WP-CLI: `wp user update localadmin --role=administrator`

**Site loads but shows PHP notices all over the page**
- `WP_DEBUG_DISPLAY` is not set to `false` in `wp-config.php` — see Step 5, Fix 2
