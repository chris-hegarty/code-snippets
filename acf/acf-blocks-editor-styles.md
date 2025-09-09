# Editor Styles for ACF Blocks

The editor styles for ACF blocks look different than native WP blocks. Here is how to clean up and reset some of them.

-Make an `editor-styles.css` file. (Can go in assets/css/ directory.)

-Enable and enqueue the editor styles in functions.php:

```php

function enable_editor_styles(){
	add_theme_support( 'editor-styles' );
	add_editor_style('assets/css/editor-styles.css');
}

add_action('after_setup_theme', 'enable_editor_styles');

```

Add/fix any styles. For example, ACF Blocks don't have margins. You can target the `editor-styles-wrapper` class to 
fix this:

```css

.editor-styles-wrapper{
    padding: 0 40px;
}

```