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

            <?php if ($user_type === 'comprador') { ?>

                <h3><?php echo sprintf(__('Olá, %s!'), $user->display_name); ?></h3>

                <p class="mb-5"><?php _e('Nesta página, você pode visualizar os leads que os seus anúncios receberam.', 'wt'); ?></p>

                <?php echo wt_account_nav('myleads'); ?>

                <h3 class="mt-2 mb-3"><?php _e('Leads', 'wt'); ?></h3>

                <div id="table-leads" class="table-responsive sort-table">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control form-control-sm search" id="table-search-input" placeholder="<?php _e('Pesquisar', 'wt'); ?>">
                                <label for="table-search-input"><?php _e('Pesquisar', 'wt'); ?></label>
                            </div>
                        </div>
                    </div>
                    <table class=" table table-bordered">
                        <thead>
                            <tr>
                                <th class="sort" data-sort="nome_vendedor" scope="col"><?php _e('Nome', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                <th class="sort" data-sort="email_vendedor" scope="col"><?php _e('E-mail', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                <th class="sort" data-sort="titulo_anuncio" scope="col"><?php _e('Anúncio', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                <th class="sort" data-sort="data_anuncio" scope="col"><?php _e('Data', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                            </tr>
                        <tbody class="list">
                            <?php
                            $my_leads = wt_get_comprador_leads($user_id);
                            foreach ($my_leads as $lead) {
                                // wt_debug($lead);
                                $lead_id = $lead->ID;
                                $lead_title = $lead->post_title;
                                $lead_vendedor_id = $lead->post_author;
                                $lead_vendedor_data = get_userdata($lead_vendedor_id);
                                $anuncio_id = get_post_meta($lead_id, 'wt_anuncio_id', true);
                            ?>
                                <tr>
                                    <td class="nome_vendedor">
                                        <a href="<?php echo get_author_posts_url($lead_vendedor_id); ?>">
                                            <?php echo $lead_vendedor_data->first_name && $lead_vendedor_data->last_name ?
                                                $lead_vendedor_data->first_name . ' ' . $lead_vendedor_data->last_name :
                                                $lead_vendedor_data->display_name ?>
                                        </a>
                                    </td>
                                    <td class="email_vendedor"><a href="mailto:<?php echo $lead_vendedor_data->user_email; ?>"><?php echo $lead_vendedor_data->user_email; ?></a></td>
                                    <td class="titulo_anuncio">
                                        <a href="<?php echo get_post_permalink($anuncio_id); ?>">
                                            <?php echo get_the_title($anuncio_id); ?>
                                        </a>
                                    </td>
                                    <td class="data_anuncio"><?php echo get_the_date('', $lead_id);
                                                                ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        </thead>
                    </table>
                    <ul class="pagination"></ul>
                </div>
            <?php } else { ?>

                <?php get_template_part('template-parts/content/content-access-denied'); ?>

            <?php } ?>

        </div>
    </div>
</div>