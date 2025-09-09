# Adding Bootstrap classes to navigation menus using WordPress filters

Example: Safety Contacts site/theme.

The filters:

`nav_menu_submenu_css_class` - This filter allows you to add custom classes to the submenu `<ul>` element.

`nav_menu_css_class` - This filter allows you to add custom classes to the menu `<li>` elements.

`nav_menu_link_attributes` - This filter allows you to add custom attributes to the menu `<a>` elements.


These examples add Bootstrap classes to the menu's `ul`, `li` and `a` items.

```php

/**
	 * Adds custom classes to submenu items.
	 *
	 * @param array $classes An array of the CSS classes that are applied to the menu item's `<ul>` element.
	 * @return array Modified array of CSS classes.
	 */

	function add_class_to_submenu_items( $classes ) {
		$classes[] = 'dropdown-menu';

		return $classes;
	}

	add_filter( 'nav_menu_submenu_css_class', 'add_class_to_submenu_items' );

/**
	 * Adds Bootstrap classes to the menu list items.
	 *
	 * @param array $classes An array of the CSS classes that are applied to the menu item's `<li>` element.
	 * @param object $item The current menu item.
	 * @param object $args An object of wp_nav_menu() arguments.
	 * @return array Modified array of CSS classes.
	 *
	 */

	function add_menu_list_item_class($classes, $item, $args) {
		if(property_exists($args, 'list_item_class')) {
			$classes[] = $args->list_item_class;
		}
		if( in_array('menu-item-has-children', $classes) ) {
			$classes[] = 'dropdown';
		}

		return $classes;
	}

	add_filter('nav_menu_css_class', 'add_menu_list_item_class', 1, 3);


 /**
	 * Adds Bootstrap classes to menu <a> link items.
	 *
	 * @param array $atts The HTML attributes applied to the menu item's `<a>` element.
	 * @param object $item The current menu item.
	 * @return array Modified array of HTML attributes.
	 */
	function add_dropdown_toggle_classes($atts, $item) {
		if(in_array('menu-item-has-children', $item->classes) ) {
			$atts['class'] = 'nav-link dropdown-toggle';
			$atts['data-bs-toggle'] = 'dropdown';
			$atts['aria-expanded'] = 'false';
		}
		if( !$item->has_children && $item->menu_item_parent > 0 ) {
			$atts['class'] = 'dropdown-item';
		}
		return $atts;
	}
	add_filter('nav_menu_link_attributes', 'add_dropdown_toggle_classes', 10, 3);

	/**
	 * Adds custom classes to the wp_nav_menu array link options.
	 *
	 * @param array $atts The HTML attributes applied to the menu item's `<a>` element.
	 * @param object $item The current menu item.
	 * @param object $args An object of wp_nav_menu() arguments.
	 * @return array Modified array of HTML attributes.
	 */

	function add_link_class_option_to_wp_nav_menu_array($atts, $item, $args) {

		if(property_exists($args, 'link_class')) {
			$atts['class'] = $args->link_class;
			$slug = $item->post_name;
		}

		return $atts;
	}

	add_filter('nav_menu_link_attributes', 'add_link_class_option_to_wp_nav_menu_array', 1, 3);

```

## Method 2: Use a nav Walker

TODO: add custom nav walker info here.



