# Navigation with submenu slide toggle example

If you need top level menu items to slide toggle on hover:

-Find the list items that have .sub-menu children

-If those list items are part of a sub-menu, stop the hover event from bubbling up past them.

-Otherwise, prevent the default

-Use .find to go through the list item’s descendants to the `<ul>` and slide-toggle it.

## .find()

This method traverse downwards along descendants of DOM elements, all the way down to the last descendant. 

To only traverse a single level down the DOM tree (to return direct children), use the `.children()` method.

```javascript
$('#header-nav li:has(.sub-menu)').hover(function (event) {
    if ($(event.target).parents('.sub-menu').length > 0) {
        event.stopPropagation();
    } else {
        event.preventDefault();
    }
    $(this).find('ul').slideToggle();
});

```
Slide toggle open sub menu items with animated caret from Font Awesome.

Set up `wp_nav_menu()` like this. 

(The important item here is adding the font awesome element after the `<a>` element:

```php
wp_nav_menu(
    array(
        'theme_location' => 'header_menu',
        'depth' => 2,
        'container' => 'div',
        'container_class' => 'collapse navbar-collapse justify-content-center dual-collapse',
        'container_id'      => 'header-nav',
        'menu_class' => 'navbar-nav gap-2 p-1 ml-auto',
        'list_item_class' => 'nav-item',
        'link_class' => 'nav-link',
        'after' => '<i class="fa-solid fa-chevron-right"></i>'
    )
);

```
Then, the Javascript looks like this:

```javascript
$('#header-nav li:has(.sub-menu) i').click(function (event) {
    if ($(event.target).parents('.sub-menu').length > 0) {
        event.stopPropagation();
    }
    $(this).toggleClass('rotate');
    $(this).closest('.menu-item-has-children').find('ul').slideToggle(300, 'swing');
    $(this).closest('.menu-item-has-children').siblings().find('.sub-menu').slideUp();
    $(this).closest('.menu-item-has-children').siblings().find('i').removeClass('rotate');
});

```

This time, you target the Font Awesome `<i>` element. (Which can also be a span).

It starts with the same checks.

Then you toggle a CSS class for the rotation animation. Here, it’s “rotate”.

Then you use `.closest()` and `.find()` to go the sub-menu ul, and slide toggle it.

The next two lines are safeguards if the user doesn’t close the submenu, but just clicks away from it.

-Go the siblings and if the submenu is open, run `slideUp()`

-Go to the siblings and if the caret still has rotate on it, remove the class.

------

If you need a media query in the Javascript:

```javascript
function runThisCode() {
    const desktop = window.matchMedia('(min-width:992px)');
    const mobile = window.matchMedia('(max-width:991px)');

    if (desktop.matches) {
	//do something
	
	} else if (mobile.matches) {
	//do something
	
	}
}

```

Then, call the function on document load:

```javascript
$(document).ready(function(){
    runThisCode();
});

```

The CSS looks like this:

```css
/* --------------------------------------------- */
/* Responsive menu styling*/
/* --------------------------------------------- */

//Hide sub-menu items and reveal only as needed:
.menu-item {
  i {
    display: none;
  }
}

//Some styling that comes baked into Underscores.
//You may need to strip this out of the main stylesheet.

#header-nav {
  position: relative;
  ul {
    list-style-type: none;
    ul {
      position: absolute;
      left: -999em;
      margin: 0 !important;
    }
  }
}

#header-nav ul li:hover ul {
  left: auto;
  background: none scroll 0 0 rgba(255, 255, 255, 1);
  display: none;
  z-index: 9999;
}

@media (max-width:991px) {
  .navbar-collapse {
    ul {
      margin-left: 0;

      li {
        border-bottom: 1px solid #000;
        width: 100%;

        :last-child {
          border-bottom: 0;
        }
      }
    }
  }
//Here is where we animate the carets.
//The tricky part with Font Awesome is to transition both the i or span element AND its pseudo element.

  .menu-item-has-children {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    > i {
      padding: 10px;
      flex-grow: 1;
      transition: transform 200ms linear;
      display: flex;
      justify-content: flex-end;
      font-size: 1.2rem;
      &::before {
        transition: transform 200ms linear;
        transform: rotate(0);
      }
      &.rotate {
        &::before {
          transition: transform 200ms linear;
          transform: rotate(90deg);
        }
      }
    }
  }
  #header-nav ul ul {
    position: absolute;
    left: auto;
    top: 100%;
    padding: 8px 0;
    background: none scroll 0 0 rgba(255, 255, 255, 1);
    display: none;
    z-index: 9999;
    border: 1px solid black;
    width: 100%;
    box-shadow: 0 8px 16px rgba(0,0,0,0.8);
  }
}

```




