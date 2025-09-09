Function that gets post thumbnail.
From brand News Network.

```php

	function brandnetwork_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

```

Used in content-post-archive and content-page.

content-post-archive

```php


<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package brandNetwork
 */

/**
 * formatted date for post
 */
$pdate = get_the_date( 'm.d.Y', $post );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'heavy-border-top' ); ?>>

			<?php brandnetwork_post_thumbnail(); ?>

			<div class="post span-3">
				
				<header class="entry-header">
					
					<p class="post-meta">
						<a title="<?php echo $cat_archive_text; ?> archive" class="cat-archive" href="<?php echo $cat_archive_link; ?>"><?php echo $cat_archive_text; ?></a> 
						<time title="Posted on <?php echo $pdate; ?>" class="post-date">
							<em><?php echo $pdate; ?></em>
						</time>
					</p>

					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;
					?>
					
				</header><!-- .entry-header -->
				
				<section class="post-content">
					<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'brandnetwork' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );
					?>
				</section>

				<footer class="entry-footer">
					
				<?php

					/**
					 * Create a list of tags from "Tags", "baselocations", "countries", and "districts".
					 */
					$tag_list = get_the_tags( $post->ID ); // retrieves post tags. Each index is a term object.

					/**
					 * Retrieve all $match_baselocations and add each term object to $tag_list
					 */
					if ( !empty( $match_baselocations ) ) {
						foreach ( $match_baselocations as $bs ) $tag_list[] = get_term_by( 'slug', $bs, 'baselocation' );
					}

					/**
					 * Retrieve all $match_countries and add each term object to $tag_list
					 */
					if ( !empty( $match_countries ) ) {
						foreach ( $match_countries as $co ) $tag_list[] = get_term_by( 'slug', $co, 'country' );
					}

					/**
					 * Retrieve all $match_districts and add each term object to $tag_list
					 */
					if ( !empty( $match_districts ) ) {
						foreach ( $match_districts as $di ) $tag_list[] = get_term_by( 'slug', $di, 'district' );
					}
				
					/**
					 * Create a links array with all tags (term link/term name).
					 */
					if ( !empty( $tag_list ) ) {
						$links = array();
						foreach( $tag_list as $tag ) {
							$link = get_term_link( $tag->term_id, $tag->taxonomy );
							if ( is_wp_error( $link ) ) {
					            return $link;
					        }
					        $links[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $tag->name . '</a>';
						}

						/**
						 * Create a comma separated list of the links
						 * to output as related tags
						 */
						$tags = join( ', ', $links );
					}
				?>
				<?php if( !empty( $tags ) ) : ?>
					<div class="post-tags dotted-border-bottom light-border-top">
						<h4>Related Tags</h4>
						<p><?php echo $tags; ?></p>
					</div>
				<?php endif; ?>
					
				</footer><!-- .entry-footer -->

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

			</div><!-- .post -->

</article><!-- #post-<?php the_ID(); ?> -->



```