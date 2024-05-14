<?php
$terms = get_terms(array(
    'taxonomy'   => 'categoria-de-anuncio',
    'hide_empty' => false,
));
$user = wp_get_current_user();
$user_id = $user->get('id');
$user_type = get_user_meta($user_id, 'wt_user_type', true);
$account_page_id = wt_get_option('wt_account_page');
$redirect_to = $account_page_id ? get_page_link($account_page_id) : get_home_url();
$wt_add_form_new_anuncio_nonce = wp_create_nonce('wt_form_new_anuncio_nonce');

$post_id = isset($_REQUEST['wt_anuncio_id']) && $_REQUEST['wt_anuncio_id'] ? $_REQUEST['wt_anuncio_id'] : null;
$post = get_post($post_id);
$title = $post_id ? get_the_title($post_id) : null;
$price = $post_id ? get_post_meta($post_id, 'wt_anuncio_preco', true) : null;
$post_terms = $post_id ? get_the_terms($post_id, 'categoria-de-anuncio') : array();
$post_terms_id = array();
if (is_array($post_terms)) {
    foreach ($post_terms as $post_term) {
        $post_terms_id[] = $post_term->term_id;
    }
}
$post_thumbnail = $post_id ? get_the_post_thumbnail($post_id, array('100', '100'), array('loading' => false, 'class' => 'img-fluid rounded my-2')) : null;
$post_thumbnail_url = $post_id ? get_the_post_thumbnail_url($post_id, 'full') : null;
$wt_faq = $post_id ? get_post_meta($post_id, 'wt_faq', true) : array(array('question' => '', 'answer' => ''));
if (count($wt_faq) === 0) {
    $wt_faq = array(array('question' => '', 'answer' => ''));
}
?>
<div class="container">
    <div class="row">
        <div class="col">

            <?php // Se for editar um anúncio existente e não for o autor dele 
            ?>
            <?php // Ou se não for um comprador 
            ?>
            <?php if (($post_id && (intval($post->post_author) !== $user_id || get_post_meta($post_id, 'wt_anuncio_status', true) === 'closed')) || ($user_type !== 'comprador')) { ?>

                <?php get_template_part('template-parts/content/content-access-denied'); ?>

            <?php } else { ?>

                <h3><?php echo sprintf(__('Olá, %s!'), $user->display_name); ?></h3>

                <p class="mb-5"><?php _e('Nesta página, você pode criar um novo anúncio.', 'wt'); ?></p>

                <?php echo wt_account_nav('editanuncio'); ?>

                <?php do_action('update_anuncio_messages'); ?>

                <h3 class="mt-5 mb-3"><?php _e('Novo anúncio', 'wt'); ?></h3>

                <form name="new-anuncio-form" id="new-anuncio-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="mb-3">
                            <label for="anuncio_title" class="form-label"><?php _e('Título', 'wt'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'wt'); ?>">*</span></label>
                            <input type="text" class="form-control" id="anuncio_title" name="anuncio_title" tabindex="1" value="<?php echo $title ?>" required>
                            <div class=" form-text"><?php _e('Procure usar um título que seja auto-explicativo. Evite títulos desnecessariamente longos.', 'wt'); ?>
                            </div>
                            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="anuncio_price" class="form-label"><?php _e('Preço', 'wt'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'wt'); ?>">*</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="anuncio_price" name="anuncio_price" aria-label="<?php _e('Apenas números', 'wt'); ?>" value="<?php echo $price; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="anuncio_content" class="form-label"><?php _e('Descrição', 'wt'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'wt'); ?>">*</span></label>
                            <div class="form-text mb-2"><?php _e('Quanto mais completa for a descrição, mais fácil será o entendimento sobre o anúncio.'); ?></div>
                            <?php echo do_shortcode('[wt_editor name="anuncio-content" tabindex="2" post_id="' . $post_id . '"]'); ?>
                        </div>

                        <div class="mb-3">
                            <label for="terms" class="form-label" tabindex="3"><?php _e('Categorias', 'wt'); ?></label>
                            <div class="form-text mb-2"><?php _e('Categorias ajudam a encontrar mais facilmente o seu anúncio. Se nenhuma categoria for escolhida, o anúncio será atribuído à categoria <strong>"Geral"</strong>.'); ?></div>

                            <div id="table-cat-produtos">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="search" class="form-control form-control-sm search" id="table-search-input" placeholder="<?php _e('Pesquisar', 'wt'); ?>">
                                            <label for="table-search-input"><?php _e('Pesquisar', 'wt'); ?></label>

                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive sort-table">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col"><?php _e('Nome', 'wt'); ?></th>
                                            </tr>
                                        </thead>

                                        <tbody class="list checkbox-terms-list">
                                            <?php foreach ($terms as $term) { ?>
                                                <?php if (!$term->parent) { ?>
                                                    <?php $parent_checked = in_array($term->term_id, $post_terms_id) ? 'checked' : ''; ?>
                                                    <tr>
                                                        <td scope="row" class="text-center" width="70px">
                                                            <input class="form-check-input" type="checkbox" value="<?php echo $term->term_id; ?>" name="terms[]" id="term-<?php echo $term->term_id; ?>" <?php echo $parent_checked; ?>>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">

                                                                <label class="form-check-label nome" for="term-<?php echo $term->term_id; ?>">
                                                                    <?php echo $term->name; ?>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php foreach ($terms as $term2) { ?>
                                                        <?php if ($term2->parent === $term->term_id) { ?>
                                                            <?php $child_checked = in_array($term2->term_id, $post_terms_id) ? 'checked' : ''; ?>
                                                            <tr>
                                                                <td scope="row" class="text-center">
                                                                    <input class="form-check-input" type="checkbox" value="<?php echo $term2->term_id; ?>" name="terms[]" id="term-<?php echo $term2->term_id; ?>" data-parent="term-<?php echo $term2->parent; ?>" <?php echo $child_checked; ?>>
                                                                </td>
                                                                <td class="child-term">
                                                                    <div class="form-check">

                                                                        <label class="form-check-label" for="term-<?php echo $term2->term_id; ?>">
                                                                            <span class="nome"><?php echo $term2->name; ?></span> — <span class="parent-term-name"><?php echo $term->name; ?></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <ul class="pagination"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 wt-file-image-preview">
                            <label for="anuncio_image" class="form-label"><?php _e('Imagem', 'wt') ?></label>
                            <input type="file" class="form-control" id="anuncio_image" name="anuncio_image" accept=".jpg,.jpeg,.png" value="<?php echo $post_thumbnail_url; ?>" tabindex="4">
                            <div class="form-text"><?php _e('Arquivos aceitos: ".jpg" e ".png". Tamanho máximo permitido: 2MB.'); ?></div>
                            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            <img class="image-preview img-thumbnail rounded" src="<?php echo $post_thumbnail_url; ?>" class="img-fluid" />
                            <div class="clearfix"></div>
                            <button class="btn btn-danger btn-sm mt-3 btn-clear-image" <?php echo $post_thumbnail_url ? '' : 'style="display: none;"'; ?>><?php _e('Remover Imagem', 'wt'); ?></button>
                            <input type="hidden" name="changed-thumbnail" value="false">
                        </div>

                        <div class="mb-3">
                            <h5 for="anuncio_faq"><?php _e('FAQ (Perguntas & Respostas', 'wt') ?></h5>
                            <div class="wt-faq-group">
                                <ul class="list-group wt-faq-group-list">
                                    <?php foreach ($wt_faq as $item) { ?>
                                        <li class="wt-faq-group-item list-group-item" id="wt-faq-group-item-1" data-faq-group-item-id="1">
                                            <label for=" anuncio_faq-pergunta-1" class="form-label"><?php _e('Pergunta', 'wt') ?></label>
                                            <input type="text" class="form-control" id="anuncio_faq-pergunta-1" name="anuncio_faq-perguntas[]" value="<?php echo $item['question']; ?>" tabindex="5">
                                            <label for="anuncio_faq-resposta-2" class="form-label"><?php _e('Resposta', 'wt') ?></label>
                                            <textarea class="form-control" id="anuncio_faq-resposta-2" name="anuncio_faq-respostas[]" tabindex="6"><?php echo $item['answer']; ?></textarea>
                                            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                                            <d class="d-flex">
                                                <a href="#" class="wt-delete-faq-group btn btn-danger btn-sm mt-2 ms-auto"><i class="bi bi-x-circle-fill"></i> <?php _e('Remover item', 'wt'); ?></a>
                                            </d>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <a href="#" class="wt-group-new-item-btn btn btn-success mt-3"><i class="bi bi-plus-circle-fill"></i> <?php _e('Adicionar item', 'wt'); ?></a>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <button type="submit" class="btn btn-primary" tabindex="7"><?php _e('Salvar', 'wt'); ?></button>

                            <?php if ($post_id) { ?>
                                <a href="#" class="btn btn-danger close-anuncio" data-bs-toggle="modal" data-bs-target="#close-anuncio-modal">
                                    <i class="bi bi-x-circle-fill me-1"></i>
                                    <?php _e('Encerrar anúncio', 'wt'); ?>
                                </a>
                            <?php } ?>

                        </div>
                    </div>

                    <input type="hidden" name="wt_form_new_anuncio_nonce" value="<?php echo $wt_add_form_new_anuncio_nonce ?>" />
                    <input type="hidden" value="wt_new_anuncio_form" name="action">
                    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                    <input type="hidden" value="<?php echo $post_id; ?>" name="post_id">
                    <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
                </form>

            <?php } ?>
        </div>
    </div>
</div>