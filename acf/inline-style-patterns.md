# Patterns for inline styles

```php
//declare variables:
$background_color = get_field('background_color') ?: '';
$text_color       = get_field('color') ?: '';

//Then build the styles into an array
//implode them and save into one variable

$styles = array('background-color: ' . $background_color, 'color: ' . $text_color);
$style  = implode('; ', $styles);

```

Use in HTML like:

```php
<div class="testimonial-block" style="<?php echo esc_attr($style); ?>">
```