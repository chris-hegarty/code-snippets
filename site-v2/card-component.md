"Card" in Static Cards - uses card component:

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