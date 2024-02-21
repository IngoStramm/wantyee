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

    $anuncio_id = $_POST['post_id'];
    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    $author_anuncio_id = get_post_field('post_author', $anuncio_id);
    $author_anuncio_data = get_userdata($author_anuncio_id);
    $anuncio_title = get_the_title($anuncio_id);
    $title = sprintf(__('Lead criado para o anúncio %s, do comprador %s, pelo vendedor %s.'), $anuncio_title, $author_anuncio_data->display_name, $curr_user->display_name);
    $has_leads = wt_get_leads($curr_user->ID, $anuncio_id, $author_anuncio_id);

    // Verifica se ainda não existe um lead deste vendedor para este anúncio
    // verificação dobrada (já ocorre na exibição do form no frontend)
    if (!$has_leads) {

        $args = array(
            'post_title'                    => $title,
            'post_status'                   => 'publish',
            'post_author'                   => $user_id,
            'post_type'                     => 'leads',
            'meta_input'                    => array(
                'wt_anuncio_id'             => $anuncio_id,
                'wt_author_anuncio_id'      => $author_anuncio_id,
            ),
        );

        $novo_lead_id = wp_insert_post($args, true);

        if (is_wp_error($novo_lead_id)) {
            $_SESSION['wt_lead_anuncio_error_message'] = $novo_lead_id->get_error_message();
            wp_safe_redirect($http_origem);
            exit;
        }
    }

    $post_link = get_page_link($anuncio_id);

    $to = $author_anuncio_data->get('user_email');
    $subject = sprintf(__('Novo Lead para o seu anúncio "%s"', 'wt'), get_the_title($anuncio_id));
    $body = '<h3>' . sprintf(__('O vendedor "%s" deseja entrar em contato com você', 'wt'), $curr_user->display_name) . '</h3>';
    $body .= '<p>' . __('Se quiser se adiantar e procurá-lo primeiro, estes são seus dados de contato:') . '</p>';
    $body .= '<ul>';
    if (get_user_meta($user_id, 'wt_user_whatsapp', true)) {
        $body .= '<li>' . __('WhatsApp: ', 'wt') . wt_format_phone_number(get_user_meta($user_id, 'wt_user_whatsapp', true)) . '</li>';
    }
    if (get_user_meta($user_id, 'wt_user_phone', true)) {
        $body .= '<li>' . __('Telefone: ', 'wt') . wt_format_phone_number(get_user_meta($user_id, 'wt_user_phone', true)) . '</li>';
    }
    $body .= '</ul>';
    $send_email_notification = wt_mail($to, $subject, $body);

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
