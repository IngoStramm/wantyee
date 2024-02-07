<?php

/**
 * Template part for displaying Reset Password page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */

?>

<?php
$redirect_to = get_home_url();
$wt_add_form_resetpassword_nonce = wp_create_nonce('wt_form_resetpassword_nonce');
$login = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
$key = isset($_REQUEST['key']) ? $_REQUEST['key'] : null;

if (!$login) {
    $_SESSION['wt_resetpassword_error_message'] = __('Usuário ausente. Utilize o link enviado por e-mail para acessar esta página.', 'wt');
}

if (!$key) {
    $_SESSION['wt_resetpassword_error_message'] = __('Chave de redefinição de senha ausente. Utilize o link enviado por e-mail para acessar esta página.', 'wt');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="container">
        <div class="row justify-content-md-center">

            <?php if (!is_user_logged_in()) { ?>

                <div class="col-md-6">

                    <?php
                    // Mensagens de erro de redefinição de senha 
                    if (isset($_SESSION['wt_resetpassword_error_message']) && $_SESSION['wt_resetpassword_error_message']) {
                        echo wt_alert_small('danger', $_SESSION['wt_resetpassword_error_message']);
                        unset($_SESSION['wt_resetpassword_error_message']);
                    }
                    ?>

                    <h3 class="mb-4"><?php _e('Redefinição de senha', 'wt'); ?></h3>
                    <p><?php _e('Digite sua nova senha abaixo.', 'wt') ?></p>

                    <?php
                    // Referência: @link: https://code.tutsplus.com/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811t
                    ?>

                    <form name="resetpassword-form" id="resetpassword-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" novalidate>

                        <div class="row">
                            <div class="mb-3">
                                <label for="user_pass" class="form-label"><?php _e('Senha', 'wt'); ?></label>
                                <input type="password" class="form-control" name="user_pass" id="user_pass" autocomplete="off" aria-autocomplete="list" aria-label="Password" aria-describedby="passwordHelp" tabindex="4" required>
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
                                <button type="submit" class="btn btn-primary"><?php _e('Salvar senha', 'wt'); ?></button>
                            </div>
                        </div>

                        <input type="hidden" name="wt_form_resetpassword_nonce" value="<?php echo $wt_add_form_resetpassword_nonce ?>" />
                        <input type="hidden" name="user_login" value="<?php echo $login; ?>" />
                        <input type="hidden" name="key" value="<?php echo $key; ?>" />
                        <input type="hidden" value="wt_resetpassword_form" name="action">
                    </form>

                    <?php if (wt_get_page_id('login') && wt_get_page_id('newuser')) { ?>
                        <div class="d-flex justify-content-between gap-2">

                            <a class="link-underline link-underline-opacity-50 link-offset-2" href="<?php echo wt_get_page_url('login'); ?>"><?php _e('Acessar', 'wt'); ?></a>

                            <a class="link-underline link-underline-opacity-50 link-offset-2" href="<?php echo wt_get_page_url('newuser'); ?>"><?php _e('Cadastre-se', 'wt'); ?></a>

                        </div>
                    <?php } ?>

                </div>

            <?php } else {
                get_template_part('template-parts/content/content-already-logged-user');
            } ?>

        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->