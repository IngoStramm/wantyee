<?php
if (!wt_check_if_plugin_is_active('cmb2/init.php')) {
    return;
}

require_once(WT_DIR . '/cmb2/cmb-user.php');
require_once(WT_DIR . '/cmb2/cmb-settings.php');
