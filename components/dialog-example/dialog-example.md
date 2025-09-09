Enqueue the JS file in functions.php:

```php
        wp_register_script( 'survey', get_template_directory_uri() . '/survey.js', array('jquery'), time(),
            true );
        wp_enqueue_script( 'survey' );

```

Call for the template in whichever PHP file makes sense.
These examples were called in a footer.php file like:
```php
get_template_part('template-parts/partials/dialog', 'spanish');


```