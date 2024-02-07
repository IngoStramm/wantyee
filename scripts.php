<?php

add_action('wp_enqueue_scripts', 'wt_frontend_scripts');

function wt_frontend_scripts()
{

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';
    $version = wt_version();

    if (empty($min)) :
        wp_enqueue_script('wantyee-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true);
    endif;

    // wp_register_script('list-js', WT_URL . '/assets/js/list' . $min . '.js', array('jquery'), $version, true);

    wp_register_script('bootstrap-script', WT_URL . '/assets/js/bootstrap.bundle.min.js', array('jquery'), $version, true);

    wp_register_script('wantyee-script', WT_URL . '/assets/js/wantyee' . $min . '.js', array('jquery', 'bootstrap-script'), $version, true);

    wp_enqueue_script('wantyee-script');

    wp_localize_script('wantyee-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'plugin_url' => WT_URL,

    ));
    wp_enqueue_style('bootstrap-style', WT_URL . '/assets/css/bootstrap.min.css', array(), $version, 'all');
    wp_enqueue_style('bootstrap-icon-style', WT_URL . '/assets/fonts/bootstrap-icons/bootstrap-icons.min.css', array(), $version, 'all');
    wp_enqueue_style('wantyee-style', WT_URL . '/assets/css/wantyee.css', array('bootstrap-style'), $version, 'all');
}

// add_action('admin_enqueue_scripts', 'wt_admin_scripts');

function wt_admin_scripts()
{
    if (!is_user_logged_in())
        return;

    $version = wt_version();

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';

    wp_register_script('wantyee-admin-script', WT_URL . '/assets/js/wantyee-admin' . $min . '.js', array('jquery'), $version, true);

    wp_enqueue_script('wantyee-admin-script');

    wp_localize_script('wantyee-admin-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
