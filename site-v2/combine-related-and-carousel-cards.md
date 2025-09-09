```php
?>

    <div class="swiper-slide col-12 col-lg-4 mx-3 cards">
        <div class="related card">
            <picture class="background">
                <img class="related-image" src="<?php echo $bg_url ?>">
            </picture>
            <div class="slide-content card__content">
            <?php //need if statement here ?>
                <div class="cpt-taxonomy">
                    <p><?php echo $first_term; ?></p>
                </div>
                <?php endif; ?>
                <div class="cpt-info">
                    <h4 class="card__content--title"><?php echo $args['title'] ?? $header ?></h4>
                    <div class="card__content--link">
                        <a href="<?php echo get_permalink( $post->ID ); ?>" target="_blank"
                           class="icon-link icon-link-hover stretched-link">
                            Read More
                            <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                        </a>
                        <!-- 
                        From carousel_card. If statement? If they have option to choose link like a static card. But 
                        not for related or when choosing posts from Relationship field"?
                        <a class="icon-link icon-link-hover"href="<?php echo $card_url ?>" target="<?php echo $card_target ?>"><?php echo $card_title?>
                            <i class="bi bi-arrow-right-short d-flex align-items-center"></i>
                        </a>
                        
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>




```