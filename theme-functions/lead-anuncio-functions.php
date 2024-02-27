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
    $has_leads = wt_check_anuncio_has_leads($curr_user->ID, $anuncio_id, $author_anuncio_id);

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

        $check_new_lead_meta = add_user_meta($author_anuncio_id, '_wt_new_leads', $novo_lead_id, false);
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

add_action('account_announces', 'wt_show_to_compradores_new_leads_alert');

function wt_show_to_compradores_new_leads_alert()
{
    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    $user_type = get_user_meta($user_id, 'wt_user_type', true);

    if ($user_type !== 'comprador') {
        return;
    }
    $new_leads = get_user_meta($user_id, '_wt_new_leads', false);
    if (!$new_leads) {
        return;
    }
    $page_my_leads_id = wt_get_page_id('myleads');
    if (!$page_my_leads_id) {
        return;
    }
    $wt_add_form_new_leads_announce_nonce = wp_create_nonce('wt_form_new_leads_announce_nonce');
    $page_my_leads_url = wt_get_page_url('myleads');
    $output = '';
    $output .= '<div class="container"><div class="row"><div class="col">';

    // $form = '
    // <form class="" name="update-user-form" id="update-user-form" action="' . esc_url(admin_url('admin-post.php')) . '" method="post">

    // <button type="submit" class="btn btn-link link-offset-1 link-underline link-underline-opacity-50 px-1">aqui</button>

    // <input type="hidden" name="wt_form_new_leads_announce_nonce" value="' .  $wt_add_form_new_leads_announce_nonce . '" />
    // <input type="hidden" value="wt_new_leads_form" name="action">

    // </form>';

    // $output .= wt_alert(sprintf(__('Você possui <strong class="ms-1">novos leads</strong>, clique %s para visualizá-los', 'wt'), $form));

    $output .= wt_alert(sprintf(__('Você possui <strong class="ms-1">novos leads</strong>, clique <a href="%s" class="link-offset-1 link-underline link-underline-opacity-50 px-1">aqui</a> para visualizá-los', 'wt'), $page_my_leads_url));

    $output .= '</div></div></div>';
    echo $output;
}

add_action('wt_user_icon_notification', 'wt_show_to_comprador_new_leads_notification');

/**
 * wt_show_to_comprador_new_leads_notification
 *
 * @return void
 */
function wt_show_to_comprador_new_leads_notification()
{
    if (!is_user_logged_in()) {
        return;
    }

    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    $user_type = get_user_meta($user_id, 'wt_user_type', true);
    if ($user_type !== 'comprador') {
        return;
    }
    $new_leads = get_user_meta($user_id, '_wt_new_leads', false);
    if (!$new_leads) {
        return;
    }
    $page_my_leads_id = wt_get_page_id('myleads');
    if (!$page_my_leads_id) {
        return;
    }
    $output = '<i class="bi bi-exclamation-circle-fill text-danger nav-user-icon-alert" data-bs-toggle="tooltip" data-bs-title="' . __('Você possui novos leads.', 'wt') . '"></i>';
    echo $output;
}

add_action('template_redirect', 'wt_reset_comprador_new_leads_count');

/**
 * wt_reset_comprador_new_leads_count
 *
 * @return void
 */
function wt_reset_comprador_new_leads_count()
{
    $page_my_leads_id = wt_get_page_id('myleads');
    if (!is_page($page_my_leads_id)) {
        return;
    };

    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    $user_type = get_user_meta($user_id, 'wt_user_type', true);
    if ($user_type !== 'comprador') {
        return;
    }

    delete_user_meta($user_id, '_wt_new_leads');
    return;
}

add_action('wt_user_icon_notification', 'show_to_vendedores_new_anuncios_notification');
// add_action('wp_head', 'show_to_vendedores_new_anuncios_notification');

function show_to_vendedores_new_anuncios_notification()
{
    if (!is_user_logged_in()) {
        return;
    }

    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    $user_type = get_user_meta($user_id, 'wt_user_type', true);
    if ($user_type !== 'vendedor') {
        return;
    }
    $new_anuncios = wt_check_if_vendedor_has_new_anuncios($user_id);
    // wt_debug(count($new_anuncios));
    if ($new_anuncios) {
        return;
    }
    $output = '<i class="bi bi-exclamation-circle-fill text-danger nav-user-icon-alert" data-bs-toggle="tooltip" data-bs-title="' . __('Novos anúncios nas categorias que você segue foram criados desde a sua última visita.', 'wt') . '"></i>';
    echo $output;
}

add_action('account_announces', 'wt_show_to_vendedores_new_anuncios_alert');

function wt_show_to_vendedores_new_anuncios_alert()
{
    if (!is_user_logged_in()) {
        return;
    }

    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    $user_type = get_user_meta($user_id, 'wt_user_type', true);

    if ($user_type !== 'vendedor') {
        return;
    }

    $following_terms_page_id = wt_get_page_id('followingtermsanuncios');
    if (!$following_terms_page_id) {
        return;
    }

    $new_anuncios = wt_check_if_vendedor_has_new_anuncios($user_id);
    if ($new_anuncios) {
        return;
    }

    $following_terms_page_url = wt_get_page_url('followingtermsanuncios');
    $output = '';
    $output .= '<div class="container"><div class="row"><div class="col">';

    $output .= wt_alert(sprintf(__('Você possui <strong class="ms-1">novos anúncios</strong> nas categorias que segue desde a sua última visita, clique <a href="%s" class="link-offset-1 link-underline link-underline-opacity-50 px-1">aqui</a> para visualizá-los', 'wt'), $following_terms_page_url));

    $output .= '</div></div></div>';
    echo $output;
}

add_action('template_redirect', 'wt_reset_vendedor_last_time_checked_for_new_anuncios');

/**
 * wt_reset_vendedor_last_time_checked_for_new_anuncios
 *
 * @return void
 */
function wt_reset_vendedor_last_time_checked_for_new_anuncios()
{
    $page_following_terms_anuncios_id = wt_get_page_id('followingtermsanuncios');
    if (!is_page($page_following_terms_anuncios_id)) {
        return;
    };

    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    $user_type = get_user_meta($user_id, 'wt_user_type', true);
    if ($user_type !== 'vendedor') {
        return;
    }
    update_user_meta($user_id, '_last_time_checked_for_new_anuncios', strtotime('now'));
    return;
}



add_action('admin_post_wt_new_leads_form', 'wt_new_leads_form_handle');
add_action('admin_post_nopriv_wt_new_leads_form', 'wt_new_leads_form_handle');

function wt_new_leads_form_handle()
{
    nocache_headers();
    $http_origem = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : get_home_url();
    unset($_SESSION['wt_new_lead_error_message']);

    $page_new_leads_url = wt_get_page_url('myleads');

    if (!isset($_POST['wt_form_new_leads_announce_nonce']) || !wp_verify_nonce($_POST['wt_form_new_leads_announce_nonce'], 'wt_form_new_leads_announce_nonce')) {

        $_SESSION['wt_new_lead_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_new_leads_form') {

        $_SESSION['wt_new_lead_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($http_origem);
        exit;
    }

    $curr_user = wp_get_current_user();
    $user_id = $curr_user->ID;
    delete_user_meta($user_id, '_wt_new_leads');
    echo '<h3>' . __('Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';
    wp_safe_redirect($page_new_leads_url);
    exit;
}
