<?php if (current_user_can('editor') || current_user_can('administrator')) { ?>
    <div class="col">
        <header class="page-header alignwide">
            <?php echo wt_breadcrumbs('anuncios'); ?>
        </header><!-- .page-header -->
    </div>

    <div class="breakfix"></div>

    <div class="col-md-12">
        <?php get_template_part('template-parts/archive/archive-sort-anuncios-form'); ?>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th scope="col"><?php _e('Anúncio', 'wt'); ?></th>
                            <th scope="col"><?php _e('Comprador', 'wt'); ?></th>
                            <th scope="col"><?php _e('Vendedor', 'wt'); ?></th>
                            <th scope="col"><?php _e('Data do lead', 'wt'); ?></th>
                            <th scope="col"><?php _e('Status do anúncio', 'wt'); ?></th>
                        </thead>
                        <tbody>
                            <?php while (have_posts()) { ?>
                                <tr>
                                    <?php the_post(); ?>
                                    <?php get_template_part('template-parts/content/content', 'archive-leads'); ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>

    <div class="col">
        <?php get_template_part('template-parts/content/content-access-denied'); ?>
    </div>

<?php } ?>