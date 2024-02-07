<?php
$current_user = wp_get_current_user();
?>
<div class="col-md-6">
    <h3 class="mb-3"><?php echo wp_sprintf(__('Você já está logado, %s.', 'wt'), $current_user->display_name); ?></h3>
    <?php
    $account_page_id = wt_get_option('wt_account_page');

    if ($account_page_id) { ?>

        <a class="btn btn-primary" href="<?php echo get_permalink($account_page_id); ?>"><?php _e('Acesse a sua conta', 'wt'); ?></a>

    <?php } ?>

    <a class="btn btn-danger" href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('Sair', 'wt'); ?></a>
</div>