<?php

add_action('init', 'wt_anuncio_post_type', 1);

function wt_anuncio_post_type()
{
    $portfolio = new WT_Post_Type(
        'Anúncio', // Nome (Singular) do Post Type.
        'anuncios' // Slug do Post Type.;
    );

    $portfolio->set_labels(
        array(
            'name'               => __('Anúncio', 'wt'),
            'singular_name'      => __('Anúncio', 'wt'),
            'menu_name'          => __('Anúncios', 'wt'),
            'name_admin_bar'     => __('Anúncio', 'wt'),
            'add_new'            => __('Adicionar Anúncio', 'wt'),
            'add_new_item'       => __('Adicionar Novo Anúncio', 'wt'),
            'new_item'           => __('Novo Anúncio', 'wt'),
            'edit_item'          => __('Editar Anúncio', 'wt'),
            'view_item'          => __('Visualizar Anúncio', 'wt'),
            'all_items'          => __('Todos os Anúncios', 'wt'),
            'search_items'       => __('Pesquisar Anúncios', 'wt'),
            'parent_item_colon'  => __('Anúncios Pai', 'wt'),
            'not_found'          => __('Nenhum Anúncio encontrado', 'wt'),
            'not_found_in_trash' => __('Nenhum Anúncio encontrado na lixeira.', 'wt'),
        )
    );

    $portfolio->set_arguments(
        array(
            'supports'             => array('title', 'editor', 'thumbnail' , 'revisions'),
            'menu_icon'         => 'dashicons-products',
            'show_in_nav_menus' => true
        )
    );
}

add_action('init', 'wt_lead_post_type', 1);

function wt_lead_post_type()
{
    $portfolio = new WT_Post_Type(
        'Lead', // Nome (Singular) do Post Type.
        'leads' // Slug do Post Type.;
    );

    $portfolio->set_labels(
        array(
            'name'               => __('Lead', 'wt'),
            'singular_name'      => __('Lead', 'wt'),
            'menu_name'          => __('Leads', 'wt'),
            'name_admin_bar'     => __('Lead', 'wt'),
            'add_new'            => __('Adicionar Lead', 'wt'),
            'add_new_item'       => __('Adicionar Novo Lead', 'wt'),
            'new_item'           => __('Novo Lead', 'wt'),
            'edit_item'          => __('Editar Lead', 'wt'),
            'view_item'          => __('Visualizar Lead', 'wt'),
            'all_items'          => __('Todos os Leads', 'wt'),
            'search_items'       => __('Pesquisar Leads', 'wt'),
            'parent_item_colon'  => __('Leads Pai', 'wt'),
            'not_found'          => __('Nenhum Lead encontrado', 'wt'),
            'not_found_in_trash' => __('Nenhum Lead encontrado na lixeira.', 'wt'),
        )
    );

    $portfolio->set_arguments(
        array(
            'supports'             => array('title', 'revisions'),
            'menu_icon'         => 'dashicons-id',
            'show_in_nav_menus' => true
        )
    );
}

add_action('init', 'wt_avaliacao_post_type', 1);

function wt_avaliacao_post_type()
{
    $avaliacao = new WT_Post_Type(
        'Avaliação', // Nome (Singular) do Post Type.
        'avaliacoes' // Slug do Post Type.;
    );

    $avaliacao->set_labels(
        array(
            'name'               => __('Avaliação', 'wt'),
            'singular_name'      => __('Avaliação', 'wt'),
            'menu_name'          => __('Avaliações', 'wt'),
            'name_admin_bar'     => __('Avaliação', 'wt'),
            'add_new'            => __('Adicionar avaliação', 'wt'),
            'add_new_item'       => __('Adicionar Nova avaliação', 'wt'),
            'new_item'           => __('Nova avaliação', 'wt'),
            'edit_item'          => __('Editar avaliação', 'wt'),
            'view_item'          => __('Visualizar avaliação', 'wt'),
            'all_items'          => __('Todas as avaliações', 'wt'),
            'search_items'       => __('Pesquisar avaliações', 'wt'),
            'parent_item_colon'  => __('Avaliação Pai', 'wt'),
            'not_found'          => __('Nenhuma avaliação encontrada', 'wt'),
            'not_found_in_trash' => __('Nenhuma avaliação encontrada na lixeira.', 'wt'),
        )
    );

    $avaliacao->set_arguments(
        array(
            'supports'             => array('title', 'editor'),
            'menu_icon'         => 'dashicons-star-filled',
            'show_in_nav_menus' => true
        )
    );
}
