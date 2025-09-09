# How to Change the Site URL in Local by Flywheel using WP-CLI

If you need to change the Site URL for a WordPress project running in [Local by Flywheel](https://localwp.com/), you can do so safely using WP-CLI. This guide will walk you through updating the URL from `kiewit-v2-dev.local` to `kiewitv2.local`.

---

## Prerequisites

- Local by Flywheel installed and running
- The site is already set up in Local
- WP-CLI available (installed by default on Local sites)
- The new URL (`kiewitv2.local`) is configured in Local
- **If your site's `wp-content` folder is under version control (e.g., Git), ensure you have committed or stashed any changes before starting this process.**

---

## Step-by-Step Guide

### 1. Change the Site Domain in Local

1. **Open Local by Flywheel.**
2. **Select your site** (`kiewit-v2-dev.local`) in the sidebar.
3. Click the **"Site Domain"** (or "Change" next to the site domain).
4. Enter the new domain name: `kiewitv2.local`.
5. Click **"Change Domain"**.
    - Local will prompt you to update your hosts file and restart the site. Confirm and wait for the process to complete.

---

### 2. Run WP-CLI Search & Replace

Even after changing the domain in Local, WordPress may still reference the old URL in the database. To update these references:

1. **Open the site’s SSH terminal:**
    - In Local, click the site name, then click the **"Open Site Shell"** button (SSH icon or "Terminal" button).

2. **Run the following WP-CLI command:**

    ```bash
    wp search-replace 'kiewit-v2-dev.local' 'kiewitv2.local' --skip-columns=guid
    ```

    - This command will replace all instances of the old URL with the new one in the database, except for the `guid` column, which should not be changed for existing content.

---

### 3. Considerations for Version-Controlled `wp-content`

If your site's `wp-content` is under version control (such as Git):

- **The search-replace command only affects the database and not files in `wp-content`.**  
  However, if you have hardcoded URLs inside files (themes, plugins, or uploads), you may need to update these files and commit the changes.

- **To check for hardcoded URLs:**

    ```bash
    cd app/public/wp-content
    grep -r 'kiewit-v2-dev.local' .
    ```

    - If any files reference the old domain, update them to use `kiewitv2.local` and commit your changes.

---

### 4. Verify the Update

- Open your browser and go to [http://kiewitv2.local](http://kiewitv2.local).
- Log in to the WordPress admin dashboard and check:
    - **Settings > General**: Both "WordPress Address (URL)" and "Site Address (URL)" should show `kiewitv2.local`.
    - Frontend and backend links work as expected.
- Check for broken images, links, or redirects that still use the old URL.

---

## Troubleshooting

- If you see "Error establishing a database connection" or issues loading the site, check your site's configuration files (`wp-config.php`) for any hardcoded URLs.
- Clear your browser cache if you’re redirected to the old site.
- If you use a caching or security plugin, clear its cache or disable it temporarily.
- If you modified files in `wp-content`, don’t forget to commit your changes to version control.

---

## References

- [LocalWP: Change a Site’s Domain](https://localwp.com/help-docs/sites/domains/change-site-domain/)
- [WP-CLI: search-replace](https://developer.wordpress.org/cli/commands/search-replace/)

---

**Note:** Always back up your database and commit your code before performing a search-replace operation.