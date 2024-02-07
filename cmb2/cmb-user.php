<?php

add_action('cmb2_admin_init', 'wt_register_user_profile_metabox');

function wt_register_user_profile_metabox()
{

    /**
     * Metabox for the user profile screen
     */
    $cmb_user = new_cmb2_box(array(
        'id'               => 'wt_user_edit',
        'title'            => esc_html__('Campos customizados do perfil de usuário', 'wt'), // Doesn't output for user boxes
        'object_types'     => array('user'), // Tells CMB2 to use user_meta vs post_meta
        'show_names'       => true,
        'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
    ));

    $cmb_user->add_field(array(
        'name'     => esc_html__('Informação extra', 'wt'),
        'id'       => 'wt_user_extra_info',
        'type'     => 'title',
        'on_front' => false,
    ));

    // $cmb_user->add_field(array(
    //     'name'    => esc_html__('Avatar', 'wt'),
    //     'desc'    => esc_html__('Opcional', 'wt'),
    //     'id'      => 'wt_user_avatar',
    //     'type'    => 'file',
    // ));

    $cmb_user->add_field(array(
        'name' => esc_html__('Tipo de usuário', 'wt'),
        'id'   => 'wt_user_type',
        'type'             => 'select',
        'options'          => array(
            'comprador' => esc_html__('Comprador', 'wt'),
            'vendedor'   => esc_html__('Vendedor', 'wt'),
        ),
    ));

    $cmb_user->add_field(array(
        'name' => esc_html__('Telefone de contato/WhatsApp', 'wt'),
        'id'   => 'wt_user_phone',
        'type' => 'text',
    ));
}
