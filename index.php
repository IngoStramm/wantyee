<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */

get_header(); ?>

<?php if (is_home() && !is_front_page() && !empty(single_post_title('', false))) : ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <header class="page-header alignwide">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header><!-- .page-header -->
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
if (is_home()) {
?>

    <div class="container">
        <div class="row">
            <?php if (have_posts()) { ?>
                <?php // wt_debug($post); 
                ?>
                <?php get_template_part('template-parts/archive/archive', 'anuncios'); ?>
            <?php } else { ?>
                <div class="row">
                    <div class="col">
                        <?php get_template_part('template-parts/content/content-none'); ?>
                    </div>
                </div>
            <?php } ?>
            <?php wt_paging_nav(); ?>
        </div>
    </div>

<?php } else {

    if (have_posts()) {
        // Load posts loop.
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content/content');
        }
    } else {
        // If no content, include the "No posts found" template.
        get_template_part('template-parts/content/content-none');
    }
}
get_footer();
