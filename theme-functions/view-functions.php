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

/**
 * wt_account_nav
 *
 * @param  string $curr_account_page_id ('account', 'editanuncio', 'catanuncioconfig')
 * @return void
 */
function wt_account_nav($slug)
{
    $user = wp_get_current_user();
    $user_type = get_user_meta($user->get('id'), 'wt_user_type', true);
    $account_page_id = wt_get_page_id('account');
    $account_edit_anuncio_page_id = wt_get_page_id('editanuncio');
    $account_cat_config_anuncio_page_id = wt_get_page_id('catanuncioconfig');
    $curr_account_page_id = wt_get_page_id($slug);
    if ($account_edit_anuncio_page_id || $account_cat_config_anuncio_page_id) {
        get_template_part('template-parts/content/account/content-account-nav', null, array(
            'account' => $account_page_id,
            'edit-anuncio' => $account_edit_anuncio_page_id,
            'cat-config' => $account_cat_config_anuncio_page_id,
            'curr-page' => $curr_account_page_id,
            'user-type' => $user_type
        ));
    }
}

// add_action('wp_head', 'wt_test');
function wt_test()
{
    echo do_shortcode('[wt_editor]');
}
