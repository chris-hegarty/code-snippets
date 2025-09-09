<?php

	/**
	 * Standard Content section
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package kmtvj
	 */

	$content          = get_sub_field( 'content_editor' );
	$background_type = get_sub_field( 'background_type' );
	$background_color = get_sub_field( 'background_color' );
	$background_image = get_sub_field( 'background_image' );
	$background_opacity = get_sub_field( 'background_opacity' );
	$opacity = $background_opacity / 10;

	$link = get_sub_field( 'button' );
	if ( $link ):
		$link_title  = $link['title'];
		$link_url    = $link['url'];
		$link_target = $link['target'] ?: '_self';
	endif;

	$button_alignment = get_sub_field( 'button_alignment' );

	$class_array = [];

	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );

	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;

	$classes = !empty($class_array) ? implode(' ', $class_array) : null;

?>

<section class="section main__content standard-content <?php echo $classes ?>">

    <div class="background-container"

		<?php if($background_type == 'color' ) : ?>

            style="<?php echo 'background-color: ' . $background_color . ';' ?>"

		<?php else : ?>

			<?php if( $background_type == 'image' ) : ?>

				<?php $bg_src = $background_image ? $background_image['url'] : null; ?>

                style="

				<?php echo $bg_src ? 'background-image: url(\'' . $bg_src . '\');' : null; ?>
                        opacity:<?php echo $opacity; ?>;

                        "

			<?php endif; ?>

		<?php endif; ?>

    ></div>

    <div class="container">
        <div class="row flex-column py-5 position-relative">
            <div class="col-12">
				<?php echo $content ?>
	            <?php if ( $link ) : ?>
                    <div class="wp-block-button" style="<?php echo get_button_alignment_style( $button_alignment ); ?>">
                        <a href="<?php echo $link_url ?>" class="wp-block-button__link wp-element-button" target="<?php echo
			            $link_target ?>" rel="noreferrer noopener"><?php echo $link_title ?></a>
                    </div>
	            <?php endif; ?>
            </div>
        </div>
    </div>
</section>