<?php

    /**
     * Suppressing warnings in PHP
     *
     * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
     *
     */


    ini_set('display_errors','Off');
    ini_set('error_reporting', E_ALL );
    define('WP_DEBUG', false);
    define('WP_DEBUG_DISPLAY', false);
