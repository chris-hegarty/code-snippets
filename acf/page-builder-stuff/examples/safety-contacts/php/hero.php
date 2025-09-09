<?php

	/**
	 * Template part for displaying the Hero section on the homepage..
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package ktg-builder
	 */

	$background_type = get_sub_field( 'background_type' );
	$background_image = get_sub_field( 'background_image' );
	$bg_src = $background_image ? $background_image['url'] : null;
	$background_color = get_sub_field( 'background_color' );
	$background_overlay = get_sub_field( 'background_overlay' );
	$overlay = ($background_overlay === 'light') ? '255,255,255' : '0,0,0';
	$background_opacity = get_sub_field( 'background_opacity' );
	$opacity = $background_opacity / 10;
	if( $background_color && empty( $background_image ) ) :
		$classes[] = 'bg-' . $background_color;
	endif;
	$heading = get_sub_field( 'heading' );
	$content = get_sub_field( 'content' );
	$link = get_sub_field( 'link' );
	if( $link ) :
		$url = $link['url'];
		$title = $link['title'];
		$target = $link['target'] ?: '_self';
	endif;
	$button_color = get_sub_field( 'button_color' );
	$text_color = get_sub_field( 'text_color' );
	$class_array = [];
	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );
	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;
	$classes = !empty( $class_array ) ? implode( ' ', $class_array ) : null;
?>

<section class="section hero container-fluid <?php echo $classes ?>">
	<div class="background-container"
		<?php if( $background_type == 'color' ) : ?>
			style="<?php echo 'background-color: ' . $background_color . ';' ?>"
		<?php else : ?>
			<?php if( $background_type == 'image' ) : ?>
				style="background-image:
					linear-gradient(
					rgba(<?php echo $overlay ?>,<?php echo $opacity ?>),
					rgba(<?php echo $overlay ?>,<?php echo $opacity ?>)
					),
					url('<?php echo $bg_src ?>');
					"
			<?php endif; ?>
		<?php endif; ?>
	></div>
	<div class="container">
		<div class="row">
			<div class="col col-12 col-lg-6">
				<div class="heading-container">
					<h1 class="hero-heading"
						<?php if( $text_color ) : ?>
							style="<?php echo 'color: ' . $text_color . ';' ?>"
						<?php endif; ?>
					>
						<?php echo esc_html( $heading ); ?>
					</h1>
				</div>
				<div class="text-container"
					<?php if( $text_color ) : ?>
						style="<?php echo 'color: ' . $text_color . ';' ?>"
					<?php endif; ?>
				><?php echo $content ?></div>
				<?php if( $link ): ?>
					<div class="link-container">
						<a class="button <?php echo get_button_theme_color( $button_color ) ?>"
						   href="<?php echo esc_url( $url ); ?>"
						   target="<?php echo esc_attr( $target ); ?>" rel="noopener noreferrer"><?php echo
							esc_html( $title ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

