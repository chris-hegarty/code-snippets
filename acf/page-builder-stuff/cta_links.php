<?php

	/**
	 * Template part to output a row of blocks containing links.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package kmtvj
	 */

	$class_array = [];

	$padding_top = get_sub_field( 'padding_top' );
	$padding_bottom = get_sub_field( 'padding_bottom' );

	$padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
	$padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;

	$classes = implode(' ', $class_array);

?>

<section class="section main__links <?php echo $classes ?? '' ?>">
    <div class="container">
<!--        <div class="links py-5">-->
            <div class="row justify-content-center links py-5">
				<?php
					if ( have_rows( 'links_row' ) ) :
						$small_heading = get_sub_field( 'small_headline' );
						$large_heading = get_sub_field( 'large_headline' );
						$background = get_sub_field( 'background' );

						while( have_rows( 'links_row' ) ) : the_row();
							$unique_link = get_sub_field( 'cta_link' );

							if ( ! empty( $unique_link ) ) :
								$wrap_url    = $unique_link['url'];
								$wrap_title  = $unique_link['title'];
								$wrap_target = $unique_link['target'] ?: '_self';
							endif;

							?>
                            <div class="col g-0">
                                <div class="links__link links__link--<?php echo get_sub_field( 'background' ); ?>">
                                    <div class="link">
                                        <div class="link__inner h-100 d-flex flex-column justify-content-center">
                                            <p><?php echo get_sub_field( 'small_headline' ) ?></p>
                                            <h3><?php echo get_sub_field( 'large_headline' ) ?></h3>
                                            <div class="wp-block-button">
                                                <a class="wp-block-button__link wp-element-button"
                                                   href="<?php echo $wrap_url ?>" target="<?php echo $wrap_target
												?>" rel="noreferrer noopener"><?php echo $wrap_title ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php
						endwhile;
					endif;
				?>
            </div>
<!--        </div>-->
    </div>
</section>
