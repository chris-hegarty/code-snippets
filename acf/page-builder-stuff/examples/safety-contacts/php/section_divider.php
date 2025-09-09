<?php

	/**
	 * Section Divider
	 *
	 * Displays a horizontal divider with optional padding.
	 *
	 *
	 * @package safetycontacts
	 */


	$class_array = [];
	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );
	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;
	$classes = !empty( $class_array ) ? implode( ' ', $class_array ) : null;

?>

<section class="section divider-line <?php echo $classes ?>">
	<div class="container">
		<hr class="hr">
	</div>
</section>
