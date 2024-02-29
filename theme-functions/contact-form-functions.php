<?php

function wt_get_field_value($name)
{
    $value = isset($_POST[$name]) && !is_null($_POST[$name]) ? $_POST[$name] : null;
    if (!$value) {
        // retorna uma mensagem de erro com o campo 'success' falso
        wp_send_json_error(array('msg' => __("Campo \"$name\" não foi passado ou está vazio.", 'cl')), 200);
    }
    return $value;
}

add_action('wp_ajax_nopriv_wt_contact_form', 'wt_contact_form');
add_action('wp_ajax_wt_contact_form', 'wt_contact_form');

function wt_contact_form()
{

    if (!isset($_POST['wt_contact_form_nonce']) || !wp_verify_nonce($_POST['wt_contact_form_nonce'], 'wt_contact_form_nonce')) {
        wp_send_json_error(array('msg' => __('Não foi possível validar a requisição.', 'wt')), 200);
    }

    $fields = array('nome', 'email', 'mensagem');
    $data = [];
    foreach ($fields as $name) {
        $data[$name] = wt_get_field_value($name);
    }

    $to = 'teste@teste.com';
    $subject = sprintf(__('Nova mensagem de contato | %s', 'wt'), get_bloginfo('name'));
    $body = '';
    $body .= '<p>' . sprintf(__('Nome: "%s"', 'wt'), $data['nome']) . '</p>';
    $body .= '<p>' . sprintf(__('Email: "%s"', 'wt'), $data['email']) . '</p>';
    $body .= '<p>' . sprintf(__('Mensagem: "%s"', 'wt'), $data['mensagem']) . '</p>';
    $send_email_notification = wt_mail($to, $subject, $body);

    if (!$send_email_notification) {
        wp_send_json_error(array('msg' => __('Ocorreu um erro ao tentar enviar a sua mensagem.', 'wt')), 200);
    }
    
    $response = array(
        'msg'                   => __('Mensagem enviada com sucesso!', 'wt'),
    );

    wp_send_json_success($response);
}
