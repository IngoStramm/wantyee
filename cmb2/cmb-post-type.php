<?php

add_action('cmb2_admin_init', 'wt_cmb_anuncio');

function wt_cmb_anuncio()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'wt_anuncion_metabox',
        'title'         => esc_html__('Opções', 'wt'),
        'object_types'  => array('anuncios'), // Post type
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Preço', 'wt'),
        'id'         => 'wt_anuncio_preco',
        'type'       => 'text',
        // 'show_option_none' => true,
    ));
    $cmb->add_field(array(
        'name'       => esc_html__('Status', 'wt'),
        'id'         => 'wt_anuncio_status',
        'type'       => 'select',
        // 'show_option_none' => true,
        'options'   => array(
            'open'      => __('Aberto', 'wt'),
            'closed'      => __('Fechado', 'wt'),
        )
    ));

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

add_action('cmb2_admin_init', 'wt_cmb_lead');

function wt_cmb_lead()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'wt_lead_metabox',
        'title'         => esc_html__('Opções', 'wt'),
        'object_types'  => array('leads'), // Post type
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('ID do Anúncio', 'wt'),
        'id'         => 'wt_anuncio_id',
        'type'       => 'text_small',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('ID do Comprador', 'wt'),
        'id'         => 'wt_author_anuncio_id',
        'type'       => 'text_small',
    ));
}
