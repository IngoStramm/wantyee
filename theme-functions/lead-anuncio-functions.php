<?php

add_action('admin_post_wt_lead_anuncio_form', 'wt_lead_anuncio_form_handle');
add_action('admin_post_nopriv_wt_lead_anuncio_form', 'wt_lead_anuncio_form_handle');

/**
 * wt_register_new_user_handle
 *
 * @return void
 */
function wt_lead_anuncio_form_handle()
{
    nocache_headers();
    $http_origem = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : get_home_url();
    // wt_debug($_POST);
    unset($_SESSION['wt_lead_anuncio_error_message']);
    // exit;

    if (!isset($_POST['wt_form_lead_anuncio_nonce']) || !wp_verify_nonce($_POST['wt_form_lead_anuncio_nonce'], 'wt_form_lead_anuncio_nonce')) {

        $_SESSION['wt_lead_anuncio_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_lead_anuncio_form') {

        $_SESSION['wt_lead_anuncio_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    if (!isset($_POST['post_id']) || !$_POST['post_id']) {

        $_SESSION['wt_lead_anuncio_error_message'] = __('ID do anúncio inválido.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    $post_id = $_POST['post_id'];
    $post_link = get_page_link($post_id);
    $_SESSION['wt_lead_anuncio_success_message'] = __('O comprador irá receber a sua solicitação de contato. Além disso, você também pode entrar em contato com ele usando os dados abaixo.');
    echo '<h3>' . __('Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect($post_link);
    exit;
}

add_action('lead_anuncio_success_message', 'wt_lead_anuncio_success_message');

function wt_lead_anuncio_success_message()
{
    if (isset($_SESSION['wt_lead_anuncio_success_message']) && $_SESSION['wt_lead_anuncio_success_message']) {
        echo wt_alert_small('success', $_SESSION['wt_lead_anuncio_success_message']);
        unset($_SESSION['wt_lead_anuncio_success_message']);
    }
}

add_action('lead_anuncio_error_message', 'wt_lead_anuncio_error_message');

function wt_lead_anuncio_error_message()
{
    if (isset($_SESSION['wt_lead_anuncio_error_message']) && $_SESSION['wt_lead_anuncio_error_message']) {
        echo wt_alert_small('danger', $_SESSION['wt_lead_anuncio_error_message']);
        unset($_SESSION['wt_lead_anuncio_error_message']);
    }
}
