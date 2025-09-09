```php


// * Move the excerpt meta box above the content editor on the edit screen for posts..
// *
// * This function removes the default "postexcerpt" meta box from its original position
// * and places it after the post title on the edit screen.
// *
// * @param WP_Post $post The current post object.
// * @return void
// */


//function move_excerpt_meta_box($post) {
//
//    echo '<pre><p>BEFORE REMOVE</p>';
//    var_dump($post);
//    echo '</pre>';
//
//    remove_meta_box( 'postexcerpt' , 'all' , 'normal' );
//
//    echo '<pre><p>AFTER REMOVE</p>';
//    var_dump($post);
//    echo '</pre>';
//
//    add_meta_box('postexcerpt' , 'post');
//    ?>
<!--    <div class="postbox" style="margin-bottom: 0;">-->
<!--        <h3 class="hndle"><span>Post Excerpt</span></h3>-->
<!--        <p class="inside"><span>(If left blank, WordPress will attempt to use text from the 1st paragraph in the-->
<!--                content editor.)-->
<!--            </span></p>-->
<!--        <div class="inside">-->
<!--            <label class="screen-reader-text" for="excerpt">--><?php //_e('Excerpt') ?><!--</label>-->
<!--            <textarea rows="1" cols="40" name="excerpt" id="excerpt">-->
<!--              --><?php //echo $post->post_excerpt; ?>
<!--         </textarea>-->
<!--        </div>-->
<!--    </div>-->
<?php //}

//add_action('edit_form_after_title', 'move_excerpt_meta_box',10,1);

//    Giving this a try:

    /* -----------------------------------------
 * Put excerpt meta-box before editor
 * ----------------------------------------- */
//    function my_add_excerpt_meta_box( $post_type ) {
//        if ( in_array( $post_type, array( 'post', 'page' ) ) ) {
//            add_meta_box(
//                'postexcerpt', __( 'Excerpt' ), 'post_excerpt_meta_box', $post_type, 'test', // change to something other then normal, advanced or side
//                'high'
//            );
//        }
//    }
//    add_action( 'add_meta_boxes', 'my_add_excerpt_meta_box' );

//    function my_run_excerpt_meta_box() {
        # Get the globals:
//        global $post, $wp_meta_boxes;

        # Output the "advanced" meta boxes:
//        do_meta_boxes( get_current_screen(), 'test', $post );

    }

//    add_action( 'edit_form_after_title', 'my_run_excerpt_meta_box' );

//    function my_remove_normal_excerpt() { /*this added on my own*/
//        remove_meta_box( 'postexcerpt' , 'post' , 'normal' );
//    }
//    add_action( 'admin_menu' , 'my_remove_normal_excerpt' );

```

