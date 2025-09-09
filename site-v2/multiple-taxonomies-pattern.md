# Pattern to get multiple taxonomies

```php

       <?php
            $term = '';
            foreach( $taxonomy_list as $taxonomy ) {
                $get_post_terms = wp_get_post_terms( $current_id, $taxonomy, ['fields' => 'names'] );
                $post_terms = array_reverse($get_post_terms);
                $term = $post_terms[0];
                 error_log('current post terms: ' . print_r($post_terms, true));
                 error_log('term: ' . print_r($term, true));


                // $related_post_terms = wp_get_post_terms( $id, $taxonomy );
                // if( !empty( $related_post_terms ) && !is_wp_error( $related_post_terms ) ) {
                //     foreach( $related_post_terms as $term ) {
                //         if( in_array( $term->term_id, $current_post_terms ) ) {
                //             $first_term_name = $term->name;
                //             break 2;
                //         }
                //     }
                // }
            }
            echo $term;
        ?>



```