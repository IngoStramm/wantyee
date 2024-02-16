<?php

add_action('init', 'wt_categoria_anuncio_tax', 1);

function wt_categoria_anuncio_tax()
{
    $video = new WT_Taxonomy(
        __('Categoria de anúncio', 'wt'), // Nome (Singular) da nova Taxonomia.
        'categoria-de-anuncio', // Slug do Taxonomia.
        'anuncios' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $video->set_labels(
        array(
            'menu_name' => __('Categorias de anúncio', 'wt')
        )
    );

    $video->set_arguments(
        array(
            'hierarchical' => true,
            'default_term' => array(
                'name' => __('Geral', 'wt'),
                'slug' => 'geral',
            )
        )
    );
}
