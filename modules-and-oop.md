# JavaScript modules | OOP patterns | SPAs 

Think of JavaScript modules like PHP classes, where PHP looks like this:

```php
class SearchComponent {
    private $searchButton;
    private $searchForm;
    
    public function __construct() {
        $this->init();
    } 
    
    private function init(){
        //setup logic
    }
    
    public function destroy(){
    // cleanup logic
    }
}
```

A JavaScript module looks like this:

```javascript
Site.Search = function(){
    // Private variables (like PHP private properties)
  var $searchButton;
  var $searchForm;

    // Private functions (like PHP private methods)
    
    function init(){
        //setup logic
    }
    
    //public methods, like PHP public methods:
    
    this.destroy = function(){
      //cleanup logic  
    };
    
    // Constructor (like PHP __construct)
    
    this.__construct = function(){
        init();
    };
}
```

## Event management

This is similar to registering and unregistering WordPress hooks.

```javascript
// Like add_action() in WordPress:
function bindEvents(){
    $searchBtn.on('click.search', handleSearchButtonClick);
    $searchForm.on('blur.search', handleSearchFormBlur);
}
// Like remove_action() in WordPress  
function unbindEvents() {
    $searchBtn.off('.search');
    $searchForm.off('.search');
}

```

Why this matters: 

In single-page applications like Barba.js, pages don't refresh. 

Without proper cleanup, you get:

-Memory leaks
-Duplicate event handlers
-Broken functionality

The .search namespace is like namespacing in PHP - it lets you remove only YOUR events without affecting other code.

## Public Methods (this.methodName)

These are your public API - methods other code can call:

```javascript
// Public methods - accessible from outside
this.reinit = function() {
    unbindEvents();
    init();
};

this.destroy = function() {
    unbindEvents();
};
```

Usage: Other code can call `searchInstance.reinit()` just like calling `$object->reinit()` in PHP.

## Lifecycle Methods - The Big Picture

This is where it gets different from typical PHP. These modules need to handle page transitions.

The constructor runs once when the module is created. Reinitialize runs when moving between "pages". Destructor runs 
when the module is destroyed.

```javascript

// Constructor

this.__construct = function(){
    init(); //set everything up
};

//Reinitialize when moving between pages

this.reinit = function(){
    unbindEvents(); // Clean up old page
    init(); //set up new page
};

// Destructor - runs when module is destroyed

this.destroy = function(){
    unbindEvents(); //clean up everything
}

```

## Site.ExtendClass (the magic glue!)

This connects your module to the page transition system. 

Think of it like extending a base class in PHP:

```php
class Search extends BaseModule {
    //Here, the module automatically gets life cycle management
}

```
## Real World Example of building a new module

```javascript

Site.CookieBanner = function(){
    // 1. Set up variables, like PHP properties:
    var $banner = $(this); // The element this module is attached to
    var $acceptButton;
    var $rejectButton;
    var isAccepted = false;
    
    // 2. Private functions (like PHP private methods)
    
    function init(){
        // Cache DOM elements (query once, use many times)
        $acceptButton = $banner.find('.cookie-accept');
        $rejectButton = $banner.find('.cookie-reject');
        
        //Guard clause - exit if elements dont exist:
        
        if(!acceptButton.length || !$rejectButton.length){
            return;
        }
        // Set up event listeners
        bindEvents();
        // Check if already accepted
        checkCookieStatus();
        
        // define functions:
        
        function bindEvents(){
            //namespace events for clean removal:
            $acceptButton.on('click.cookieBanner', handleAccept);
            $rejectButton.on('click.cookieBanner', handleReject);
        }
    }
}

```
