<?php

/**
 * Template Name: Create/Edit Anuncio Post Type
 * 
 * The template for Create/Edit Anuncio Post Type User Account Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Wantyee
 */

get_header();

/* Start the Loop */
while (have_posts()) :
    the_post();
    get_template_part('template-parts/content/account/content-account-new-anuncio-page');

endwhile; // End of the loop.

get_footer();
