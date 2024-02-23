<?php

/**
 * Template part for displaying anuncios posts type
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 * @since Twenty Twenty-One 1.0
 */

?>

<?php
$curr_user = wp_get_current_user();
$user_type = get_user_meta($curr_user->ID, 'wt_user_type', true);
$author_id = get_the_author_meta('ID');
$author_data = get_userdata($author_id);
$wt_email = $author_data->user_email;
$wt_whatsapp = get_user_meta($author_id, 'wt_user_whatsapp', true);
$wt_phone = get_user_meta($author_id, 'wt_user_phone', true);
$wt_faq = get_post_meta(get_the_ID(), 'wt_faq', true);
$has_leads = wt_check_anuncio_has_leads($curr_user->ID, get_the_ID(), $author_id);
$anuncio_status = get_post_meta(get_the_ID(), 'wt_anuncio_status', true);
?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs', null, array('anuncios')); ?>

<?php /* wt_debug($anuncio_status); */ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <?php do_action('redirect_anuncio_messages'); ?>
                <?php do_action('closed_anuncio_messages'); ?>
            </div>

            <?php if ($anuncio_status !== 'closed' && is_user_logged_in() && $curr_user->ID === $author_data->ID) { ?>
                <?php $wt_add_form_redirect_anuncio_nonce = wp_create_nonce('wt_form_redirect_anuncio_nonce'); ?>
                <div class="d-flex justify-content-end mb-3">
                    <form id="redirect-anuncio-form" name="redirect-anuncio-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                        <input type="hidden" name="action" value="wt_redirect_anuncio_form">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                        <input type="hidden" name="wt_form_redirect_anuncio_nonce" value="<?php echo $wt_add_form_redirect_anuncio_nonce; ?>">
                        <button class="btn btn-success btn-sm"><i class="bi bi-pencil-fill me-2"></i><?php _e('Editar Anúncio', 'wt'); ?></button>
                    </form>
                </div>
            <?php } ?>

            <div class="col-md-6">

                <header class="entry-header alignwide">

                    <?php if (is_singular()) : ?>

                        <figure class="post-thumbnail">
                            <?php
                            // Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
                            the_post_thumbnail('post-thumbnail', array('loading' => false, 'class' => 'img-fluid rounded'));
                            ?>
                            <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                                <figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
                            <?php endif; ?>
                        </figure><!-- .post-thumbnail -->

                    <?php else : ?>

                        <figure class="post-thumbnail">
                            <a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                <?php the_post_thumbnail('post-thumbnail', array('class' => 'img-fluid rounded')); ?>
                            </a>
                        </figure><!-- .post-thumbnail -->

                    <?php endif; ?>
                </header><!-- .entry-header -->

            </div>

            <div class="col-md-6">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </div>

            <?php if ($wt_faq) { ?>
                <div class="col-md-6">
                    <h4 class="mb-4"><?php _e('FAQ', 'wt'); ?></h4>
                    <div class="accordion" id="accordion-anuncio-faq">
                        <?php foreach ($wt_faq as $k => $item) { ?>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-item-<?php echo $k; ?>" aria-expanded="false" aria-controls="accordion-item-<?php echo $k; ?>">
                                        <?php echo $item['question']; ?>
                                    </button>
                                </h2>
                                <div id="accordion-item-<?php echo $k; ?>" class="accordion-collapse collapse" data-bs-parent="#accordion-anuncio-faq">
                                    <div class="accordion-body">
                                        <?php echo $item['answer']; ?>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="<?php echo $wt_faq ? 'col-md-6' : 'col-md-12'; ?>">

                <?php if (!is_user_logged_in()) { // Se não estiver logado

                    echo wt_alert_not_logged_in(__('É preciso estar logado para visualizar as informações de contato do vendedor.', 'wt'));
                } else if ($curr_user->ID !== $author_data->ID && ($user_type !== 'vendedor' && !current_user_can('edit_posts'))) { // Se não for um vendedor e adminstrador
                    echo wt_alert(__('Apenas vendedores podem visualizar dados de contato de outros compradores.', 'wt'));
                } else { // É vendedor ou admim
                ?>

                    <?php do_action('lead_anuncio_error_message') ?>

                    <?php if (current_user_can('edit_posts') || $curr_user->ID === $author_data->ID || $has_leads) { ?>

                        <?php do_action('lead_anuncio_success_message') ?>

                        <h4><?php _e('Dados do Comprador', 'wt'); ?></h4>
                        <dl class="row">

                            <dt class="col-sm-3"><?php _e('Comprador', 'wt'); ?></dt>
                            <dd class="col-sm-9"><?php echo get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name'); ?></a></dd>

                            <?php if ($wt_phone) { ?>
                                <dt class="col-sm-3"><?php _e('Telefone', 'wt'); ?></dt>
                                <dd class="col-sm-9"><a href="tel:+55<?php echo preg_replace('~\D~', '', $wt_phone); ?>"><?php echo wt_format_phone_number($wt_phone); ?></a></dd>
                            <?php } ?>

                            <?php if ($wt_email) { ?>
                                <dt class="col-sm-3"><?php _e('E-mail', 'wt'); ?></dt>
                                <dd class="col-sm-9"><a href="mailto:<?php echo $wt_email; ?>"><?php echo $wt_email; ?></a></dd>
                            <?php } ?>

                            <?php if ($wt_whatsapp) { ?>
                                <dt class="col-sm-3"><?php _e('WhatsApp', 'wt'); ?></dt>
                                <dd class="col-sm-9"><a href="https://wa.me/55<?php echo preg_replace('~\D~', '', $wt_whatsapp); ?>" target="_blank"><?php echo wt_format_phone_number($wt_whatsapp); ?></a></dd>
                            <?php } ?>
                        </dl>

                    <?php } elseif ($anuncio_status !== 'closed') { ?>
                        <?php $wt_add_form_lead_anuncio_nonce = wp_create_nonce('wt_form_lead_anuncio_nonce'); ?>
                        <div class="d-flex justify-content-end mb-3">
                            <form id="lead-anuncio-form" name="lead-anuncio-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                                <input type="hidden" name="action" value="wt_lead_anuncio_form">
                                <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="wt_form_lead_anuncio_nonce" value="<?php echo $wt_add_form_lead_anuncio_nonce; ?>">
                                <button class="btn btn-warning btn-sm"><i class="bi bi-chat-text-fill me-2"></i><?php _e('Visualizar dados de contato', 'wt'); ?></button>
                            </form>
                        </div>
                    <?php } ?>

                <?php } ?>

            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->