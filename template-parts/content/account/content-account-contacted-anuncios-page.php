<?php
$user = wp_get_current_user();
$user_id = $user->get('id');
$user_type = get_user_meta($user_id, 'wt_user_type', true);
$account_page_id = wt_get_option('wt_account_page');
$redirect_to = $account_page_id ? get_page_link($account_page_id) : get_home_url();
?>

<div class="container">
    <div class="row">
        <div class="col">

            <?php if ($user_type === 'vendedor') { ?>

                <h3><?php echo sprintf(__('Olá, %s!'), $user->display_name); ?></h3>

                <p class="mb-5"><?php _e('Nesta página, você pode visualizar os seus anúncios criados.', 'wt'); ?></p>

                <?php echo wt_account_nav('contactedanuncios'); ?>

                <h3 class="mt-2 mb-3"><?php _e('Meus Anúncios', 'wt'); ?></h3>

                <div id="table-contacted-anuncios">
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
                                    <th class="sort" data-sort="titulo" scope="col"><?php _e('Anúncio', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sort" data-sort="nome" scope="col"><?php _e('Nome', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sort" data-sort="data" scope="col"><?php _e('Data', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sort" data-sort="status" scope="col"><?php _e('Status', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                </tr>
                            <tbody class="list">
                                <?php
                                $args = array(
                                    'post_type' => 'leads',
                                    'posts_per_page' => -1,
                                    'author' => $user_id,
                                    'status'    => 'published'
                                );
                                $user_leads = get_posts($args);
                                $leads_anuncios_ids = [];
                                foreach ($user_leads as $lead) {
                                    $leads_anuncios_ids[] = get_post_meta($lead->ID, 'wt_anuncio_id', true);
                                }
                                wp_reset_postdata();
                                ?>
                                <?php
                                $args = array(
                                    'post_type' => 'anuncios',
                                    'posts_per_page' => -1,
                                    'author' => $user_id,
                                    'status'    => 'published'
                                );
                                $my_anuncios = get_posts($args);
                                foreach ($leads_anuncios_ids as $anuncio_id) {
                                    $anuncio = get_post($anuncio_id);
                                    $anuncio_title = $anuncio->post_title;
                                    $anuncio_author_id = $anuncio->post_author;
                                    $anuncio_author_data = get_userdata($anuncio_author_id);
                                    $anuncio_status = get_post_meta($anuncio_id, 'wt_anuncio_status', true);
                                ?>
                                    <tr>
                                        <td class="titulo">
                                            <a href="<?php echo get_post_permalink($anuncio_id); ?>">
                                                <?php echo get_the_title($anuncio_id); ?>
                                            </a>
                                        </td>
                                        <td class="nome">
                                            <?php echo $anuncio_author_data->first_name && $anuncio_author_data->last_name ?
                                                $anuncio_author_data->first_name . ' ' . $anuncio_author_data->last_name :
                                                $anuncio_author_data->display_name ?>
                                        </td>
                                        <td class="data">
                                            <?php echo get_the_date('', $anuncio_id); ?>
                                        </td>
                                        <td class="status">
                                            <?php echo $anuncio_status === 'closed' ? __('Encerrado', 'wt') : __('Aberto', 'wt'); ?>
                                        </td>
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