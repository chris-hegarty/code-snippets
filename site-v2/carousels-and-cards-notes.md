## Carousels + Cards

------
"Card" in carousel_cards.php:
```php
?>
    <div class="col-12 col-lg-4 mx-3 cards">
        <div class="card" style="background-image: url('<?php echo esc_url($src); ?>');">
            <div class="card__content">
                <h4 class="card__content--title"><?php echo $card_name ?></h4>
                <div class="card__content--link">
                    <a class="icon-link icon-link-hover"href="<?php echo $card_url ?>" target="<?php echo $card_target ?>"><?php echo $card_title?>
                        <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                    </a>
                    <i class="card-icon"></i>
                </div>
            </div>
        </div>
    </div>

```
"Card" in carousel_related.php:
```php
?>
 <!-- Begin slide -->
    <div class="swiper-slide">
        <div class="related">
            <picture class="background">
                <img class="related-image" src="<?php echo $bg_url ?>">
            </picture>
            <div class="slide-content">
                <div class="cpt-taxonomy">
                    <p><?php echo $first_term; ?></p>
                </div>
                <div class="cpt-info">
                    <h4><?php echo $args['title'] ?? $header ?></h4>
                    <a href="<?php echo get_permalink( $post->ID ); ?>" target="_blank"
                       class="icon-link icon-link-hover stretched-link">
                        Read More
                        <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<!-- End slide -->
```

"Card" in Static Cards - uses card component:
-needs an aspect-ratio option?
-carousel_cards - vertical
-carousel_related - horizontal
```php
?>
<div class="<?php echo $args['container_class'];?> card" style="background-image: url('<?php echo $args['background_image'];?>; ?>')">
    <div class="card__content">
        <h4 class="card__title"><?php echo $args['title']; ?></h4>
        <?php if ( $args['type'] === 'expand' ) : ?>
            <div class="card__description card__description--hidden">
                <?php echo apply_filters( 'the_content', $args['description'] ); ?>
                <div class="card__footer">
                    <a class="card__link" href="<?php echo $args['link']['url']; ?>"><?php echo $args['link']['title']; ?></a>
                </div>
            </div>
            <div class="card__button">
                <i class="fa-sharp fa-solid fa-plus fa-lg"></i>
            </div>
        <?php else : ?>
            <a class="card__link" href="<?php echo $args['link']['url']; ?>"><?php echo $args['link']['title']; ?></a>
        <?php endif; ?>
    </div>
</div>
```

