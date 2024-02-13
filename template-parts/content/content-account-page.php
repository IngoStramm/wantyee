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
$redirect_to = get_home_url();
$wt_add_form_update_user_nonce = wp_create_nonce('wt_form_update_user_nonce');

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

                    <form name="update-user-form" id="update-user-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="mb-3">
                                <label for="user_name" class="form-label"><?php _e('Nome', 'wt'); ?></label>
                                <input type="text" class="form-control" id="user_name" name="user_name" tabindex="1" value="<?php echo $user->get('first_name'); ?>" required>
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="user_surname" class="form-label"><?php _e('Sobrenome', 'wt'); ?></label>
                                <input type="text" class="form-control" id="user_surname" name="user_surname" tabindex="2" value="<?php echo $user->get('last_name'); ?>" required>
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="user_email" class="form-label"><?php _e('E-mail', 'wt') ?></label>
                                <input type="email" class="form-control" id="user_email" name="user_email" tabindex="3" value="<?php echo $user->get('user_email'); ?>" required>
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="user_whatsapp" class="form-label"><?php _e('WhatsApp', 'wt') ?></label>
                                <input type="tel" maxlength="15" minlength="15" class="form-control phone-input" id="user_whatsapp" name="user_whatsapp" tabindex="3" value="<?php echo get_user_meta($user_id, 'wt_user_whatsapp', true); ?>">
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="user_phone" class="form-label"><?php _e('Telefone', 'wt') ?></label>
                                <input type="tel" maxlength="15" minlength="14" class="form-control phone-input" id="user_phone" name="user_phone" tabindex="3" value="<?php echo get_user_meta($user_id, 'wt_user_phone', true); ?>">
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="user_pass" class="form-label"><?php _e('Senha', 'wt'); ?></label>
                                <input type="password" class="form-control" name="user_pass" id="user_pass" autocomplete="off" aria-autocomplete="list" aria-label="Password" aria-describedby="passwordHelp" tabindex="4">
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                                <div class="password-meter">
                                    <div class="meter-section rounded me-2"></div>
                                    <div class="meter-section rounded me-2"></div>
                                    <div class="meter-section rounded me-2"></div>
                                    <div class="meter-section rounded"></div>
                                </div>
                                <div id="passwordHelp" class="form-text text-muted"><?php _e('Use 8 ou mais caracteres com uma mistura de letras, números e símbolos.', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" tabindex="6"><?php _e('Salvar', 'wt'); ?></button>

                            </div>
                        </div>

                        <input type="hidden" name="wt_form_update_user_nonce" value="<?php echo $wt_add_form_update_user_nonce ?>" />
                        <input type="hidden" value="wt_update_user_form" name="action">
                        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                        <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
                    </form>

                <?php } else { ?>
                    <div class="row col-md-6">
                        <?php echo wt_alert_not_logged_in(__('É preciso estar logado para visualizar os dados da sua conta.', 'wt')); ?>
                    </div>
                <?php } ?>


                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->

            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->