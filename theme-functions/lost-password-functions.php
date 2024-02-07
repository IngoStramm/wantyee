<?php

add_action('login_form_lostpassword', 'wt_redirect_to_custom_lostpassword');

/** 
 * Redirects the user to the custom "Forgot your password?" page instead of 
 * wp-login.php?action=lostpassword. 
 * 
 * wt_redirect_to_custom_lostpassword
 *
 * @return void
 */
function wt_redirect_to_custom_lostpassword()
{
    if ('GET' === $_SERVER['REQUEST_METHOD']) {
        if (is_user_logged_in()) {
            wp_safe_redirect(get_home_url());
            exit;
        }
        wp_redirect(wt_get_page_url('lostpassword'));
        exit;
    }
}

add_action('admin_post_wt_lostpassword_form', 'wt_lostpassword_form_handle');
add_action('admin_post_nopriv_wt_lostpassword_form', 'wt_lostpassword_form_handle');

function wt_lostpassword_form_handle()
{
    nocache_headers();

    $login_page_id = wt_get_page_id('login');
    $login_page_url = $login_page_id ? wt_get_page_url('login') : get_home_url();

    $lostpassword_page_id = wt_get_page_id('lostpassword');
    $lostpassword_page_url = $lostpassword_page_id ? wt_get_page_url('lostpassword') : get_home_url();
    unset($_SESSION['wt_lostpassword_error_message']);

    if (!isset($_POST['wt_form_lostpassword_nonce']) || !wp_verify_nonce($_POST['wt_form_lostpassword_nonce'], 'wt_form_lostpassword_nonce')) {

        $_SESSION['wt_lostpassword_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($lostpassword_page_url);
        exit;
    }

    if (!isset($_POST['user_login']) || !$_POST['user_login']) {

        $_SESSION['wt_lostpassword_error_message'] = __('Usuário ou e-mail inválido.', 'wt');
        wp_safe_redirect($lostpassword_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_lostpassword_form') {

        $_SESSION['wt_lostpassword_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($lostpassword_page_url);
        exit;
    }

    $user_login = $_POST['user_login'];

    $lostpassword_result = retrieve_password($user_login);
    if (is_wp_error($lostpassword_result)) {
        // Errors found 
        $redirect_url = home_url('member-password-lost');
        $redirect_url = add_query_arg('errors', join(',', $lostpassword_result->get_error_codes()), $redirect_url);

        $error_string = $lostpassword_result->get_error_message() ? $lostpassword_result->get_error_message() : __('Login falhou. Verifique se os dados de login estão corretos e tente novamente.', 'wt');
        $_SESSION['wt_lostpassword_error_message'] = $error_string;
        wp_safe_redirect($lostpassword_page_url);
        exit;
    }

    $_SESSION['wt_lostpassword_success_message'] = __('E-mail de redefinição de senha enviado. Verifique as instruções no e-mail para redefinr a sua senha.', 'wt');

    echo '<h3>' . __('E-mail de redefinição de senha enviado com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect($login_page_url);
    exit;
}
