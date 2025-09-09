
One example:

```php
function custom_login_logo() {
     echo '<style type="text/css">
     body {background-color: #000000 !important;}
     a {color: #FFFFFF !important;}
     h1 a {
          background-image:url("' . wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] . '") !important;
          -webkit-background-size: contain !important;
          background-size: contain !important;
          background-position: bottom !important;
          height: 150px !important;
          width: 100% !important;
          outline: none !important;}
     h1 a:focus {
          -webkit-box-shadow: none !important;
          box-shadow: none !important;}
     </style>';
}
add_action( 'login_head', 'custom_login_logo' );

```