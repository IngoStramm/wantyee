<?php

add_action('admin_post_wt_redirect_anuncio_form', 'wt_redirect_anuncio_form_handle');
add_action('admin_post_nopriv_wt_redirect_anuncio_form', 'wt_redirect_anuncio_form_handle');

/**
 * wt_redirect_anuncio_form_handle
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

    if (!isset($_REQUEST['wt_form_redirect_anuncio_nonce']) || !wp_verify_nonce($_REQUEST['wt_form_redirect_anuncio_nonce'], 'wt_form_redirect_anuncio_nonce')) {

        $_SESSION['wt_redirect_anuncio_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    if (!isset($_REQUEST['action']) || $_REQUEST['action'] !== 'wt_redirect_anuncio_form') {

        $_SESSION['wt_redirect_anuncio_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    if (!isset($_REQUEST['wt_anuncio_id']) || !$_REQUEST['wt_anuncio_id']) {

        $_SESSION['wt_redirect_anuncio_error_message'] = __('ID do anúncio inválido.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    $post_id = $_REQUEST['wt_anuncio_id'];
    // $_SESSION['wp_anuncio_id'] = $post_id;
    echo '<h3>' . __('Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect($edit_anuncio_page_url . '?wt_anuncio_id=' . $post_id);
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

add_action('admin_post_wt_close_anuncio_form', 'wt_close_anuncio_form_handle');
add_action('admin_post_nopriv_wt_close_anuncio_form', 'wt_close_anuncio_form_handle');

/**
 * wt_close_anuncio_form_handle
 *
 * @return void
 */
function wt_close_anuncio_form_handle()
{
    nocache_headers();
    $edit_anuncio_page_id = wt_get_page_id('editanuncio');
    $edit_anuncio_page_url = $edit_anuncio_page_id ? wt_get_page_url('editanuncio') : wt_get_page_url('account');
    unset($_SESSION['wt_close_anuncio_error_message']);

    if (!isset($_POST['wt_anuncio_id']) || !$_POST['wt_anuncio_id']) {

        $_SESSION['wt_close_anuncio_error_message'] = __('ID do anúncio inválido.', 'wt');
        wp_safe_redirect($edit_anuncio_page_url);
        exit;
    }
    $post_id = $_POST['wt_anuncio_id'];

    if (!isset($_POST['wt_form_close_anuncio_nonce']) || !wp_verify_nonce($_POST['wt_form_close_anuncio_nonce'], 'wt_form_close_anuncio_nonce')) {

        $_SESSION['wt_close_anuncio_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($edit_anuncio_page_url . '?wt_anuncio_id=' . $post_id);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_close_anuncio_form') {

        $_SESSION['wt_close_anuncio_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($edit_anuncio_page_url . '?wt_anuncio_id=' . $post_id);
        exit;
    }

    $vendedor_id = null;
    if (isset($_POST['vendedor-id']) && $_POST['vendedor-id']) {
        $vendedor_id = $_POST['vendedor-id'];
    }

    if ($vendedor_id) {
        $vendedor_id = $vendedor_id === 'none' ? null : $vendedor_id;
    }

    $avaliacao_nota = null;
    if (isset($_POST['avaliacao-nota']) && $_POST['avaliacao-nota']) {
        $avaliacao_nota = $_POST['avaliacao-nota'];
    }

    $avaliacao_comentario = null;
    if (isset($_POST['avaliacao-comentario']) && $_POST['avaliacao-comentario']) {
        $avaliacao_comentario = $_POST['avaliacao-comentario'];
    }

    $user_id = null;
    if (isset($_POST['wt_user_id']) && $_POST['wt_user_id']) {
        $user_id = $_POST['wt_user_id'];
    }

    // Atualiza o status do anúncio
    // Por segurança, caso o valor do meta field seja um array é melhor apagar tudo
    $status_deleted = delete_post_meta($post_id, 'wt_anuncio_status');
    // wt_debug($status_deleted);

    $status_updated = add_post_meta($post_id, 'wt_anuncio_status', 'closed', true);
    // wt_debug($status_updated);

    // Cria a avaliação se um vendedor tiver sido selecionado
    if ($vendedor_id) {

        $user_data = get_userdata($user_id);
        $vendedor_data = get_userdata($vendedor_id);

        $title = sprintf(__('Avaliação criada para o anúncio %s, do comprador %s, para o vendedor %s.'), get_the_title($post_id), $user_data->display_name, $vendedor_data->display_name);

        $args = array(
            'post_title'                    => $title,
            'post_status'                   => 'publish',
            'post_author'                   => $user_id,
            'post_type'                     => 'avaliacoes',
        );

        if ($avaliacao_comentario) {
            $args['post_content'] = $avaliacao_comentario;
        }

        $meta_input = [];
        $meta_input['wt_avaliacao_anuncio_id'] = $post_id;
        $meta_input['wt_avaliacao_author_lead_id'] = $vendedor_id;

        if ($avaliacao_nota) {
            $meta_input['wt_avaliacao_nota'] = $avaliacao_nota;
        }

        $wt_avaliacao_lead_id = null;
        $leads = wt_get_anuncio_leads($post_id);
        foreach ($leads as $lead) {
            if ($lead->post_author === $vendedor_id) {
                $wt_avaliacao_lead_id = $lead->ID;
                continue;
            }
        }
        
        if ($wt_avaliacao_lead_id) {
            $meta_input['wt_avaliacao_lead_id'] = $wt_avaliacao_lead_id;
        }

        $args['meta_input'] = $meta_input;

        $nova_avaliacao = wp_insert_post($args, true);

        if (is_wp_error($nova_avaliacao)) {
            $_SESSION['wt_close_anuncio_error_message'] = $nova_avaliacao->get_error_message();
            wp_safe_redirect($edit_anuncio_page_url . '?wt_anuncio_id=' . $post_id);
            exit;
        }
    }

    $_SESSION['wp_anuncio_id'] = $post_id;
    // $_SESSION['wt_close_anuncio_success_message'] = __('Anúncio encerrado com sucesso.', 'wt');
    echo '<h3>' . __('Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect(get_permalink($post_id));
    exit;
}


add_action('update_anuncio_messages', 'wt_close_anuncio_error_message');

function wt_close_anuncio_error_message()
{
    if (isset($_SESSION['wt_close_anuncio_error_message']) && $_SESSION['wt_close_anuncio_error_message']) {
        echo wt_alert_small('danger', $_SESSION['wt_close_anuncio_error_message']);
        unset($_SESSION['wt_close_anuncio_error_message']);
    }
}

add_action('closed_anuncio_messages', 'wt_is_closed_anuncio_message');

function wt_is_closed_anuncio_message()
{
    $post_id = get_the_ID();
    if (!$post_id) {
        return;
    }

    $status = get_post_meta($post_id, 'wt_anuncio_status', true);
    if ($status === 'closed') {
        echo wt_alert(__('Anúncio encerrado.'));
    }
}
