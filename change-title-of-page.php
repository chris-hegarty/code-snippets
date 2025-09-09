<?php
    /**
     * Example of changing the title of a page
     *
     * Uses document_title_parts filter:
     *
     * @link https://developer.wordpress.org/reference/hooks/document_title_parts/
     *
     */


    function mcnally_custom_title( $title_parts ){
        if (is_tax('specialties')):
            $title_parts['title'] = mcnally_tax_custom_title();
        endif;
        return $title_parts;
    }
    add_filter( 'document_title_parts', 'mcnally_custom_title' );

/*

The $title_parts parameter is an array of the document title parts:
The document title parts.
•	title string
Title of the viewed page.
•	page string
Optional. Page number if paginated.
    •	tagline string
Optional. Site description when on home page.
•	site string
Optional. Site title when not on home page.

*/

