# Patterns for working with taxonomies and terms



Changes Made:
Removed debug output: Eliminated the var_dump statements that were cluttering the output.

Added hierarchical taxonomy filtering: Now only checks taxonomies that are hierarchical using get_object_taxonomies($post_type, 'objects') and checking the hierarchical property.

Implemented parent-child term logic: The code now:

Loops through terms assigned to the post
For each child term (terms with parent != 0), finds its parent term
Checks if the parent term is also assigned to the post
If a parent term with children is found, it uses that as the $first_term
Falls back to the first term from any hierarchical taxonomy if no parent-child relationship is found
Uncommented the output: The term name is now properly displayed in the slide using $first_term->name.

How it works:
If a post has both a "Market" parent term and "Market Sub-category" child terms assigned, it will display the parent "Market" term
If no parent-child relationship exists, it falls back to the first term from the first hierarchical taxonomy
Only hierarchical taxonomies are considered (non-hierarchical ones like tags are ignored)
The code now properly identifies and displays the parent term when both parent and child terms are assigned to a post, which was your main goal.

```php
<?php

    /**
     * Template part for displaying a carousel of related posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package brandDev
     */

    $header = get_field( 'section_heading' );
    $content = get_field( 'section_content' );
    $current_post_id = get_the_id();
    $post_type = get_post_type( $current_post_id);
    $post_type_string = ucfirst( $post_type );
    $default_header = "Related {$post_type_string} Experience";

    


?>

<section class="carousel-related carousel-cards">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9 content-container section-top">
                <span></span>
                <h3 class="section-header"><?php echo $header ?: $default_header ?></h3>
                <div class="section-content"><?php echo $content ?></div>
            </div>
            <div class="col-12 col-lg-3 related-nav">
                <div class="button-container">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!-- Begin swiperRelated-->
        <div id="swiperRelated" class="swiper hide-left">
            <!-- Begin swiper-wrapper-->
            <div class="swiper-wrapper">
                <?php
                    // Check which content type to display: default or custom.
                    // If 'custom', we get the ACF Relationship field.
                    // If 'default', filter by the first taxonomy that has terms assigned to this post.
                    $posts_list = get_field( 'carousel_content' );

                    if( $posts_list === 'custom' ) {

                        $related_posts = get_field( 'related_posts' );

                        foreach( $related_posts as $post_object ) {

                            if( $post_object ) {
                                // Get post data
                                $post = $post_object;
                                $header = $post->post_title;
                                $id = $post->ID;
                                // Get first slide's image for the card background
                                $slides = get_field( 'cpt_slides', $id );
                                $bg_url = '';
                                if( $slides && !empty( $slides[0]['image']['url'] ) ) {
                                    $bg_url = $slides[0]['image']['url'];
                                }
                                // Get the term for this post (using first market term)
                                $post_terms = wp_get_post_terms( $post->ID, 'tax_markets' );
                                $custom_term = !empty( $post_terms ) ? $post_terms[0] : null;
                                ?>

                                <!-- Begin custom slide  -->
                                <div class="swiper-slide">
                                    <div class="related">
                                        <picture class="background">
                                            <img class="related-image" src="<?php echo $bg_url ?>">
                                        </picture>
                                        <div class="slide-content">
                                            <div class="cpt-taxonomy">
                                                <p><?php echo $custom_term ? $custom_term->name : ''; ?></p>
                                            </div>
                                            <div class="cpt-info">
                                                <h4><?php echo $header ?></h4>
                                                <a href="<?php echo get_permalink( $post->ID ); ?>" target="_blank"
                                                   class="icon-link icon-link-hover stretched-link">
                                                    Read More
                                                    <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end custom slide-->

                            <?php } ?>
                            <!-- end custom if post object check  -->

                        <?php } ?>
                        <!-- end custom foreach loop  -->

                    <?php }
                    // end post list selection = "custom" 

                    if($posts_list === 'default') {

                    $current_post_id = get_the_ID();
                    $post_type = get_post_type( $current_post_id );
                    $related_posts = get_related_posts( $current_post_id, $post_type, 16, [] );

                    foreach( $related_posts as $related_post ) {

                        $id = $related_post->ID;
                        $related_post_type = get_post_type( $id );
                        $header = $related_post->post_title;

                        
                        // Goal: Get the first term that is hierarchical AND has child terms assigned to it. 
                        // For example, if a post of post type "project" has a Market term and one or more child Market terms assigned to it, get that parent Market term and output it on line 164.

                        $first_term = null;
                        $taxonomies = get_object_taxonomies($post_type, 'objects');
                        
                        foreach($taxonomies as $taxonomy) {
                            // Only check hierarchical taxonomies
                            if(!$taxonomy->hierarchical) {
                                continue;
                            }
                            
                            $id = $related_post->ID;
                            $terms = get_the_terms($id, $taxonomy->name);

                            if($terms && !is_wp_error($terms)) {
                                // Look for parent terms that have children assigned to this post
                                foreach($terms as $term) {
                                    // Check if this term has a parent (meaning it's a child term)
                                    if($term->parent != 0) {
                                        // Get the parent term
                                        $parent_term = get_term($term->parent, $taxonomy->name);
                                        if($parent_term && !is_wp_error($parent_term)) {
                                            // Check if this parent term is also assigned to the post
                                            $parent_assigned = false;
                                            foreach($terms as $check_term) {
                                                if($check_term->term_id == $parent_term->term_id) {
                                                    $parent_assigned = true;
                                                    break;
                                                }
                                            }
                                            // If parent is assigned and has children, use it
                                            if($parent_assigned) {
                                                $first_term = $parent_term;
                                                break 2; // Break out of both loops
                                            }
                                        }
                                    }
                                }
                                
                                // If no parent-child relationship found, just use the first term from hierarchical taxonomy
                                if(!$first_term) {
                                    $first_term = $terms[0];
                                    break;
                                }
                            }
                        }
                            
                        // Get first slide's image for the card background
                        $slides = get_field( 'cpt_slides', $id );
                        $bg_url = '';
                            if( $slides && !empty( $slides[0]['image']['url'] ) ) {
                                $bg_url = $slides[0]['image']['url'];
                            }
                        ?>

                            <!-- Begin DEFAULT slide -->

                            <div class="swiper-slide">
                                <div class="related">
                                    <picture class="background">
                                        <img class="related-image" src="<?php echo $bg_url ?>">
                                    </picture>
                                    <div class="slide-content">
                                        <div class="cpt-taxonomy">
                                            <p><?php echo $first_term ? $first_term->name : ''; ?></p>
                                        </div>
                                        <div class="cpt-info">
                                            <h4><?php echo $header ?></h4>
                                            <a href="<?php echo get_permalink( $related_post->ID ); ?>" target="_blank"
                                               class="icon-link icon-link-hover stretched-link">
                                                Read More
                                                <!-- <i class="bi bi-arrow-right-short d-flex align-items-center"></i> -->
                                                <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End DEFAULT slide -->
                    <?php } ?>
                    <!-- eND FOREACH  -->

                <?php } ?>
                <!-- End default conditional -->
            
            </div>
            <!-- Close swiper wrapper -->
        
        </div>
        <!-- End the swiper-->

    </div>
    <!-- Close the container -->

</section>
<!-- Close the section -->
```

```php


function get_related_posts( $post_id = null, $post_type = null, $limit = 16, $args = [] ) {

        $defaults = [
            'taxonomies' => array()
        ];

        $default_args = wp_parse_args($args, $defaults);

        if(!$post_id || !$post_type) {
            return array();
        }

        // Get all the taxonomies for the post_type
        $taxonomies = get_object_taxonomies($post_type, 'objects');

        if(empty($taxonomies)) {
            return array();
        }

        $hierarchical_taxonomies = array();

        foreach($taxonomies as $taxonomy){
            if($taxonomy->hierarchical){
                $hierarchical_taxonomies[] = $taxonomy->name;
            }
        }

        if(empty($hierarchical_taxonomies)) {
            return array();
        }

        // Set up terms arrays
        $all_term_ids = [];
        $tax_query = [];

        foreach($hierarchical_taxonomies as $taxonomy) {
            $terms = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'all'));

            if(!is_wp_error($terms) && !empty($terms)) {
                $taxonomy_terms = [];
                
                foreach($terms as $term) {
                    // Add the current term
                    $taxonomy_terms[] = $term->term_id;
                    
                    // Add parent terms if this is a child term
                    if($term->parent != 0) {
                        $ancestors = get_ancestors($term->term_id, $taxonomy);
                        if(!empty($ancestors)) {
                            $taxonomy_terms = array_merge($taxonomy_terms, $ancestors);
                        }
                    }
                    
                    // Add child terms if this term has children
                    $children = get_term_children($term->term_id, $taxonomy);
                    if(!is_wp_error($children) && !empty($children)) {
                        $taxonomy_terms = array_merge($taxonomy_terms, $children);
                    }
                }

                // Remove duplicates
                $taxonomy_terms = array_unique($taxonomy_terms);
                
                if(!empty($taxonomy_terms)) {
                    $tax_query[] = [
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $taxonomy_terms,
                        'operator' => 'IN'
                    ];
                }
            }
        }

        // If no terms found, return empty array
        if(empty($tax_query)) {
            return array();
        }

        // Set relation to OR if multiple taxonomies
        if(count($tax_query) > 1) {
            $tax_query['relation'] = 'OR';
        }

        $query_args = [
            'post_type' => $post_type,
            'posts_per_page' => $limit,
            'post__not_in' => array($post_id),
            'update_post_meta_cache' => false,
            'update_post_term_cache' => true,
            'no_found_rows' => true,
            'tax_query' => $tax_query,
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        $query_args = wp_parse_args($default_args, $query_args);

        $related_query = new WP_Query($query_args);
        $related_posts = $related_query->posts;

        if(empty($related_posts)) {
            return array();
        }

        return $related_posts;
    }

```

