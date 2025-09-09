

```php

Array
(
    [render_template] => template.php
    // ... 
    [supports] => Array
        (
            [align] => 1
            [html] => 
            [mode] => 1
            [jsx] => 1
            [anchor] => 1
            [ariaLabel] => 1
            [color] => Array
                (
                    [background] => 1
                    [gradients] => 1
                    [link] => 1
                    [text] => 1
                )

            [position] => Array
                (
                    [sticky] => 1
                )

            [spacing] => Array
                (
                    [margin] => 1
                    [padding] => 1
                    [blockGap] => 1
                )

            [typography] => Array
                (
                    [fontSize] => 1
                    [lineHeight] => 1
                )

        )
    [acf_block_version] => 2
    [api_version] => 3
    [title] => ACF Block Json Basic: Text with Block Supports
    [category] => acf-block-json
    [icon] => welcome-write-blog
    [mode] => preview
    [name] => acf-block-json/text-with-block-supports
    [data] => Array
        (
            [text] => Test Block.
            [_text] => field_64a8ebaf28669
        )
    [align] => 
    [backgroundColor] => vivid-red
    [textColor] => luminous-vivid-amber
    [fontSize] => x-large
    [id] => block_6be9f1b1aa3b7a2d677a19b71715d58c
)

```

Then, use like this:

```php
?> <div id="<?= $block['id']; ?>">
```

## Usage Examples
link: https://github.com/RockyKev/acf-6-with-block-json/blob/main/blocks/acf-basic/text-with-support/template.php

Alignment support

```php
// == Align (align: true) ==
//  This determines alignment. 
//  NOTE: On the WP Editor, it's a bit buggy. 
$alignSupport = "text-align: " . $block['align'] . ";" ?: '';

```

Background Color support:

```php
// == Color [background, text] == 
//  Two types of values. Named values vs custom values.
//  Named values have a class: <div class="has-vivid-green-cyan-background-color"></div>
//  Custom values are style injected: <div style="background-color:#ffffff;"></div>
$backgroundColorNamed = ($block['backgroundColor']) ? "has-" . $block['backgroundColor'] . "-background-color" : '';
$backgroundColorCustom = ($block['style']['color']['background']) ? "background-color:" . $block['style']['color']['background'] . ";": '';
```

Other supports:

```php
$textColorNamed = ($block['textColor']) ? "has-" . $block['textColor'] . "-color" : '';
$textColorCustom = ($block['style']['color']['text']) ? "color:" . $block['style']['color']['text'] . ";": '';

// == Typography == 
//  Two types of values. Named values vs custom values.
//  Named values have a class: <div class="has-x-large-font-size"></div>
//  Custom values are style injected: <div style="font-size: 1.9em;"></div>

$fontSizeNamed = ($block['fontSize']) ? "has-" . $block['fontSize'] . "-font-size" : '';
$fontSizeCustom = ($block['style']['typography']['fontSize']) ? "font-size:" . $block['style']['typography']['fontSize'] . ";": '';

// == AdditionalClasses (true) == 
// Default is true. This allows you to add classes from the editor side
$additionalClasses .= !empty($block['className']) ? $block['className'] : ' no-classes-added';

// FRONTEND
$additionalStyles .= "$backgroundColorCustom $textColorCustom $fontSizeCustom $alignSupport ";
$additionalClasses .= "$backgroundColorNamed $textColorNamed $fontSizeNamed ";
$addAnchorID = "id=$anchorID";
?>

<div <?= $addAnchorID;?> class="outline outline-4 outline-blue-500 py-4 my-4 <?= $additionalClasses; ?>" style="<?= $additionalStyles; ?>">

    <h1 class="text-4xl underline pb-4">ACF-basic/Text</h1>

    <p>Text: <?= $text; ?></p>

</div>
```

