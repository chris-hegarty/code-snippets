# KiewitNetwork (WPE.KiewitNetwork)

The KiewitNetwork WordPress theme powers the Kiewit intranet homepage. It is hosted on **WP Engine** and deployed via **Azure DevOps Pipelines** using `git subtree push`.

| Detail | Value |
|--------|-------|
| **Theme** | KiewitNetwork (based on [Underscores](https://underscores.me/)) |
| **Version** | 1.2.2 |
| **License** | MIT |
| **Hosting** | WP Engine (`knndev` / `knnprod`) |
| **CI/CD** | Azure DevOps Pipelines |
| **Repo** | `KiewitCorp@vs-ssh.visualstudio.com:v3/KiewitCorp/KTG/WPE.KiewitNetwork` |

---

## Repository Structure

```
WPE.KiewitNetwork/
├── azure-pipelines.yml          # CI/CD pipeline definition
├── .azure/steps/                 # Reusable pipeline templates
│   ├── validate-theme.yml
│   └── wpe-git-push.yml
├── scripts/
│   └── bump-version.sh           # Semver version bump script
├── CHANGELOG.md
└── kiewitnetwork/                # ← Subtree root (deployed to WP Engine)
    ├── composer.json              # Plugin dependency management
    └── wp-content/
        ├── plugins/               # Composer-installed plugins (gitignored)
        └── themes/kiewitnetwork/  # ← WordPress theme root
            ├── style.css          # Theme header (static, not compiled)
            ├── functions.php
            ├── package.json
            ├── gulpfile.babel.js
            ├── wpgulp.config.js
            ├── acf-json/          # ACF field groups & taxonomies
            ├── assets/css/        # Compiled CSS output
            ├── inc/               # Custom PHP modules
            ├── js/                # Theme JavaScript
            ├── sass/              # SCSS source files
            └── template-parts/    # Template partials
```

Only the `kiewitnetwork/` subtree is deployed to WP Engine.

---

## Getting Started

### Prerequisites

- **Node.js** 18.x
- **npm** (ships with Node)
- **Composer** 2.x ([getcomposer.org](https://getcomposer.org/))
- **PHP** 7.4+ (for local WordPress)
- **Local WordPress** environment (e.g., Local by Flywheel, MAMP) with the site URL set to `kiewitnetwork.local`

### Installation

```bash
git clone KiewitCorp@vs-ssh.visualstudio.com:v3/KiewitCorp/KTG/WPE.KiewitNetwork WPE.KiewitNetwork
cd WPE.KiewitNetwork/kiewitnetwork/wp-content/themes/kiewitnetwork
npm install
```

### Installing Plugins (Composer)

Plugins are managed via Composer from the `kiewitnetwork/` directory:

```bash
cd WPE.KiewitNetwork/kiewitnetwork
composer install --no-dev
```

Plugins are installed to `wp-content/plugins/` and are **gitignored** — the CI/CD pipeline runs `composer install` during each deployment.

**ACF Pro** requires a license key. Create an `auth.json` file before running `composer install`:

```bash
 
```

This file is also gitignored. In the pipeline, the key is sourced from the `ACF_PRO_LICENSE_KEY` variable in the `WPE.KiewitNetwork` variable group.

### Local Development

```bash
npm start          # Starts Gulp + BrowserSync (watches SCSS, JS, PHP)
```

BrowserSync proxies `kiewitnetwork.local` and live-reloads on changes.

---

## Build Commands

All commands run from the **theme directory** (`kiewitnetwork/wp-content/themes/kiewitnetwork`):

| Command | Description |
|---------|-------------|
| `npm start` | Full development workflow with BrowserSync watch |
| `npm run styles` | Compile SCSS → `assets/css/style.min.css` |
| `npm run stylesRTL` | Generate RTL stylesheet |
| `npm run vendorsJS` | Concatenate & minify vendor JS → `js/vendor.min.js` |
| `npm run customJS` | Concatenate & minify custom JS → `js/custom.min.js` |
| `npm run images` | Optimize images in `assets/img/raw/` → `assets/img/` |
| `npm run clearCache` | Clear Gulp image cache |
| `npm run translate` | Generate `.pot` translation file |

### Build Tooling

The theme uses [WPGulp](https://github.com/ahmadawais/WPGulp) with Dart Sass. Configuration lives in `wpgulp.config.js`.

- **SCSS source:** `sass/style.scss` (imports all partials)
- **CSS output:** `assets/css/style.min.css` (compressed)
- **Root `style.css`** is a static file containing only the WordPress theme header — it is **not** compiled by Gulp.

---

## Plugin Management

WordPress plugins are managed via [Composer](https://getcomposer.org/) using the `kiewitnetwork/composer.json` file. Plugins are **not** committed to the repository — they are installed during CI/CD and deployed alongside the theme.

### Plugin Sources

| Source | URL | Plugins |
|--------|-----|---------|
| **WPackagist** | `wpackagist.org` | Classic Editor, Custom Typekit Fonts, Metronet Reorder Posts, Query Monitor, Reorder by Term, Safe SVG, Simple Comment Editing |
| **ACF Pro** | `connect.advancedcustomfields.com` | Advanced Custom Fields Pro (requires license key) |
| **GitHub** | GitHub zip archives | AAD SSO for WordPress, ACF Conditional Taxonomy Rules |

### Managed Plugins

| Package | Constraint | Description |
|---------|-----------|-------------|
| `wpengine/advanced-custom-fields-pro` | `^6.8` | Custom fields framework |
| `psignoret/aad-sso-wordpress` | `^0.7` | Azure AD Single Sign-On |
| `mattkeys/acf-conditional-taxonomy-rules` | `^3.0` | Conditional taxonomy rules for ACF |
| `wpackagist-plugin/classic-editor` | `^1.6` | Classic WordPress editor |
| `wpackagist-plugin/custom-typekit-fonts` | `^2.1` | Adobe Fonts integration |
| `wpackagist-plugin/metronet-reorder-posts` | `^2.6` | Drag-and-drop post reordering |
| `wpackagist-plugin/query-monitor` | `^4.0` | Developer debugging panel |
| `wpackagist-plugin/reorder-by-term` | `^1.3` | Reorder posts within taxonomy terms |
| `wpackagist-plugin/safe-svg` | `^2.2` | Safe SVG upload support |
| `wpackagist-plugin/simple-comment-editing` | `^3.3` | Front-end comment editing |

### Adding or Updating Plugins

```bash
cd kiewitnetwork

# Add a new plugin from WordPress.org
composer require wpackagist-plugin/plugin-slug:"^1.0"

# Update all plugins to latest compatible versions
composer update

# Update a specific plugin
composer update wpackagist-plugin/plugin-slug
```

After updating, commit the updated `composer.json` (and `composer.lock` if tracked). The pipeline will install the resolved versions on the next deploy.

---

## Theme Architecture

### PHP Modules (`inc/`)

| File | Purpose |
|------|---------|
| `custom-acf.php` | ACF field customizations, options pages (Footer Settings, Optional Sidebar) |
| `custom-api-endpoint.php` | Custom REST endpoints for feature posts, news promos, and filtered post queries |
| `custom-blog-query.php` | User subscription–based post filtering; retrieves Azure AD subscriptions and filters content by territory/country/district |
| `custom-comments.php` | Custom threaded comment template with avatars and author info |
| `custom-header.php` | Custom header image support (1000×250px) |
| `custom-user-settings.php` | API integration for user tag subscriptions; audit logging for taxonomy term changes |
| `customizer.php` | WordPress Customizer: site title/description with live preview |
| `jetpack.php` | Jetpack compatibility (infinite scroll, responsive videos) |
| `rest-api-auth.php` | Azure AD JWT bearer token validation via JWKS endpoint (6-hour key cache) |
| `template-functions.php` | Body classes, pingback headers, oEmbed wrappers (Wistia), responsive iframes |
| `template-tags.php` | Post meta output helpers (date, author, tags, comment links) |

### ACF Field Groups

| JSON File | Field Group |
|-----------|-------------|
| `group_5db72eb7ee418` | User Tags (BaseLocations, Countries checkboxes) |
| `group_5db852dfb54a7` | Feature / News / Promo (category + priority fields) |
| `group_5db9b6419a1af` | Promo Fields (link URL, image shape) |
| `group_5ddd4119a1a8e` | Footer Fields (logo, repeater links) |
| `group_5dfa9248dacca` | Optional Sidebar (KMS Link) |

### ACF Taxonomies

| Taxonomy | Slug | Applies To |
|----------|------|------------|
| Base Locations | `BaseLocations` | Posts |
| Countries | `Countries` | Posts |
| Districts | `Districts` | Posts |

### Template Parts

```
template-parts/
├── content.php               # Default post loop
├── content-kiewit-search.php # Kiewit search results
├── content-login-form.php    # Login form
├── content-none.php          # No results
├── content-page.php          # Page template
├── content-post-archive.php  # Post archive
├── content-search.php        # Search results
├── content-tax-archive.php   # Taxonomy archive
├── kms-sidebar.php           # KMS sidebar
├── pages/
│   ├── content-home.php      # Home page
│   ├── content-not-allowed.php
│   ├── content-settings.php  # User settings
│   ├── home-desktop.php
│   └── home-mobile.php
├── post-lists/
│   ├── feature.php           # Featured post layout
│   ├── match-term-posts.php  # Term-filtered posts
│   └── post.php              # Standard post
└── users/
    └── user-terms.php        # User subscription terms
```

### JavaScript

| File | Description |
|------|-------------|
| `kiewitnetwork-scripts.js` | Main theme scripts |
| `navigation.js` | Responsive menu toggle |
| `customizer.js` | Customizer live preview |
| `skip-link-focus-fix.js` | Accessibility focus fix |
| `vendor.js` / `vendor.min.js` | Bundled vendor libraries |

### SCSS Structure

```
sass/
├── style.scss            # Main entry point (imports all partials)
├── _normalize.scss       # CSS reset
├── elements/             # Base HTML elements
├── forms/                # Buttons, fields, forms
├── layout/               # Content/sidebar layouts
├── media/                # Responsive media
├── mixins/               # Reusable SCSS mixins
├── modules/              # UI component modules
├── navigation/           # Menu/nav styles
├── site/                 # Global header, footer, layout
├── typography/           # Headings, copy, font rules
└── variables-site/       # Colors, spacing, breakpoints
```

---

## Versioning

This project follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html). The version is tracked in three files that must stay in sync:

| File | Field |
|------|-------|
| `package.json` | `"version"` |
| `style.css` | `Version:` header line |
| `readme.txt` | `Stable tag:` |

### Bumping the Version

Use the bump script from the **theme directory**:

```bash
npm run bump:patch   # Bug fixes        (1.1.3 → 1.1.4)
npm run bump:minor   # New features      (1.1.3 → 1.2.0)
npm run bump:major   # Breaking changes  (1.1.3 → 2.0.0)
```

Or with an explicit version from the **repo root**:

```bash
./scripts/bump-version.sh 2.0.0-rc.1
```

The script will:

1. Update `package.json`, `style.css`, and `readme.txt` with the new version
2. Stamp the `## [Unreleased]` section in `CHANGELOG.md` with the version and date
3. Create a git commit: `chore(theme): bump version to X.Y.Z`

### Changelog

The [CHANGELOG.md](CHANGELOG.md) follows the [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) format. Add entries under `## [Unreleased]` as you work. The bump script stamps the release automatically.

---

## Deployment

### How It Works

Deployments are triggered by **git tags** and handled by Azure DevOps Pipelines. The pipeline compiles assets, then uses `git subtree push` to deploy only the `kiewitnetwork/wp-content` directory to WP Engine.

| Tag Pattern | Target | WP Engine Install |
|-------------|--------|-------------------|
| `knndev/vX.Y.Z` | DEV | `knndev` |
| `knnprod/vX.Y.Z` | PROD | `knnprod` |

### Pipeline Steps

1. Full checkout with history (required for subtree operations)
2. Install Node.js 18.x and `npm ci`
3. Install plugins via `composer install --no-dev` (with ACF Pro auth)
4. Compile theme assets via Gulp (`styles`, `customJS`, `vendorsJS`, `images`)
5. Remove dev-only files (node_modules, sass, build configs, Composer artifacts)
6. Stage and commit compiled assets + plugins
7. Install WP Engine SSH key
8. `git subtree split` on `kiewitnetwork/`
9. `git push --force` the split branch to WP Engine's remote
10. Clean up residual dev files and Composer artifacts on server via SSH
11. Verify deployment via SSH (style.css version, plugins directory)
12. Smoke test site URL

### Deployment Workflow

```bash
# 1. Finish feature work on your story branch
git add . && git commit -m "feat(theme): your feature description"

# 2. Bump the version (last step before PR)
npm run bump:minor

# 3. Push and create PR to main
git push origin your-branch

# 4. After PR merges to main, tag for deployment
git checkout main && git pull

# Deploy to DEV
git tag knndev/v1.2.0
git push origin knndev/v1.2.0

# Deploy to PROD
git tag knnprod/v1.2.0
git push origin knnprod/v1.2.0
```

### Pipeline Variables

The pipeline uses the Azure DevOps variable group **`WPE.KiewitNetwork`**, which stores:

- `WPE_SSH_PUB_KEY` — WP Engine SSH public key
- `wpengine_ssh_key` — Secure file reference for the private key
- `ACF_PRO_LICENSE_KEY` — Advanced Custom Fields Pro license key (used for Composer auth)

---

## Authentication & API Integration

- **Azure AD JWT Auth** — REST API endpoints are protected via Azure AD bearer tokens. The theme validates JWTs against the Azure AD v2.0 JWKS endpoint with a 6-hour signing key cache (`rest-api-auth.php`).
- **User Subscriptions** — Users' tag subscriptions are fetched from `/api/tagapi/GetAllTagsForSubscriber` and cached in the PHP session for 5 minutes. Posts are filtered by the user's subscribed BaseLocations, Countries, and Districts.
- **Audit Trail** — Taxonomy term changes during API sync are logged as term meta (`_kiewit_created_at`, `_kiewit_updated_at`, `_kiewit_audit_log`).

---

## Commit Convention

This project uses [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/):

```
<type>(<scope>): <description>
```

| Type | Use |
|------|-----|
| `feat` | New feature |
| `fix` | Bug fix |
| `docs` | Documentation only |
| `style` | Formatting (no logic change) |
| `refactor` | Code restructure (no new feature or fix) |
| `perf` | Performance improvement |
| `test` | Adding/correcting tests |
| `build` | Build system or dependency changes |
| `ci` | CI/CD configuration |
| `chore` | Maintenance tasks |

Use `BREAKING CHANGE:` in the footer or `!` after the type/scope for breaking changes.