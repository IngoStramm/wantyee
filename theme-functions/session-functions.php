<?php
add_action('init', 'wt_init_session');

function wt_init_session()
{
    if (!session_id()) {
        session_start();
    }
}
