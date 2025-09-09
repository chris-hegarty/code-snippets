<?php

	/**
	 * Template part for displaying the home page hero section.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/
	 *
	 * @link https://www.advancedcustomfields.com/resources/create-your-first-acf-block/
	 *
	 * @package kmtvj
	 */

	$heading          = get_sub_field( 'heading' );
    $text_editor      = get_sub_field( 'text_editor' );

	$background_type = get_sub_field( 'background_type' );
	$background_image = get_sub_field( 'background_image' );
	$background_color = get_sub_field( 'background_color' );
	$background_opacity = get_sub_field( 'background_opacity' );
	$opacity = $background_opacity / 10;

	$button           = get_sub_field( 'button' );
	$button_alignment = get_sub_field( 'button_alignment' );

	if ( $button ) :
		$url    = $button['url'];
		$title  = $button['title'];
		$target = $button['target'] ?: '_self';
	endif;

    $class_array = [];

	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );

	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;

	$classes = !empty($class_array) ? implode(' ', $class_array) : null;

?>

<section class="section main__hero section__hero home-hero <?php echo $classes ?>">

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

    <div class="hero">
        <div class="container h-100">
            <div class="hero__content">
				<?php if ( $heading ) : ?>
                    <h1 class="hero__heading"><?php echo $heading ?></h1>
				<?php endif; ?>
                <div class="p-3 py-5 p-md-5 align-self-center w-100">
					<?php echo $text_editor ?>
	                <?php if ( $button ) : ?>
                        <div class="wp-block-button" style="<?php echo get_button_alignment_style( $button_alignment ); ?>">
                            <a class="wp-block-button__link wp-element-button" href="<?php echo $url ?>"><?php echo $title
				                ?></a>
                        </div>
	                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
