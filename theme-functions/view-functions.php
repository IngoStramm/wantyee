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
    if ((is_home() || is_author() || is_search()) && is_main_query() && !is_admin() && $wp_query->get('post_type') !== 'nav_menu_item') {
        $wp_query->set('post_type', array('anuncios'));
        $wp_query->set('meta_key', 'wt_anuncio_status');
        $wp_query->set('meta_value', 'open');
    }
}

/**
 * wt_account_nav
 *
 * @param  string $curr_account_page_id ('account', 'editanuncio', 'catanuncioconfig', 'myleads', 'myanuncios', 'contactedanuncios', 'followingtermsanuncios')
 * @return void
 */
function wt_account_nav($slug)
{
    $user = wp_get_current_user();
    $user_type = get_user_meta($user->get('id'), 'wt_user_type', true);
    $account_page_id = wt_get_page_id('account');
    $account_edit_anuncio_page_id = wt_get_page_id('editanuncio');
    $account_cat_config_anuncio_page_id = wt_get_page_id('catanuncioconfig');
    $page_new_leads_id = wt_get_page_id('myleads');
    $page_my_anuncios_id = wt_get_page_id('myanuncios');
    $page_contacted_anuncios_id = wt_get_page_id('contactedanuncios');
    $page_following_terms_anuncios_id = wt_get_page_id('followingtermsanuncios');
    $curr_account_page_id = wt_get_page_id($slug);
    if ($account_edit_anuncio_page_id || $account_cat_config_anuncio_page_id) {
        get_template_part('template-parts/content/account/content-account-nav', null, array(
            'account' => $account_page_id,
            'edit-anuncio' => $account_edit_anuncio_page_id,
            'cat-config' => $account_cat_config_anuncio_page_id,
            'curr-page' => $curr_account_page_id,
            'new-leads' => $page_new_leads_id,
            'my-anuncios' => $page_my_anuncios_id,
            'contacted-anuncios' => $page_contacted_anuncios_id,
            'following-terms-anuncios' => $page_following_terms_anuncios_id,
            'user-type' => $user_type,
        ));
    }
}

/**
 * wt_show_anuncio_terms_nav
 *
 * @param  WP_Term $terms
 * @return string
 */
function wt_show_anuncio_terms_nav($terms)
{
    $output = '';
    $output .= '
        <div class="terms-menu">
        <ul class="list-unstyled ps-0">';
    foreach ($terms as $term) {
        $term_id = $term->term_id;
        $term_name = $term->name;
        $term_slug = $term->slug;
        $term_link = get_term_link($term);
        if ($term->parent === 0) {
            $output .= '
                    <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#' . $term_slug . '" aria-expanded="false"></button>
                        <a href="' . $term_link . '" class="parent-term-name">' . $term_name . '</a>

                        <div class="collapse" id="' . $term_slug . '">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">';
            foreach ($terms as $term_child) {
                if ($term_child->parent === $term_id) {
                    $term_child_id = $term_child->term_id;
                    $term_child_name = $term_child->name;
                    $term_child_slug = $term_child->slug;
                    $term_child_link = get_term_link($term_child);
                    $output .= '
                                        <li><a href="' . $term_child_link . '" class="link-body-emphasis d-inline-flex text-decoration-none rounded">' . $term_child_name . '</a></li>';
                }
            }
            $output .= '
                            </ul>
                        </div>

                    </li>';
        }
    }
    $output .= '
        </ul>
    </div>
    ';
    return $output;
}

add_action('wp_head', 'wt_test');
function wt_test()
{
    $emails = wt_get_option('wt_contact_form_emails');
    // $filetype = wp_check_filetype($default_image, null);
    // $filename = basename($default_image);
    // $curr_user = wp_get_current_user();
    // $user_id = $curr_user->ID;
    // delete_user_meta($user_id, '_wt_new_leads');
    // $meta_value = 'Opa';
    // $new_user_meta = add_user_meta($user_id, '_wt_new_leads', $meta_value, false);
    // $get_new_user_meta = get_user_meta($user_id, '_wt_new_leads', false);
    wt_debug($emails);
    // wt_debug($filetype);
    // wt_debug($filename);
}
