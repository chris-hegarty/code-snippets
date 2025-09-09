<?php

//Quick reference from Example Two:

/*

style="background-image: linear-gradient(rgba(<?php echo $overlay ?>,<?php echo $opacity ?>),rgba(<?php echo
$overlay ?>,<?php echo $opacity ?>) ), url(<?php echo $background_image[ 'url' ] ?>)">

*/

//Notes on multiple backgrounds:
//
//You can apply multiple backgrounds to elements.
//These are layered atop one another with the first background you provide on top and the last background listed in the back.
//Syntax: they are separated by commas:
//
//background-image: url(img_flwr.gif), url(paper.gif);
//
//Only the last background can include a background color.
//
//If using multiple background-image sources but also want a background-color, the background-color parameter needs to be last in the list.


    //Example One:

    $content = get_field( 'content' );
    $background_image = get_field('background-image');
    if($background_image) :
        $src = $background_image['url'];
    endif;

?>
    <div class="hero" style="background-image: url('<?php echo $src?>');">
        <div class="container h-100">
            <div class="d-flex hero__content">
                <div class="p-3 py-5 p-md-5 align-self-center w-100">
					<?php echo $content ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>

  /*
  1. Background properties go on hero section b/c the bg image is on here.
  2. "&::before" pseudo element creates the overlay.
  For white, use rgba(255,255,255,0.5).
  For black, use rgba(0,0,0,0.5);
  3. Text color should be set inversely and be set to position relative

  */

  .hero {
    position: relative;
    background-position: 50% 50%;
    background-size: cover;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    &::before {
      content: '';
      position: absolute;
      background: rgba(255,255,255,0.5);
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      height: 100%;
      width: 100%;
    }
    &__content {
      color:#000;
      position: relative;
    }

</style>

<?php

//Example Two: Multi-column background settings:

    /*

    Begin by setting variables for
    -background image
    -a light or dark image overlay setting
    -a range slider, from 1-10. Divide results by 10 and use for rgba opacity setting.

    */

    $columns = get_sub_field( 'columns' ) ?: [];
    $cols_count = count( $columns );
    $anchor_link_id = get_sub_field( 'anchor_link_id' );
    $background = get_sub_field( 'background' );
    $background_image = get_sub_field( 'background_image' );
    $background_image_position = get_sub_field( 'background_image_position' );
    $background_image_overlay = get_sub_field( 'background_image_overlay' );
    $background_image_opacity = get_sub_field('background_image_opacity');
    $text_color = get_sub_field( 'text_color' );
    $padding_top = get_sub_field( 'padding_top' );
    $padding_bottom = get_sub_field( 'padding_bottom' );
    $add_border_top = get_sub_field( 'add_border_top' );

    $classes = [
        'content-columns',
        'color-' . $text_color,
        'padding-top-' . $padding_top,
        'padding-bottom-' . $padding_bottom,
    ];
    if ( $add_border_top ) {
        $classes[] = 'add-border-top';
    }
    if ($background && empty($background_image)) {
        $classes[] = 'bg-' . $background;
    }

    $align_columns = get_sub_field( 'align_columns' );

?>

<section <?= $anchor_link_id ? 'id="' . $anchor_link_id . '"' : '' ?> class="<?= implode( ' ', $classes ); ?>">

    <?php if ( $background_image ) : ?>

        <?php $overlay = ($background_image_overlay === 'light') ? '255,255,255' : '0,0,0' ?>
        <?php $opacity = $background_image_opacity / 10  ?>

<!--

Note: In the style tag, use "background-image" instead of "background".
Then, you can have two comma-separated values: linear gradient with rgba on top; url on the bottom.

style="background-image: linear-gradient(rgba(<?php echo $overlay ?>,<?php echo $opacity ?>),rgba(<?php echo$overlay
?>,<?php echo $opacity ?>) ), url(<?php echo $background_image[ 'url' ] ?>)">

-->

        <figure class="background <?php echo $background_image_position ? 'background-' . $background_image_position : '' ?>"
                style="background-image: linear-gradient(
                        rgba(<?php echo $overlay ?>,<?php echo $opacity ?>),rgba(<?php echo
                $overlay ?>,<?php echo $opacity ?>) ), url(<?php echo
                $background_image[ 'url' ] ?>)">

        </figure>

    <?php endif; ?>

    <style>
      .background {
        position: absolute;
        top: 0;
        left: 50%;
        width: 100%;
        height: 100%;
        margin: 0;
        margin-left: -50%;
        z-index: -1;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;

        &.contain {
          background-size: contain;
        }

        &.bump-index {
          z-index: 1;
        }

        &.background-top {
          background-position: top;
        }

        &.background-bottom {
          background-position: bottom;
        }

        &.background-left {
          background-position: left;
        }

        &.background-right {
          background-position: right;
        }
      }


      /*Color utilities*/

      .bg {
        &-gray {
          background-color: #474c55;
        }

        &-gray-200 {
          background-color: #2f2e2f;
        }

        &-white {
          background-color: #fff;
        }

        &-brand {
          background-color: #0079c1;
        }
      }

      .color {
        &-black {
          color: #000;
        }

        &-white {
          color: #fff;

          .button-alt a {
            color: #fff;
          }
        }

        &-brand {
          color: #0079c1;
        }
      }



    </style>
