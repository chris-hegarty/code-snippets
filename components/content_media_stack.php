<?php
    /**
     * Template part for displaying content with a stack of three imagez.
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package KiewitDev
     */

    //If no alt tag is set for images, this will grab and use the title:
    //Credit: https://julienmelissas.com/setting-the-alt-attribute-from-an-acf-image-object/
    function acf_set_alt($img) {
        $alt = $img['alt'];
        if(!empty($alt)) {
            return $alt;
        } else {
            $title = $img['title'];
            $title = preg_replace('%\s*[-_\s]+\s*%', ' ', $title);
            $title = ucwords(strtolower($title));
            $img['alt'] = $title;
            return $title;
        }
    }

    $header = get_sub_field( 'header' );
    $text = get_sub_field( 'content' );
    $link = get_sub_field( 'link' );
    if( $link ) :
        $url = $link['url'];
        $title = $link['title'];
        $target = $link['target'] ?: '_self';
    endif;

    $img_top = get_sub_field( 'image_top' );
    if( $img_top ) :
        $t_src = $img_top['url'];
        $t_alt = acf_set_alt( $img_top );
    endif;

    $img_middle = get_sub_field( 'image_middle' );
    if( $img_middle ) :
        $m_src = $img_middle['url'];
        $m_alt = acf_set_alt( $img_middle );
    endif;

    $img_bottom = get_sub_field( 'image_bottom' );
    if( $img_bottom ) :
        $b_src = $img_bottom['url'];
        $b_alt = acf_set_alt( $img_bottom );
    endif;

?>

<section class="section content-media-stack">
    <div class="container">
        <div class="row">
            <div class="column column__content col-12 col-md-6">
                <div class="content-container">
                    <h3><?php echo $header ?></h3>
                    <p><?php echo $text; ?></p>
                    <div class="link-container">
                        <a class="button arrow arrow__right" href="<?php echo $url ?>" target="<?php echo $target?>">

                            <?php echo $title ?>
                            <img class="ktg-link" src="<?php echo get_template_directory_uri();
                            ?>/assets/img/arrow-right.svg"
                                 alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="column column__media col-12 col-md-6">
                <div class="media-container">
                    <figure class="img img__top">
                        <img src="<?php echo $t_src ?>" alt="<?php echo $t_alt ?>">
                    </figure>
                    <figure class="img img__middle">
                        <img src="<?php echo $m_src ?>" alt="<?php echo $m_alt ?>">
                    </figure>
                    <figure class="img img__bottom">
                        <img src="<?php echo $b_src ?>" alt="<?php echo $b_alt ?>">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
