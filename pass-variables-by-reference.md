# Why is there an ampersand next to a variable in a foreach loop?

### It creates a reference to the original array element, rather than a copy of it. 

It means that any changes made to the variable in the loop directly affects the corresponding element in the array.

#### Without the ampersand:

The loop iterates over each element of the array, and $color is a copy of the array element. 

Any modifications to $color _**will not affect the original array**_.

#### With the ampersand:

With the ampersand: The loop iterates over each element of the array, 

and $color is a reference to the original array element. 

Any modifications to $color _**will directly update the original array**_.

Example:

```php

foreach ($theme_json['settings']['color']['palette'] as &$color) {
    if ($color['slug'] === $color_slug) {
        // Update the existing color
        $color['name'] = $color_name;
        $color['color'] = $color_value;
        $color_exists = true;
        break; // Exit the loop once the color is found and updated
    }
}

```