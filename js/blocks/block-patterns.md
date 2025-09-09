# Block Patterns

The weird thing about these is that you have to build them in the editor first, THEN register them.

* You have to copy and paste the markup from the editor
* Assign the markup to a variable
* Set the variable to the "content" key in the register_block_pattern() function.
  (example: https://gist.github.com/annezazu/acee30f8b6e8995e1b1a52796e6ef805)

--------

Questions: Do I have to spell these out in the function or can't we just declare this stuff in theme.json?

## register_block_pattern()

The register_block_pattern helper function receives two arguments.

* title: A machine-readable title with a naming convention of namespace/title.
* properties: An array describing properties of the pattern.

### Available properties:

The properties available for block patterns are:

* title (required): A human-readable title for the pattern.
* content (required): Block HTML Markup for the pattern.
* description (optional): A visually hidden text used to describe the pattern in the inserter. A description is optional but it is strongly encouraged when the title does not fully describe what the pattern does. The description will help users discover the pattern while searching.
* categories (optional): An array of registered pattern categories used to group block patterns. Block patterns can be shown on multiple categories. A category must be registered separately in order to be used here.
* keywords (optional): An array of aliases or keywords that help users discover the pattern while searching.
* viewportWidth (optional): An integer specifying the intended width of the pattern to allow for a scaled preview of the pattern in the inserter.
* blockTypes (optional): An array of block types that the pattern is intended to be used with. Each value needs to be the declared block’s name.
* postTypes (optional): An array of post types that the pattern is restricted to be used with. The pattern will only be available when editing one of the post types passed on the array. For all the other post types, the pattern is not available at all.
* templateTypes (optional): An array of template types where the pattern makes sense, for example, 404 if the pattern is for a 404 page, single-post if the pattern is for showing a single post.
* inserter (optional): By default, all patterns will appear in the inserter. To hide a pattern so that it can only be inserted programmatically, set the inserter to false.
* source (optional): A string that denotes the source of the pattern. For a plugin registering a pattern, pass the string plugin. For a theme, pass the string theme.

### Register the pattern
1. Use `register_block_pattern()`
```php

register_block_pattern(
    'my-plugin/my-awesome-pattern',
    array(
        'title'       => __( 'Two buttons', 'my-plugin' ),
        'description' => _x( 'Two horizontal buttons, the left button is filled in, and the right button is outlined.', 'Block pattern description', 'my-plugin' ),
        'content'     => "<!-- wp:buttons {\"align\":\"center\"} -->\n<div class=\"wp-block-buttons aligncenter\"><!-- wp:button {\"backgroundColor\":\"very-dark-gray\",\"borderRadius\":0} -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link has-background has-very-dark-gray-background-color no-border-radius\">" . esc_html__( 'Button One', 'my-plugin' ) . "</a></div>\n<!-- /wp:button -->\n\n<!-- wp:button {\"textColor\":\"very-dark-gray\",\"borderRadius\":0,\"className\":\"is-style-outline\"} -->\n<div class=\"wp-block-button is-style-outline\"><a class=\"wp-block-button__link has-text-color has-very-dark-gray-color no-border-radius\">" . esc_html__( 'Button Two', 'my-plugin' ) . "</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
    )
);
```

2. Call it on the init hook:

```php
function my_plugin_register_my_patterns() {
  register_block_pattern( ... );
}

add_action( 'init', 'my_plugin_register_my_patterns' );

```

### You can create custom categories for patterns

Use the `register_block_pattern_category()` function.

Note: You wont see the new category in the editor until you have saved a pattern to it.
```php
function my_plugin_register_my_pattern_categories() {
    register_block_pattern_category(
        'hero',
        array( 'label' => __( 'Hero', 'my-plugin' ) )
    );
}

add_action( 'init', 'my_plugin_register_my_pattern_categories' );
```

