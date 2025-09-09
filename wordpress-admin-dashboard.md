Add a custom box to the WordPress admin dashboard:

```php

function ktg_customize_dashboard(){
	wp_add_dashboard_widget('ktg_box','Welcome from brand Technology Group.','ktg_box_contents');
}

add_action('wp_dashboard_setup','ktg_customize_dashboard');

function ktg_box_contents(){

	$html = '';
	$html .= "<a style='font-weight:bold;' target='_blank' href='https://kiedrive.brand.com/:p:/g/personal/chris_hegarty_brand_com/EYw3AN2_jUtGvphdtAq_HfkBbe9Z6j9EQ2YrnW9sJgrmzg?e=YRdep3'>Click here for a quick start guide.</a>";
//	$html .= "<img style='width:100%;height=auto;' src='" . get_template_directory_uri() . "/assets/img/admin-info.png'>";
	echo $html;
}

```