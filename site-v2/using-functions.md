```php

/**
 * Get taxonomy for different post types
 */
function get_post_taxonomy_term($post, $term_object = null) {
    if ($term_object && is_object($term_object) && isset($term_object->name) && !empty($term_object->taxonomy)) {
        return $term_object->name;
    }
    
    $post_type = get_post_type($post);
    $taxonomy_map = [
        'article' => 'tax_topics',
        'project' => 'tax_markets',
        'tag' => 'post_tag'
    ];
    
    $taxonomy = $taxonomy_map[$post_type] ?? 'category';
    $terms = get_the_terms($post, $taxonomy);
    
    return !empty($terms) && !is_wp_error($terms) ? $terms[0]->name : '';
}

/**
 * Get first slide image URL
 */
function get_first_slide_image($post_id) {
    $slides = get_field('cpt_slides', $post_id);
    
    if (!$slides || empty($slides[0]['image']['url'])) {
        return '';
    }
    
    foreach ($slides as $slide) {
        if ($slide['media_type'] === "image" && !empty($slide['image']['url'])) {
            return $slide['image']['url'];
        }
    }
    
    return '';
}

<?php
/**
 * Generic template for displaying custom post type posts
 */

global $post, $brand_post_counter, $term_object;

if (!isset($brand_post_counter)) {
    $brand_post_counter = 0;
}

$i = $brand_post_counter;
$id = get_the_ID();
$title = get_field('cpt_hero_title', $id) ?: $post->post_title;
$src = get_first_slide_image($id);
$term = get_post_taxonomy_term($post, $term_object);
$post_type = get_post_type($id);

// Add specific CSS classes based on post type
$loop_class = $post_type . '-loop';
if ($post_type === 'article') {
    $loop_class .= ' articles-loop';
} elseif ($post_type === 'tag') {
    $loop_class .= ' posts-loop';
}
?>

<article class="col-12 col-lg-<?php echo $i <= 3 ? "6" : "4" ?> cards <?php echo $loop_class; ?>">
    <div class="card h-100">
        <div class="cpt-taxonomy">
            <p><?php echo esc_html($term); ?></p>
        </div>
        <?php if (!empty($src)) : ?>
            <div class="image-container <?php echo $i <= 3 ? "ar-6136" : "ar-4027" ?>">
                <img class="img-fluid" src="<?php echo esc_url($src); ?>" alt="">
            </div>
        <?php endif; ?>
        <div class="card-body">
            <h4 class="card-title"><?php echo esc_html($title); ?></h4>
            <div class="link-container">
                <a class="icon-link icon-link-hover stretched-link" 
                   href="<?php echo esc_url(get_permalink($id)); ?>"
                   <?php echo $post_type === 'article' ? 'target="_blank"' : ''; ?>>
                    View <?php echo esc_html($post_type); ?>
                    <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                </a>
            </div>
        </div>
    </div>
</article>

?>

```

```php


//Filter tags by post type if needed.
// In archive.php, around line 82
$requested_post_type = get_query_var('post_type') ?: $_GET['post_type'] ?? null;

if (is_tag()) {
    if ($requested_post_type && post_type_exists($requested_post_type)) {
        // Filter by specific post type
        $template_part = 'content-' . $requested_post_type;
        
        // Modify the main query to filter by post type
        global $wp_query;
        $wp_query->set('post_type', $requested_post_type);
        
        get_template_part('template-parts/custom-post-types/' . $template_part);
    } else {
        // Show all post types (current behavior)
        get_template_part('template-parts/custom-post-types/content', 'tag');
    }
} else {
    get_template_part('template-parts/custom-post-types/content', get_post_type());
}

```

URLs would look like:

/tag/tag-name-one/?post_type=article
/tag/tag-name-one/?post_type=project