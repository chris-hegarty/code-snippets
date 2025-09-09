# Nav Walker Class Notes

Source: https://developer.wordpress.org/reference/classes/walker/

https://awhitepixel.com/wordpress-menu-walkers-tutorial/

## Deployment instructions

1. Copy and place the "KTG_Bootstrap_Navwalker" file somewhere in your theme directory. (If there's an "inc" or 
   "includes" folder, that's usually a good spot.)

2. Require the file in functions.php, like:

```php
/**
 * Custom KTG Bootstrap navwalker for menu.
 */
require get_template_directory() . '/inc/KTG_Bootstrap_Navwalker.php';
```
3. Add it into your `wp_nav_menu` call. (Usually in header.php... but wherever you are outputting your menu):

Adjust the other array keys as needed. (See notes below about `menu_class` and `items_wrap`)

```php
    wp_nav_menu( array(
        'menu' => 'primary-menu',
        'theme_location' => 'primary',
        'menu_id' => 'menu-header',
        'menu_class' => '',
        'items_wrap' => '<ul id="%1$s" class="nav navbar-nav mb-2 mb-md-0 %2$s">%3$s</ul>',
        'depth' => 0,
        'container' => false,
        'walker' => new KTG_Bootstrap_Navwalker() // Use our custom nav walker
    ) );    
```

4. (Optional)

Here is some JavaScript to slide toggle the dropdowns open and closed:

```javascript

( function($) {

	$(document).ready( function(){

		// Add animations to Bootstrap's navigation dropdowns.
		// Sources:
		// https://stackoverflow.com/questions/12115833/adding-a-slide-effect-to-bootstrap-dropdown
		// Bootstrap dropdown events: https://getbootstrap.com/docs/5.3/components/dropdowns/#events

		// slideDown:

		$('.dropdown').on('show.bs.dropdown', function() {
			$(this).find('.dropdown-menu').first().stop(true, true).slideDown();
		});

		// slideUp:

		$('.dropdown').on('hide.bs.dropdown', function() {
			$(this).find('.dropdown-menu').first().stop(true, true).slideUp();
		});

	});

}( jQuery ));

```

5. (Optional )Here's some basic `<header>` HTML and CSS to get started with 

```html

	<header id="masthead" class="site-header navbar-static-top <?php echo safetycontacts_bg_class(); ?>" role="banner">
		<div class="container">
			<nav id="site-navigation" class="navbar navbar-expand-lg">
				<div class="navbar-brand">
					<?php if( get_theme_mod( 'safetycontacts_logo' ) ): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo esc_url( get_theme_mod( 'safetycontacts_logo' ) ); ?>" alt="<?php echo
							esc_attr( get_bloginfo( 'name' ) ); ?>" style="width:300px;">
						</a>
					<?php else : ?>
						<a class="site-title"
						   href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_url( bloginfo( 'name' ) ); ?>
						</a>
					<?php endif; ?>
				</div>
				<button type="button"
						class="navbar-toggler collapsed btn-menu btn"
						data-bs-toggle="collapse"
						data-bs-target="#main-nav"
						aria-controls="#main-nav"
						aria-expanded="false"
						aria-label="Toggle navigation"
				>
					<span class="bar top"></span>
					<span class="bar middle"></span>
					<span class="bar bottom"></span>
				</button>
				<div id="main-nav" class="main-navigation navbar-collapse collapse justify-content-end">
					<?php
						wp_nav_menu( array(
							'menu' => 'primary-menu',
							'theme_location' => 'primary',
							'menu_id' => 'menu-header',
							'menu_class' => '',
							'depth' => 0,
							'container' => false,
							'items_wrap' => '<ul id="%1$s" class="nav navbar-nav mb-2 mb-md-0 %2$s">%3$s</ul>',
							'walker' => new KTG_Bootstrap_Navwalker() // Use our custom nav walker
						) );
					?>
				</div>
			</nav>
		</div>
	</header><!-- #masthead -->

```

```css

header#masthead {
	width: 100%;
	margin-bottom: 0;
	background-color: #ffffff ;
	box-shadow: 0 0.4rem 1rem rgba(0,0,0,.05), inset 0 -1px 0 rgba(0,0,0,.1);
	@media screen and (max-width: 1199px) {
		position: fixed;
		top: 0;
		display: flex;
		padding: 10px;
		min-height: 60px;
		z-index: 100;
	}
	nav, #main-nav {
		@media screen and (min-width: 1200px) {
			min-height: 60px;
		}

		.navbar-brand {
			height: auto;
			padding: 0;
			& > a {
				color: #282827;
				font-size: 1.1rem;
				outline: medium none;
				text-decoration: none;
				font-weight: 700;
				&:hover {
					text-decoration: none;
					transition: all 0.2s ease;
				}
			}
			@media screen and (max-width: 768px){
				flex-basis: 45%;
			}
			img {
				max-height: 100px;
			}
		}
		.btn-menu.navbar-toggler {
			height: 26px;
			width: 40px;
			position: relative;
			padding: 0;
			border: none;
			background-color: transparent;
			color: inherit;
			cursor: pointer;
			//transition: all .3s ease;
			.bar {
				position: absolute;
				left: 0;
				display: block;
				height: 2px;
				background: #000;
				margin: 0;
				transition: all 0.3s;
				width: 36px;
				&.top {
					top: 0;
				}
				&.middle {
					top: 12px;
				}
				&.bottom {
					bottom: 0;
				}
			}
			&[aria-expanded="true"] {
				box-shadow: none;
				.top {
					transform-origin: top left;
					transform: rotate(45deg);
				}
				.middle {
					top: 12px;
					opacity: 0;
				}
				.bottom {
					bottom: 0;
					transform-origin: bottom left;
					transform: rotate(-45deg);
				}
			}
			&:focus {
				outline: 0;
				-webkit-box-shadow: none;
				-moz-box-shadow: none;
				box-shadow: none;
			}
		}
	}
}


```

------------------------

## Some important `wp_nav_menu()` notes
source: https://developer.wordpress.org/reference/functions/wp_nav_menu/

The Walker class does -NOT- create the top level `<ul>`, or wrapper element. 

You have do that with `wp_nav_menu()`.

Examples:

1) Add a custom class to the default top-level <ul> using 'menu_class':

```php
wp_nav_menu(array(
    'theme_location' => 'primary',
    'menu_class'     => 'custom-menu-class',
    )
);
```

OR

2) Define and use a custom element instead of the default <ul> using 'items_wrap'.

(If you use both 'menu_class' and 'items_wrap', items_wrap' takes precedence and 'menu_class' will be ignored.).

```php
wp_nav_menu( array(
    'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
) );
```

-------------------------------------------

------------------------------------------

## Some other general information

-------------------------------------------

------------------------------------------


### Understanding the $depth parameter

`$depth == 0` means you are at the top level of the menu (the first `<ul>`).

`$depth == 1` means you are at the first level of sub-menus -- a direct child of a top-level menu item. (the first child 
`<ul>`).

`$depth == 2` means you are a 2nd level submenu, or a child of a first-level submenu item.

------------------------

### Passing the `$output` variable by reference

"Passed by reference" means that a reference to a variable is passed to the function, rather than a copy of the 
variable's value. 

This allows the function to modify the original variable directly.

In the `start_lvl` method, the `$output` parameter is passed by reference, so that any changes made to `$output`
within the method will affect the original variable outside the method. 

This is useful for appending additional content to `$output` without needing to return the modified value.

The other parameters, `$depth` and `$args`, are not passed by reference because they are used as input values within 
the method, and do not need to be modified outside the method. 

Passing them by value ensures that the original variables remain unchanged.

-----------------------------------------

### Walker_Nav_Menu::start_el

The `start_el()` method is used to add the opening HTML tag for a **single tree item (such as `<li>`, `<span>`, or `<a>`)`** to `$output`.


```php

function start_el(&output, $item, $depth = 0, $args = array() $id = 0){
    $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
    
    $depth_classes = array(
        ($depth === 0 ? 'main-menu-item' : 'sub-menu-item'),
        ($depth >= 2 ? 'sub-sub-menu-item' : '')
    );
    
    $classes = implode('', $depth_classes);
    
    $output .= $indent .'<li class="'. $classes .'">';
}

```

----------------------------------------------

### Walker_Nav_Menu::start_lvl

Adds classes to the unordered list sub-menus.

The start_lvl() method is used for children elements.

It is run when the Walker reaches the start of a new "branch" in the 
tree structure. 

Generally, this method is used to add the opening tag of a **container HTML element (such as `<ol>`, `<ul>`, or `<div>`)** to `$output`.

EXAMPLE: This adds classes to the `<ul>` sub-menu:

```php

function start_lvl(&output, $depth=0, $args=array()){
    $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
    $display_depth = ($depth + 1); // because it counts the first submenu as 0.
    $classes = array(
        'sub-menu',
        ($display_depth % 2 ? 'menu-odd' : 'menu-even'), // Odd/even menu classes.
        ($display_depth >=2 ? 'sub-sub-menu' : ''),
        'menu-depth-' . $display_depth
    );
    
    $class_names = implode('', $classes);
    
    // Now use &$output to build the HTML:
    
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
}

```
-------------------------

### new line and new tab characters:

`\n` and `\t` respectively.

Example: This is how the HTML gets indented::
```php
$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
```

-------------------------
