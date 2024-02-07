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
