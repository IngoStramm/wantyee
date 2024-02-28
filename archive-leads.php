<?php

/**
 * The template for displaying Leads post_type archive pages
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
        <?php get_template_part('template-parts/archive/archive', 'leads'); ?>
        <?php wt_paging_nav(); ?>
    </div>
</div>
<?php get_footer();
