<?php

/**
 * Template Name: Reset Password Page
 * 
 * The template for Reset Password page
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
    get_template_part('template-parts/content/login/content-reset-password-page');

endwhile; // End of the loop.

get_footer();
