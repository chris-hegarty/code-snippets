function dark_theme(){
	$primary_color = get_field('primary_color', 'options');
	$row = get_field('row_50');
	$module_theme = $row['module_theme'];
    $background_color = '';
	if( $module_theme === 'dark-theme' ) {
        $background_color = 'style="background-color:'.$primary_color.'; color:#fff;"';
	}
	return $background_color;
}
$background = dark_theme();

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>"<?php echo (!empty( $background ) ? $background  : '' ) ?>>
