<?php

/**
 * Template part for displaying User Account Page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */
$user = wp_get_current_user();
$user_type = get_user_meta($user->get('id'), 'wt_user_type', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="container">
        <div class="row">
            <div class="col">

                <?php if (is_user_logged_in()) { ?>
                    <?php $user_id = $user->get('ID'); ?>

                    <h3><?php echo sprintf(__('Olá, %s!'), $user->display_name); ?></h3>
                    <p>Nesta área você pode alterar os seus dados pessoais, como:</p>
                    <ul>
                        <li>Nome</li>
                        <li>Sobrenome</li>
                        <li>E-mail</li>
                        <li>Telefone/WhatsApp</li>
                        <li>Senha</li>
                    </ul>

                    <p>Se você for um comprador, pode visualizar os seus anúncios, assim como a notificação de novas solicitações de contato (leads).</p>

                    <p>Já se for um vendedor, pode visualizar os anúncios que solicitou entrar em contato. Além disso, também pode configurar quais categorias deseja acompanhar.</p>

                    <?php
                    // Mensagens de erro de atualização do usuário
                    if (isset($_SESSION['wt_update_user_error_message']) && $_SESSION['wt_update_user_error_message']) {
                        echo wt_alert_small('danger', $_SESSION['wt_update_user_error_message']);
                        unset($_SESSION['wt_update_user_error_message']);
                    }
                    ?>

                    <?php
                    // Mensagens de successo de atualização do usuário
                    if (isset($_SESSION['wt_update_user_success_message']) && $_SESSION['wt_update_user_success_message']) {
                        echo wt_alert_small('success', $_SESSION['wt_update_user_success_message']);
                        unset($_SESSION['wt_update_user_success_message']);
                    }
                    ?>

                    <?php
                    // Mensagens de erro de atualização das configurações de categoria
                    if (isset($_SESSION['wt_update_vendedor_terms_error_message']) && $_SESSION['wt_update_vendedor_terms_error_message']) {
                        echo wt_alert_small('danger', $_SESSION['wt_update_vendedor_terms_error_message']);
                        unset($_SESSION['wt_update_vendedor_terms_error_message']);
                    }
                    ?>

                    <?php
                    // Mensagens de successo de atualização das configurações de categoria
                    if (isset($_SESSION['wt_update_user_success_message']) && $_SESSION['wt_update_user_success_message']) {
                        echo wt_alert_small('success', $_SESSION['wt_update_user_success_message']);
                        unset($_SESSION['wt_update_user_success_message']);
                    }
                    ?>

                    <?php
                    // Mensagens de erro de novo anúncio
                    if (isset($_SESSION['wt_new_anuncio_error_message']) && $_SESSION['wt_new_anuncio_error_message']) {
                        echo wt_alert_small('danger', $_SESSION['wt_new_anuncio_error_message']);
                        unset($_SESSION['wt_new_anuncio_error_message']);
                    }
                    ?>

                    <?php
                    // Mensagens de successo de novo anúncio
                    if (isset($_SESSION['wt_new_anuncio_success_message']) && $_SESSION['wt_new_anuncio_success_message']) {
                        echo wt_alert_small('success', $_SESSION['wt_new_anuncio_success_message']);
                        unset($_SESSION['wt_new_anuncio_success_message']);
                    }
                    ?>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">

                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><?php _e('Dados Pessoais', 'wt'); ?></button>

                            <?php if ($user_type === 'vendedor') { ?>
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><?php _e('Configuração de categorias', 'wt'); ?></button>
                            <?php } else { ?>
                                <button class="nav-link" id="nav-new-anuncio-tab" data-bs-toggle="tab" data-bs-target="#nav-new-anuncio" type="button" role="tab" aria-controls="nav-new-anuncio" aria-selected="false"><?php _e('Novo Anúncio', 'wt'); ?></button>
                            <?php } ?>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                            <?php get_template_part('template-parts/content/content-account-update-user-form'); ?>
                        </div>

                        <?php if ($user_type === 'vendedor') { ?>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                <?php get_template_part('template-parts/content/content-account-vendedor-page'); ?>
                            </div>
                        <?php } else { ?>
                            <div class="tab-pane fade" id="nav-new-anuncio" role="tabpanel" aria-labelledby="nav-new-anuncio-tab" tabindex="0">
                                <?php get_template_part('template-parts/content/content-account-new-anuncio-page'); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="row col-md-6">
                        <?php echo wt_alert_not_logged_in(__('É preciso estar logado para visualizar os dados da sua conta.', 'wt')); ?>
                    </div>
                <?php } ?>


            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->