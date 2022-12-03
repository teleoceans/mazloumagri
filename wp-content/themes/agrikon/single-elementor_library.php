<?php

/**
* The template for displaying all single posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package WordPress
* @subpackage Agrikon
* @since 1.0.0
*/

    remove_action( 'agrikon_header_action', 'agrikon_main_header', 10 );
    remove_action( 'agrikon_footer_action', 'agrikon_footer', 10 );

    get_header();

    while ( have_posts() ) : the_post();
        the_content();
    endwhile;

    get_footer();
?>
