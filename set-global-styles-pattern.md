1. Get the colors from the options page:

```php
    <?php $primary_color = get_field('global_primary_color','options'); ?>
    <?php $secondary_color = get_field('global_secondary_color','options'); ?>
    <?php $primary_text_color = get_field('global_text_color','options'); ?>

```

2. Set them as global CSS variables in header.php:

```php
?>
    <style>
      :root {
        --primary-theme-color: <?php echo $primary_color ?>;
        --secondary-theme-color: <?php echo $secondary_color ?>;
        --primary-text-color: <?php echo $primary_text_color?>
      }
    </style>


```