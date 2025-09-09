Interesting function:

```php

function add_custom_headers() {
// These are now handled by NGINX in its config file, setting these here sends them to the client TWICE
/*
    add_filter( 'rest_pre_serve_request', function( $value ) {
        //header( 'Access-Control-Allow-Headers: Authorization, X-WP-Nonce,Content-Type, X-Requested-With');
        //header( 'Access-Control-Allow-Headers: Authorization,*');
        //header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE' );
        header( 'Access-Control-Allow-Credentials: true' );

        return $value;
    } );
/**/
}
add_action( 'rest_api_init', 'add_custom_headers', 15 );


```