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
                    <p><?php _e('Nesta área você pode alterar os seus dados pessoais:', 'wt') ?></p>
                    <ul>
                        <li><?php _e('Nome', 'wt'); ?></li>
                        <li><?php _e('Sobrenome', 'wt'); ?></li>
                        <li><?php _e('E-mail', 'wt'); ?></li>
                        <li><?php _e('Telefone/WhatsApp', 'wt') ?></li>
                        <li><?php _e('Senha', 'wt'); ?></li>
                    </ul>

                    <?php if ($user_type === 'comprador') { ?>
                        <p><?php _e('Você também pode visualizar e fazer a gestão dos seus anúncios, assim como visualizar as notificações de novas solicitações de contato (leads).', 'wt'); ?></p>

                    <?php } else { ?>

                        <p><?php _e('Você pode visualizar os anúncios que solicitou entrar em contato. Além disso, também pode configurar quais categorias deseja acompanhar.', 'wt'); ?></p>

                    <?php } ?>

                    <?php echo wt_account_nav('account'); ?>

                    <?php do_action('update_user_messages'); ?>
                                        
                    <h3 class="mt-2 mb-3"><?php _e('Dados pessoais', 'wt'); ?></h3>

                    <?php get_template_part('template-parts/content/account/content-account-update-user-form'); ?>

                <?php } else { ?>
                    <div class="row col-md-6">
                        <?php echo wt_alert_not_logged_in(__('É preciso estar logado para visualizar os dados da sua conta.', 'wt')); ?>
                    </div>
                <?php } ?>


            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->