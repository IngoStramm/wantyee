<?php

/**
 * Template Name: Meus Anúncios
 * 
 * The template for Meus Anúncios Criados
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
    get_template_part('template-parts/content/account/content-account-my-anuncios-page');

endwhile; // End of the loop.

get_footer();
