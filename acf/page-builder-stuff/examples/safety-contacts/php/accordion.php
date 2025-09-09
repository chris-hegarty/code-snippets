<?php

	/**
	 * Template part for displaying accordions
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package kwt
	 */

	$group_heading = get_sub_field( 'group_heading' );
	$group_slug = sanitize_title( $group_heading );
	$background_color = get_sub_field( 'background_color' );
	$text_color = get_sub_field( 'text_color' );
	$class_array = [];
	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );
	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;
	$classes = !empty( $class_array ) ? implode( ' ', $class_array ) : null;

?>

<section class="section accordions <?php echo $classes ?>">
	<div class="background-container"
		<?php if( $background_color ) : ?>
			style="<?php echo 'background-color: ' . $background_color . ';' ?>"
		<?php endif; ?>
	>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if( $group_heading ) : ?>
					<div class="info-section">
						<h2 class="section-title section-heading"
							<?php if( $text_color ) : ?>
								style="<?php echo 'color: ' . $text_color . ';' ?>"
							<?php endif; ?>
						><?php echo esc_html( $group_heading ); ?>
						</h2>
					</div>
				<?php endif; ?>
				<div class="accordion">
					<?php
						if( have_rows( 'items' ) ):
							while( have_rows( 'items' ) ) : the_row();
								$item_title = get_sub_field( 'heading' );
								$item_slug = sanitize_title( $item_title );
								$item_content = get_sub_field( 'content' );
								$item_index = get_row_index();
								$item_id = $item_slug . '-' . $item_index;
								?>
								<div class="accordion-item">
									<h3 class="accordion-header m-0">
										<button class="accordion-button focus-ring collapsed"
												type="button"
												data-bs-toggle="collapse"
												data-bs-target="#<?php echo $item_id ?>"
												aria-expanded="false"
												aria-controls="#<?php echo $item_id ?>">
											<?php echo $item_title ?>
										</button>
									</h3>
									<div id="<?php echo $item_id ?>"
										 class="accordion-collapse collapse"
										 data-bs-parent="#<?php echo $group_slug ?>">
										<div class="accordion-body">
											<?php echo $item_content ?>
										</div>
									</div>
								</div>
							<?php
							endwhile;
						endif;
					?>
				</div>
			</div>
		</div>
	</div>
</section>
