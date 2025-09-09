<?php

    $img = get_sub_field('image');
    if($img) :
        $src = $img['url'];
        $alt = acf_set_alt($img);
    endif;

    $link = get_sub_field('link');
    if($link) :
        $url = $link['url'];
        $title = $link['title'];
        $target = $link['target'] ? : '_self';
    endif;

