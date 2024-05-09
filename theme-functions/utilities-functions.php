<?php

/**
 * wt_debug
 *
 * @param  mixed $a
 * @return string
 */
function wt_debug($a)
{
    echo '<pre>';
    var_dump($a);
    echo '</pre>';
}

/**
 * wt_version
 *
 * @return string
 */
function wt_version()
{
    $version = '1.0.6';
    return $version;
}

/**
 * wt_logo
 *
 * @return string
 */
function wt_logo()
{
    $html = '';
    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $image = wp_get_attachment_image_src($custom_logo_id, 'full');
        $html .= '<img class="site-logo img-fluid" src="' . $image[0] . '" />';
    }
    return $html;
}

/**
 * wt_check_if_plugin_is_active
 *
 * @param  string $plugin
 * @return boolean
 */
function wt_check_if_plugin_is_active($plugin)
{
    $active_plugins = get_option('active_plugins');
    return in_array($plugin, $active_plugins);
}

/**
 * wt_get_pages
 *
 * @return array
 */
function wt_get_pages()
{
    $pages = get_pages();
    $return_array = [];
    foreach ($pages as $page) {
        $return_array[$page->ID] = $page->post_title;
    }
    return $return_array;
}

/**
 * wt_get_option
 *
 * @param  string $key
 * @param  boolean $default
 * @return mixed
 */
function wt_get_option($key = '', $default = false)
{
    if (function_exists('cmb2_get_option')) {
        // Use cmb2_get_option as it passes through some key filters.
        return cmb2_get_option('wt_theme_options', $key, $default);
    }
    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option('wt_theme_options', $default);
    $val = $default;
    if ('all' == $key) {
        $val = $opts;
    } elseif (is_array($opts) && array_key_exists($key, $opts) && false !== $opts[$key]) {
        $val = $opts[$key];
    }
    return $val;
}

/**
 * wt_get_url
 *
 * @return string
 */
function wt_get_url()
{
    $url = $_SERVER['HTTP_HOST'];
    $url .= $_SERVER['REQUEST_URI'];
    return $url;
}

/**
 * wt_get_page_id
 *
 * @param  string $slug ('login', 'newuser', 'lostpassword', 'resetpassword', 'account', 'editanuncio', 'catanuncioconfig', 'myleads', 'myanuncios', 'contactedanuncios', 'followingtermsanuncios')
 * @return string
 */
function wt_get_page_id($slug)
{
    $return_id = '';
    switch ($slug) {
        case 'login':
            $login_page_id = wt_get_option('wt_login_page');
            if ($login_page_id) {
                $return_id = $login_page_id;
            }
            break;

        case 'newuser':
            $new_user_page_id = wt_get_option('wt_new_user_page');
            if ($new_user_page_id) {
                $return_id = $new_user_page_id;
            }
            break;

        case 'lostpassword':
            $lostpassword_page_id = wt_get_option('wt_lostpassword_page');
            if ($lostpassword_page_id) {
                $return_id = $lostpassword_page_id;
            }
            break;

        case 'resetpassword':
            $resetpassword_page_id = wt_get_option('wt_resetpassword_page');
            if ($resetpassword_page_id) {
                $return_id = $resetpassword_page_id;
            }
            break;

        case 'account':
            $account_page_id = wt_get_option('wt_account_page');
            if ($account_page_id) {
                $return_id = $account_page_id;
            }
            break;

        case 'editanuncio':
            $account_edit_anuncio_page_id = wt_get_option('wt_edit_anuncio_page');
            if ($account_edit_anuncio_page_id) {
                $return_id = $account_edit_anuncio_page_id;
            }
            break;

        case 'catanuncioconfig':
            $account_cat_config_anuncio_page_id = wt_get_option('wt_categorias_settings_page');
            if ($account_cat_config_anuncio_page_id) {
                $return_id = $account_cat_config_anuncio_page_id;
            }
            break;

        case 'myleads':
            $account_new_leads_page_id = wt_get_option('wt_my_leads_page');
            if ($account_new_leads_page_id) {
                $return_id = $account_new_leads_page_id;
            }
            break;

        case 'myanuncios':
            $account_my_leads_page_id = wt_get_option('wt_my_anuncios_page');
            if ($account_my_leads_page_id) {
                $return_id = $account_my_leads_page_id;
            }
            break;

        case 'contactedanuncios':
            $account_contacted_anuncios_page_id = wt_get_option('wt_contacted_anuncios_page');
            if ($account_contacted_anuncios_page_id) {
                $return_id = $account_contacted_anuncios_page_id;
            }
            break;

        case 'followingtermsanuncios':
            $account_following_terms_anuncios_page_id = wt_get_option('wt_following_terms_anuncios_page');
            if ($account_following_terms_anuncios_page_id) {
                $return_id = $account_following_terms_anuncios_page_id;
            }
            break;

        default:
            $return_id = get_option('page_for_posts');
            break;
    }
    return $return_id;
}

/**
 * wt_get_page_url
 *
 * @param  string $slug ('login', 'newuser', 'lostpassword', 'resetpassword', 'account', 'editanuncio', 'catanuncioconfig', 'myleads', 'myanuncios', 'contactedanuncios', 'followingtermsanuncios')
 * @return string
 */
function wt_get_page_url($slug)
{
    $return_url = '';
    switch ($slug) {
        case 'login':
            $login_page_id = wt_get_page_id('login');
            if ($login_page_id) {
                $return_url = get_page_link($login_page_id);
            }
            break;

        case 'newuser':
            $new_user_page_id = wt_get_page_id('newuser');
            if ($new_user_page_id) {
                $return_url = get_page_link($new_user_page_id);
            }
            break;

        case 'lostpassword':
            $lostpassword_page_id = wt_get_page_id('lostpassword');
            if ($lostpassword_page_id) {
                $return_url = get_page_link($lostpassword_page_id);
            }
            break;

        case 'resetpassword':
            $resetpassword_page_id = wt_get_page_id('resetpassword');
            if ($resetpassword_page_id) {
                $return_url = get_page_link($resetpassword_page_id);
            }
            break;

        case 'account':
            $account_page_id = wt_get_page_id('account');
            if ($account_page_id) {
                $return_url = get_page_link($account_page_id);
            }
            break;

        case 'editanuncio':
            $account_edit_anuncio_page_id = wt_get_page_id('editanuncio');
            if ($account_edit_anuncio_page_id) {
                $return_url = get_page_link($account_edit_anuncio_page_id);
            }
            break;

        case 'catanuncioconfig':
            $account_cat_config_anuncio_page_id = wt_get_page_id('catanuncioconfig');
            if ($account_cat_config_anuncio_page_id) {
                $return_url = get_page_link($account_cat_config_anuncio_page_id);
            }
            break;

        case 'myleads':
            $account_my_leads_page_id = wt_get_page_id('myleads');
            if ($account_my_leads_page_id) {
                $return_url = get_page_link($account_my_leads_page_id);
            }
            break;

        case 'myanuncios':
            $account_my_leads_page_id = wt_get_page_id('myanuncios');
            if ($account_my_leads_page_id) {
                $return_url = get_page_link($account_my_leads_page_id);
            }
            break;

        case 'contactedanuncios':
            $account_contacted_anuncios_page_id = wt_get_page_id('contactedanuncios');
            if ($account_contacted_anuncios_page_id) {
                $return_url = get_page_link($account_contacted_anuncios_page_id);
            }
            break;

        case 'followingtermsanuncios':
            $account_following_terms_anuncios_page_id = wt_get_page_id('followingtermsanuncios');
            if ($account_following_terms_anuncios_page_id) {
                $return_url = get_page_link($account_following_terms_anuncios_page_id);
            }
            break;

        default:
            $return_url = get_home_url();
            break;
    }
    return $return_url;
}

/**
 * wt_anuncio_terms
 *
 * @return array
 */
function wt_anuncio_terms()
{
    $terms = get_terms(array(
        'taxonomy'   => 'categoria-de-anuncio',
        'hide_empty' => false,
    ));
    $array_terms = array();
    foreach ($terms as $term) {
        if (!$term->parent) {
            $array_terms[$term->term_id] = $term->name;
            foreach ($terms as $term2) {
                if ($term2->parent === $term->term_id) {
                    $array_terms[$term2->term_id] = $term2->name;
                }
            }
        }
    }
    return $array_terms;
}



/**
 * wt_alert_small
 *
 * @param  string $type
 * @param  string $message
 * @return string
 */
function wt_alert_small($type = 'success', $message)
{
    if (!$message) {
        return;
    }
    $output = '';
    $output .= '
    <div class="alert alert-' . $type . ' alert-dismissible d-flex align-items-center gap-2 fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>' . $message . '</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
    return $output;
}

/**
 * Pagination.
 *
 * @since  2.2.0
 *
 * @global array $wp_query   Current WP Query.
 * @global array $wp_rewrite URL rewrite rules.
 *
 * @param  int   $mid   Total of items that will show along with the current page.
 * @param  int   $end   Total of items displayed for the last few pages.
 * @param  bool  $show  Show all items.
 * @param  mixed $query Custom query.
 *
 * @return string       Return the pagination.
 */
function wt_pagination($mid = 2, $end = 1, $show = false, $query = null)
{
    // Prevent show pagination number if Infinite Scroll of JetPack is active.
    if (!isset($_GET['infinity'])) {

        global $wp_query, $wp_rewrite;

        $total_pages = $wp_query->max_num_pages;

        if (is_object($query) && null != $query) {
            $total_pages = $query->max_num_pages;
        }

        if ($total_pages > 1) {
            $url_base = $wp_rewrite->pagination_base;
            $big = 999999999;

            // Sets the paginate_links arguments.
            $arguments = apply_filters(
                'odin_pagination_args',
                array(
                    'base'      => esc_url_raw(str_replace($big, '%#%', get_pagenum_link($big, false))),
                    'format'    => '',
                    'current'   => max(1, get_query_var('paged')),
                    'total'     => $total_pages,
                    'show_all'  => $show,
                    'end_size'  => $end,
                    'mid_size'  => $mid,
                    'type'      => 'list',
                    'prev_text' => '<span aria-hidden="true">&laquo;</span>',
                    'next_text' => '<span aria-hidden="true">&raquo;</span>',
                )
            );

            // Aplica o HTML/classes CSS do bootstrap
            $wt_paginate_links = paginate_links($arguments);
            // $wt_paginate_links = str_replace('page-numbers', 'pagination', paginate_links($arguments));
            $wt_paginate_links = str_replace('<li>', '<li class="page-item">', $wt_paginate_links);
            $wt_paginate_links = str_replace('<li class="page-item"><span aria-current="page" class="page-numbers current">', '<li class="page-item active"><a class="page-link" href="">', $wt_paginate_links);
            $wt_paginate_links = str_replace('</span></li>', '</a></li>', $wt_paginate_links);
            $wt_paginate_links = str_replace('<a class="page-numbers"', '<a class="page-link"', $wt_paginate_links);
            $wt_paginate_links = str_replace('page-numbers dots', 'page-link dots', $wt_paginate_links);
            $wt_paginate_links = str_replace('<a class="next page-numbers"', '<a class="page-link"', $wt_paginate_links);
            $wt_paginate_links = str_replace('<a class="prev page-numbers"', '<a class="page-link"', $wt_paginate_links);
            $wt_paginate_links = str_replace('<span class="page-link dots">', '<a class="page-link dots" href="">', $wt_paginate_links);
            $wt_paginate_links = str_replace('</span>', '</a>', $wt_paginate_links);
            $wt_paginate_links = str_replace('<ul class=\'page-numbers\'>', '<ul class="pagination justify-content-center">', $wt_paginate_links);
            $wt_paginate_links = str_replace('<li class="page-item"><a class="page-link dots" href="">', '<li class="page-item disabled"><a class="page-link dots" href="">', $wt_paginate_links);

            $pagination = '<div class="my-4"><nav aria-label="Page navigation">' . $wt_paginate_links . '</nav></div>';

            // Prevents duplicate bars in the middle of the url.
            if ($url_base) {
                $pagination = str_replace('//' . $url_base . '/', '/' . $url_base . '/', $pagination);
            }

            return $pagination;
        }
    }
}

if (!function_exists('wt_paging_nav')) {

    /**
     * Print HTML with meta information for the current post-date/time and author.
     *
     * @since 2.2.0
     */
    function wt_paging_nav()
    {
        $mid  = 2;     // Total of items that will show along with the current page.
        $end  = 1;     // Total of items displayed for the last few pages.
        $show = false; // Show all items.

        echo wt_pagination($mid, $end, false);
    }
}

/**
 * wt_check_anuncio_has_leads
 *
 * @param  string/int $vendedor_id
 * @param  string/int $anuncio_id
 * @param  string/int $comprador_id
 * @return void
 */
function wt_check_anuncio_has_leads($vendedor_id, $anuncio_id, $comprador_id)
{
    $leads = get_posts(
        array(
            'post_type'             => 'leads',
            'posts_per_page'        => -1,
            'status'                => 'published',
            'author'                => $vendedor_id,
            'meta_query'            => array(
                'relation'          => 'AND',
                array(
                    'key'      => 'wt_anuncio_id',
                    'value'    => $anuncio_id,
                ),
                array(
                    'key'      => 'wt_author_anuncio_id',
                    'value'    => $comprador_id,
                ),
            )
        )
    );
    wp_reset_postdata();
    return count($leads) > 0;
}

/**
 * wt_get_comprador_leads
 *
 * @param  string $comprador_id
 * @return array
 */
function wt_get_comprador_leads($comprador_id)
{
    $leads = get_posts(
        array(
            'post_type'             => 'leads',
            'posts_per_page'        => -1,
            'status'                => 'published',
            'meta_query'            => array(
                'relation'          => 'AND',
                array(
                    'key'      => 'wt_author_anuncio_id',
                    'value'    => $comprador_id,
                ),
            )
        )
    );
    wp_reset_postdata();
    return $leads;
}

function wt_get_vendedor_following_terms_anuncios($vendedor_id)
{
    $user_type = get_user_meta($vendedor_id, 'wt_user_type', true);
    if ($user_type !== 'vendedor') {
        return;
    }
    $wt_user_following_terms = get_user_meta($vendedor_id, 'wt_user_following_terms', true);
    $args = array(
        'post_type' => 'anuncios',
        'posts_per_page' => -1,
        'status'    => 'published',
        'tax_query' => array(
            array(
                'taxonomy' => 'categoria-de-anuncio',
                'field' => 'term_id',
                'terms' => $wt_user_following_terms,
            ),
        ),
    );
    $anuncios = get_posts($args);
    wp_reset_postdata();
    return $anuncios;
}


/**
 * wt_format_phone_number
 *
 * @param  string $phone
 * @return string
 */
function wt_format_phone_number($phone)
{
    $formated_phone = preg_replace('/[^0-9]/', '', $phone);
    $matches = [];
    preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $formated_phone, $matches);
    if ($matches) {
        return '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
    }
    return $phone;
}

/**
 * wt_check_if_vendedor_has_new_anuncios
 *
 * @param  int $user_id
 * @return boolean
 */
function wt_check_if_vendedor_has_new_anuncios($user_id)
{
    if (!isset($user_id) || !$user_id) {
        return false;
    }

    $last_time_checked_for_new_anuncios = get_user_meta($user_id, '_last_time_checked_for_new_anuncios', true);
    $wt_user_following_terms = get_user_meta($user_id, 'wt_user_following_terms', true);
    $args = array(
        'post_type' => 'anuncios',
        'posts_per_page' => -1,
        'status'    => 'published',
        'tax_query' => array(
            array(
                'taxonomy' => 'categoria-de-anuncio',
                'field' => 'term_id',
                'terms' => $wt_user_following_terms,
            ),
        ),
        // 'date_query' => array(
        //     'after' =>
        //     array(
        //         'year' => date('Y', intval($last_time_checked_for_new_anuncios)),
        //         'month' => date('m', intval($last_time_checked_for_new_anuncios)),
        //         'day' => date('d', intval($last_time_checked_for_new_anuncios)),
        //     )
        // )
    );
    $last_anuncios_from_day_before = get_posts($args);
    $new_anuncios = [];
    // converte para data
    $last_time_checked_for_new_anuncios = intval($last_time_checked_for_new_anuncios);
    // wt_debug(number_format($last_time_checked_for_new_anuncios, 0, ',', '.'));

    foreach ($last_anuncios_from_day_before as $anuncio) {

        // converte para data
        // usando post_date_gmt para a data do post ser consistente com a data do servidor
        $post_date_timestamp = strtotime($anuncio->post_date_gmt);

        // Por segurnaça, converte para número inteiro
        $post_date_timestamp = intval($post_date_timestamp);
        // wt_debug(number_format($post_date_timestamp, 0, ',', '.'));

        // Verifica se a data do post é mais nova (maior) que a data do login
        $is_new_post = $post_date_timestamp > $last_time_checked_for_new_anuncios;
        // wt_debug($is_new_post);

        // Caso afirmativo, salva o post no array
        if ($is_new_post) {
            $new_anuncios[] = $anuncio;
        }
    }
    wp_reset_postdata();
    return !count($new_anuncios);
}
