<?php
	/**
	 * Template part for displaying content with a WYSIWYG editor.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package ktg-builder
	 */

	$background_color = get_sub_field( 'background_color' );
	$text_color = get_sub_field( 'text_color' );
	$class_array = [];
	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );
	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;
	$classes = !empty( $class_array ) ? implode( ' ', $class_array ) : null;
?>

<section class="section standard-content <?php echo $classes ?> ">
	<div class="background-container"
		<?php if( $background_color ) : ?>
			style="<?php echo 'background-color: ' . $background_color . ';' ?>"
		<?php endif; ?>
	>
	</div>
	<div class="container">
		<div class="row">
			<div class="col col-12">
				<div class="sc-text"
					<?php if( $text_color ) : ?>
						style="<?php echo 'color: ' . $text_color . ';' ?>"
					<?php endif; ?>
				>
					<?php echo get_sub_field( 'sc_content' ); ?>
				</div>
			</div>
		</div>
	</div>
</section>


