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
    $version = '1.0.0';
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
 * @param  string $slug
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

        default:
            $return_id = get_option('page_for_posts');
            break;
    }
    return $return_id;
}

/**
 * wt_get_page_url
 *
 * @param  string $slug
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

        default:
            $return_url = get_home_url();
            break;
    }
    return $return_url;
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
