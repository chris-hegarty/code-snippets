```php

function be_custom_loop() { 

	$tags = wp_get_post_tags( get_the_ID() );
	if( ! $tags )
		return;
		
	$tags = wp_list_pluck( $tags, 'term_id' );

	$args = array(
		'tag__in'             => $tags,
		'post__not_in'        => array( get_the_ID() ),
		'posts_per_page'      => 5,
		'ignore_sticky_posts' => true,
	);
	
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ):
	
		echo '<h3>Related Posts</h3>';
		while( $loop->have_posts() ): $loop->the_post();
			echo '<p><a href="' . get_permalink() . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => false ) ) . '">' . get_the_title() . '</a></p>';
		endwhile;
		
	endif;
	wp_reset_postdata();

}


```

## Get all terms with specific arguments:

```php



$args = array(
'taxonomy' => 'post_tag',
'hide_empty' => false,
);
$terms = get_terms( $args );
foreach ( $terms as $term ) {
echo $term->name;
}

```