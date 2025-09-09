<?php

    /**
     * Two-column content plus media module
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package safetycontacts
     */

    $header = get_sub_field( 'heading' );
    $text = get_sub_field( 'text' );
    $link = get_sub_field( 'link' );
    if( $link ) :
        $url = $link['url'];
        $title = $link['title'];
        $target = $link['target'] ?: '_self';
    endif;
    $content_background = get_sub_field('content_background_color');
    $text_color = get_sub_field('text_color');
    $img = get_sub_field( 'image' );
    if( $img ) :
        $src = $img['url'];
//        $alt = acf_set_alt( $img );
    endif;
    $background_color = get_sub_field( 'background_color' );
    $layout = get_sub_field( 'layout' );
    $class_array = [];
    $padding_top = get_sub_field( 'padding_top' );
    $padding_bottom = get_sub_field( 'padding_bottom' );
    $padding_top ? $class_array[] = 'padding-top-' . $padding_top : null;
    $padding_bottom ? $class_array[] = 'padding-bottom-' . $padding_bottom : null;
    $classes = !empty( $class_array ) ? implode( ' ', $class_array ) : null;

?>

<section class="section content-media <?php echo $classes ?>">
    <div class="background-container"
        <?php if( $background_color ) : ?>
            style="<?php echo 'background-color: ' . $background_color . ';' ?>"
        <?php endif; ?>
    ></div>
    <div class="container">
        <div class="row <?php echo $layout ?>">
            <div class="col col-12 col-md-6 column-content p-0 m-0">
                <div class="column-wrapper" style="background-color: <?php echo $content_background; ?>">
                    <?php if( $header ) : ?>
                        <h2 class="header-field"
                            <?php if( $text_color ) : ?>
                                style="<?php echo 'color: ' . $text_color . ';' ?>"
                            <?php endif; ?>
                        ><?php echo $header ?>
                        </h2>
                    <?php
                    endif;
                        if( $text ): ?>
                            <div class="sc-text"
                                <?php if( $text_color ) : ?>
                                    style="<?php echo 'color: ' . $text_color . ';' ?>"
                                <?php endif; ?>
                            > <?php echo $text ?></div>
                        <?php
                        endif;
                        if( $link ) : ?>
                            <div class="sc-links">
                                <a
                                    class="column-link icon-link icon-link-hover"
                                    href="<?php echo esc_url( $url ); ?>"
                                    target="<?php echo esc_attr( $target ); ?>">
                                    <?php echo $title ?>
                                    <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                </div>
            </div>
            <?php if( $img ) : ?>
                <div class="col col-12 col-md-6 column-media p-0 m-0">
                    <div class="column-wrapper">
                        <img src="<?php echo $src ?>" alt="<?php echo "alt" ?>" width="600" height="400" loading="lazy">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
