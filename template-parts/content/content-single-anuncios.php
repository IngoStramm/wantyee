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
$author_id = get_the_author_meta('ID');
$wt_email = get_post_meta(get_the_ID(), 'wt_email', true);
$wt_whatsapp = get_user_meta($author_id, 'wt_user_whatsapp', true);
$wt_phone = get_user_meta($author_id, 'wt_user_phone', true);
$wt_faq = get_post_meta(get_the_ID(), 'wt_faq', true);
$custom_post_types = 'anuncios';
?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs', null, array('anuncios')); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="row">

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

            <div class="col-md-6">

                <?php if (is_user_logged_in()) { ?>

                    <h4><?php _e('Dados do Comprador', 'wt'); ?></h4>
                    <dl class="row">

                        <dt class="col-sm-3"><?php _e('Comprador', 'wt'); ?></dt>
                        <dd class="col-sm-9"><?php echo get_the_author_meta('display_name'); ?></a></dd>

                        <?php if ($wt_phone) { ?>
                            <dt class="col-sm-3"><?php _e('Telefone', 'wt'); ?></dt>
                            <dd class="col-sm-9"><a href="tel:+55<?php echo preg_replace('~\D~', '', $wt_phone); ?>"><?php echo $wt_phone; ?></a></dd>
                        <?php } ?>

                        <?php if ($wt_email) { ?>
                            <dt class="col-sm-3"><?php _e('E-mail', 'wt'); ?></dt>
                            <dd class="col-sm-9"><a href="mailto:<?php echo $wt_email; ?>"><?php echo $wt_email; ?></a></dd>
                        <?php } ?>

                        <?php if ($wt_whatsapp) { ?>
                            <dt class="col-sm-3"><?php _e('WhatsApp', 'wt'); ?></dt>
                            <dd class="col-sm-9"><a href="https://wa.me/55<?php echo preg_replace('~\D~', '', $wt_whatsapp); ?>" target="_blank"><?php echo $wt_whatsapp; ?></a></dd>
                        <?php } ?>
                    </dl>

                <?php } else {
                    echo wt_alert_not_logged_in(__('É preciso estar logado para visualizar as informações de contato do vendedor.', 'wt'));
                } ?>

            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->