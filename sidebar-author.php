<?php
if (!is_author()) {
    return;
}
$author = get_queried_object();
$author_id = $author->data->ID;
$author_display_name = $author->data->display_name;
$author_terms = [];
$author_posts = get_posts(array('post_type' => 'anuncios', 'posts_per_page' => -1, 'author' => $author_id));
?>
<form class="" role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
    <div class="input-group mb-3">
        <input type="text" name="s" class="form-control" placeholder="<?php _e('Pesquisar', 'wt'); ?>" aria-label="<?php _e('Pesquisar', 'wt'); ?>" aria-describedby="button-addon2">
        <input type="hidden" name="post_type" value="anuncios" />
        <button class="btn btn-secondary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
    </div>
</form>

<?php
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
get_template_part('template-parts/archive/archive-sort-anuncios-form', '', array('post_type' => 'anuncios'));
echo wt_show_anuncio_terms_nav($author_terms);
