
# ACF Options page setup example

We can create options pages in the ACf admin area now, OR set them up with code.

This snippet will create a single "Theme Options" spot in the admin sidebar, with multiple sub pages under the main 
options tab.

```php
/**
* Set up ACF theme options.
  */

if( function_exists('acf_add_options_page') ) {
acf_add_options_page(array(
'page_title'    => 'Theme Options',
'menu_title'    => 'Theme Options',
'menu_slug'  => 'theme-general-settings',
'capability' => 'edit_posts',

    ));

	acf_add_options_sub_page(array(
		'page_title'    => 'Styles',
		'menu_title'    => 'Styles',
		'parent_slug'   => 'theme-general-settings',
		'capability' => 'edit_posts',
	));

	acf_add_options_sub_page(array(
        'page_title'    => 'Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'theme-general-settings',
        'capability' => 'edit_posts',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-general-settings',
        'capability' => 'edit_posts',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Page Defaults',
        'menu_title'    => 'Page Defaults',
        'parent_slug'   => 'theme-general-settings',
        'capability' => 'edit_posts',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Tracking Code',
        'menu_title'    => 'Tracking Code',
        'parent_slug'   => 'theme-general-settings',
        'capability' => 'edit_posts',
    ));
}

```