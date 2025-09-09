# Global carousel scaffolding

Global Carousel scaffolding

```php

<?php

    /**
     * Template part for displaying a hero carousel
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     *
     */
     
    /**
     * args: id, classes, apply content across all slides?, manual tag? add date? 
     *
     */
     
        $id = $args['current_post_id'] ?? get_the_ID();
        $swiper_id = $args['swiper_id'];
        $post_type = $args['post_type'] ?? get_post_type($id);
        $taxonomies = $args['taxonomies'];
        $current_post_terms = $args['current_post_terms'];
        $current_post_term_names = $args['current_post_term_names'];
        $term = $current_post_term_names[0];

?>
<div class="swiper" id=""> <!-- args: id, viewport + overflow classes, etc...-->
    <div class="swiper-wrapper">
    <!-- set up args from get_template part, set up ACF values -->
        <div class="swiper-slide">
            <div class="outer-slide-wrapper">

            <?php if( $img && $media_type === "image" ) : ?>
                <picture class="d-block w-100 h-100">
                    <img class="w-100" src="<?php echo $src ?>"/>
                </picture>
            <?php else : ?>
                <video class="d-block w-100 h-100" preload muted autoplay loop playsinline>
                    <source src="<?php echo $video ?>" type="video/mp4">
                </video>
            <?php endif; ?>
                <!-- if HERO: -->
                <div class="carousel__container position-absolute d-flex w-100 align-items-end top-0">
                    <div class="container position-relative z-3">
                        <?php ?>
                            <span><?php echo $term; ?></span>
                        <?php ?>
                        <h1 class="cpt-heading m-0 py-3"><?php echo $title ? $title : get_the_title() ?></h1>
                        <p class="cpt-location"><?php echo $location ?></p>
                    </div>
                </div>
                <!-- if Related:  -->
                <div class="slide-content">
                    <div class="cpt-taxonomy">
                        <p><?php echo $term ? $term->name : ''; ?></p>
                    </div>
                    <div class="cpt-info">
                        <h4><?php echo $header ?></h4>
                        <a href="<?php echo get_permalink( $post->ID ); ?>" target="_blank"
                            class="icon-link icon-link-hover stretched-link">
                            Read More
                            <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
            <!-- if hero: -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- if hero: -->
    <div class="jump-to-content container">
        <a class="d-inline-block" href="#cpt-outer">
            <button class="background-transparent circle border-white">
                <i class="bi bi-arrow-down"></i>
            </button>
        </a>
    </div>
</div>

```

