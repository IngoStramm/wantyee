<?php

/**
 * Template Name: Anúncios que solicitei contato
 * 
 * The template for Anúncios que solicitei contato Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Wantyee
 */

get_header();

do_action('account_announces');

/* Start the Loop */
while (have_posts()) :
    the_post();
    get_template_part('template-parts/content/account/content-account-contacted-anuncios-page');

endwhile; // End of the loop.

get_footer();
