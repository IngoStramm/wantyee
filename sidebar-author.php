<?php

if (is_author()) {
    $author = get_queried_object();
    $author_id = $author->data->ID;
    $author_display_name = $author->data->display_name;
    $author_terms = [];
    $author_posts = get_posts(array('post_type' => 'anuncios', 'posts_per_page' => -1, 'author' => $author_id));
    foreach ($author_posts as $author_post) {
        $author_post_terms = wp_get_object_terms($author_post->ID, 'categoria-de-anuncio');
        if (!empty($author_post_terms) && !is_wp_error($author_post_terms)) {
            foreach ($author_post_terms as $author_post_term) {
                $author_terms[$author_post_term->name] = $author_post_term;
            }
        }
    }
    wp_reset_postdata();
    ksort($author_terms);
    echo wt_show_anuncio_terms_nav($author_terms);
}
