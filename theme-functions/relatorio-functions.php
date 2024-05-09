<?php

/**
 * wt_filter_by_date_args
 *
 * @param  array $args
 * @return array
 */
function wt_filter_by_date_args($args)
{
    $date_query_array = array();
    if (isset($_GET['action']) && $_GET['action'] === 'wt_filter_relatorio_form') {
        $start_date = isset($_GET['start-date']) && $_GET['start-date'] ? $_GET['start-date'] : null;
        $end_date = isset($_GET['end-date']) && $_GET['end-date'] ? $_GET['end-date'] : null;

        if ($start_date) {
            $start_date = strtotime($start_date . '-1 day');
            $date_query_array['after'] = array(
                'day' => date('d', $start_date),
                'month' => date('m', $start_date),
                'year' => date('Y', $start_date),
            );
        }

        if ($end_date) {
            $end_date = strtotime($end_date . '+1 day');
            $date_query_array['before'] = array(
                'day' => date('d', $end_date),
                'month' => date('m', $end_date),
                'year' => date('Y', $end_date),
            );
        }
    }
    if (count($date_query_array) > 0) {
        $args['date_query'] = $date_query_array;
    }
    return $args;
}
/**
 * wt_get_all_anuncios
 *
 * @return array
 */
function wt_get_all_anuncios()
{
    $args = array(
        'post_type' => 'anuncios',
        'posts_per_page' => -1,
        'status'    => 'published'
    );
    $args = wt_filter_by_date_args($args);
    $anuncios = get_posts($args);
    wp_reset_postdata();
    return $anuncios;
}

/**
 * wt_get_term_anuncios
 *
 * @param  int $term_id
 * @return array
 */
function wt_get_term_anuncios($term_id)
{
    $args = array(
        'post_type' => 'anuncios',
        'posts_per_page' => -1,
        'status'    => 'published',
        'tax_query' => array(
            array(
                'taxonomy' => 'categoria-de-anuncio',
                'field' => 'term_id',
                'terms' => $term_id,
            ),
        ),
    );
    $args = wt_filter_by_date_args($args);
    $anuncios = get_posts($args);
    wp_reset_postdata();
    return $anuncios;
}

/**
 * wt_get_all_anuncios_ativos
 *
 * @return array
 */
function wt_get_all_anuncios_ativos()
{
    $args = array(
        'post_type' => 'anuncios',
        'posts_per_page' => -1,
        'status'    => 'published',
        'meta_key'  => 'wt_anuncio_status',
        'meta_value' => 'open',
        'meta_compare' => '=',
    );
    $args = wt_filter_by_date_args($args);
    $anuncios = get_posts($args);
    wp_reset_postdata();
    return $anuncios;
}

/**
 * wt_get_all_anuncios_fechados
 *
 * @return array
 */
function wt_get_all_anuncios_fechados()
{
    $args = array(
        'post_type' => 'anuncios',
        'posts_per_page' => -1,
        'status'    => 'published',
        'meta_key'  => 'wt_anuncio_status',
        'meta_value' => 'open',
        'meta_compare' => '!=',
    );
    $args = wt_filter_by_date_args($args);
    $anuncios = get_posts($args);
    wp_reset_postdata();
    return $anuncios;
}

/**
 * wt_get_all_anuncios_min_price
 *
 * @return float
 */
function wt_get_all_anuncios_min_price()
{
    $anuncios = wt_get_all_anuncios();
    $prices = array();
    foreach ($anuncios as $anuncio) {
        $price = get_post_meta($anuncio->ID, 'wt_anuncio_preco', true);
        if ($price) {
            $prices[] = $price;
        }
    }
    if (count($prices) === 0) {
        $prices[] = 0;
    };
    return min($prices);
}

/**
 * wt_get_all_anuncios_max_price
 *
 * @return float
 */
function wt_get_all_anuncios_max_price()
{
    $anuncios = wt_get_all_anuncios();
    $prices = array();
    foreach ($anuncios as $anuncio) {
        $price = get_post_meta($anuncio->ID, 'wt_anuncio_preco', true);
        if ($price) {
            $prices[] = $price;
        }
    }
    if (count($prices) === 0) {
        $prices[] = 0;
    };
    return max($prices);
}

/**
 * wt_get_all_anuncios_media_price
 *
 * @return float
 */
function wt_get_all_anuncios_media_price()
{
    $anuncios = wt_get_all_anuncios();
    $prices = array();
    foreach ($anuncios as $anuncio) {
        $price = get_post_meta($anuncio->ID, 'wt_anuncio_preco', true);
        if ($price) {
            $prices[] = $price;
        }
    }
    $total_price = array_sum($prices);
    $media_price = count($prices) > 0 ? $total_price / count($prices) : 0;
    return $media_price;
}

/**
 * wt_get_all_users
 *
 * @return array
 */
function wt_get_all_users()
{
    $args = array(
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'wt_user_type',
                'value' => 'comprador',
                'compare' => '='
            ),
            array(
                'key' => 'wt_user_type',
                'value' => 'vendedor',
                'compare' => '='
            ),
        ),
    );
    // $args = wt_filter_by_date_args($args);
    $users = get_users($args);
    return $users;
}

/**
 * wt_get_all_users_compradores
 *
 * @return array
 */
function wt_get_all_users_compradores()
{
    $args = array(
        'meta_key' => 'wt_user_type',
        'meta_value' => 'comprador',
        'meta_compare' => '='
    );
    // $args = wt_filter_by_date_args($args);
    $users = get_users($args);
    return $users;
}

/**
 * wt_get_all_users_vendedores
 *
 * @return array
 */
function wt_get_all_users_vendedores()
{
    $args = array(
        'meta_key' => 'wt_user_type',
        'meta_value' => 'vendedor',
        'meta_compare' => '='
    );
    // $args = wt_filter_by_date_args($args);
    $users = get_users($args);
    return $users;
}

/**
 * wt_get_term_anuncios_min_price
 *
 * @param  int $term_id
 * @return float
 */
function wt_get_term_anuncios_min_price($term_id)
{
    $anuncios = wt_get_term_anuncios($term_id);
    $prices = array();
    foreach ($anuncios as $anuncio) {
        $price = get_post_meta($anuncio->ID, 'wt_anuncio_preco', true);
        if ($price) {
            $prices[] = $price;
        }
    }
    if (count($prices) === 0) {
        $prices[] = 0;
    };
    return min($prices);
}

/**
 * wt_get_term_anuncios_max_price
 *
 * @param  int $term_id
 * @return float
 */
function wt_get_term_anuncios_max_price($term_id)
{
    $anuncios = wt_get_term_anuncios($term_id);
    $prices = array();
    foreach ($anuncios as $anuncio) {
        $price = get_post_meta($anuncio->ID, 'wt_anuncio_preco', true);
        if ($price) {
            $prices[] = $price;
        }
    }
    if (count($prices) === 0) {
        $prices[] = 0;
    };
    return max($prices);
}

/**
 * wt_get_term_anuncios_media_price
 *
 * @param  int $term_id
 * @return array
 */
function wt_get_term_anuncios_media_price($term_id)
{
    $anuncios = wt_get_term_anuncios($term_id);
    $prices = array();
    foreach ($anuncios as $anuncio) {
        $price = get_post_meta($anuncio->ID, 'wt_anuncio_preco', true);
        if ($price) {
            $prices[] = $price;
        }
    }
    $total_price = array_sum($prices);
    $media_price = count($prices) > 0 ? $total_price / count($prices) : 0;
    return $media_price;
}

/**
 * wt_get_terms_name
 *
 * @return array
 */
function wt_get_terms_name()
{
    $nomes = array();
    $terms = get_terms(array(
        'taxonomy'   => 'categoria-de-anuncio',
        'hide_empty' => false,
    ));
    foreach ($terms as $term) {
        if (!$term->parent) {
            $nomes[] = $term->name;
            foreach ($terms as $term2) {
                if ($term2->parent === $term->term_id) {
                    $nomes[] = $term2->name;
                }
            }
        }
    }
    return $nomes;
}

/**
 * wt_get_terms_minval
 *
 * @return array
 */
function wt_get_terms_minval()
{
    $minvalues = array();
    $terms = get_terms(array(
        'taxonomy'   => 'categoria-de-anuncio',
        'hide_empty' => false,
    ));
    foreach ($terms as $term) {
        if (!$term->parent) {
            $minvalues[] = wt_get_term_anuncios_min_price($term->term_id);
            foreach ($terms as $term2) {
                if ($term2->parent === $term->term_id) {
                    $minvalues[] = wt_get_term_anuncios_min_price($term2->term_id);
                }
            }
        }
    }
    return $minvalues;
}

/**
 * wt_get_terms_maxval
 *
 * @return array
 */
function wt_get_terms_maxval()
{
    $maxvalues = array();
    $terms = get_terms(array(
        'taxonomy'   => 'categoria-de-anuncio',
        'hide_empty' => false,
    ));
    foreach ($terms as $term) {
        if (!$term->parent) {
            $maxvalues[] = wt_get_term_anuncios_max_price($term->term_id);
            foreach ($terms as $term2) {
                if ($term2->parent === $term->term_id) {
                    $maxvalues[] = wt_get_term_anuncios_max_price($term2->term_id);
                }
            }
        }
    }
    return $maxvalues;
}

/**
 * wt_get_terms_midval
 *
 * @return array
 */
function wt_get_terms_midval()
{
    $midvalues = array();
    $terms = get_terms(array(
        'taxonomy'   => 'categoria-de-anuncio',
        'hide_empty' => false,
    ));
    foreach ($terms as $term) {
        if (!$term->parent) {
            $midvalues[] = wt_get_term_anuncios_media_price($term->term_id);
            foreach ($terms as $term2) {
                if ($term2->parent === $term->term_id) {
                    $midvalues[] = wt_get_term_anuncios_media_price($term2->term_id);
                }
            }
        }
    }
    return $midvalues;
}
