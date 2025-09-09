

Register the new category in functions.php

```php

function add_ktg_blocks_category($categories, $post){
        array_unshift($categories, array(
        'slug' => 'ktg-blocks',
        'title' => 'KTG Blocks'
        ));
    return $categories;
}

add_filter('block_categories_all','add_ktg_blocks_category', 10, 2);


```

Set the category and icon in block.json:

```json

  "category": "ktg-blocks",
  "icon": {
    "background": "#2E2787",
    "foreground": "#ffd200",
    "src": "insert"
  }


```





