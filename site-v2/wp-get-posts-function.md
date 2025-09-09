# get_posts()

get_posts() does not alter the main loop the way WP_Query does.

Allows you to control not only the post type in the function arguments, but also things like:

* -the number of posts to retrieve, 
* -the order
* -how the posts are ordered and much more.

Returns an **array of WP_Post objects**.

Under the hood, it is using the WP_Query object.

## Default arguments:

```php

$defaults = array(
		'numberposts'      => 5,
		'category'         => 0,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => array(),
		'exclude'          => array(),
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'suppress_filters' => true,
	);

```

## To change to alphabetical ordering:

```php

  'order'       => 'ASC',
  'orderby'     => 'title'
```

## Remember that Taxonomy queries are an array of arrays:

```php

	"tax_query" => array(
		array(
			"taxonomy" => "category",
			"field"    => "slug",
			"terms"    => "videos,movies",
		)
	),
```

## Meta queries
## `meta_key()` and `meta_value()`: 

If you provide only meta_key, then posts which have the key will be returned. 

If you also provide meta_value then posts matching the meta_value for the meta_key is returned.

If you have a key and value, it automatically  "COMPARE".

If you need more than one element returned, you have to set up a meta_query.

If you have a key and value, it automatically uses "COMPARE".

Example: find all posts where a custom field called ‘color’ has 
* -a value of ‘red’ or ‘orange’, and
* another custom field called ‘featured’ (checkbox) is checked.

(Source: https://www.advancedcustomfields.com/resources/query-posts-custom-fields/)

```php
$posts = get_posts(array(
    'posts_per_page'    => -1,
    'post_type'     => 'post',
    'meta_query'    => array(
        'relation'      => 'AND',
        array(
            'key'       => 'color',
            'value'     => array('red', 'orange'),
            'compare'   => 'IN',
        ),
        array(
            'key'       => 'featured',
            'value'     => '1',
            'compare'   => '=',
        ),
    ),
));

```

```php
$posts = get_posts(array(
    'posts_per_page'    => -1,
    'post_type'     => 'post',
    'meta_key'      => 'color',
    'meta_value'    => 'red'
));
```

Retrieve posts with matching metakey and value:

**(Note: get_posts returns an ARRAY of WP_Post objects.)**

```php
<?php
  $args = array("posts_per_page" => -1, "meta_key" => "reviewer", "meta_value" = "narayanprusty");
  $posts_array = get_posts($args);
  foreach($posts_array as $post)
  {
    echo "<h1>" . $post->post_title . "</h1><br>";
    echo "<p>" . $post->post_content . "</p><br>";
  } 
?>
```


Another complex example:
get all the events ordered by the event city 
-in alphabetical/ascending order 
-and then by the most recent events.
(Source: https://andriy.space/wordpress-meta-query/)

```php
$query = new WP_Query([
    'post_type' => 'event',
    'meta_query' => [
        'relationship' => 'AND',
        'city_clause' => [
            'key' => 'event_city',
            'compare' => 'EXISTS',
        ],
        'date_clause' => [
            'key' => 'date',
            'compare' => 'EXISTS',
            'type' => 'DATETIME'
        ]
    ],
    'orderby' => [
        'city_clause' => 'ASC',
        'date_clause' => 'DESC'
    ],
]);

$posts = $query->get_posts();


```

## pre_get_posts()

Use this to alter the main query. (If have posts while have posts the post).

Strictly, you don't need to use a loop in a page template.

(But it doesn't hurt, the content of the page will still load, the loop will simply only run once as there is only 
one post/page. Many themes include a loop in page templates.)

## Taxonomies

`get_the_terms()` - Fetch all terms for a single, specific taxonomy
`get_terms()` - Fetch all terms for a one or more taxonomies



