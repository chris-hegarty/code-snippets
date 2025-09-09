# JS Helper Snippets

### Run something on page scroll

Could be useful for adding/removing classes or triggering animations.

```js

	// Run on page scroll.
	$( window ).scroll( function() {

		// Toggle header class after threshold point.
		if ( 50 < $( document ).scrollTop() ) {
			$( '.site-container' ).addClass( 'shadow' );
		} else {
			$( '.site-container' ).removeClass( 'shadow' );
		}

	});

// Handler for click a show/hide button.
    $hsToggle.on( 'click', function( event ) {
    
      event.preventDefault();
    
      if ( $( this ).hasClass( 'close' ) ) {
        hideSearch();
      } else {
        showSearch();
      }
    
    });

    // Hide something on blur, like a search modal, when clicking outside it.
    $hsInput.on( 'blur', hideSearch );

    // Helper function to show the search form.
    function showSearch() {

      $header.addClass( 'search-visible' );
      $hsWrap.fadeIn( 'fast' ).find( 'input[type="search"]' ).focus();
      $hsToggle.attr( 'aria-expanded', true );

    }

    // Helper function to hide the search form.
    function hideSearch() {

      $hsWrap.fadeOut( 'fast' ).parents( '.site-header' ).removeClass( 'search-visible' );
      $hsToggle.attr( 'aria-expanded', false );

    }
```