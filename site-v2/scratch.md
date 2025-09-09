```php

   $current_id = get_the_ID();
                        $post_type = get_post_type( $current_id );
                        $taxonomy_list = get_object_taxonomies( $post_type );
                        $taxonomy_to_use = 'tax_markets'; // Default fallback

                        // Find the first taxonomy that has terms assigned to this post
                        foreach($taxonomy_list as $taxonomy) {
                            $terms = get_the_terms($current_id, $taxonomy);
                            if($terms && !is_wp_error($terms) && !empty($terms)) {
                                $taxonomy_to_use = $taxonomy;
                                break;
                            }
                        }

                        $current_post_terms = wp_get_post_terms( $current_id, $taxonomy_to_use, array('fields' => 'slugs') );

                        if( !empty( $current_post_terms ) ) {
                            // Only get posts that share the same term(s) as the current post
                            $default_args = array(
                                'post_type' => 'project',
                                'posts_per_page' => -1,
                                'post__not_in' => array($current_id), // Exclude current post
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $taxonomy_to_use,
                                        'field' => 'slug',
                                        'terms' => $current_post_terms,
                                    )
                                )
                            );

                            $related_posts = get_posts( $default_args );

                            // Group posts by their market terms for the carousel
                            // TODO: Refactor to use with any tax/term
                            $posts_by_term = array();
                            foreach( $related_posts as $post ) {
                                $post_terms = wp_get_post_terms( $post->ID, 'tax_markets' );
                                foreach( $post_terms as $term ) {
                                    if( in_array( $term->slug, $current_post_terms ) ) {
                                        if( !isset( $posts_by_term[$term->term_id] ) ) {
                                            $posts_by_term[$term->term_id] = array(
                                                'term' => $term,
                                                'posts' => array()
                                            );
                                        }
                                        $posts_by_term[$term->term_id]['posts'][] = $post;
                                    }
                                }
                            }

                            // Now loop through each term and its posts
                            foreach( $posts_by_term as $term_data ) {
                                $term = $term_data['term'];
                                // For each term, display its posts
                                foreach( $term_data['posts'] as $post ) {
                                    $header = $post->post_title;
                                    $id = $post->ID;
                                    // Get first slide's image for the card background
                                    $slides = get_field( 'cpt_slides', $id );
                                    $bg_url = '';
                                    if( $slides && !empty( $slides[0]['image']['url'] ) ) {
                                        $bg_url = $slides[0]['image']['url'];
                                    }
                                    ?>
                                    
                                                                <?php } // close posts foreach loop ?>
                        <?php } // close terms foreach ?>
                        
                        <?php } ?>




```