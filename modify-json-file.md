# How to modify a theme.json file (or any json file)

The WordPress json files do -not- support dynamic variables.

If you have a global setting you want to include in your theme.json, here is a possible way to do it.

(TODO: refactor to check if color already exists?)

## 1) Read the existing json file.

```php

$theme_json_path = get_template_directory() . '/theme.json';
$theme_json = json_decode(file_get_contents($theme_json_path), true);

```

## 2) Write the array you want to add. 
and make sure it is stored in a variable: 

```php

$new_color = array(
    'name'  => 'Primary',
    'slug'  => 'primary',
    'color' => get_field('primary'),
);

```
## 3) Use PHP variable syntax to add it where you need in theme.json:

```php

// Assuming you want to add it to the 'palette' array under 'settings' -> 'color'
$theme_json['settings']['color']['palette'][] = $new_color;

```

## 4) Write the modified array back into the theme.json file:

```php

file_put_contents($theme_json_path, json_encode($theme_json, JSON_PRETTY_PRINT));

```