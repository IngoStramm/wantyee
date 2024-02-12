<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */

?>

<?php get_template_part('template-parts/breadcrumbs/breadcrumbs', null, array('anuncios')); ?>

<section class="no-results not-found">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <header class="page-header alignwide">
            <?php if (is_search()) : ?>

                <h1 class="page-title">
                    <?php
                    printf(
                        /* translators: %s: Search term. */
                        esc_html__('Resultados para "%s"', 'wt'),
                        '<span class="page-description search-term">' . esc_html(get_search_query()) . '</span>'
                    );
                    ?>
                </h1>

            <?php else : ?>

                <h1 class="page-title"><?php esc_html_e('Nada aqui', 'wt'); ?></h1>

            <?php endif; ?>
        </header><!-- .page-header -->

        <div class="page-content default-max-width">

            <?php if (is_search()) : ?>

                <p><?php esc_html_e('Desculpe, mas nada corresponde aos seus termos de pesquisa. Por favor, tente novamente com algumas palavras-chave diferentes.', 'wt'); ?></p>
                <?php get_search_form(); ?>

            <?php else : ?>

                <p><?php esc_html_e('Parece que não conseguimos encontrar o que você procura. Talvez pesquisar possa ajudar.', 'wt'); ?></p>
                <?php get_search_form(); ?>

            <?php endif; ?>
        </div><!-- .page-content -->
    </div>
</section><!-- .no-results -->