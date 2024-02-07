<?php

/**
 * wt_login_form_handle
 *
 * @return void
 */
function wt_login_form_handle()
{
    nocache_headers();
    $login_page_id = wt_get_page_id('login');
    $login_page_url = $login_page_id ? wt_get_page_url('login') : get_home_url();
    unset($_SESSION['wt_login_error_message']);

    if (!isset($_POST['wt_form_login_nonce']) || !wp_verify_nonce($_POST['wt_form_login_nonce'], 'wt_form_login_nonce')) {

        $_SESSION['wt_login_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($login_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_login_form') {

        $_SESSION['wt_login_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($login_page_url);
        exit;
    }

    $login_result = wp_signon();

    if (is_wp_error($login_result)) {

        $error_string = $login_result->get_error_message() ? $login_result->get_error_message() : __('Login falhou. Verifique se os dados de login estão corretos e tente novamente.', 'wt');
        $_SESSION['wt_login_error_message'] = $error_string;
        wp_safe_redirect($login_page_url);
        exit;
    }

    $user = $login_result;

    $_SESSION['wt_login_success_message'] = wp_sprintf(__('Bem vindo de volta, %s!', 'wt'), $user->display_name);

    echo '<h3>' . __('Login feito com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect(get_home_url());
    exit;
}

add_action('wp_logout', 'wt_auto_redirect_after_logout');

/**
 * wt_auto_redirect_after_logout
 *
 * @return void
 */
function wt_auto_redirect_after_logout()
{
    wp_safe_redirect(get_home_url());
    exit;
}

/**
 * Recursive function to generate a unique username.
 *
 * If the username already exists, will add a numerical suffix which will increase until a unique username is found.
 *
 * @param string $username
 *
 * @return string The unique username.
 */
function wt_generate_unique_username($username)
{
    $username = sanitize_title($username);
    static $i;
    if (null === $i) {
        $i = 1;
    } else {
        $i++;
    }

    if (!username_exists($username)) {
        return $username;
    }

    $new_username = sprintf('%s-%s', $username, $i);

    if (!username_exists($new_username)) {
        return $new_username;
    } else {
        return call_user_func(__FUNCTION__, $username);
    }
}
