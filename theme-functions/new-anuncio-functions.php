<?php

add_action('admin_post_wt_new_anuncio_form', 'wt_new_anuncio_form_handle');
add_action('admin_post_nopriv_wt_new_anuncio_form', 'wt_new_anuncio_form_handle');

/**
 * wt_update_user_handle
 *
 * @return void
 */
function wt_new_anuncio_form_handle()
{
    nocache_headers();
    $new_anuncio_page_id = wt_get_page_id('editanuncio');
    $account_page_url = $new_anuncio_page_id ? wt_get_page_url('editanuncio') : get_home_url();
    $post_id = isset($_POST['post_id']) && $_POST['post_id'] ? $_POST['post_id'] : null;
    $changed_thumbnail = isset($_POST['changed-thumbnail']) && $_POST['changed-thumbnail'] !== 'false';
    unset($_SESSION['wp_anuncio_id']);
    unset($_SESSION['wt_new_anuncio_error_message']);

    if (!isset($_POST['wt_form_new_anuncio_nonce']) || !wp_verify_nonce($_POST['wt_form_new_anuncio_nonce'], 'wt_form_new_anuncio_nonce')) {

        $_SESSION['wt_new_anuncio_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_new_anuncio_form') {

        $_SESSION['wt_new_anuncio_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['user_id']) || !$_POST['user_id']) {

        $_SESSION['wt_new_anuncio_error_message'] = __('ID do usuário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $user_id = $_POST['user_id'];

    $check_user_exists = get_user_by('id', $user_id);
    if (!$check_user_exists) {

        $_SESSION['wt_new_anuncio_error_message'] = __('Usuário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['anuncio_title']) || !$_POST['anuncio_title']) {

        $_SESSION['wt_new_anuncio_error_message'] = __('Título inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $title = wp_strip_all_tags($_POST['anuncio_title']);

    if (!isset($_POST['anuncio-content']) || !$_POST['anuncio-content']) {

        $_SESSION['wt_new_anuncio_error_message'] = __('Descrição inválida.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $content = $_POST['anuncio-content'];

    // if (!isset($_POST['terms']) || !$_POST['terms']) {

    //     $_SESSION['wt_new_anuncio_error_message'] = __('Categoria(s) inválida(s).', 'wt');
    //     wp_safe_redirect($account_page_url);
    //     exit;
    // }
    $terms_id = isset($_POST['terms']) && $_POST['terms'] ? $_POST['terms'] : null;

    if (!isset($_POST['anuncio_faq-perguntas']) || !$_POST['anuncio_faq-perguntas']) {

        $_SESSION['wt_new_anuncio_error_message'] = __('Pergunta(s) do FAQ inválida(s).', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $faq_perguntas = $_POST['anuncio_faq-perguntas'];

    if (!isset($_POST['anuncio_faq-respostas']) || !$_POST['anuncio_faq-respostas']) {

        $_SESSION['wt_new_anuncio_error_message'] = __('Resposta(s) do FAQ inválida(s).', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $faq_respostas = $_POST['anuncio_faq-respostas'];

    // if (!isset($_FILES['anuncio_image']['tmp_name']) || !$_FILES['anuncio_image']['tmp_name']) {

    //     $_SESSION['wt_new_anuncio_error_message'] = __('Imagem inválida.', 'wt');
    //     wp_safe_redirect($account_page_url);
    //     exit;
    // }
    $file = isset($_FILES['anuncio_image']['tmp_name']) || $_FILES['anuncio_image']['tmp_name'] ? $_FILES['anuncio_image']['tmp_name'] : null;

    $faq = [];
    foreach ($faq_perguntas as $key => $pergunta) {
        if (!is_null($pergunta) && !empty($pergunta)) {
            $item = array(
                'question'          => $pergunta,
                'answer'            => $faq_respostas[$key]
            );
            $faq[] = $item;
        }
    }

    $args = array(
        'post_title'        => $title,
        'post_content'      => $content,
        'post_status'       => 'publish',
        'post_author'       => $user_id,
        'post_type'         => 'anuncios',
        // 'tax_input' não funciona se o usuário não tiver permissão de 'assign_terms'
        // 'tax_input'         => array(
        //     'categoria-de-anuncio'     => $terms_id,
        // ),
        'meta_input'        => array(
            'wt_faq' =>     $faq,
        ),
    );

    if ($post_id) {
        $args['ID'] = $_POST['post_id'];
    }

    $novo_anuncio_id = wp_insert_post($args, true);

    if (is_wp_error($novo_anuncio_id)) {
        $_SESSION['wt_new_anuncio_error_message'] = $novo_anuncio_id->get_error_message();
        wp_safe_redirect($account_page_url);
        exit;
    }

    $insert_terms = '';

    if ($terms_id) {

        // Converte para int os IDs dos termos no array
        // Isso é necessário para que a função 'wp_set_object_terms' entenda que se trata de IDs,
        // senão ela irá criar novos termos tratando os IDs como se fossem títulos (ou slugs) dos termos
        // como não irá encontrar estes termos, então irá criar novos termos usando os IDs como título
        $int_terms_id = [];
        foreach ($terms_id as $term) {
            $int_terms_id[] = intval($term);
        }

        // os termos precisam ser inseridos após o post ser criado, 
        // porque o usuário não tem permissãi para criar termos
        $insert_terms = wp_set_object_terms($novo_anuncio_id, $int_terms_id, 'categoria-de-anuncio');
    } else {
        $tax = get_taxonomy('categoria-de-anuncio');
        $default_term = ($tax->default_term);
        $insert_terms = wp_set_object_terms($novo_anuncio_id, $default_term['slug'], 'categoria-de-anuncio');
    }

    if (is_wp_error($insert_terms)) {
        $_SESSION['wt_new_anuncio_error_message'] = $insert_terms->get_error_message();
        wp_safe_redirect($account_page_url);
        exit;
    }

    // Se for um novo anúncio ou se houve mudança na imagem
    if (!$post_id || $changed_thumbnail) {

        if ($file) {

            $filename = $_FILES['anuncio_image']['name'];
            $file_size = $_FILES['anuncio_image']['size'];

            if ($file_size > 2097152) {
                $_SESSION['wt_new_anuncio_error_message'] = __('O arquivo é muito pesado, o tamanho máximo permitido é de 2MB..', 'wt');
                wp_safe_redirect($account_page_url);
                exit;
            }

            $upload_file = wp_upload_bits($filename, null, @file_get_contents($file));
            if (!$upload_file['error']) {
                // Check the type of file. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype($filename, null);

                // Get the path to the upload directory.
                $wp_upload_dir = wp_upload_dir();

                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                    'post_parent'    => $novo_anuncio_id
                );

                // Insert the attachment.
                $attach_id = wp_insert_attachment($attachment, $upload_file['file'], $novo_anuncio_id);

                if (!is_wp_error($attach_id)) {
                    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    require_once(ABSPATH . 'wp-admin/includes/image.php');

                    // Generate the metadata for the attachment, and update the database record.
                    $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file['file']);
                    wp_update_attachment_metadata($attach_id, $attach_data);

                    set_post_thumbnail($novo_anuncio_id, $attach_id);
                } else {
                    $_SESSION['wt_new_anuncio_error_message'] = $attach_id->get_error_message();
                    wp_safe_redirect($account_page_url);
                    exit;
                }
            } else {
                $_SESSION['wt_new_anuncio_error_message'] = __('Ocorreu um erro ao tentar fazer o upload do arquivo.', 'wt');
                wp_safe_redirect($account_page_url);
                exit;
            }
        } else {
            $default_image = wt_get_option('wt_anuncio_default_image_id');
            if ($default_image) {
                set_post_thumbnail($novo_anuncio_id, $default_image);
            }
        }
    }

    $new_anuncio_link = get_page_link($novo_anuncio_id);
    if ($post_id) {
        $_SESSION['wt_new_anuncio_success_message'] = sprintf(__('Anúncio atualizado com sucesso! Ver <a href="%s">anúncio</a>.', 'wt'), $new_anuncio_link);
        echo '<h3>' . __('Anúncio atualizado com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';
    } else {
        $_SESSION['wt_new_anuncio_success_message'] = sprintf(__('Novo anúncio criado com sucesso! Ver <a href="%s">anúncio</a>.', 'wt'), $new_anuncio_link);
        echo '<h3>' . __('Novo anúncio criado com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';
    }

    wp_safe_redirect($account_page_url);
    exit;
}

add_action('update_anuncio_messages', 'wt_new_anuncio_error_message');

function wt_new_anuncio_error_message()
{
    // Mensagens de erro de novo anúncio
    if (isset($_SESSION['wt_new_anuncio_error_message']) && $_SESSION['wt_new_anuncio_error_message']) {
        echo wt_alert_small('danger', $_SESSION['wt_new_anuncio_error_message']);
        unset($_SESSION['wt_new_anuncio_error_message']);
    }
}

add_action('update_anuncio_messages', 'wt_new_anuncio_success_message');

function wt_new_anuncio_success_message()
{
    // Mensagens de successo de novo anúncio
    if (isset($_SESSION['wt_new_anuncio_success_message']) && $_SESSION['wt_new_anuncio_success_message']) {
        echo wt_alert_small('success', $_SESSION['wt_new_anuncio_success_message']);
        unset($_SESSION['wt_new_anuncio_success_message']);
    }
}
