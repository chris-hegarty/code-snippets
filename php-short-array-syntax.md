# PHP Short Array syntax

Existing array:

```php
$fruits = ['apple', 'banana'];
```

Add to the array:

```php
$fruits[] = 'cherry'; // $fruits is now ['apple', 'banana', 'cherry']
```

Specify a key to add or modify an element:
```php

$args = [
    'name' => 'Chris',
    'cat' => 'Zoe',
    'vet' => 'Dr Simon'
]
//To add a NEW key + value:
$args['city'] = 'Omaha';

//To modify an existing value:
$args['cat'] = 'Firecracker'

//Ends up with:
$args = [
    'name' => 'Chris',
    'cat' => 'Firecracker',
    'vet' => 'Dr Simon',
    'city' => 'Omaha'
]

```

Here is an example of adding to or modifying a tax_query in a WordPress get_posts() $args parameter:

```php
$args['tax_query'] = [
    [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => ['shoes', 'clothing'],
    ],
    [
        'taxonomy' => 'color',
        'field'    => 'slug',
        'terms'    => ['red'],
    ],
];
// get_posts($args);
```
Also:
```php
if ( isset($_GET['author_id']) ) {
    $args['author'] = intval($_GET['author_id']);
}
```

Other misc patterns:

```php
$value = isset($array['key']) ? $array['key'] : 'default';
// Same as with null coalescing operator:
$value = $array['key'] ?? 'default';
```

Sort an array by a subfield:

```php
usort($acf_repeater, function($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
});
```