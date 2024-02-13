<?php

/**
 * Template Name: Account Page
 * 
 * The template for User Account Page
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
    get_template_part('template-parts/content/content-account-page');

endwhile; // End of the loop.

get_footer();