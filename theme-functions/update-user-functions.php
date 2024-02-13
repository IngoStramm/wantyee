<?php

add_action('admin_post_wt_update_user_form', 'wt_update_user_form_handle');
add_action('admin_post_nopriv_wt_update_user_form', 'wt_update_user_form_handle');

/**
 * wt_update_user_handle
 *
 * @return void
 */
function wt_update_user_form_handle()
{
    nocache_headers();
    $account_page_id = wt_get_option('wt_account_page');
    $account_page_url = $account_page_id ? get_page_link($account_page_id) : get_home_url();
    unset($_SESSION['wt_update_user_error_message']);

    if (!isset($_POST['wt_form_update_user_nonce']) || !wp_verify_nonce($_POST['wt_form_update_user_nonce'], 'wt_form_update_user_nonce')) {

        $_SESSION['wt_update_user_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_update_user_form') {

        $_SESSION['wt_update_user_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['user_id']) || !$_POST['user_id']) {

        $_SESSION['wt_update_user_error_message'] = __('ID do usuário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $user_id = $_POST['user_id'];

    $check_user_exists = get_user_by('id', $user_id);
    if (!$check_user_exists) {

        $_SESSION['wt_update_user_error_message'] = __('Usuário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    $user_name = (isset($_POST['user_name']) && $_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : null;

    $user_surname = (isset($_POST['user_surname']) && $_POST['user_surname']) ? sanitize_text_field($_POST['user_surname']) : null;

    $user_email = (isset($_POST['user_email']) && $_POST['user_email']) ? sanitize_email($_POST['user_email']) : null;

    $user_whatsapp = (isset($_POST['user_whatsapp']) && $_POST['user_whatsapp']) ? preg_replace('/[^0-9]/', '', $_POST['user_whatsapp']) : null;

    $user_phone = (isset($_POST['user_phone']) && $_POST['user_phone']) ? preg_replace('/[^0-9]/', '', $_POST['user_phone']) : null;

    $user_password = (isset($_POST['user_pass']) && $_POST['user_pass']) ? $_POST['user_pass'] : null;

    $userdata = array();
    $userdata['ID'] = $user_id;

    if ($user_name) {
        $userdata['user_nicename'] = $user_name;
        $userdata['display_name'] = $user_name;
        $userdata['nickname'] = $user_name;
        $userdata['first_name'] = $user_name;
    }

    if ($user_surname) {
        $userdata['last_name'] = $user_surname;
    }

    if ($user_email) {
        $userdata['user_email'] = $user_email;
    }

    if ($user_password) {
        $userdata['user_pass'] = $user_password;
    }

    if ($user_password) {
        $userdata['user_pass'] = $user_password;
    }

    if ($user_password) {
        $userdata['user_pass'] = $user_password;
    }

    if ($user_password) {
        $userdata['user_pass'] = $user_password;
    }

    // if ($user_phone || $user_whatsapp) {
    //     $userdata['user_pass']['meta_input'] = array();
    //     if ($user_phone) {
    //         $userdata['user_pass']['meta_input']['wt_user_phone'] = $user_phone;
    //     }
    //     if ($user_whatsapp) {
    //         $userdata['user_pass']['meta_input']['wt_user_whatsapp'] = $user_whatsapp;
    //     }
    // }

    $update_user_result = wp_update_user($userdata);
    // wt_debug($user_name);
    // wt_debug($userdata);
    // wt_debug($update_user_result);
    // exit;

    if (is_wp_error($update_user_result)) {
        $error_string = $update_user_result->get_error_message() ? $update_user_result->get_error_message() : __('Ocorreu um erro ao tentar atualizar os dados do usuário. Revise os dados inseridos e tente novamente.', 'wt');
        $_SESSION['wt_update_user_error_message'] = $error_string;
        wp_safe_redirect($account_page_url);
        exit;
    }

    $update_user_phone = update_user_meta($user_id, 'wt_user_phone', $user_phone);

    $update_user_phone = update_user_meta($user_id, 'wt_user_whatsapp', $user_whatsapp);

    $user = get_user_by('id', $update_user_result);

    $_SESSION['wt_update_user_success_message'] = wp_sprintf(__('Dados do usuário %s atualizados com sucesso!', 'wt'), $user->display_name);

    echo '<h3>' . __('Dados do usuário atualizados com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect($account_page_url);
    exit;
}

function wt_anuncio_terms()
{
    $terms = get_terms(array(
        'taxonomy'   => 'categoria-de-anuncio',
        'hide_empty' => false,
    ));
    $array_terms = array();
    foreach ($terms as $term) {
        if (!$term->parent) {
            $array_terms[$term->term_id] = $term->name;
            foreach ($terms as $term2) {
                if ($term2->parent === $term->term_id) {
                    $array_terms[$term2->term_id] = $term2->name;
                }
            }
        }
    }
    return $array_terms;
}


add_action('admin_post_wt_update_vendedor_terms_form', 'wt_update_vendedor_terms_form_handle');
add_action('admin_post_nopriv_wt_update_vendedor_terms_form', 'wt_update_vendedor_terms_form_handle');

/**
 * wt_update_user_handle
 *
 * @return void
 */
function wt_update_vendedor_terms_form_handle()
{
    nocache_headers();
    $account_page_id = wt_get_option('wt_account_page');
    $account_page_url = $account_page_id ? get_page_link($account_page_id) : get_home_url();
    unset($_SESSION['wt_update_vendedor_terms_error_message']);

    if (!isset($_POST['wt_form_following_terms_user_nonce']) || !wp_verify_nonce($_POST['wt_form_following_terms_user_nonce'], 'wt_form_following_terms_user_nonce')) {

        $_SESSION['wt_update_vendedor_terms_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_update_vendedor_terms_form') {

        $_SESSION['wt_update_vendedor_terms_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['user_id']) || !$_POST['user_id']) {

        $_SESSION['wt_update_vendedor_terms_error_message'] = __('ID do usuário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $user_id = $_POST['user_id'];

    $check_user_exists = get_user_by('id', $user_id);
    if (!$check_user_exists) {

        $_SESSION['wt_update_vendedor_terms_error_message'] = __('Usuário inválido.', 'wt');
        wp_safe_redirect($account_page_url);
        exit;
    }

    $terms = (isset($_POST['terms']) && $_POST['terms']) ? $_POST['terms'] : null;

    $wt_user_following_terms = update_user_meta($user_id, 'wt_user_following_terms', $terms);

    $user = $check_user_exists;

    $_SESSION['wt_update_user_success_message'] = __('Configuração de categorias de anúncio atualizadas!', 'wt');

    echo '<h3>' . __('Configuração de categorias de anúncio atualizadas com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect($account_page_url);
    exit;
}
