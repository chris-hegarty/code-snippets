# How to make a custom template path
(Source: https://developer.wordpress.org/reference/hooks/type_template/)

This could be handy for keeping the directory tree clean.

Example: Add an archive page for a custom taxonomy:

```php
add_filter( "taxonomy_template", 'load_our_custom_tax_template');

function load_our_custom_tax_template ($tax_template) {
  if (is_tax('custom-tax-name')) {
    $tax_template = dirname(  __FILE__  ) . '/templates/custom-taxonomy-template.php';
  }
  return $tax_template;
}
```

```php

add_filter( 'single_template', 'get_custom_post_type_template' );

function get_custom_post_type_template( $single_template ) {
	global $post;

	if ( 'my_post_type' === $post->post_type ) {
		$single_template = dirname( __FILE__ ) . '/post-type-template.php';
	}

	return $single_template;
}
```

```php

<?php
add_filter( 'single_template', 'add_postType_slug_template', 10, 1 );

function add_posttype_slug_template( $single_template ) {
	$object                            = get_queried_object();
	$single_posttype_postname_template = locate_template( "single-{$object->post_type}-{$object->post_name}.php" );

	if ( file_exists( $single_posttype_postname_template ) ) {
		return $single_posttype_postname_template;
	} else {
		return $single_template;
	}
}
?>

```