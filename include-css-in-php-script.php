<?php

/**
 * Example of How to include CSS in a PHP script
 *
 */

?>

    <style type="text/css">
<?php
// Has the text been hidden?
if ( ! display_header_text() ) :
    ?>
    .site-title,
    .site-description {
    position: absolute;
    clip: rect(1px, 1px, 1px, 1px);
    }
<?php
// If the user has set a custom color for the text use that.
else :
    ?>
    .site-title a,
    .site-description {
    color: #<?php echo esc_attr( $header_text_color ); ?>;
    }
<?php endif; ?>
    </style>
<?php

