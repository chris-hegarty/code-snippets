# JS Script wrappers

For jQuery:

```javascript

( function( $ ) {


}( jQuery ) );


```

Vanilla JS:

```javascript

    $( document ).ready( function() {

    } );


```

Test if jQuery is loaded on the page:

```javascript
  if (typeof jQuery == 'undefined') {
    console.log("jQuery is not loaded");
  } else {
    console.log("jQuery is loaded");
  }
```