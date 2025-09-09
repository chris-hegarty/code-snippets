<?php

//If no alt tag is set for images, this will grab and use the title:
//Credit: https://julienmelissas.com/setting-the-alt-attribute-from-an-acf-image-object/
    function acf_set_alt($img) {
        $alt = $img['alt'];
        if(!empty($alt)) {
            return $alt;
        } else {
            $title = $img['title'];
            $title = preg_replace('%\s*[-_\s]+\s*%', ' ', $title);
            $title = ucwords(strtolower($title));
            $img['alt'] = $title;
            return $title;
        }
    }

    //Set the alt variable:

    $img = get_field(‘’);
    if($img) :
        $src = $img['url'];
        $alt = acf_set_alt($img);
    endif;

    ?>

<!--    Use in the image tag like this:-->

<img src="<?php echo $src; ?>" alt="<?php echo $alt; ?>">







