<?php

	/**
	 * Columns with icon, text and button/link options.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package safetycontacts
	 */

	$background_color = get_sub_field( 'background_color' );
	$text_color = get_sub_field( 'text_color' );
	$class_array = [];
	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );
	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;
	$classes = !empty( $class_array ) ? implode( ' ', $class_array ) : null;
	$i = 1;

	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');

?>

<section class="section standard-columns <?php echo $classes ?> ">
	<div class="background-container"
		<?php if( $background_color ) : ?>
			style="<?php echo 'background-color: ' . $background_color . '; ' ?>"
		<?php endif; ?>
	></div>
	<div class="container">
		<div class="ktg-grid-row">
			<?php if( have_rows( 'column' ) ):
				while( have_rows( 'column' ) ) : the_row();
					?>
					<article class="standard-column item-<?php echo $i++ ?>">
						<div class="column-wrapper h-100"
							<?php if( $text_color ) : ?>
								style="<?php echo 'color: ' . $text_color . ';' ?>"
							<?php endif; ?>
						>
							<?php
								$header = get_sub_field( 'heading' );
								$text = get_sub_field( 'text' );
								add_image_size( 'PDF Thumbnail', 164, 258, true );
								$media = get_sub_field( 'icon_or_image' );
								if( $media ) {
									$img = null;
									$pdf_thumbnail = null;
									$pdf_url = null;
									if( $media === 'icon' ) {
										$img = get_sub_field( 'icon' );
									}
									elseif( $media === 'image' ) {
										$img = get_sub_field( 'image' );
									}
									elseif( $media === 'pdf_thumbnail' ) {
										if( have_rows( 'column_links' ) ) :
											while( have_rows( 'column_links' ) ) : the_row();
												$pdf_link = get_sub_field( 'link' );
												if( $pdf_link ) :
													$pdf_url = $pdf_link['url'];
													$pdf_title = $pdf_link['title'];
													$pdf_target = $pdf_link['target'] ?: '_self';
													// Check for a relative URL and convert it to absolute if needed.
													if (strpos($pdf_url, 'http') !== 0 && strpos($pdf_url, 'https') !== 0) {
														// Add site URL to the relative path
														$pdf_url = site_url($pdf_url);
													}
													$pdf_id = attachment_url_to_postid($pdf_url);
													$pdf_thumbnail = wp_get_attachment_image( $pdf_id, 'PDF Thumbnail' );
												endif;
											endwhile;
										endif;
									}
									?>
									<div class="column-top sc-<?php echo $media ?> d-flex">
										<?php
											if( $pdf_thumbnail ) {
												echo $pdf_thumbnail;
											}
											else { ?>
												<img src="<?php echo esc_url( $img['url'] ) ?>"/>
											<?php } ?>
									</div>
								<?php } ?>

							<?php
								if( $header ) : ?>
									<h3 class="header-field"
										<?php if( $text_color ) : ?>
											style="<?php echo 'color:unset;' ?>"
										<?php endif; ?>
									>
										<?php echo $header ?>
									</h3>
								<?php
								endif;
								if( $text ): ?>
									<div class="sc-text"
										<?php if( $text_color ) : ?>
											style="<?php echo 'color: ' . $text_color . ';' ?>"
										<?php endif; ?>
									><?php echo $text ?></div>
								<?php
								endif;
								if( have_rows( "column_links" ) ): ?>
									<div class="sc-links d-flex">
										<?php while( have_rows( "column_links" ) ) : the_row();
											$link = get_sub_field( 'link' );
											if( $link ) :
												$url = $link['url'];
												$title = $link['title'];
												$target = $link['target'] ?: '_self';
											endif;
											$link_icon = get_sub_field( 'link_icon' );
											$display = get_sub_field( 'display' );
											$button_color = get_sub_field( 'button_color' );
											?>
											<a <?php if( $display ) : ?>
												class="button <?php echo $button_color ? get_button_theme_color( $button_color ) : null ?> "
											<?php endif; ?>
												href="<?php echo esc_url( $url ); ?>"
												target="<?php echo esc_attr( $target ); ?>">
												<?php echo _e( $title, 'safetycontacts' ); ?>
												<?php if( $link_icon ) : ?>
													<i class="fa fa-solid fa-<?php echo $link_icon ?>"
													   aria-hidden="true"></i>
												<?php endif; ?>
											</a>
										<?php endwhile; ?>
									</div>
								<?php endif; ?>
							<div class="file-link">

							</div>
						</div>
					</article>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>



