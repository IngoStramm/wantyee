<?php
$wrapper_classes  = 'site-header mb-5 sticky-top';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= (true === get_theme_mod('display_title_and_tagline', true)) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu('primary') ? ' has-menu' : '';
?>
<header class="<?php echo esc_attr($wrapper_classes); ?>">
    <nav class="navbar navbar-expand-md bg-body-tertiary">
        <div class="container">

            <?php get_template_part('template-parts/header/site-branding'); ?>

            <button class=" navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <?php get_template_part('template-parts/header/site-nav'); ?>

                <?php if (is_user_logged_in()) { ?>
                    <div class="d-grid d-md-block">
                        <a class="btn btn-danger btn-sm" href="<?php echo wp_logout_url(); ?>"><?php _e('Sair', 'wt'); ?></a>
                    </div>
                <?php } ?>

                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
            </div>
        </div>
    </nav>
</header>