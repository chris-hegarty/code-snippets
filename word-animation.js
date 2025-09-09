$( document ).ready( function() {
  let wordCount;
  let wordInterval;
  let currentWord = 0;
  let previousWord = 0;

  // eslint-disable-next-line prefer-const
  wordCount = $( '.word-slide' ).length;
  //use .eq to get the 1st word and only give it a top of 5px.
  $( '.word-slide:eq(' + currentWord + ')' ).animate( { top: 5 }, 'fast' );

  // eslint-disable-next-line no-unused-vars,prefer-const
  wordInterval = setInterval( wordRotate, 2000 );
  // eslint-disable-next-line no-mixed-spaces-and-tabs
  function wordRotate() {
    currentWord = ( previousWord + 1 ) % wordCount;
    // eslint-disable-next-line no-mixed-spaces-and-tabs
    $( '.word-slide:eq(' + previousWord + ')' ).animate( { top: -205 },
      'slow',
      function() {
        $( this ).css( 'top', '210px' );
      } );
    $( '.word-slide:eq(' + currentWord + ')' ).animate( { top: 5 }, 'slow' );
    previousWord = currentWord;
  }
} );
