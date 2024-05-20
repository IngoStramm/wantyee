<?php

function wt_get_vendedor_anuncio_rating($vendedor_id, $anuncio_id)
{
    // pegar avaliacao com o $vendedor_id e com o $anuncio_id
    // se não encontrar, exibe "Não avaliado"
    // Senão, exibe form para avaliar
    // wt_avaliacao_anuncio_id
    // wt_avaliacao_author_lead_id
    $args = array(
        'post_type' => 'avaliacoes',
        'posts_per_page' => -1,
        'status'    => 'published',
        'meta_query'            => array(
            'relation'          => 'AND',
            array(
                'key'      => 'wt_avaliacao_anuncio_id',
                'value'    => $anuncio_id,
            ),
            array(
                'key'      => 'wt_avaliacao_author_lead_id',
                'value'    => $vendedor_id,
            ),
        )
    );
    $avaliacoes = get_posts($args);
    wp_reset_postdata();
    $nota = 0;
    if (count($avaliacoes) >= 0) {
        foreach ($avaliacoes as $avaliacao) {
            $avaliacao_nota = get_post_meta($avaliacao->ID, 'wt_avaliacao_nota', true);
            $nota = $avaliacao_nota ? $avaliacao_nota : $nota;
        }
    }
    return $nota;
}

add_action('wt_modal', 'wt_rate_vendedor_modal');

function wt_rate_vendedor_modal()
{
    $wt_add_form_rate_vendedor_nonce = wp_create_nonce('wt_form_rate_vendedor_nonce');
    $post_id = isset($_REQUEST['wt_anuncio_id']) && $_REQUEST['wt_anuncio_id'] ? $_REQUEST['wt_anuncio_id'] : null;
    $current_user = wp_get_current_user();

    $output = '';
    $output .= '
    <!-- Modal -->
<div class="modal fade" id="rate-vendedor-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rate-vendedor-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="rate-vendedor-modalLabel">' . __('Avaliar vendedor', 'wt') . '</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h5>' . __('Avalie o vendedor', 'wt') . ' "<span id="vendedor-nome-span"></span>"</h5>';

    $output .= '        
          <form id="rate-vendedor-form" name="rate-vendedor-form" action="' . esc_url(admin_url('admin-post.php')) . '" method="post" class="needs-validation" novalidate>';

    $output .= '<div id="avaliacao-nota-wrapper" class="mt-3">';
    $output .= '<label>' . __('Selecione uma nota', 'wt') . '</label>';
    $output .= '<div class="form-check">';
    $output .= '<input class="form-check-input" type="radio" name="avaliacao-nota" id="avaliacao-nota-1" value="1" />';
    $output .= '<label class="form-check-label" for="avaliacao-nota-1">
        <i class="bi bi-star-fill"></i>
        </label>';
    $output .= '</div>';
    $output .= '<div class="form-check">';
    $output .= '<input class="form-check-input" type="radio" name="avaliacao-nota" id="avaliacao-nota-2" value="2" />';
    $output .= '<label class="form-check-label" for="avaliacao-nota-2">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        </label>';
    $output .= '</div>';
    $output .= '<div class="form-check">';
    $output .= '<input class="form-check-input" type="radio" name="avaliacao-nota" id="avaliacao-nota-3" value="3" />';
    $output .= '<label class="form-check-label" for="avaliacao-nota-3">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        </label>';
    $output .= '</div>';
    $output .= '<div class="form-check">';
    $output .= '<input class="form-check-input" type="radio" name="avaliacao-nota" id="avaliacao-nota-4" value="4" checked />';
    $output .= '<label class="form-check-label" for="avaliacao-nota-4">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        </label>';
    $output .= '</div>';
    $output .= '<div class="form-check">';
    $output .= '<input class="form-check-input" type="radio" name="avaliacao-nota" id="avaliacao-nota-5" value="5" />';
    $output .= '<label class="form-check-label" for="avaliacao-nota-5">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        </label>';
    $output .= '</div>';

    $output .=  '<div class="mt-3">';
    $output .=  '<label class="form-label" for="avaliacao-comentario">' . __('Deixe um comentário sobre como foi a sua experiência com o vendedor', 'wt') . '</label>';
    $output .=   '<textarea id="avaliacao-comentario" name="avaliacao-comentario" class="form-control"></textarea>';
    $output .=  '</div>';

    $output .= '</div>';

    $output .= '<input type="hidden" id="vendedor-id" name="vendedor_id" />';
    $output .= '<input type="hidden" id="lead-id" name="lead_id" />';
    $output .= '<input type="hidden" id="anuncio-id" name="anuncio_id" />';

    $output .=
        '<input type="hidden" name="action" value="wt_rate_vendedor_form">
        <input type="hidden" name="wt_user_id" value="' .   $current_user->ID . '">
        <input type="hidden" name="wt_form_rate_vendedor_nonce" value="' .  $wt_add_form_rate_vendedor_nonce . '">
              <button class="btn btn-primary mt-3">' . __(' Confirmar', 'wt') . '</button>
          </form>';
    $output .= '</div>';
    $output .=
        '<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . __('Cancelar', 'wt') . '</button>';
    $output .= '
      </div>
    </div>
  </div>
</div>
    ';
    echo $output;
}

add_action('admin_post_wt_rate_vendedor_form', 'wt_rate_vendedor_form_handle');
add_action('admin_post_nopriv_wt_rate_vendedor_form', 'wt_rate_vendedor_form_handle');

function wt_rate_vendedor_form_handle()
{
    nocache_headers();
    $myleads_page_id = wt_get_page_id('myleads');
    $myleads_page_url = $myleads_page_id ? wt_get_page_url('myleads') : wt_get_page_url('account');
    unset($_SESSION['wt_rate_vendedor_error_message']);

    if (!isset($_POST['anuncio_id']) || !$_POST['anuncio_id']) {

        $_SESSION['wt_rate_vendedor_error_message'] = __('ID do anúncio inválido.', 'wt');
        wp_safe_redirect($myleads_page_url);
        exit;
    }
    $post_id = $_POST['anuncio_id'];

    if (!isset($_POST['wt_user_id']) || !$_POST['wt_user_id']) {

        $_SESSION['wt_rate_vendedor_error_message'] = __('ID do comprador inválido.', 'wt');
        wp_safe_redirect($myleads_page_url);
        exit;
    }
    $user_id = $_POST['wt_user_id'];

    if (!isset($_POST['vendedor_id']) || !$_POST['vendedor_id']) {

        $_SESSION['wt_rate_vendedor_error_message'] = __('ID do vendedor inválido.', 'wt');
        wp_safe_redirect($myleads_page_url);
        exit;
    }
    $vendedor_id = $_POST['vendedor_id'];

    if (!isset($_POST['wt_form_rate_vendedor_nonce']) || !wp_verify_nonce($_POST['wt_form_rate_vendedor_nonce'], 'wt_form_rate_vendedor_nonce')) {

        $_SESSION['wt_rate_vendedor_error_message'] = __('Não foi possível validar a requisição.', 'wt');
        wp_safe_redirect($myleads_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_rate_vendedor_form') {

        $_SESSION['wt_rate_vendedor_error_message'] = __('Formulário inválido.', 'wt');
        wp_safe_redirect($myleads_page_url);
        exit;
    }

    if (!isset($_POST['avaliacao-nota']) || !$_POST['avaliacao-nota']) {

        $_SESSION['wt_rate_vendedor_error_message'] = __('Nota ausente.', 'wt');
        wp_safe_redirect($myleads_page_url);
        exit;
    }
    $avaliacao_nota = $_POST['avaliacao-nota'];

    if (!isset($_POST['avaliacao-comentario']) || !$_POST['avaliacao-comentario']) {

        $_SESSION['wt_rate_vendedor_error_message'] = __('Comentário ausente.', 'wt');
        wp_safe_redirect($myleads_page_url);
        exit;
    }
    $avaliacao_comentario = $_POST['avaliacao-comentario'];

    $user_data = get_userdata($user_id);
    $vendedor_data = get_userdata($vendedor_id);

    $title = sprintf(__('Avaliação criada para o anúncio %s, do comprador %s, para o vendedor %s.'), get_the_title($post_id), $user_data->display_name, $vendedor_data->display_name);

    $args = array(
        'post_title'                    => $title,
        'post_status'                   => 'publish',
        'post_author'                   => $user_id,
        'post_type'                     => 'avaliacoes',
    );

    $args['post_content'] = $avaliacao_comentario;

    $meta_input = [];
    $meta_input['wt_avaliacao_anuncio_id'] = $post_id;
    $meta_input['wt_avaliacao_author_lead_id'] = $vendedor_id;
    $meta_input['wt_avaliacao_nota'] = $avaliacao_nota;

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
        wp_safe_redirect($myleads_page_url);
        exit;
    }

    $_SESSION['wt_rate_vendedor_success_message'] = __('Avaliação cadastrada com sucesso.', 'wt');
    echo '<h3>' . __('Por favor, aguarde enquanto está sendo redicionando...', 'wt') . '</p>';

    wp_safe_redirect($myleads_page_url);
}

add_action('wt_rate_vendedor_error_message', 'wt_rate_vendedor_error_message_handle');

function wt_rate_vendedor_error_message_handle()
{
    if (isset($_SESSION['wt_rate_vendedor_error_message']) && $_SESSION['wt_rate_vendedor_error_message']) {
        echo wt_alert_small('danger', $_SESSION['wt_rate_vendedor_error_message']);
        unset($_SESSION['wt_rate_vendedor_error_message']);
    }
}

add_action('wt_rate_vendedor_success_message', 'wt_rate_vendedor_success_message_handle');

function wt_rate_vendedor_success_message_handle()
{
    if (isset($_SESSION['wt_rate_vendedor_success_message']) && $_SESSION['wt_rate_vendedor_success_message']) {
        echo wt_alert_small('success', $_SESSION['wt_rate_vendedor_success_message']);
        unset($_SESSION['wt_rate_vendedor_success_message']);
    }
}
