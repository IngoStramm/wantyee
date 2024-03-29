<?php

/**
 * Template Name: Página Configuração de Categoria-de-Anúncio
 * 
 * The template for Categoria-de-Anúncio Settings User Account Page
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
    get_template_part('template-parts/content/account/content-account-terms-settings-page');

endwhile; // End of the loop.

get_footer();
