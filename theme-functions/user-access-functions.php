<?php

// add_action('wp', 'wt_forcelogin');

/**
 * wt_forcelogin
 *
 * @return void
 */
function wt_forcelogin()
{
    if (is_admin()) {
        return;
    }

    global $wp_query;
    $current_page_id = isset($wp_query->post->ID) ? $wp_query->post->ID : null;
    $login_page_id = wt_get_page_id('login');
    $new_user_page_id = wt_get_page_id('newuser');
    $lostpassword_page_id = wt_get_page_id('lostpassword');
    $resetpassword_page_id = wt_get_page_id('resetpassword');
    $account_page_id = wt_get_page_id('account');

    if ($account_page_id) {

        if (($current_page_id === (int)$login_page_id) ||
            ($current_page_id === (int)$new_user_page_id) ||
            ($current_page_id === (int)$lostpassword_page_id) ||
            ($current_page_id === (int)$resetpassword_page_id)
        ) {
            return;
        }

        if (!is_user_logged_in()) {
            $url = wt_get_url();
            $redirect_url = apply_filters('wt_forcelogin_redirect', $url);
            wp_safe_redirect(wt_get_page_url('login'), '302', $redirect_url);
            exit();
        }
    }
}


function wt_alert($text)
{
    $output = '';
    $output .= '<div class="alert alert-warning">';
    $output .= $text;
    $output .= '</div>';
    return $output;
}

function wt_alert_not_logged_in($text)
{
    $login_page_id = wt_get_page_id('login');
    if (!$login_page_id) {
        return;
    }
    $login_page_url = wt_get_page_url('login');
    $output = '';
    $output .= '<div class="alert alert-warning">';
    $output .= $text;
    $output .= '<br><a class="" href="';
    $output .= $login_page_url . '">' . __('Entrar', 'wt') . '</a></div>';
    return $output;
}
