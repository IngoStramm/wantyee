<?php

/**
 * Template part for displaying login page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */

?>

<?php
$redirect_to = get_home_url();
$wt_add_form_login_nonce = wp_create_nonce('wt_form_login_nonce');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="container">
        <div class="row justify-content-md-center">

            <?php if (!is_user_logged_in()) { ?>

                <div class="col-md-6">

                    <?php
                    // Mensagens de erro de login 
                    if (isset($_SESSION['wt_login_error_message']) && $_SESSION['wt_login_error_message']) {
                        echo wt_alert_small('danger', $_SESSION['wt_login_error_message']);
                        unset($_SESSION['wt_login_error_message']);
                    }

                    // Mensagens de erro de reset password 
                    if (isset($_SESSION['wt_resetpassword_error_message']) && $_SESSION['wt_resetpassword_error_message']) {
                        echo wt_alert_small('danger', $_SESSION['wt_resetpassword_error_message']);
                        unset($_SESSION['wt_resetpassword_error_message']);
                    }

                    // Mensagens de successo de senha perdida
                    if (isset($_SESSION['wt_lostpassword_success_message']) && $_SESSION['wt_lostpassword_success_message']) {
                        echo wt_alert_small('success', $_SESSION['wt_lostpassword_success_message']);
                        unset($_SESSION['wt_lostpassword_success_message']);
                    } 

                    // Mensagens de successo de redefinição senha
                    if (isset($_SESSION['wt_resetpassword_success_message']) && $_SESSION['wt_resetpassword_success_message']) {
                        echo wt_alert_small('success', $_SESSION['wt_resetpassword_success_message']);
                        unset($_SESSION['wt_resetpassword_success_message']);
                    } 
                    ?>

                    <h3 class="mb-4"><?php _e('Login', 'wt'); ?></h3>

                    <form name="loginform" id="loginform" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" novalidate>

                        <div class="row">
                            <div class="mb-3">
                                <label for="user_login" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="user_login" name="log" required>
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="user_pass" class="form-label"><?php _e('Senha', 'wt'); ?></label>
                                <input type="password" class="form-control" name="pwd" id="user_pass" required>
                                <div class="invalid-feedback"><?php _e('Campo obrigatório', 'wt'); ?></div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary"><?php _e('Entrar', 'wt'); ?></button>
                            </div>
                        </div>

                        <input type="hidden" name="wt_form_login_nonce" value="<?php echo $wt_add_form_login_nonce ?>" />
                        <input type="hidden" value="wt_login_form" name="action">
                        <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
                    </form>

                    <?php if (wt_get_page_id('newuser') && wt_get_page_id('lostpassword')) { ?>
                        <div class="d-flex justify-content-between gap-2">

                            <a class="link-underline link-underline-opacity-50 link-offset-2" href="<?php echo wt_get_page_url('newuser'); ?>"><?php _e('Cadastre-se', 'wt'); ?></a>

                            <a class="link-underline link-underline-opacity-50 link-offset-2" href="<?php echo wt_get_page_url('lostpassword'); ?>"><?php _e('Perdeu a senha?', 'wt'); ?></a>

                        </div>
                    <?php } ?>

                </div>

            <?php } else {
                get_template_part('template-parts/content/login/content-already-logged-user');
            } ?>

        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->