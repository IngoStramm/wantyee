<?php

/**
 * wt_get_vendedor_avaliacoes
 *
 * @param  int $vendedor_id
 * @return array
 */
function wt_get_vendedor_avaliacoes($vendedor_id)
{
    $args = array(
        'post_type' => 'avaliacoes',
        'posts_per_page' => -1,
        'status'    => 'published',
        'meta_key' => 'wt_avaliacao_author_lead_id',
        'meta_value' => $vendedor_id,
        'meta_compare' => '='
    );
    $avaliacoes = get_posts($args);
    wp_reset_postdata();
    return $avaliacoes;
}
/**
 * wt_get_vendedor_rating
 *
 * @param  int $vendedor_id
 * @return int
 */
function wt_get_vendedor_rating($vendedor_id)
{
    $avaliacoes = wt_get_vendedor_avaliacoes($vendedor_id);
    $rating = 0;
    foreach ($avaliacoes as $avaliacao) {
        $avaliacao_nota = get_post_meta($avaliacao->ID, 'wt_avaliacao_nota', true);
        $rating += $avaliacao_nota;
    }
    if (count($avaliacoes) > 0) {
        $rating = $rating / count($avaliacoes);
    }
    return floor($rating);
}

function wt_get_avaliacao_rating($avaliacao_id)
{
    $rating = get_post_meta($avaliacao_id, 'wt_avaliacao_nota', true);
    return floor($rating);
}

/**
 * wt_display_vendedor_stars_rating
 *
 * @param  int $vendedor_id
 * @return string
 */
function wt_display_vendedor_stars_rating($vendedor_id)
{
    $rating = wt_get_vendedor_rating($vendedor_id);
    $output = '';
    if ($rating > 0) {
        $output .= '<div class="stars-rating">';
        for ($i = 0; $i < $rating; $i++) {
            $output .= '<i class="bi bi-star-fill"></i>';
        }
        if ($rating < 5) {
            $empty_stars = 5 - $rating;
            for ($i = 0; $i < $empty_stars; $i++) {
                $output .= '<i class="bi bi-star"></i>';
            }
        }
        $output .= '</div>';
    } else {
        $output .= '<small>' . __('Não avaliado.', 'true') . '</small>';
    }
    return $output;
}

function wt_display_avaliacao_stars_rating($avaliacao_id)
{
    $rating = wt_get_avaliacao_rating($avaliacao_id);
    $output = '<div class="stars-rating">';
    if ($rating > 0) {
        for ($i = 0; $i < $rating; $i++) {
            $output .= '<i class="bi bi-star-fill"></i>';
        }
        if ($rating < 5) {
            $empty_stars = 5 - $rating;
            for ($i = 0; $i < $empty_stars; $i++) {
                $output .= '<i class="bi bi-star"></i>';
            }
        }
    } else {
        $output = '<small>' . __('Não avaliado.', 'true') . '</small>';
    }
    $output .= '</div>';
    return $output;
}

function wt_display_static_stars_rating($nota)
{
    $output = '<div class="stars-rating">';
    if ($nota > 0) {
        for ($i = 0; $i < $nota; $i++) {
            $output .= '<i class="bi bi-star-fill"></i>';
        }
        if ($nota < 5) {
            $empty_stars = 5 - $nota;
            for ($i = 0; $i < $empty_stars; $i++) {
                $output .= '<i class="bi bi-star"></i>';
            }
        }
    } else {
        $output = '<small>' . __('Não avaliado.', 'true') . '</small>';
    }
    $output .= '</div>';
    return $output;
}
