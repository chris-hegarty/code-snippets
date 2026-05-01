# Bootstrap 5.3 + WordPress Nav Menu: Implementation Reference

This document covers everything the team needs to know about the responsive, multi-level navigation menu built for this theme. It explains the decisions made, the gotchas we hit, and the rules to follow when making any future changes.

---

## Table of Contents

1. [Architecture Overview](#1-architecture-overview)
2. [Who Owns What (Precedence Map)](#2-who-owns-what-precedence-map)
3. [header.php — wp_nav_menu() Configuration](#3-headerphp--wp_nav_menu-configuration)
4. [KTG_Bootstrap_Navwalker — The Walker Class](#4-ktg_bootstrap_navwalker--the-walker-class)
5. [_header.scss — Styling Rules and Gotchas](#5-_headerscss--styling-rules-and-gotchas)
6. [functions.js — Desktop Hover Behavior](#6-functionsjs--desktop-hover-behavior)
7. [The Split-Button Pattern Explained](#7-the-split-button-pattern-explained)
8. [The flex-wrap Trick (Mobile Submenus)](#8-the-flex-wrap-trick-mobile-submenus)
9. [Active Item Alignment (border-bottom)](#9-active-item-alignment-border-bottom)
10. [Common Mistakes and How to Avoid Them](#10-common-mistakes-and-how-to-avoid-them)
11. [File Reference](#11-file-reference)

---

## 1. Architecture Overview

The nav menu is built from four cooperating pieces:

| Piece | File | Responsibility |
|---|---|---|
| Menu registration & `wp_nav_menu()` call | `header.php` | Outer `<ul>` wrapper, which menu to load |
| Walker class | `inc/KTG_Bootstrap_Navwalker.php` | Every `<li>`, `<a>`, `<button>`, submenu `<ul>` |
| SCSS | `sass/site/_header.scss` | All visual styling |
| JavaScript | `assets/js/functions.js` | Desktop hover behavior, slide animation |

Bootstrap 5.3 is loaded via CDN (CSS + Bundle JS) in `functions.php`. Bootstrap Bundle includes Popper.js, which powers dropdown positioning.

---

## 2. Who Owns What (Precedence Map)

This is the most important thing to understand before touching any file:

```
<header class="navbar navbar-expand-lg ...">        ← header.php
  <div class="container">                           ← header.php
    <button class="navbar-toggler ...">             ← header.php (hamburger)
    <nav class="collapse navbar-collapse" id="main-nav"> ← header.php

      <ul class="nav navbar-nav gap-3">             ← items_wrap in wp_nav_menu()
                                                       (header.php)
        <li class="nav-item [dropdown] [current-menu-item] ...">
                                                    ← WordPress core populates $item->classes
                                                    ← Walker APPENDS to that array
          <a class="nav-link [active]">             ← Walker owns entirely
          <button class="dropdown-toggle-btn">      ← Walker owns entirely (parent items only)

          <ul class="dropdown-menu">                ← Walker's start_lvl() owns
            <li>
              <a class="dropdown-item">             ← Walker owns entirely
```

**Key rule:** WordPress populates `$item->classes` before the walker runs. The walker appends to it — it does not replace it. Whatever ends up in that array passes through the `nav_menu_css_class` filter (plugins can inject more classes here, which is normal).

---

## 3. header.php — wp_nav_menu() Configuration

```php
wp_nav_menu(array(
    'menu'        => 'primary-menu',          // Slug of the menu assigned in WP Admin
    'theme_location' => 'header_menu',        // Registered location (functions.php)
    'menu_id'     => 'menu-header',           // id="" on the <ul>
    'menu_class'  => '',                      // INTENTIONALLY EMPTY — see below
    'depth'       => 0,                       // 0 = unlimited depth (not "zero levels")
    'container'   => false,                   // Prevents WP adding a wrapping <div>/<nav>
    'items_wrap'  => '<ul id="%1$s" class="nav navbar-nav mb-2 mb-md-0 gap-3 %2$s">%3$s</ul>',
    'walker'      => new KTG_Bootstrap_Navwalker(),
    'fallback_cb' => false
));
```

### Why `menu_class` is empty

`menu_class` is substituted into `%2$s` inside `items_wrap`. If you put `navbar-nav` in both `menu_class` and `items_wrap`, you'd get it rendered twice in the HTML. Keep all outer `<ul>` classes in `items_wrap` only.

### Why `depth => 0`

Counterintuitive: `0` means **unlimited levels**, not "show nothing." Positive integers cap depth (e.g. `'depth' => 2` stops at two levels).

### Why `container => false`

WordPress would otherwise wrap the `<ul>` in a `<div class="menu-header_menu-container">`. Since the `<nav>` is already in `header.php`, this would be a redundant extra wrapper.

### The hamburger toggler must match the nav ID

The toggler button uses `data-bs-target="#main-nav"` and `aria-controls="main-nav"`. The `<nav>` element must have `id="main-nav"`. If these ever drift apart, the mobile hamburger silently stops working — no JS error, just no toggle.

Note: `aria-controls` takes the plain ID, **no `#`** (that's a CSS selector syntax, not an ARIA attribute value).

### Container padding on small screens

The `.container` uses `py-0` (not `p-0`) so vertical padding stays zero but Bootstrap's default horizontal gutters (`px-3`, 15px each side) remain in place. Using `p-0` removes all padding including the horizontal gutters, which pushes the hamburger against the viewport edge below ~590px.

---

## 4. KTG_Bootstrap_Navwalker — The Walker Class

The walker extends WordPress's `Walker_Nav_Menu` and overrides four methods:

| Method | What it outputs |
|---|---|
| `start_lvl()` | Opening `<ul class="dropdown-menu menu-depth-N">` |
| `end_lvl()` | Closing `</ul>` |
| `start_el()` | `<li>`, `<a>`, and (for parent items) `<button>` |
| `end_el()` | Closing `</li>` |

### Class assignments in start_el()

**On the `<li>`:**

| Condition | Classes added |
|---|---|
| `$depth === 0` | `nav-item` |
| `menu-item-has-children` present | `dropdown` |
| Always | WordPress core classes (`menu-item`, `menu-item-type-*`, `current-menu-item`, etc.) |

**On the `<a>`:**

| Condition | Classes added |
|---|---|
| `$depth === 0` | `nav-link` |
| `$depth > 0` | `dropdown-item` |
| `current-menu-item` + `$depth === 0` | `active` |
| `$depth > 0` AND `has_children` | `dropdown-toggle` + `data-bs-toggle="dropdown"` |

**The `nav_menu_link_atts` filter** is applied to the `$atts` array before rendering. This is the standard WordPress hook that lets plugins add attributes to nav links (e.g. `rel="noopener"` for external links). Always keep this filter call in place.

### Fake/non-existent wp_nav_menu() arguments

`link_class` and `list_item_class` are **not** real `wp_nav_menu()` parameters. WordPress silently ignores them without a walker that reads them. All class assignment happens in the walker itself.

---

## 5. _header.scss — Styling Rules and Gotchas

### The flex-wrap trick (most important rule in the SCSS)

```scss
ul.navbar-nav li {
  display: flex;
  align-items: center;
  flex-wrap: wrap;

  .dropdown-menu {
    flex: 0 0 100%;
  }
}
```

This single pattern handles both desktop and mobile correctly **without any media queries**:

- **Desktop:** Bootstrap sets `.dropdown-menu { position: absolute }` → it leaves flex flow → `flex: 0 0 100%` has no visual effect → link and caret sit side by side on one row.
- **Mobile:** Bootstrap sets `.dropdown-menu { position: static }` inside `.navbar-nav` → it re-enters flex flow → `flex: 0 0 100%` forces it to wrap onto its own full-width row below the link and caret.

**Do not** use `display: flex` without `flex-wrap: wrap` on these `<li>` elements, or the submenu will appear beside the link on mobile instead of below it.

**Do not** use Bootstrap's `d-flex` utility class on the `<li>` from PHP/walker — it carries `!important` and cannot be overridden by a media-query-conditional rule in SCSS.

### Active item border-bottom alignment

```scss
ul.navbar-nav > li {
  border-bottom: 4px solid transparent;  // Always reserves the space
}
.current-menu-item {
  border-bottom: 4px solid $primary_color;  // Just changes the color
}
```

Every `<li>` must have the `border-bottom` space reserved (as `transparent`) so the active item's colored border doesn't push that item upward relative to its siblings. Applying `border-bottom` only to `.current-menu-item` shifts the layout.

### nav-link right padding on parent items

```scss
li.dropdown > .nav-link {
  padding-right: 0;
}
```

Bootstrap's `.nav-link` has `padding-right: 1rem` by default. For parent items, that space sits between the link text and the caret button, making the caret visually far away. Zero it out here; the `0.3rem padding-left` on `.dropdown-toggle-btn` provides the only gap.

### position: relative on .menu-item

```scss
.menu-item {
  position: relative;
}
```

This is essential for two reasons:
1. The hover animation `::before` pseudo-element is `position: absolute` and needs a positioned ancestor.
2. The dropdown menu's `position: absolute` on desktop anchors relative to this `<li>`, keeping the flyout properly below the nav item.

### Dropdown toggle caret animation

```scss
.dropdown-toggle::after {
  transition: transform 0.3s ease;
}
.dropdown-toggle[aria-expanded="true"]::after {
  transform: rotate(180deg);
}
```

Bootstrap's default caret is a CSS border-triangle rendered via `::after`. These rules animate it rotating 180° when the dropdown is open. This applies to the `.dropdown-toggle-btn` button since it carries the `.dropdown-toggle` class — no additional selectors needed.

---

## 6. functions.js — Desktop Hover Behavior

Bootstrap 5 removed built-in hover support for dropdowns (it was always a UX anti-pattern on touch devices). Hover is implemented manually and scoped to desktop only:

```js
var navMql = window.matchMedia('(min-width: 992px)');

function addNavHover() {
    $('.navbar .nav-item.dropdown').each(function(i) {
        var $btn = $(this).find('.dropdown-toggle-btn').first();
        $(this)
            .on('mouseenter.navhover', function() {
                clearTimeout(navHoverTimers[i]);
                navHoverTimers[i] = setTimeout(function() {
                    bootstrap.Dropdown.getOrCreateInstance($btn[0]).show();
                }, 150);
            })
            .on('mouseleave.navhover', function() {
                clearTimeout(navHoverTimers[i]);
                navHoverTimers[i] = setTimeout(function() {
                    bootstrap.Dropdown.getOrCreateInstance($btn[0]).hide();
                }, 150);
            });
    });
}
```

Key points:
- **150ms delay** prevents accidental triggering as the mouse moves across the navbar.
- **`window.matchMedia`** with a `change` listener tears down hover listeners when switching to mobile and re-applies them when returning to desktop. This prevents hover from firing inside the open mobile menu.
- **`bootstrap.Dropdown.getOrCreateInstance()`** is Bootstrap 5's API for programmatically controlling dropdowns. The toggle `<button>` element is passed (not the `<li>`).
- **`.navhover` namespace** on the event listeners allows clean removal with `.off('.navhover')` without accidentally removing other click/keyboard listeners.
- Submenu slide animation is handled separately via Bootstrap's `show.bs.dropdown` and `hide.bs.dropdown` events using jQuery's `.slideDown()` and `.slideUp()`.

---

## 7. The Split-Button Pattern Explained

This is the core architectural decision of the implementation.

### The problem with the standard Bootstrap approach

The standard Bootstrap pattern puts `data-bs-toggle="dropdown"` directly on the `<a>` tag:

```html
<a href="/services" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
```

Bootstrap intercepts the click event and calls `e.preventDefault()`, blocking navigation to `/services`. The parent page becomes unreachable via the nav.

### Our solution: separate `<a>` and `<button>`

For every top-level parent item, the walker outputs two sibling elements inside the `<li>`:

```html
<li class="nav-item dropdown">
  <a class="nav-link" href="/services">Services</a>
  <button class="dropdown-toggle-btn dropdown-toggle"
          data-bs-toggle="dropdown"
          aria-expanded="false"
          aria-label="Open submenu">
    <span class="visually-hidden">Toggle submenu</span>
  </button>
  <ul class="dropdown-menu">...</ul>
</li>
```

- The `<a>` navigates freely — no Bootstrap JS attached to it.
- The `<button>` carries `data-bs-toggle="dropdown"` — Bootstrap finds its associated dropdown menu as the next sibling `<ul class="dropdown-menu">` in the DOM.
- The `<button>` shows Bootstrap's caret (▾) via the `.dropdown-toggle::after` CSS pseudo-element.

### Why not data-bs-reference="parent"?

`data-bs-reference="parent"` was tried and removed. It forces Popper.js to use the `<li>` as the positioning reference. On desktop this is fine, but on mobile — where Bootstrap sets `.dropdown-menu { position: static }` — Popper overrides that with absolute positioning and the menu flies sideways instead of expanding inline.

### Sub-menu items at depth > 0

For items deeper than the top level that also have children, the toggle stays on the `<a>` (standard Bootstrap behavior). This is a less common case and the split-button pattern is only needed at depth 0 where parent navigation matters.

---

## 8. The flex-wrap Trick (Mobile Submenus)

See [Section 5](#5-_headerscss--styling-rules-and-gotchas) for the full explanation. Summary of what to never do:

| Approach | What happens on mobile |
|---|---|
| `display: flex` alone on `<li>` | Submenu appears to the right of the link |
| `display: flex; flex-direction: column` | Link, caret, and submenu all stack full-width |
| `display: flex; flex-wrap: wrap` + `flex: 0 0 100%` on `.dropdown-menu` | ✅ Link and caret on row 1, submenu wraps to row 2 |
| `d-flex` Bootstrap class in PHP | Cannot be overridden by SCSS media queries (`!important`) |

---

## 9. Active Item Alignment (border-bottom)

The pattern to **always** use when a bottom border indicates the active/current state:

```scss
// Wrong — shifts the active item upward:
.current-menu-item { border-bottom: 4px solid $primary_color; }

// Right — all items reserve the space, active item gets the color:
ul.navbar-nav > li { border-bottom: 4px solid transparent; }
.current-menu-item { border-bottom: 4px solid $primary_color; }
```

---

## 10. Common Mistakes and How to Avoid Them

### Hamburger not working (silent failure)
**Symptom:** Clicking the hamburger does nothing. No JS error.  
**Cause:** `data-bs-target` on the button and `id` on the `<nav>` don't match.  
**Fix:** Ensure `data-bs-target="#main-nav"` and `id="main-nav"` are identical. Also check `aria-controls="main-nav"` has no `#`.

### Submenu appears beside the link on mobile
**Symptom:** Tapping the caret on mobile opens the submenu to the right.  
**Cause:** `<li>` is `display: flex` without `flex-wrap: wrap`, OR `data-bs-reference="parent"` is set on the toggle button.  
**Fix:** Add `flex-wrap: wrap` to the `<li>` styles and `flex: 0 0 100%` to `.dropdown-menu`. Remove `data-bs-reference="parent"`.

### Parent link not navigating (click opens dropdown instead)
**Symptom:** Clicking the parent link text opens the submenu instead of navigating to the URL.  
**Cause:** `data-bs-toggle="dropdown"` is on the `<a>` tag.  
**Fix:** Move `data-bs-toggle="dropdown"` to the separate `<button>` element (the split-button pattern).

### Duplicate Bootstrap classes on the outer `<ul>`
**Symptom:** `navbar-nav navbar-nav` in the rendered HTML.  
**Cause:** Same class in both `menu_class` and `items_wrap`.  
**Fix:** Keep `menu_class => ''` (empty) and put all classes in `items_wrap` only.

### Active item pushes menu items out of alignment
**Symptom:** The currently active nav item sits slightly lower than the others.  
**Cause:** `border-bottom` only applied to `.current-menu-item`, shifting its height.  
**Fix:** Apply `border-bottom: 4px solid transparent` to all `<li>` elements first.

### Hover triggering on mobile
**Symptom:** Hover-open behavior fires inside the open mobile menu.  
**Cause:** Hover JS not scoped to desktop breakpoint.  
**Fix:** Wrap in `window.matchMedia('(min-width: 992px)')` with a `change` listener that tears down and re-applies the listeners on breakpoint crossing.

### WordPress classes bloating the `<li>`
**Symptom:** `<li>` has many unfamiliar classes like `menu-item-type-post_type`, `menu-item-object-page`.  
**Cause:** WordPress core adds these before the walker runs. They are normal, harmless, and expected.  
**Action:** None required. Use your own classes in CSS selectors and ignore the WP housekeeping classes.

---

## 11. File Reference

| File | Purpose |
|---|---|
| `header.php` | `wp_nav_menu()` call, hamburger button, nav container HTML |
| `inc/KTG_Bootstrap_Navwalker.php` | Custom walker — all `<li>`, `<a>`, `<button>`, submenu `<ul>` output |
| `sass/site/_header.scss` | All nav/header visual styling |
| `assets/js/functions.js` | Desktop hover with delay, dropdown slide animation |
| `functions.php` | Nav menu location registration, walker `require`, Bootstrap enqueueing |

### Bootstrap 5.3 docs quick links

- [Navbar component](https://getbootstrap.com/docs/5.3/components/navbar/)
- [Dropdowns](https://getbootstrap.com/docs/5.3/components/dropdowns/)
- [Dropdown JS API](https://getbootstrap.com/docs/5.3/components/dropdowns/#via-javascript)
- [Navs & Tabs](https://getbootstrap.com/docs/5.3/components/navs-tabs/)
