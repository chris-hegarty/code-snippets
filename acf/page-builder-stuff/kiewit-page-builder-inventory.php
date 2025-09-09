<?php
//Function to iterate on.
//Checks for usage of Flexible Content Layouts.
//Should output a CSV similar to kwt_locations_export_all_data() function
//Which lives in custom-post-filters.php on brand.com.

    function flexible_layout_row_usage($slug) {

        $list = array();

        $args = array(
            'post_type' => 'any',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $fcl_query = new WP_Query( $args );

        if( $fcl_query->have_posts() ) :
            while( $fcl_query->have_posts() ) : $fcl_query->the_post();

                $post_id = get_the_ID();

                // Check if the 'page_builder' Flexible Content field exists for this page.
                if( have_rows( 'page_builder', $post_id ) ) :
                    while( have_rows( 'page_builder', $post_id ) ) :
                        the_row(); // Move to the next layout.

                        $layout_name = get_row_layout();

                        // Check if the layout name is what was passed into the function.
                        // NEED TO TEST THIS
                        if( $layout_name === $slug ) :
                            $list[] = $post_id;
                            break; // No need to continue checking other layouts.
                        endif;
                    endwhile;
                endif;

            endwhile;
        endif;

        wp_reset_postdata();

        return $list;
    }

    //Use like this:

    $pages = flexible_layout_row_usage('fifty-fifty');
    if( !empty( $pages ) ) : ?>
        <div>
            <p><strong>Usage:</strong></p>
            <ul>
                <?php foreach( $pages as $page_id ) :
                echo '<li>' . esc_html( get_the_title( $page_id ) ) . ' (ID: ' . $page_id . ')' . '</li>';
            endforeach;
            ?>
            </ul>
        </div>
    <?php else : ?>
        <?php echo "None found"; ?>
    <?php endif; ?>

<?php

//==========================
//Original:
//==========================

    function flexible_layout_usage() {

        $pages_with_fifty_fifty = array();

        $args = array(
            'post_type' => 'any',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $pages_query = new WP_Query( $args );

        if( $pages_query->have_posts() ) :
            while( $pages_query->have_posts() ) : $pages_query->the_post();

                $post_id = get_the_ID();

                // Check if the 'page_builder' Flexible Content field exists for this page.
                if( have_rows( 'page_builder', $post_id ) ) :
                    while( have_rows( 'page_builder', $post_id ) ) :
                        the_row(); // Move to the next layout.

                        $layout_name = get_row_layout();

                        // Check if the layout name is 'fifty-fifty'.
                        if( $layout_name === 'fifty-fifty' ) :
                            $pages_with_fifty_fifty[] = $post_id;
                            break; // No need to continue checking other layouts.
                        endif;
                    endwhile;
                endif;

            endwhile;
        endif;

        wp_reset_postdata();

        return $pages_with_fifty_fifty;
    }

    //Then use like this:

    //    $fifty_fifty_pages = flexible_layout_usage();
    //    if( !empty( $fifty_fifty_pages ) ) : ?>
<!--        <div>-->
<!--            <p><strong>Content + Media Row Usage:</strong></p>-->
<!--            <ul>-->
<!--                --><?php //foreach( $fifty_fifty_pages as $page_id ) :
    //                    echo '<li>' . esc_html( get_the_title( $page_id ) ) . ' (ID: ' . $page_id . ')' . '</li>';
    //                endforeach;
    //                ?>
<!--            </ul>-->
<!--        </div>-->
<!--    --><?php //else : ?>
<!--        --><?php //echo "None found"; ?>
<!--    --><?php //endif; ?>

?>