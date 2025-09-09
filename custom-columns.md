

The hooks to create custom columns and their associated data for a custom post type are 

`manage_{$post_type}_posts_columns`

and 

`manage_{$post_type}_posts_custom_column` respectively, where 

`{$post_type}`

is the name of the custom post type.

Note on custom taxonomy columns:
(Source: Stack OVerflow https://wordpress.stackexchange.com/questions/253640/adding-custom-columns-to-custom-post-types)
"register_taxonomy() now has support for that built in via the show_admin_column setting passed via arguments. 
[developer.wordpress.org/reference/functions/register_taxonomy]() 
If you aren't registering the taxonomy yourself, you can still alter the args via the 
`register_taxonomy_args` filter 
[developer.wordpress.org/reference/hooks/register_taxonomy_args]()


### Example from brand.com | custom-post-columns.php

Add the custom columns to the "Projects" post type:
```php
function brand_projects_columns( $columns ) {

    $columns = array(
        'cb' => $columns['cb'],
        'image' => __( 'Image' ),
        'title' => __( 'Title' ),
        'market' => __( 'Market' ),
		'submarket' => __( 'Submarket' ),
        'photos' => __( 'Photos' ),
        'date' => __( 'Date' )
    );

    return $columns;
}
add_filter( 'manage_projects_posts_columns', 'brand_projects_columns' );
```
Add the data to the custom columns for the Projects post type:
```php

function brand_projects_column( $column, $post_id ) {
    
    $photos = get_post_meta( $post_id, 'project_photos', true );
    
    switch ( $column ) {
        
        case 'image':
			
			if ($photos) {
            	echo '<img src="' .  str_replace( '1024px@2x','240px',wp_get_attachment_image_src( $photos[0], 'full' )[0] ) . '?quality=60" width="100%">';
			}
            
            break;
            
        case 'photos':
            
			if ($photos) {
            	echo sizeof( $photos );
			} else {
				echo intval( '0' );
			}
                
            break;
            
        case 'market':
            
            /*
			$value = get_post_meta( $post_id, 'project_market', true );
			$title = get_page_by_path( $value, ARRAY_A, 'markets' );
			echo $title['post_title'];
            */
            
            $value = get_post_meta( $post_id, 'project_market', true );
            
            echo $value;
            
			break;
			
		case 'submarket':
            
            /*
			$market = get_post_meta( $post_id, 'project_market', true );
			$field = get_field_object( 'project_sub_market_' . str_replace('-','_',$market), $post_id );
			$value = get_post_meta( $post_id, 'project_sub_market_' . str_replace( '-', '_', $market), true );
            			
            
			if ( array_key_exists($value, $field['choices']) ) {
				echo $field['choices'][ $value ];
			} else {
				echo $value;
			}
			*/
            $market = get_post_meta( $post_id, 'project_market', true );
            $value = get_post_meta( $post_id, 'project_sub_market_' . str_replace( '-', '_', $market), true );
            
            echo $value;
            
			break;
            
        default:
            
            break;

    }
}
add_action( 'manage_projects_posts_custom_column', 'brand_projects_column', 10, 2);

```

### More resources

manage_edit-${post_type}_columns : applied to the list of columns to print on the manage posts screen for a custom post type. Filter function argument/return value is an associative array where the element key is the name of the column, and the value is the header text for that column. See also action manage_${post_type}_posts_custom_column, which puts the column information into the edit screen.

manage_link-manager_columns : was manage_link_columns until wordpress 2.7. applied to the list of columns to print on the blogroll management screen. Filter function argument/return value is an associative list where the element key is the name of the column, and the value is the header text for that column. See also action manage_link_custom_column, which puts the column information into the edit screen.

manage_posts_columns : applied to the list of columns to print on the manage posts screen. Filter function argument/return value is an associative array where the element key is the name of the column, and the value is the header text for that column. See also action manage_posts_custom_column, which puts the column information into the edit screen. (see Scompt’s tutorial for examples and use.)

manage_pages_columns : applied to the list of columns to print on the manage pages screen. Filter function argument/return value is an associative array where the element key is the name of the column, and the value is the header text for that column. See also action manage_pages_custom_column, which puts the column information into the edit screen.

manage_users_columns

manage_users_custom_column

manage_users_sortable_columns