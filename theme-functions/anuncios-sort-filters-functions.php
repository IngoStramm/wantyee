<?php

add_filter('posts_search', 'wt_db_filter_authors_search');

/**
 * wt_db_filter_authors_search
 *
 * Include posts from authors in the search results where
 * either their display name or user login matches the query string
 * 
 * @param  string $posts_search
 * @return string
 */
function wt_db_filter_authors_search($posts_search)
{

    // Don't modify the query at all if we're not on the search template or if the LIKE is empty
    if (!is_search() || empty($posts_search)) return $posts_search;

    global $wpdb;

    // Get all of the users of the blog and see if the search query matches either the display name or the user login
    add_filter('pre_user_query', 'wt_db_filter_user_query');

    $search = sanitize_text_field(get_query_var('s'));

    $args = array(
        'count_total' => false,
        'search' => sprintf('*%s*', $search),
        'search_fields' => array(
            'display_name',
            'user_login',
        ),
        'fields' => 'ID',
    );

    $matching_users = get_users($args);

    remove_filter('pre_user_query', 'wt_db_filter_user_query');

    // Don't modify the query if there aren't any matching users
    if (empty($matching_users)) return $posts_search;

    // Take a slightly different approach than core where we want all of the posts from these authors
    $posts_search = str_replace(')))', ")) OR ( {$wpdb->posts}.post_author IN (" . implode(',', array_map('absint', $matching_users)) . ")))", $posts_search);
    return $posts_search;
}

/**
 * wt_db_filter_user_query
 * 
 * Modify get_users() to search display_name instead of user_nicename. Helper function used inside of db_filter_authors_search()
 *
 * @param  WP_Query $user_query
 * @return WP_Query
 */
function wt_db_filter_user_query(&$user_query)
{

    if (is_object($user_query))
        $user_query->query_where = str_replace("user_nicename LIKE", "display_name LIKE", $user_query->query_where);
    return $user_query;
}

add_action('pre_get_posts', 'wt_custom_query');

/**
 * wt_custom_query
 *
 * @param  mixed $query
 * @return void
 */
function wt_custom_query($wp_query)
{
    if (!isset($_POST['wt_form_sort_anuncio_nonce']) || !wp_verify_nonce($_POST['wt_form_sort_anuncio_nonce'], 'wt_form_sort_anuncio_nonce')) {
        return;
    }
    
    if (!isset($_POST['action']) || $_POST['action'] !== 'wt_sort_anuncio_form') {
        return;
    }

    if (!isset($_POST['orderby']) || !$_POST['orderby']) {
        return;
    }

    $orderby = $_POST['orderby'];
    $order_array = array(
        'date_asc' => array(
            'orderby'   => 'date',
            'order'     => 'ASC'
        ),
        'date_desc' => array(
            'orderby'   => 'date',
            'order'     => 'DESC'
        ),
        'title_asc' => array(
            'orderby'   => 'title',
            'order'     => 'ASC'
        ),
        'title_desc' => array(
            'orderby'   => 'title',
            'order'     => 'DESC'
        ),
    );

    if ((is_home() || is_author()) && is_main_query() && !is_admin() && $wp_query->get('post_type') !== 'nav_menu_item') {

        $wp_query->set('orderby', $order_array[$orderby]['orderby']);
        $wp_query->set('order', $order_array[$orderby]['order']);
    }
}
