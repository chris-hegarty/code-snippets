# Customizing the WordPress login screen

Source: https://codex.wordpress.org/Customizing_the_Login_Form

Add this bit of code in functions.php.
You'll need to adjust the background-image URL depending on where you're getting the logo.

This example will get an image uploaded to the Media section:

```php

function my_login_logo() { 

//This returns the /wp-content/uploads directory:
$uploads_directory = wp_upload_dir()['baseurl'] ;

?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url("<?php echo $uploads_directory; ?>/2024/08/logo-4c-600.png");
            max-height:65px;
            width:100%;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
    
<?php }

add_action( 'login_enqueue_scripts', 'my_login_logo' );

```

### If you want to use a logo that has been stored in your theme files:

It's a common pattern at brand to store images in an assets/img/ directory:

```php
?>
background-image: url("<?php echo get_template_directory_uri() . '/assets/img/' ; ?>/2024/08/logo-4c-600.png");
```
### If you want to use the logo that has been uploaded to the theme Customizer:
```php

	function customize_login_page() {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

		?>
		<style type="text/css">
          #login h1 a, .login h1 a {
            /*background-image: url("*/<?php //echo $uploads_directory; ?>/*/2024/08/logo-4c-600.png");*/
            background-image: url("<?php echo esc_url($logo[0]);   ?>");
            max-height:65px;
            width:100%;
            background-size: contain;
            background-repeat: no-repeat;
          }
		</style>
		<?php
	}

	add_action( 'login_enqueue_scripts', 'customize_login_page' );

```

### If you want to make and use a separate style sheet:

Another common pattern is to make an "admin" directory in your theme root, and enqueue a separate stylesheet.
So if you have "theme-name/admin/acf-admin.css", it would look like this:

```php

function my_login_logo() { 

//Enqueue the stylesheets:
wp_enqueue_style( 'acf-admin-styles', get_template_directory_uri() . '/admin/acf-admin.css' );

?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url("<?php echo $uploads_directory; ?>/2024/08/logo-4c-600.png");
            height:65px;
            width:320px;
            background-size: 320px 65px;
            background-repeat: no-repeat;
                padding-bottom: 30px;
        }
    </style>
    
<?php }

add_action( 'login_enqueue_scripts', 'my_login_logo' );

```

Then, inside that acf-admin.css file:

```css
.login #login h1 a {
    background-image: url('../../../uploads/2024/08/logo-4c-600.png');
    background-color: #efefef;
    height: 40px;
    width: 320px;
    background-size: 90%;
    background-repeat: no-repeat;
    background-position: center;
    padding-bottom: 10px;
}


```