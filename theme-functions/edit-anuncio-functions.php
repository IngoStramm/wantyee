<?php

add_action('admin_post_wt_redirect_anuncio_form', 'wt_redirect_anuncio_form_handle');
add_action('admin_post_nopriv_wt_redirect_anuncio_form', 'wt_redirect_anuncio_form_handle');

/**
 * wt_register_new_user_handle
 *
 * @return void
 */
function wt_redirect_anuncio_form_handle()
{
    nocache_headers();
    $http_origem = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : get_home_url();
    $edit_anuncio_page_id = wt_get_page_id('editanuncio');
    $edit_anuncio_page_url = $edit_anuncio_page_id ? wt_get_page_url('editanuncio') : $http_origem;
    unset($_SESSION['wt_redirect_anuncio_error_message']);

    if (!isset($_POST['wt_form_redirect_anuncio_nonce']) || !wp_verify_nonce($_POST['wt_form_redirect_anuncio_nonce'], 'wt_form_redirect_anuncio_nonce')) {

        $_SESSION['wt_redirect_anuncio_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_redirect_anuncio_form') {

        $_SESSION['wt_redirect_anuncio_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    if (!isset($_POST['post_id']) || !$_POST['post_id']) {

        $_SESSION['wt_redirect_anuncio_error_message'] = __('ID do anúncio inválido.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    $post_id = $_POST['post_id'];
    $_SESSION['wp_anuncio_id'] = $post_id;
    echo '<h3>' . __('Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect($edit_anuncio_page_url);
    exit;
}

add_action('redirect_anuncio_messages', 'wt_redirect_anuncio_error_message');

function wt_redirect_anuncio_error_message()
{
    if (isset($_SESSION['wt_redirect_anuncio_error_message']) && $_SESSION['wt_redirect_anuncio_error_message']) {
        echo wt_alert_small('danger', $_SESSION['wt_redirect_anuncio_error_message']);
        unset($_SESSION['wt_redirect_anuncio_error_message']);
    }
}
