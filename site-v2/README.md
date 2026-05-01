# Kiewit.com CSS and Fonts

This directory contains the compiled CSS files for the project. All SASS files are compiled into `style.css`.

* **Do not edit `style.css` directly.** Make changes in the SASS files and recompile.
* Compilation is handled using commands in package.json.
* Open the 'kiewit' theme directory in your terminal, and run 'npm run watch'.

## Font Documentation

Fonts for this site are served from Adobe Typekit, with this link to their script: 

```html
<link rel="stylesheet" href="https://use.typekit.net/gxt0acc.css">
```

They are enqueued in functions.php:
```php
wp_enqueue_style( 'typekit', 'https://use.typekit.net/gxt0acc.css', array(), time() );
```

These fonts are saved in variables for global use in `/sass/abstracts/variables/typography`.

If you need to call them directly, the font-family CSS is included below.

_Note: TypeKit is exacting about the slugs. Make sure they are in quotes and in kebab case, like 
`lowercase-with-dashes-inbetween`_

## Font List

### Industry

**CSS:**
```css
{ font-family: "industry",sans-serif; }
```

**Weights + Styles:**

* 700 (normal + italic)
* 600 (normal + italic)
* 500 (normal + italic)
* 400 (normal + italic)

### Acumin Pro

**CSS:**
```css
{ font-family: "acumin-pro",sans-serif; }
```

**Weights + Styles:**

* 700 (normal + italic)
* 500 (normal)
* 400 (normal + italic)
* 300 (normal + italic)


### Acumin Pro Condensed

**CSS:**
```css
{ font-family: "acumin-pro-condensed",sans-serif; }
```

**Weights + Styles:**

* 700 (normal + italic)
* 600 (normal)
* 500 (normal)
* 400 (normal + italic)
* 300 (normal + italic)

### Open Sans

**Notes:** 

* This was previously being included via Google Fonts, and was the only one coming from there.
* It's included here to eliminate the CDN call to Google Fonts.
* It's included as a fallback and should not be called directly; the site uses Acumin Pro as the base font.

**CSS:**
```css
{font-family: "acumin-pro", sans-serif;}
```
Only 400/normal is included.
