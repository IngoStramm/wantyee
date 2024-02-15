<?php

add_shortcode('wt_editor', 'wt_editor');

function wt_editor($atts)
{
    $a = shortcode_atts(array(
        'name' => 'wt_editor',
        'tabindex' => -1
    ), $atts);
    $content = '';
    $editor_id = 'wt_editor';
    $args = array(
        'media_buttons'     => false, // This setting removes the media button.
        'textarea_name'     => $a['name'], // Set custom name.
        'textarea_rows'     => get_option('default_post_edit_rows', 10), //Determine the number of rows.
        'quicktags'         => false, // Remove view as HTML button.
        'tabindex'          => $a['tabindex'],
        'teeny'             => false,
        'tinymce'           => array(
            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,undo,redo',
            'toolbar2'      => '',
            'toolbar3'      => '',
        ),
    );
    return wp_editor($content, $editor_id, $args);
}
