<?php

/**
 * Calculates classes for the main <html> element.
 *
 * @return void
 */
function wt_the_html_classes()
{
    /**
     * Filters the classes for the main <html> element.
     *
     * @param string The list of classes. Default empty string.
     */
    $classes = apply_filters('wt_html_classes', '');
    if (!$classes) {
        return;
    }
    echo 'class="' . esc_attr($classes) . '"';
}

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
add_filter('excerpt_length', 'wt_excerpt_length', 999);

function wt_excerpt_length($length)
{
    return 10;
}
add_action('pre_get_posts', 'wt_show_anuncios_instead_posts');

/**
 * wt_show_anuncios_instead_posts
 *
 * @param  object $wp_query
 * @return void
 */
function wt_show_anuncios_instead_posts($wp_query)
{
    if (is_home() && is_main_query() && !is_admin() && $wp_query->get('post_type') !== 'nav_menu_item') {
        // wt_debug($wp_query->get('post_type'));
        $wp_query->set('post_type', array('anuncios'));
    }
}

// add_action('wp_head', 'wt_test');
function wt_test()
{
    echo do_shortcode('[wt_editor]');
}
