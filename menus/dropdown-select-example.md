```php

<?php
/**
 * Template part for displaying posts or pages in a dropdown menu.
 *
 * This template fetches and displays a list of counties as a dropdown menu.
 * The counties are fetched based on the current post's ID, and are ordered
 * alphabetically by title.
 */
?>

<div class="dropdown-container py-5">

    <?php

    $args = array(
        'post_parent' => get_the_id(),
        'post_type' => 'state',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    $counties = get_posts($args);

    ?>

    <?php if ( !empty($counties) ) : ?>
    <div class="dropdown county-dropdown">
        <select name="counties" id="select-county">
            <option disabled selected value="0">Filter by County</option>
            <?php foreach ( $counties as $county ) : ?>
                <option value="<?php echo $county->ID; ?>" data-url="<?php echo get_permalink($county->ID); ?>"><?php
                        echo $county->post_title; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php endif; ?>
</div>



```