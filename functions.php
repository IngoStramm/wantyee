<?php
#region Constants
define('WT_DIR', get_template_directory());
define('WT_URL', get_template_directory_uri());

#endregion Constants

#region Classes

require_once(WT_DIR . '/classes/classes.php');

#endregion Classes

#region Requires

// Theme Functions
require_once(WT_DIR . '/theme-functions/theme-functions.php');

// CMB2
require_once(WT_DIR . '/cmb2/cmb2.php');

// Style/Scripts include
require_once(WT_DIR . '/scripts.php');

#endregion Requires

#region Debug

// add_action('wp_head', 'wp_test');

function wp_test()
{
    // if (!function_exists('get_plugins')) {
    //     require_once ABSPATH . 'wp-admin/includes/plugin.php';
    // }
    // $plugins = get_plugins();
    // $active_plugins = get_option('active_plugins');
    // wt_debug($plugins);
    global $wp_query;
    $current_page_id = $wp_query->post->ID;
    $login_page_id = wt_get_option('wt_login_page');
    wt_debug($current_page_id);
    wt_debug($login_page_id);
}

#endregion Debug