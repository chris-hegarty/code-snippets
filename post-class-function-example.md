### WordPress post class function

```php
?>
<div id="post-<?php the_ID(); ?>" class="column-item <?php echo $post_class . ' ' . $postCategorySlug; ?>-post">

```