### Find Embeds in the_content()

```php



function brand_video_embed( $post_id ) {
$post = get_post( $post_id );
$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
$embeds = get_media_embedded_in_content( $content, array( 'video', 'iframe', 'object' ) );

    if( !empty($embeds) ) {
        return '<div class="jetpack-video-wrapper">' . $embeds[0] . '</div>';
    } else {
        //No embeds found
        return;
    }
}

```

```php

// Wrap iframe for embedded video in <div> with custom class.
// Add class-modifier if aspect ratio is 4/3. 
function wrap_oembed_dataparse($return, $data, $url) {

    $mod = '';

    if  (  ( $data->type == 'video' ) && ( isset($data->width) ) && ( isset($data->height) ) && ( round($data->height/$data->width, 2) == round( 3/4, 2) ) )
    {
        $mod = ' embed-responsive--4-3';
    }

    return '<div class="embed-responsive' . $mod . '">' . $return . '</div>';
}

add_filter( 'oembed_dataparse', 'wrap_oembed_dataparse', 99, 4 );


```