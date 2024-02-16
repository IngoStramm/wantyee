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
?>
<div class="container">
    <div class="row">
        <div class="col">

            <?php if ($user_type === 'comprador') { ?>

                <?php echo wt_account_nav('editanuncio'); ?>

                <?php do_action('update_anuncio_messages'); ?>

                <h3 class="mt-5 mb-3"><?php _e('Novo anúncio', 'wt'); ?></h3>

                <form name="new-anuncio-form" id="new-anuncio-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="mb-3">
                            <label for="anuncio_title" class="form-label"><?php _e('Título', 'wt'); ?></label>
                            <input type="text" class="form-control" id="anuncio_title" name="anuncio_title" tabindex="1" required>
                            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="anuncio_content" class="form-label"><?php _e('Descrição', 'wt'); ?></label>
                            <?php echo do_shortcode('[wt_editor name="anuncio-content" tabindex="2"]'); ?>
                        </div>

                        <div class="mb-3">
                            <label for="terms" class="form-label" tabindex="3"><?php _e('Categorias', 'wt'); ?></label>
                            <ul class="list-group checkbox-terms-list">
                                <?php foreach ($terms as $term) { ?>
                                    <?php if (!$term->parent) { ?>
                                        <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $term->term_id; ?>" name="terms[]" id="term-<?php echo $term->term_id; ?>">
                                                <label class="form-check-label" for="term-<?php echo $term->term_id; ?>">
                                                    <?php echo $term->name; ?>
                                                </label>
                                            </div>
                                            <?php foreach ($terms as $term2) { ?>
                                                <ul class="list-group">
                                                    <?php if ($term2->parent === $term->term_id) { ?>
                                                        <li class="list-group-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="<?php echo $term2->term_id; ?>" name="terms[]" id="term-<?php echo $term2->term_id; ?>" data-parent="term-<?php echo $term2->parent; ?>">
                                                                <label class="form-check-label" for="term-<?php echo $term2->term_id; ?>">
                                                                    <?php echo $term2->name; ?>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label for="anuncio_image" class="form-label"><?php _e('Imagem', 'wt') ?></label>
                            <input type="file" class="form-control" id="anuncio_image" name="anuncio_image" accept=".jpg,.jpeg,.png" tabindex="4">
                            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                        </div>

                        <div class="mb-3">
                            <h5 for="anuncio_faq"><?php _e('FAQ (Perguntas & Respostas', 'wt') ?></h5>
                            <div class="wt-faq-group">
                                <ul class="list-group wt-faq-group-list">
                                    <li class="wt-faq-group-item list-group-item" id="wt-faq-group-item-1" data-faq-group-item-id="1">
                                        <label for=" anuncio_faq-pergunta-1" class="form-label"><?php _e('Pergunta', 'wt') ?></label>
                                        <input type="text" class="form-control" id="anuncio_faq-pergunta-1" name="anuncio_faq-perguntas[]" tabindex="5" required>
                                        <label for="anuncio_faq-resposta-2" class="form-label"><?php _e('Resposta', 'wt') ?></label>
                                        <textarea class="form-control" id="anuncio_faq-resposta-2" name="anuncio_faq-respostas[]" tabindex="6" required></textarea>
                                        <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                                        <d class="d-flex">
                                            <a href="#" class="wt-delete-faq-group btn btn-danger btn-sm mt-2 ms-auto"><i class="bi bi-x-circle-fill"></i> <?php _e('Remover item', 'wt'); ?></a>
                                        </d>
                                    </li>
                                </ul>
                                <a href="#" class="wt-group-new-item-btn btn btn-success mt-3"><i class="bi bi-plus-circle-fill"></i> <?php _e('Adicionar item', 'wt'); ?></a>
                            </div>
                        </div>

                        <div class=" mb-3">
                            <button type="submit" class="btn btn-primary" tabindex="7"><?php _e('Salvar', 'wt'); ?></button>

                        </div>
                    </div>

                    <input type="hidden" name="wt_form_new_anuncio_nonce" value="<?php echo $wt_add_form_new_anuncio_nonce ?>" />
                    <input type="hidden" value="wt_new_anuncio_form" name="action">
                    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                    <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
                </form>

            <?php } else { ?>

                <?php get_template_part('template-parts/content/content-access-denied'); ?>

            <?php } ?>
        </div>
    </div>
</div>