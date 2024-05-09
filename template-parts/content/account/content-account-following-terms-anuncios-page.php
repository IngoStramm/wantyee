<?php
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

                <p class="mb-5"><?php _e('Nesta página, você pode visualizar os anúncios das categorias que você segue.', 'wt'); ?></p>

                <?php echo wt_account_nav('followingtermsanuncios'); ?>

                <h3 class="mt-2 mb-3"><?php _e('Anúncios', 'wt'); ?></h3>
                <div id="table-following-terms-anuncios">
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
                                    <th class="sort" data-sort="nome" scope="col"><?php _e('Nome', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sort" data-sort="email" scope="col"><?php _e('Categoria', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sort" data-sort="titulo" scope="col"><?php _e('Anúncio', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sort" data-sort="data" scope="col"><?php _e('Data', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php
                                $anuncios = wt_get_vendedor_following_terms_anuncios($user_id);
                                foreach ($anuncios as $post) {
                                    // wt_debug($post);
                                    $post_id = $post->ID;
                                    $post_title = $post->post_title;
                                    $author_id = $post->post_author;
                                    $author_data = get_userdata($author_id);
                                    $args = array(
                                        'fields' => 'all'
                                    );
                                    $post_terms = wp_get_post_terms($post_id, 'categoria-de-anuncio', $args);
                                ?>
                                    <tr>
                                        <td class="nome">
                                            <a href="<?php echo get_author_posts_url($author_id); ?>">
                                                <?php echo $author_data->first_name && $author_data->last_name ?
                                                    $author_data->first_name . ' ' . $author_data->last_name :
                                                    $author_data->display_name ?>
                                            </a>
                                        </td>
                                        <td class="categorias">
                                            <div class="d-flex gap-1">
                                                <?php
                                                foreach ($post_terms as $term) {
                                                    if (in_array($term->term_id, $wt_user_following_terms)) {
                                                        echo '<a href="' . get_term_link($term) . '"><span class="badge text-bg-secondary">' . $term->name . '</span></a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td class="titulo">
                                            <a href="<?php echo get_post_permalink($post_id); ?>">
                                                <?php echo get_the_title($post_id); ?>
                                            </a>
                                        </td>
                                        <td class="data"><?php echo get_the_date('', $post_id);
                                                            ?></td>
                                    </tr>
                                <?php } ?>
                                <?php wp_reset_postdata(); ?>
                            </tbody>
                            </thead>
                        </table>
                        <ul class="pagination"></ul>
                    </div>
                </div>
            <?php } else { ?>

                <?php get_template_part('template-parts/content/content-access-denied'); ?>

            <?php } ?>

        </div>
    </div>
</div>