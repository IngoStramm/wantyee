<?php

/**
 * Display the breadcrumb automaticaly
 * @param  Array $custom_post_types [OPTIONAL] Prevent custom post types with hierarchical structure
 */
function wt_breadcrumbs($custom_post_types = false)
{
    wp_reset_query();
    global $post;
    $output = '';
    $is_custom_post = $custom_post_types ? is_singular('anuncios') : false;

    if (!is_front_page() && !is_home()) {
        $output .= '<ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">';
        $output .= '<li class="breadcrumb-item"><a class="link-body-emphasis" href="';
        $output .= get_option('home');
        $output .= '">';
        $output .= '<i class="bi bi-house-door-fill"></i>';
        $output .= '<span class="visually-hidden">' . get_bloginfo('name') . '</span>';
        $output .= "</a></li>";
        if (has_category()) {
            $output .= '<li class="breadcrumb-item active" aria-current="page"><a class="link-body-emphasis fw-semibold text-decoration-none" href="' . esc_url(get_permalink(get_page(get_the_category($post->ID)))) . '">';
            $output .= get_the_category(', ');
            $output .= '</a></li>';
        }
        if (is_category() || is_single() || $is_custom_post) {
            if (is_category())
                $output .= '<li class="breadcrumb-item active"><a class="link-body-emphasis fw-semibold text-decoration-none" href="' . esc_url(get_permalink(get_page(get_the_category($post->ID)))) . '">' . get_the_category($post->ID)[0]->name . '</a></li>';
            if ($is_custom_post) {
                $output .= '<li class="breadcrumb-item active"><a class="link-body-emphasis fw-semibold text-decoration-none" href="' . get_option('home') . '/' . get_post_type_object(get_post_type($post))->name . '">' . get_post_type_object(get_post_type($post))->label . '</a></li>';
                if ($post->post_parent) {
                    $home = get_page(get_option('page_on_front'));
                    for ($i = count($post->ancestors) - 1; $i >= 0; $i--) {
                        if (($home->ID) != ($post->ancestors[$i])) {
                            $output .= '<li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none" href="';
                            $output .= get_permalink($post->ancestors[$i]);
                            $output .= '">';
                            $output .= get_the_title($post->ancestors[$i]);
                            $output .= "</a></li>";
                        }
                    }
                }
            }
            if (is_single()) {
                $output .= '<li class="breadcrumb-item active">' . get_the_title($post->ID) . '</li>';
            }
        } elseif (is_page() && $post->post_parent) {
            $home = get_page(get_option('page_on_front'));
            for ($i = count($post->ancestors) - 1; $i >= 0; $i--) {
                if (($home->ID) != ($post->ancestors[$i])) {
                    $output .= '<li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none" href="';
                    $output .= get_permalink($post->ancestors[$i]);
                    $output .= '">';
                    $output .= get_the_title($post->ancestors[$i]);
                    $output .= "</a></li>";
                }
            }
            $output .= '<li class="breadcrumb-item active">' . get_the_title($post->ID) . '</li>';
        } elseif (is_page()) {
            $output .= '<li class="breadcrumb-item active">' . get_the_title($post->ID) . '</li>';
        } elseif (is_404()) {
            $output .= '<li class="breadcrumb-item active">404</li>';
        }
        $output .= '<li class="ms-auto"><a class="go-back-btn link-body-emphasis fw-semibold text-decoration-none" href="#">' . __('Voltar', 'wt') . '</a></li>';
        $output .= '</ol>';
    }
    return $output;
}
