<?php

add_action('admin_post_wt_register_new_user_form', 'wt_register_new_user_form_handle');
add_action('admin_post_nopriv_wt_register_new_user_form', 'wt_register_new_user_form_handle');

/**
 * wt_register_new_user_handle
 *
 * @return void
 */
function wt_register_new_user_form_handle()
{
    nocache_headers();
    $login_page_id = wt_get_option('wt_login_page');
    $login_page_url = $login_page_id ? get_page_link($login_page_id) : get_home_url();
    $register_new_user_page_id = wt_get_option('wt_new_user_page');
    $register_new_user_page_url = $register_new_user_page_id ? get_page_link($register_new_user_page_id) : get_home_url();
    unset($_SESSION['wt_register_new_user_error_message']);

    if (!isset($_POST['wt_form_register_new_user_nonce']) || !wp_verify_nonce($_POST['wt_form_register_new_user_nonce'], 'wt_form_register_new_user_nonce')) {

        $_SESSION['wt_register_new_user_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_register_new_user_form') {

        $_SESSION['wt_register_new_user_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }

    if (!isset($_POST['user_name']) || !$_POST['user_name']) {

        $_SESSION['wt_register_new_user_error_message'] = __('Nome inválido.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }
    $user_name = sanitize_text_field($_POST['user_name']);
    $user_login = wt_generate_unique_username($user_name);

    if (!isset($_POST['user_surname']) || !$_POST['user_surname']) {

        $_SESSION['wt_register_new_user_error_message'] = __('Sobrenome inválido.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }
    $user_surname = sanitize_text_field($_POST['user_surname']);

    if (!isset($_POST['user_email']) || !$_POST['user_email']) {

        $_SESSION['wt_register_new_user_error_message'] = __('E-mail inválido.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }
    $user_email = sanitize_email($_POST['user_email']);

    if (!isset($_POST['user_whatsapp']) || !$_POST['user_whatsapp']) {

        $_SESSION['wt_register_new_user_error_message'] = __('WhatsApp inválido.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }
    $user_whatsapp = preg_replace('/[^0-9]/', '', $_POST['user_whatsapp']);

    if (!isset($_POST['user_phone']) || !$_POST['user_phone']) {

        $_SESSION['wt_register_new_user_error_message'] = __('Telefone inválido.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }
    $user_phone = preg_replace('/[^0-9]/', '', $_POST['user_phone']);

    if (!isset($_POST['user_type']) || !$_POST['user_type']) {

        $_SESSION['wt_register_new_user_error_message'] = __('Tipo de usuário inválido.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }
    $user_type = sanitize_text_field($_POST['user_type']);

    if (!isset($_POST['user_pass']) || !$_POST['user_pass']) {

        $_SESSION['wt_register_new_user_error_message'] = __('Senha inválida.', 'wt');
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }
    $user_password = $_POST['user_pass'];

    // if (!isset($_POST['user_avatar']) || !$_POST['user_avatar']) {

    //     $_SESSION['wt_register_new_user_error_message'] = __('Avatar inválido.', 'wt');
    //     wp_safe_redirect($register_new_user_page_url);
    //     exit;
    // }
    // $user_avatar = $_POST['user_avatar'];

    $userdata = array(
        'user_pass'                => $user_password,     //(string) The plain-text user password.
        'user_login'             => $user_login,     //(string) The user's login username.
        'user_nicename'         => $user_name,     //(string) The URL-friendly user name.
        'user_url'                 => '',     //(string) The user URL.
        'user_email'             => $user_email,     //(string) The user email address.
        'display_name'             => $user_name,     //(string) The user's display name. Default is the user's username.
        'nickname'                 => $user_name,     //(string) The user's nickname. Default is the user's username.
        'first_name'             => $user_name,     //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
        'last_name'             => $user_surname,     //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
        // 'description'             => '',     //(string) The user's biographical description.
        // 'rich_editing'             => '',     //(string|bool) Whether to enable the rich-editor for the user. False if not empty.
        // 'syntax_highlighting'     => '',     //(string|bool) Whether to enable the rich code editor for the user. False if not empty.
        // 'comment_shortcuts'     => '',     //(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
        // 'admin_color'             => '',     //(string) Admin color scheme for the user. Default 'fresh'.
        'use_ssl'                 => 'true',     //(bool) Whether the user should always access the admin over https. Default false.
        // 'user_registered'         => '',     //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
        'show_admin_bar_front'     => 'false',     //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
        'role'                     => 'subscriber',     //(string) User's role.
        // 'locale'                 => '',     //(string) User's locale. Default empty.
        'meta_input'            => array(
            'wt_user_type'      => $user_type,
            'wt_user_phone'     => $user_phone,
            'wt_user_whatsapp'     => $user_whatsapp,
        )

    );
    $register_new_user_result = wp_insert_user($userdata);

    if (is_wp_error($register_new_user_result)) {
        $error_string = $register_new_user_result->get_error_message() ? $register_new_user_result->get_error_message() : __('Ocorreu um erro ao tentar cadastrar o usuário. Revise os dados inseridos e tente novamente.', 'wt');
        $_SESSION['wt_register_new_user_error_message'] = $error_string;
        wp_safe_redirect($register_new_user_page_url);
        exit;
    }

    $user = get_user_by('id', $register_new_user_result);

    $_SESSION['wt_register_new_user_success_message'] = wp_sprintf(__('Seja bem vindo(a), %s!', 'wt'), $user->display_name);

    echo '<h3>' . __('Novo usuário cadastrado com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    $login_result = wp_signon(array(
        'user_login'        => $user_login,
        'user_password'     => $user_password,
    ));

    if (is_wp_error($login_result)) {
        $error_string = $login_result->get_error_message() ? $login_result->get_error_message() : __('Login falhou. Verifique se os dados de login estão corretos e tente novamente.', 'wt');
        $_SESSION['wt_login_error_message'] = $error_string;
        wp_safe_redirect($login_page_url);
        exit;
    }

    wp_safe_redirect(get_home_url());
    exit;
}
