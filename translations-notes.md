# Translations

### Resources:

WordPress Internatiolization (i18n) Functions
https://developer.wordpress.org/apis/internationalization/internationalization-guidelines/

Escaping Data on WordPress
https://developer.wordpress.org/apis/security/escaping/
--------

### Escaping strings

Use `_e` to echo a translatable string:
```php
<?php _e('Delivery Method:', 'brand'); ?>

<button class="button loadmore"><?php _e( 'Load More', 'brand'); ?></button>

<a href="<?=__( '/markets/', 'brand'); ?>" class="button"><?php _e( 'See more of our work', 'brand'); ?></a>

<h3><?php _e('Want to learn more?', 'brand'); ?></h3>
```

Before:
```html
<h1>Settings Page</h1>
```
After:
```php
?>
<h1><?php _e( 'Settings Page' ); ?></h1>
```

Themes that are hosted on WordPress.org the text domain must match the slug of your theme URL (wordpress.
org/themes/slug).
There are a few escape functions that are integrated with internationalization functions.
```php
?>
<a title="<?php esc_attr_e( 'Skip to content', 'my-theme' ); ?>" class="screen-reader-text skip-link" href="#content" >
  <?php _e( 'Skip to content', 'my-theme' ); ?>
</a>
```

### More on escaping + localization

Rather than using echo to output data, it’s common to use the WordPress localization functions, such as _e() or __().

These functions simply wrap a localization function inside an escaping function:

```php
esc_html_e( 'Hello World', 'text_domain' );
// Same as
echo esc_html( __( 'Hello World', 'text_domain' ) );
```

These helper functions combine localization and escaping:
```php
esc_html__()
esc_html_e()
esc_html_x()
esc_attr__()
esc_attr_e()
esc_attr_x()
```

### Use format strings instead of string concatenation:

Don't do this:
```php
__( 'Your city is ', 'my-theme' ) . $city . __( ', and your zip code is ', 'my-theme' ) . $zipcode;
```
Do this instead:
```php
printf(
__( 'Your city is %1$s, and your zip code is %2$s.', 'my-theme' ),
$city,
$zipcode
);
```
## Escape functions

### `esc_url()`

`<img alt="" src="<?php echo esc_url( $media_url ); ?>" />`

`echo '<a href="'. esc_url( $url ) . '">' . esc_html( $text ) . '</a>';`

### `esc_attr()`
`<ul class="<?php echo esc_attr( $stored_class ); ?>">`

### ...with localization:

`esc_html_e( 'Hello World', 'text_domain' );`

esc_attr_e():

```php
?>
<input title="<?php esc_attr_e( 'Read More', 'your_text_domain' ) ?>" type="submit" value="submit" />
// Returns <input title="Read More" type="submit" value="submit" />
```

### Escape arbitrary variable within an HTML attribute:

When a variable is used as part of an attribute or url, it is always better to escape the whole string.
```php
echo '<div id="', esc_attr( $prefix . '-box' . $id ), '">';

echo '<a href="', esc_url( $url ), '">';
```