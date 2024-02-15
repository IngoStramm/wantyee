<?php

add_action('cmb2_admin_init', 'wt_cmb_anuncio');

function wt_cmb_anuncio()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'wt_anuncion_metabox',
        'title'         => esc_html__('Opções', 'wt'),
        'object_types'  => array('anuncios'), // Post type
    ));

    // $cmb->add_field(array(
    //     'name'       => esc_html__('Telefone de contato', 'wt'),
    //     'id'         => 'wt_fone',
    //     'type'       => 'text',
    // ));

    // $cmb->add_field(array(
    //     'name'       => esc_html__('E-mail de contato', 'wt'),
    //     'id'         => 'wt_email',
    //     'type'       => 'text_email',
    // ));

    // $cmb->add_field(array(
    //     'name'       => esc_html__('WhatsApp', 'wt'),
    //     'id'         => 'wt_whatsapp',
    //     'type'       => 'text',
    // ));

    $group_field_id = $cmb->add_field(array(
        'id'          => 'wt_faq',
        'type'        => 'group',
        'description' => esc_html__('Perguntas e respostas (FAQ)', 'wt'),
        'options'     => array(
            'group_title'    => esc_html__('Pergunta/Resposta #{#}', 'wt'), // {#} gets replaced by row number
            'add_button'     => esc_html__('Adicionar nova pergunta/resposta', 'wt'),
            'remove_button'  => esc_html__('Remover pergunta/resposta', 'wt'),
            'sortable'       => true,
        ),
    ));

    $cmb->add_group_field($group_field_id, array(
        'name'       => esc_html__('Pergunta', 'wt'),
        'id'         => 'question',
        'type'       => 'text',
    ));

    $cmb->add_group_field($group_field_id, array(
        'name'       => esc_html__('Resposta', 'wt'),
        'id'         => 'answer',
        'type'       => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 3,
        ),
    ));
}
