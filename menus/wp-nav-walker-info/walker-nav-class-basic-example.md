# Walker Nav Class - Basic Example 

-------------------

-First, be aware of some PHP syntax here, like **double quote variable interpolation**:
```php
$output .= "$indent</ul>\n";
```
This can also be written like:
```php
$output .= $indent . '<ul>' . "\n"
```
Or, using curly brace syntax:
```php
$output .= "{$indent} </ul>\n";
```
Curly braces also let us do more complicated stuff, like accessing array elements:
```php
$output .= "{$items[0]}"
```
or object properties:
```php
$output .= "{$item->title}";
```
--------------------

```php

class My_Custom_Walker extends Walker_Nav_Menu {

    // Add custom markup to the sub-menu <ul> element
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"my-custom-submenu-class\">\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null){
        $indent = str_repeat("\t", $depth); // Indent for the closing tag
        $output .= "$indent</ul>\n";
    }

    // Customize the <li> and <a> elements
    // Note: See "menu-item-object-output-examples.md" to see what we get from the $item object.
    
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = str_repeat("\t", $depth);
       
        // Default item class
        $classes = empty($item->classes) ? array() : (array) $item->classes;
       
        // Add your custom class to <li>
        $classes[] = 'my-custom-item-class';
       
        // If this item has children, add another class
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
        }
       
        // Join all classes with spaces
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
       
        // Start the <li> output
        $output .= $indent . '<li' . $class_names . '>';
        
       
        // Default link attributes
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
       
        // Add your custom class to <a>
        $atts['class'] = 'my-custom-link-class';
       
        // Convert attributes to string
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
       
        // Build the <a> element
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
       
        // Add to the main output
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
   
    // Close the <li> element
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}
```