<?php /** @noinspection ALL */

	class KTG_Bootstrap_Navwalker extends Walker_Nav_Menu {

	// Begin here with the sub-menu <ul> element:
	public function start_lvl( &$output, $depth = 0, $args = null ) {

		// b/c this starts the <ul> for submenus, not sure we need the level check here.
		$indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' );
		$display_depth = $depth + 1;

		$classes = array(
			'dropdown-menu',
			'menu-depth-' . $display_depth,
		);

		$class_names = implode( ' ', $classes );
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {

//		$indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' );
		$indent = str_repeat("\t", $depth);
		$output .= $indent . '</ul>' . "\n";
	}

	// Now we customize the <li> and <a> elements:
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0){
		$indent = str_repeat("\t", $depth);

		//Let's set up our classes array:
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		//Now we can add custom classes to our <li>.
		//"nav-item" only goes on top level <li> elements:

		if($depth === 0){
			$classes[] = 'nav-item';
		}

		//Check for children in the $classes array:
		if( in_array('menu-item-has-children', $classes) ) {
			//add the dropdown class
			$classes[] = 'dropdown';
		}
		//join the classes together | add a hook for future devs | use array_filter to remove any empty values
		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth) );
		$class_names = $class_names ? ' class="' . esc_attr($class_names). '" ' : '';

		// begin the <li> element:
		// let's use double quotes with curly braces here:
		$output .= "{$indent}<li{$class_names}>";

		// Time to move on to our <a> element. We are working with attributes now.
		// Set up the attributes array along with the defaults.
		// Again, we are using the $item object heavily here.
		$atts = array();
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		$atts['rel'] = !empty($item->xfn) ? $item->xfn : '' ;
		$atts['href'] = !empty($item->url) ? $item->url : '#' ;

		$atts['class'] = null;

		//Now we can add some custom classes via $atts['class]:
		if( in_array('menu-item-has-children', $classes) ){
			$atts['class'] .= 'dropdown-toggle ';
			$atts['data-bs-toggle'] = 'dropdown';
			$atts['role'] = 'button';
		}

		if(in_array('current-menu-item', $classes)){
			$atts['class'] .= 'active';
		}

		if($depth > 0) {
			// for sub-menu items, add the dropdown-item class
			$atts['class'] .= 'dropdown-item';
		} else {
			$atts['class'] .= 'nav-link';
		}

		//Bring all the atts together in a string we can drop into the output:
		$attributes = '';
		foreach( $atts as $attr => $value ) {
			if( !empty($value) ){
				//if it's the href, use esc_url, otherwise use esc_attr:
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				//add each value into the string:
				$attributes .= '' . $attr . '="' . $value . '"';
			}
		}

		//Now we output the <a> element, including any $args that may be passed in from wp_nav_menu():
		$item_output = !empty($args->before) ? $args->before : '';
		$item_output .= '<a ' . $attributes . '>';
		// This is the simpler way of writing this next line:
		// $item_output .= $args->link_before . $item->title . $args->link_after;
		// but we will use apply_filters to allow future devs to customize the output:
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		// Same as above...let's add a filter for the final output of the item, in case someone wants to customize it:
		// $output .= $item_output;
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	public function end_el(&$output, $item, $depth = 0, $args = null){
		//Now close the <li> and add a new line break.
		$output .= "</li>\n";
	}
}

