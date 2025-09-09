# Customize an ACF color picker

Note: There is probably a better way to do this within a js file, but still need to look into that.

This code will output brand colors:
```php


    /**
     *ACF color picker customizations.
     * Description:
     * This changes the default colors in the ACF color picker to brand colors.
     * Sources:
     * https://www.advancedcustomfields.com/resources/color-picker/
     * https://www.advancedcustomfields.com/resources/javascript-api/#filters-color_picker_args
     */
    function acf_custom_color_picker() {
        ?>
        <script type="text/javascript">
          (function ($) {
            acf.add_filter('color_picker_args', function (args, $field) {
              console.log(args);
              args.palettes = [
                "#000000",
                "#ffd200",
                "#525252",
                "#ffffff",
                "#2f2e2f",
                "#d3d3d3",
                "#474c55"
              ]
              return args;
            });
          })(jQuery);
        </script>
    <?php }

    add_action( 'acf/input/admin_footer', 'acf_custom_color_picker' );

```
If we add a global option/field to set a primary theme color, here is how we include that in the color picker:

```php

/**
*ACF color picker customizations.
* Description:
* This changes the default colors in the ACF color picker to brand colors.
* Sources:
* https://www.advancedcustomfields.com/resources/color-picker/
* https://www.advancedcustomfields.com/resources/javascript-api/#filters-color_picker_args
  */
  function acf_custom_color_picker() {

  $primary_color = get_field('global_primary_color','options');
  ?>

  <script type="text/javascript">
  	(function ($) {
  		acf.add_filter('color_picker_args', function (args, $field) {
  			args.palettes = [
  				<?php echo $primary_color ? " '{$primary_color}', " : '' ?>
  				'#000000',
  				'#ffffff',
  				'#d3d3d3',
  				'#525252',
  				'#474c55',
  				'#2f2e2f',
  			]
  			return args;
  		});
  	})(jQuery);
  </script>
<?php }

add_action( 'acf/input/admin_footer', 'acf_custom_color_picker' );

```