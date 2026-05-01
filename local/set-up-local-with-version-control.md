# Local + WPE.WordPress setup

Update 3/23/2026: 

Instead of symlinks, here's how to make directory junctions:

`mklink /J "C:\Users\brad.wedeking\Local Sites\kiewitdev\app\public\wp-content\plugins" "C:\Users\brad.wedeking\Documents\Development\WPE.WordPress\kiewitdev.wpengine.com\wp-content\plugins"`

`mklink /J "C:\Users\brad.wedeking\Local Sites\kiewitdev\app\public\wp-content\themes"  "C:\Users\brad.wedeking\Documents\Development\WPE.WordPress\kiewitdev.wpengine.com\wp-content\themes"`
 

------

## Before you start: 

-You will need admin access to your machine!

-These steps assume you have already cloned the repository to your machine, and that you already have Local installed.

----

### First, create a new site in Local. 

(Example: My Job Benefits 2025)

Instructions from Claude AI:

In Windows, we use the `New-Item` cmdlet with the `-ItemType` SymbolicLink parameter to create symbolic links. 

The syntax is a bit different from Unix-based systems, but the concept is the same - we're creating a reference from one location to another.

Here's how to set it up:

First, let's understand the paths we're working with:

•	Your Local by Flywheel sites are typically located in `C:\Users\[YourUsername]\Local Sites`

•	Let's say your repository is cloned to `C:\Users\[YourUsername]\WPE.WordPress`

Now, here's the PowerShell command to create a symbolic link:

--------------------------------------------------------------------------------------

**(IMPORTANT: You need to run PowerShell as Administrator to create symbolic links!)**

--------------------------------------------------------------------------------------

### First, navigate to your Local site's `public` folder.

NOTE: Use single quotes around paths with spaces! You'll need them because of the 'Local Sites' directory.

`cd 'C:\Users\[YourUsername]\Local Sites\[your-site-name]\app\public'`

### Remove the existing wp-content folder

```powershell
Remove-Item -Path wp-content -Recurse -Force
```

### Create the symbolic link

Again...make sure you are in your Local site's 'public folder'!
'C:\Users\[YourUsername]\Local Sites\[your-site-name]\app\public'

```powershell
New-Item -ItemType SymbolicLink -Path "wp-content" -Target "C:\Users\[YourUsername]\Development\wordpress-sites-repo\[site-folder]\wp-content"
```

Let's break this down:

•	`ItemType SymbolicLink` tells Windows we want to create a symbolic link

•	Path `wp-content` is where we want the link to appear (in your Local site).

•	Target is the actual folder in your repository that we're linking to.

For example, if your username is "John" and you're setting up a site called "company-blog", it would look like this:

### Navigate to the site folder:

`cd 'C:\Users\John\Local Sites\company-blog\app\public' `

### Remove existing wp-content
```powershell
Remove-Item -Path wp-content -Recurse -Force
```
### Create symbolic link

```powershell
New-Item -ItemType SymbolicLink -Path "wp-content" -Target 
"C:\Users\Firstname.Lastname\WPE.WordPress\site-folder\wp-content"
```
To verify the symbolic link was created correctly, you can use:
```powershell
Get-Item wp-content | Select-Object 
```
This will show you details about the symbolic link, including where it's pointing to.

Once the link is set up, you'll want to open and work in the repo folder.

---------

#### Some important things to note:
1.	You need to run PowerShell as Administrator to create symbolic links
2.	Use single quotes around paths with spaces
3.	Make sure all paths are exact - Windows is particular about this!

#### If you get a "permission denied" error, here's how to open PowerShell as Administrator:

1.	Press Windows key
2.	Type "PowerShell"
3.	Right-click on "Windows PowerShell"
4.	Select "Run as administrator"
5.  Enter your admin name and password
-----


The Core Problem with Plugins in Local WordPress
Why plugins cause fatal errors on setup
WordPress stores active plugin paths in the database (wp_options, key: active_plugins). It stores them as relative paths like:

When WordPress loads, it tries to include every file in that list. If the file path in the database doesn't match the actual folder name on disk, PHP throws a fatal error — before the admin panel can even load, which is what makes them so hard to recover from.

Your repo has two plugins with -master suffixes in their folder names because they were downloaded as GitHub zip archives:

aad-sso-wordpress-master/ → DB may expect aad-sso-wordpress/
ACF-Conditional-Taxonomy-Rules-master/ → DB may expect acf-conditional-taxonomy-rules/
Basic-Auth-master/ → DB may expect basic-auth/
This is the #1 cause of fatal errors on local setup. The folder exists, the file exists, but the path in the database doesn't match.

The Second Problem: Plugins in the Database but Not in the Repo
The backup you imported contains a database that lists every plugin that was active on the live dev site. But not every plugin installed on a WP Engine site is necessarily tracked in this repo. If you junctioned wp-content (including plugins/) to the repo, plugins that existed on the live site but are absent from the repo are now missing from disk but still "active" in the database — another fatal error source.

The goal is: get WordPress to load cleanly first, then activate only what you need.

Step 1 — Pre-empt the fatal error using WP-CLI before loading the site

Local by WP Engine includes WP-CLI. Right-click the site → Open Site Shell, then:

This updates the database to mark everything inactive before PHP tries to load them. You can then open wp-admin cleanly.

Step 3 — Re-activate only what you need for backend/REST work

Leave the others inactive until you actually need them — fewer active plugins = fewer fatal error surface areas.

What This Junction Setup Means
The live dev site on WP Engine had plugins installed in folders without -master suffixes. The database backup stores their active paths accordingly, e.g.:

But your repo — and therefore your Local site's wp-content/plugins/ — has:

PHP can't find the file at the path in the database → fatal error on every page load, including wp-admin.

Additionally, the live site almost certainly had plugins installed on WP Engine that were never committed to this repo. Those are in the database as active but now completely absent from disk.

The Fix — In Order
Step 1: Open the Local site shell (right-click the site in Local → "Open Site Shell")

Step 2: Deactivate everything via WP-CLI before WordPress even tries to load

This rewrites active_plugins in the database to an empty array. WordPress can now load without fatal errors regardless of what's on disk.

Step 3: Rename the -master folders in the repo

Do this in VS Code's terminal or Explorer. These three need renaming:

Current folder name	Rename to
aad-sso-wordpress-master	aad-sso-wordpress
ACF-Conditional-Taxonomy-Rules-master	acf-conditional-taxonomy-rules
Basic-Auth-master	basic-auth
Because the junction makes wp-content/plugins/ === the repo folder, renaming in the repo instantly renames them in Local too — no copy needed.

Note: Renaming files that are tracked by Git will show up as a delete + add (or a rename, if Git detects it). Commit the renames intentionally with a message like refactor: normalize plugin folder names (drop -master suffix).

Step 4: Re-activate only what you need for backend/REST work

Back in the Local site shell:

Leave everything else inactive. You can activate others as your work requires them.

Step 5: Verify

Then open dev-kiewitnetwork.local/wp-admin/ — it should load cleanly.

One More Concern: Plugins on WP Engine Not in the Repo
The WP Engine backup may reference plugins that aren't in the repo at all (installed via the WP admin directly on the server, never committed). wp plugin deactivate --all in Step 2 already handles this — you don't need to find or restore them, just leave them inactive.

If you later find a feature that's broken in Local that works on the live dev site, a missing plugin is likely the cause. You can check what was active on the live site at any time with:

Run it before deactivate --all if you want to capture the original active list first.

Potential Problems

When you click "Download ZIP" on a GitHub repository page, GitHub names the extracted folder {repo-name}-{branch-name} — so downloading the master branch of aad-sso-wordpress gives you a folder called aad-sso-wordpress-master. Someone dragged that extracted folder directly into wp-content/plugins/ and committed it without renaming.

It's purely a manual download workflow problem, not a deliberate choice.

Why This Is the Wrong Way to Manage Plugins
Committing plugin folders directly into a repo (whether named correctly or not) creates several ongoing problems:

You own the update burden — any plugin update means manually re-downloading, re-dropping, re-committing
Diff noise — plugin updates pollute your Git history with hundreds of changed lines you didn't write
Version drift — easy to forget which plugins are intentionally pinned vs. just stale
The -master naming problem — as you've just experienced
Licensing risk — committing commercial plugin code (like ACF Pro) to a repo, especially one connected to Azure DevOps, means that code lives in your org's version history permanently
The Two Legitimate Approaches
Option A — Composer (recommended for teams)
Plugins are declared as dependencies in a composer.json at the wp-content or site root level. Running composer install downloads them to the correct folder with the correct name. WPackagist mirrors the entire WordPress.org plugin directory as Composer packages. Premium plugins (like ACF Pro) can be included via their own Composer endpoint or a private Composer repository.

The repo tracks composer.json and composer.lock only — never the plugin folders themselves. Plugin folders go in .gitignore.

Pros: Reproducible installs, correct naming, clean history, easy updates (composer update), handles dependencies
Cons: Requires Composer discipline across the team; premium plugins need extra setup

Possible path forward:


On the Composer future goal — when the time comes, the path would be: move everything except ACF Pro out of the repo into a composer.json, add wp-content/plugins/ (minus ACF Pro) to .gitignore, and let composer install recreate them with correct names automatically. That's a clean, one-time migration that also gives you composer update for free. Worth flagging as a future ticket.





