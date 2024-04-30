<?php
$terms = get_terms(array(
    'taxonomy'   => 'categoria-de-anuncio',
    'hide_empty' => false,
));
$user = wp_get_current_user();
$user_id = $user->get('id');
$user_type = get_user_meta($user_id, 'wt_user_type', true);
$wt_user_following_terms = get_user_meta($user_id, 'wt_user_following_terms', true);
$account_page_id = wt_get_option('wt_account_page');
$redirect_to = $account_page_id ? get_page_link($account_page_id) : get_home_url();
$wt_add_form_update_user_nonce = wp_create_nonce('wt_form_following_terms_user_nonce');
?>

<div class="container">
    <div class="row">
        <div class="col">

            <?php if ($user_type === 'vendedor') { ?>

                <h3><?php echo sprintf(__('Olá, %s!'), $user->display_name); ?></h3>

                <p class="mb-5"><?php _e('Nesta página, você pode configurar quais categorias de anúncio deseja seguir. Quando novos anúncios das categorias que você segue forem, criados, você será notificado.', 'wt'); ?></p>

                <?php echo wt_account_nav('catanuncioconfig'); ?>

                <?php do_action('update_vendedor_terms_messages'); ?>

                <h3 class="mt-2 mb-3"><?php _e('Seguir Categorias de Produtos', 'wt'); ?></h3>

                <div id="table-following-cat-produtos">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="search" class="form-control form-control-sm search" id="table-search-input" placeholder="<?php _e('Pesquisar', 'wt'); ?>">
                                <label for="table-search-input"><?php _e('Pesquisar', 'wt'); ?></label>
                                
                            </div>
                        </div>
                    </div>

                    <form name="following-terms-user-form" id="following-terms-user-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" novalidate>

                        <div class="table-responsive sort-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"><?php _e('Nome', 'wt'); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="list checkbox-terms-list">
                                    <?php foreach ($terms as $term) {
                                        if (!$term->parent) {
                                            $is_parent_checked = $wt_user_following_terms && in_array($term->term_id, $wt_user_following_terms) ? 'checked' : ''; ?>
                                            <tr>
                                                <td scope="row" class="text-center" width="70px">
                                                    <input class="form-check-input" type="checkbox" value="<?php echo $term->term_id; ?>" name="terms[]" id="term-<?php echo $term->term_id; ?>" <?php echo $is_parent_checked; ?>>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label" for="term-<?php echo $term->term_id; ?>">
                                                            <?php echo $term->name; ?>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php foreach ($terms as $term2) {
                                                $is_child_checked = $wt_user_following_terms && in_array($term2->term_id, $wt_user_following_terms) ? 'checked' : '';
                                                if ($term2->parent === $term->term_id) { ?>
                                                    <tr>
                                                        <td scope="row" class="text-center">
                                                            <input class="form-check-input" type="checkbox" value="<?php echo $term2->term_id; ?>" name="terms[]" id="term-<?php echo $term2->term_id; ?>" data-parent="term-<?php echo $term2->parent; ?>" <?php echo $is_child_checked; ?>>
                                                        </td>
                                                        <td class="child-term">
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="term-<?php echo $term2->term_id; ?>">
                                                                    <span><?php echo $term2->name; ?></span> — <span class="parent-term-name"><?php echo $term->name; ?></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <ul class="pagination"></ul>
                        </div>

                        <input type="hidden" name="wt_form_following_terms_user_nonce" value="<?php echo $wt_add_form_update_user_nonce ?>" />
                        <input type="hidden" value="wt_update_vendedor_terms_form" name="action">
                        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                        <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" tabindex="6"><?php _e('Salvar', 'wt'); ?></button>

                        </div>
                    </form>

                <?php } else { ?>

                    <?php get_template_part('template-parts/content/content-access-denied'); ?>

                <?php } ?>

                </div>
        </div>
    </div>