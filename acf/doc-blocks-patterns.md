# Patterns for Doc Blocks

ACF blocks:
```php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

```

# Block Variables (or Parameters for Callbacks) in PHP

You have access to data about your block by default when creating an ACF Block, either by variables made available in your template or passed into your callback as parameters. New parameters are defined in exactly the same way as any other PHP template file.

$block (array) The block settings and attributes.
$content (string) The block inner HTML (empty).
$is_preview (boolean) True during backend preview render.
$is_preview (boolean) True during backend preview render, i.e., when rendering inside the block editor’s content, or rendered inside the block editor when adding a new block, showing a preview when hovering over the new block. This variable is only set to true when is_admin() and current screen is_block_editor() both return true.
$context (array) The context provided to the block by the post or its parent block.
