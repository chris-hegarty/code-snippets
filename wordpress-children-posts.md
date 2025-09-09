# WordPress: Working with hierarchical/children posts

WordPress is a powerful CMS that allows you to create hierarchical posts. 

This means that you can create a parent post and then create child posts that are associated with the parent post. 

This can be useful for organizing content and creating relationships between posts.

## Use cases

### Display child pages on a parent page:

```php

$child_pages = get_children( array( 'post_parent' => get_the_ID() ) );

if( !empty( $child_pages ) ) {
    echo '<ul>';
    foreach ( $child_pages as $child ) {
        echo '<li><a href="' . get_permalink( $child->ID ) . '">' . $child->post_title . '</a></li>';
    }
    echo '</ul>';
} else {
    echo 'No child pages found.';
}


```

### Retrieve attachments for a post

```php

$attachments = get_children( array(
    'post_parent'    => get_the_ID(),
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'orderby'        => 'menu_order'
) );

if ( $attachments ) {
    echo '<div class="gallery">';
    foreach ( $attachments as $attachment ) {
        echo wp_get_attachment_image( $attachment->ID, 'medium' );
    }
    echo '</div>';
}

```

### Create a dropdown of child pages

```php

$child_pages = get_children( array( 'post_parent' => get_the_ID() ) );

if( !empty( $child_pages ) ) {
    echo '<select onchange="location = this.value;">';
    echo '<option>Select a child page</option>';
    foreach ( $child_pages as $child ) {
        echo '<option value="' . get_permalink( $child->ID ) . '">' . $child->post_title . '</option>';
    }
    echo '</select>';
}
```

```php

```