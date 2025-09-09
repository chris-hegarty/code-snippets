```php

/**
* Get primary term for a post
*
* @param int    $post_id   Post ID
* @param string $taxonomy  Taxonomy name
* @return string           Term name or empty string
  */
  
  function branddev_get_primary_term($post_id, $taxonomy = 'tax_markets') {
  $terms = wp_get_post_terms($post_id, $taxonomy);
  return !empty($terms) ? $terms[0]->name : '';
  }
  
  ```
```php
/**
* Get all child terms of a parent term
*
* @param string|int $parent_term Parent term ID or slug
* @param string     $taxonomy    Taxonomy name (default: tax_markets)
* @param array      $args        Optional arguments to pass to get_terms()
* @return array                  Array of term objects
  */
  function kwd_get_child_terms($parent_term, $taxonomy = 'tax_markets', $args = []) {
  // If slug is provided, get the term ID
  if (!is_numeric($parent_term)) {
  $parent = get_term_by('slug', $parent_term, $taxonomy);
  $parent_term = $parent ? $parent->term_id : 0;
  }

  $defaults = [
  'taxonomy' => $taxonomy,
  'parent' => $parent_term,
  'hide_empty' => false,
  ];

  $args = array_merge($defaults, $args);
  return get_terms($args);
  }
```

```php

/**
 * Get a post's term breadcrumb (hierarchical path)
 *
 * @param int    $post_id  Post ID
 * @param string $taxonomy Taxonomy name (default: tax_markets)
 * @param string $separator Separator between terms (default: ' > ')
 * @return string          Breadcrumb string (e.g., "Building > Commercial")
 */
function kwd_get_term_breadcrumb($post_id, $taxonomy = 'tax_markets', $separator = ' > ') {
    $terms = wp_get_post_terms($post_id, $taxonomy, ['fields' => 'all']);
    
    if (empty($terms) || is_wp_error($terms)) {
        return '';
    }
    
    // Get the primary term (first one)
    $primary_term = $terms[0];
    $breadcrumb_parts = [];
    
    // Walk up the hierarchy and collect ancestors
    $term_id = $primary_term->term_id;
    $ancestors = get_ancestors($term_id, $taxonomy, 'taxonomy');
    
    // Put ancestors in the right order (top level first)
    $ancestors = array_reverse($ancestors);
    
    // Get names for all ancestors
    foreach ($ancestors as $ancestor_id) {
        $ancestor = get_term($ancestor_id, $taxonomy);
        if ($ancestor && !is_wp_error($ancestor)) {
            $breadcrumb_parts[] = esc_html($ancestor->name);
        }
    }
    
    // Add the current term
    $breadcrumb_parts[] = esc_html($primary_term->name);
    
    return implode($separator, $breadcrumb_parts);
}
```

```php
/**
 * Get all posts grouped by taxonomy terms
 * 
 * @param string $taxonomy    Taxonomy name
 * @param string $post_type   Post type or array of post types
 * @param array  $query_args  Additional query args
 * @return array              Associative array of terms and their posts
 */
function kwd_get_posts_by_terms($taxonomy = 'tax_markets', $post_type = 'project', $query_args = []) {
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => true
    ]);
    
    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }
    
    $result = [];
    
    foreach ($terms as $term) {
        $defaults = [
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $term->term_id
                ]
            ]
        ];
        
        $args = array_merge($defaults, $query_args);
        $posts = get_posts($args);
        
        if (!empty($posts)) {
            $result[$term->term_id] = [
                'term' => $term,
                'posts' => $posts
            ];
        }
    }
    
    return $result;
}

```

```php
/**
 * Find related posts sharing parent terms (higher level relationship)
 *
 * @param int    $post_id   Current post ID
 * @param string $taxonomy  Taxonomy to use
 * @param int    $count     Number of posts to return
 * @return array            Array of related post objects
 */
function kwd_get_posts_by_parent_terms($post_id, $taxonomy = 'tax_markets', $count = 6) {
    $terms = wp_get_post_terms($post_id, $taxonomy);
    
    if (empty($terms) || is_wp_error($terms)) {
        return [];
    }
    
    // Get parent terms of all assigned terms
    $parent_term_ids = [];
    foreach ($terms as $term) {
        // If term has parent, use it
        if ($term->parent > 0) {
            $parent_term_ids[] = $term->parent;
        } else {
            // If it's a top-level term, use it directly
            $parent_term_ids[] = $term->term_id;
        }
    }
    
    // Remove duplicates
    $parent_term_ids = array_unique($parent_term_ids);
    
    if (empty($parent_term_ids)) {
        return [];
    }
    
    // Get posts that share the parent terms
    $args = [
        'post_type' => get_post_type($post_id),
        'posts_per_page' => $count,
        'post__not_in' => [$post_id], // Exclude current post
        'tax_query' => [
            [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $parent_term_ids,
                'operator' => 'IN',
            ]
        ]
    ];
    
    return get_posts($args);
}

```

```php


/**
 * Create hierarchical term select field based on post type
 * 
 * @param string $post_type The post type to build fields for
 */
function kwd_build_term_filter_fields($post_type = 'project') {
    // Get taxonomies for this post type
    $taxonomies = get_object_taxonomies($post_type, 'objects');
    
    if (empty($taxonomies)) {
        return;
    }
    
    // For each hierarchical taxonomy
    foreach ($taxonomies as $tax_name => $tax_object) {
        if (!$tax_object->hierarchical) {
            continue;
        }
        
        // Get top level terms
        $parent_terms = get_terms([
            'taxonomy' => $tax_name,
            'parent' => 0,
            'hide_empty' => false
        ]);
        
        if (empty($parent_terms)) {
            continue;
        }
        
        // Create JS/Ajax to handle cascading selection
        add_action('wp_footer', function() use ($tax_name, $parent_terms) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                // Trigger change when a parent term is selected
                $('#filter-<?php echo esc_attr($tax_name); ?>-parent').on('change', function() {
                    var parentId = $(this).val();
                    if (!parentId) {
                        $('#filter-<?php echo esc_attr($tax_name); ?>-child').empty().hide();
                        return;
                    }
                    
                    // AJAX to get child terms
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            action: 'kwd_get_child_terms',
                            parent: parentId,
                            taxonomy: '<?php echo esc_attr($tax_name); ?>',
                            security: '<?php echo wp_create_nonce('kwd_term_filter'); ?>'
                        },
                        success: function(response) {
                            if (response.success && response.data) {
                                var $select = $('#filter-<?php echo esc_attr($tax_name); ?>-child');
                                $select.empty().append('<option value="">Any</option>');
                                
                                $.each(response.data, function(id, name) {
                                    $select.append('<option value="' + id + '">' + name + '</option>');
                                });
                                
                                $select.show();
                            }
                        }
                    });
                });
            });
            </script>
            <?php
        });
    }
}

/**
 * AJAX handler for getting child terms
 */
function kwd_ajax_get_child_terms() {
    check_ajax_referer('kwd_term_filter', 'security');
    
    $parent_id = isset($_POST['parent']) ? intval($_POST['parent']) : 0;
    $taxonomy = isset($_POST['taxonomy']) ? sanitize_text_field($_POST['taxonomy']) : '';
    
    if (!$parent_id || empty($taxonomy)) {
        wp_send_json_error();
    }
    
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'parent' => $parent_id,
        'hide_empty' => false
    ]);
    
    if (empty($terms) || is_wp_error($terms)) {
        wp_send_json_error();
    }
    
    $result = [];
    foreach ($terms as $term) {
        $result[$term->term_id] = $term->name;
    }
    
    wp_send_json_success($result);
}
add_action('wp_ajax_kwd_get_child_terms', 'kwd_ajax_get_child_terms');
add_action('wp_ajax_nopriv_kwd_get_child_terms', 'kwd_ajax_get_child_terms');


```

-Do we need posts by multiple terms of a single taxonomy? or
-Do we need posts by multiple taxonomies?


