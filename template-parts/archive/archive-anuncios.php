<div class="col">
    <header class="page-header alignwide">
        <?php echo wt_breadcrumbs('anuncios'); ?>
    </header><!-- .page-header -->
</div>

<div class="breakfix"></div>

<div class="col-md-4 col-lg-3 col-sm-12 mb-4">
    <?php if (is_author()) {
        get_sidebar('author');
    } else {
        get_sidebar();
    } ?>
</div>

<div class="col-md-8 col-lg-9 col-sm-12">
    <?php get_template_part('template-parts/archive/archive-sort-anuncios-form'); ?>
    <div class="row row-cols-1 row-cols-md-2 g-3">
        <?php while (have_posts()) { ?>
            <div class="col">
                <?php the_post(); ?>
                <?php get_template_part('template-parts/content/content', 'archive'); ?>
            </div>
        <?php } ?>
    </div>
</div>