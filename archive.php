<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */

get_header();
?>

<div class="container">
    <div class="row">
        <?php if (have_posts()) { ?>
            <?php get_template_part('template-parts/archive/archive', 'anuncios'); ?>
        <?php } else { ?>
            <div class="col">
                <?php get_template_part('template-parts/content/content-none'); ?>
            </div>
        <?php } ?>
        <?php wt_paging_nav(); ?>
    </div>
</div>
<?php get_footer();
