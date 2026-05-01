# Helper functions for terms

## Best practices for getting terms across different contexts

### Core Helper Function for Getting Terms

Create a centralized function that handles all term retrieval scenarios:

```php

// /inc/taxonomy-helpers.php

/**
 * Get terms for a post with caching and flexible return formats
 */
function get_post_terms_helper($post_id = null, $taxonomy = '', $args = []) {
    // Handle different input types
    if (is_object($post_id) && isset($post_id->ID)) {
        $post_id = $post_id->ID; // Post object
    } elseif (empty($post_id)) {
        $post_id = get_the_ID(); // Current post
    }

    if (empty($post_id) || empty($taxonomy)) {
        return [];
    }

    // Default arguments
    $defaults = [
        'fields' => 'all', // 'all', 'ids', 'names', 'slugs'
        'format' => 'array', // 'array', 'comma', 'links'
        'link_class' => 'term-link',
        'separator' => ', ',
        'cache' => true
    ];
    $args = wp_parse_args($args, $defaults);

    // Check cache first if enabled
    $cache_key = "post_terms_{$post_id}_{$taxonomy}_" . md5(serialize($args));
    if ($args['cache']) {
        $cached = wp_cache_get($cache_key, 'post_terms');
        if ($cached !== false) {
            return $cached;
        }
    }

    // Get terms
    $terms = wp_get_object_terms($post_id, $taxonomy, [
        'fields' => $args['fields']
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        $result = [];
    } else {
        // Format based on requested format
        switch ($args['format']) {
            case 'comma':
                $result = implode($args['separator'], wp_list_pluck($terms, 'name'));
                break;
            case 'links':
                $links = [];
                foreach ($terms as $term) {
                    $links[] = sprintf(
                        '<a href="%s" class="%s">%s</a>',
                        esc_url(get_term_link($term)),
                        esc_attr($args['link_class']),
                        esc_html($term->name)
                    );
                }
                $result = implode($args['separator'], $links);
                break;
            default:
                $result = $terms;
        }
    }

    // Cache the result
    if ($args['cache']) {
        wp_cache_set($cache_key, $result, 'post_terms', HOUR_IN_SECONDS);
    }

    return $result;
}
```

### Specific Helper Functions for Common Use Cases

```php

// /inc/taxonomy-helpers.php

/**
 * Get primary term (first term) for a post
 */
function get_primary_post_term($post_id = null, $taxonomy = '') {
    $terms = get_post_terms_helper($post_id, $taxonomy);
    return !empty($terms) ? $terms[0] : null;
}

/**
 * Get term names as comma-separated string
 */
function get_post_term_names($post_id = null, $taxonomy = '', $separator = ', ') {
    return get_post_terms_helper($post_id, $taxonomy, [
        'format' => 'comma',
        'separator' => $separator
    ]);
}

/**
 * Get term links as HTML
 */
function get_post_term_links($post_id = null, $taxonomy = '', $class = 'term-link') {
    return get_post_terms_helper($post_id, $taxonomy, [
        'format' => 'links',
        'link_class' => $class
    ]);
}

/**
 * Check if post has specific term
 */
function post_has_term_helper($post_id = null, $term_slug = '', $taxonomy = '') {
    $post_id = is_object($post_id) ? $post_id->ID : ($post_id ?: get_the_ID());
    return has_term($term_slug, $taxonomy, $post_id);
}

/**
 * Get related posts by shared terms
 */
function get_related_posts_by_terms($post_id = null, $taxonomy = '', $args = []) {
    $post_id = is_object($post_id) ? $post_id->ID : ($post_id ?: get_the_ID());
    $terms = get_post_terms_helper($post_id, $taxonomy, ['fields' => 'ids']);
    
    if (empty($terms)) return [];

    $defaults = [
        'post_type' => get_post_type($post_id),
        'posts_per_page' => 5,
        'post__not_in' => [$post_id],
        'tax_query' => [
            [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $terms,
            ]
        ]
    ];
    
    return get_posts(wp_parse_args($args, $defaults));
}


```

### Usage Examples in Different Contexts

```php

// In single post templates
$categories = get_post_term_names(null, 'category'); // Current post
$tags_html = get_post_term_links(null, 'post_tag', 'tag-link');

// With Post objects from queries
$posts = get_posts(['post_type' => 'project']);
foreach ($posts as $post) {
    $project_types = get_post_term_names($post, 'project_type');
    $primary_location = get_primary_post_term($post->ID, 'location');
}

// In loops with different post types
while (have_posts()) : the_post();
    $terms = get_post_terms_helper(get_the_ID(), 'custom_taxonomy');
    $related = get_related_posts_by_terms(null, 'custom_taxonomy');
endwhile;

// On pages showing other posts
$featured_posts = get_posts(['meta_key' => 'featured', 'meta_value' => 'yes']);
foreach ($featured_posts as $featured_post) {
    echo get_post_term_links($featured_post, 'category');
}

```

### Load helpers with WordPress hooks

If the helper functions are outside the template files, you have to require or include the file they are in EACH 
TIME YOU NEED THEM.

But if you load them in functions.php in one of the early hooks, they become available whenever and wherever you 
need them.

```php

// functions.php
function load_taxonomy_helpers() {
    require_once get_template_directory() . '/inc/taxonomy-helpers.php';
}
add_action('after_setup_theme', 'load_taxonomy_helpers');

```

Here is how you can now call them in template files:

```php


// template-parts/builder/standard_columns.php

// Get terms for posts in your columns
while (have_rows('column')) : the_row();
    $featured_posts = get_sub_field('featured_posts'); // ACF relationship field
    
    foreach ($featured_posts as $post) {
        // Now you can easily get terms
        $categories = get_post_term_names($post, 'category');
        $tags = get_post_term_links($post, 'post_tag');
        $custom_terms = get_post_terms_helper($post, 'custom_taxonomy');
        
        echo "<h3>{$post->post_title}</h3>";
        echo "<p>Categories: {$categories}</p>";
        echo "<p>Tags: {$tags}</p>";
    }
endwhile;

```

### Really useful grouping pattern:

```php
$terms_by_post[$term->object_id] = [];
```

This creates a multidimensional array where:

-The key is the post ID ($term->object_id)
-The value is an array that will hold all terms for that post

Let's say you have these term objects from the database.

```php

// Raw terms from wp_get_object_terms()
$all_terms = [
    (object) ['name' => 'Category A', 'object_id' => 123],
    (object) ['name' => 'Category B', 'object_id' => 123],
    (object) ['name' => 'Category C', 'object_id' => 456],
    (object) ['name' => 'Category D', 'object_id' => 789],
    (object) ['name' => 'Category E', 'object_id' => 456],
];

```

The loop processes this into:

```php
$terms_by_post = [];

foreach ($all_terms as $term) {
    // First, ensure the post ID key exists
    if (!isset($terms_by_post[$term->object_id])) {
        $terms_by_post[$term->object_id] = []; // Create empty array for this post
    }
    // Then add the term to that post's array
    $terms_by_post[$term->object_id][] = $term;
}

// The result is term objects grouped by post:

// Result:
$terms_by_post = [
    123 => [
        (object) ['name' => 'Category A', 'object_id' => 123],
        (object) ['name' => 'Category B', 'object_id' => 123]
    ],
    456 => [
        (object) ['name' => 'Category C', 'object_id' => 456],
        (object) ['name' => 'Category E', 'object_id' => 456]
    ],
    789 => [
        (object) ['name' => 'Category D', 'object_id' => 789]
    ]
];

```

#### Why this is useful:

Before grouping, a loop like this would query the database for EACH post:

```php
// For each post, query database separately
foreach ($posts as $post) {
    $terms = wp_get_object_terms($post->ID, 'category'); // Database query!
    echo "Post {$post->ID} categories: " . implode(', ', wp_list_pluck($terms, 'name'));
}
// Result: 3 posts = 3 database queries (N+1 problem)

```
After:

```php

// One database query for all posts
$post_ids = [123, 456, 789];
$all_terms = wp_get_object_terms($post_ids, 'category'); // Single query!

```

You can get post IDs like this via `wp_list_pluck()` after any posts query, like:

```php
// Get post IDs from a query
$posts = get_posts([
    'post_type' => 'project',
    'posts_per_page' => 10,
    'meta_key' => 'featured',
    'meta_value' => 'yes'
]);
$post_ids = wp_list_pluck($posts, 'ID');
// Result: [123, 456, 789, 234, 567]
```
Here is how it would look getting posts from an ACF relationship field:

```php
$all_post_ids = [];

if (have_rows('column')) :
    while (have_rows('column')) : the_row();
        
        // If you have a relationship field for featured posts
        $featured_posts = get_sub_field('featured_posts'); // ACF relationship field
        if ($featured_posts) {
            $column_post_ids = wp_list_pluck($featured_posts, 'ID');
            $all_post_ids = array_merge($all_post_ids, $column_post_ids);
        }
        
        // Or if you're pulling posts by category
        $category = get_sub_field('post_category');
        if ($category) {
            $category_posts = get_posts([
                'category' => $category->term_id,
                'posts_per_page' => 3,
                'fields' => 'ids' // Only get IDs for performance
            ]);
            $all_post_ids = array_merge($all_post_ids, $category_posts);
        }
        
    endwhile;
endif;

```

Or how to use it on category or archive pages:

```php
// On category/archive pages
global $wp_query;
$post_ids = wp_list_pluck($wp_query->posts, 'ID');

// Or get all posts in current category
if (is_category()) {
    $category_id = get_queried_object_id();
    $post_ids = get_posts([
        'category' => $category_id,
        'posts_per_page' => -1,
        'fields' => 'ids'
    ]);

```

Here is a helper function for dynamic collection:

```php


// /inc/template-helpers.php

/**
 * Collect post IDs from various ACF field types
 */
function collect_post_ids_from_acf_fields($fields = []) {
    $post_ids = [];
    
    foreach ($fields as $field_name => $field_type) {
        $field_value = get_sub_field($field_name);
        
        switch ($field_type) {
            case 'relationship':
                if ($field_value) {
                    $post_ids = array_merge($post_ids, wp_list_pluck($field_value, 'ID'));
                }
                break;
                
            case 'taxonomy':
                if ($field_value) {
                    $term_posts = get_posts([
                        'tax_query' => [
                            [
                                'taxonomy' => $field_value->taxonomy,
                                'field' => 'term_id',
                                'terms' => $field_value->term_id
                            ]
                        ],
                        'fields' => 'ids',
                        'posts_per_page' => 5
                    ]);
                    $post_ids = array_merge($post_ids, $term_posts);
                }
                break;
                
            case 'post_object':
                if ($field_value) {
                    $post_ids[] = $field_value->ID;
                }
                break;
        }
    }
    
    return array_unique($post_ids);
}

// Usage in your template
$post_ids = collect_post_ids_from_acf_fields([
    'featured_posts' => 'relationship',
    'related_category' => 'taxonomy',
    'highlighted_post' => 'post_object'
]);

```




```php

// Group terms by post ID
$terms_by_post = [];
foreach ($all_terms as $term) {
    $terms_by_post[$term->object_id][] = $term;
}

// Now use the grouped data
foreach ($posts as $post) {
    $post_terms = $terms_by_post[$post->ID] ?? [];
    echo "Post {$post->ID} categories: " . implode(', ', wp_list_pluck($post_terms, 'name'));
}
// Result: 3 posts = 1 database query


```

