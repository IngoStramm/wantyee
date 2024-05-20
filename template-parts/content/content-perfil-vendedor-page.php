<?php

/**
 * Template part for displaying Perfil Vendedor page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */
$vendedor_id = isset($_GET['vendedor_id']) && $_GET['vendedor_id'] ? $_GET['vendedor_id'] : null;
$vendedor_id = !$vendedor_id ? get_current_user_id() : $vendedor_id;
$vendedor_data = get_userdata($vendedor_id);
$user_type = get_user_meta($vendedor_id, 'wt_user_type', true);
$avaliacoes = wt_get_vendedor_avaliacoes($vendedor_id);

?>

<div class="container">
    <div class="row">
        <?php if ($user_type !== 'vendedor') { ?>
            <div class="col-md-12">
                <?php get_template_part('template-parts/content/content-access-denied'); ?>
            </div>
        <?php } else { ?>
            <div class="col-md-3">
                <h4>
                    <?php echo $vendedor_data->first_name && $vendedor_data->last_name ?
                        $vendedor_data->first_name . ' ' . $vendedor_data->last_name :
                        $vendedor_data->display_name; ?>
                </h4>
                <div class="d-flex align-content-center gap-1 justify-content-start">
                    <?php echo wt_display_vendedor_stars_rating($vendedor_id); ?>
                    <span>(<?php echo count($avaliacoes); ?>)</span>
                </div>
            </div>
            <div class="col-md-9">
                <div id="avaliacoes">
                    <div class="d-flex flex-grow-0 mb-3">
                        <select class="search form-select" id="filter-avaliacao">
                            <option value=""><?php _e('Todas as avaliações', 'wt'); ?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="list row mb-3 gy-4">

                        <?php if (count($avaliacoes) === 0) { ?>
                            <div class="col-md-12">
                                <h5><?php _e('Ainda não existem avaliações para este vendedor', 'wt'); ?></h5>
                            </div>
                        <?php } else { ?>
                            <?php foreach ($avaliacoes as $avaliacao) { ?>
                                <?php $nota = wt_get_avaliacao_rating($avaliacao->ID); ?>
                                <?php $author_data = get_userdata($avaliacao->post_author); ?>
                                <div class="col-md-6" data-nota="<?php echo wt_get_avaliacao_rating($avaliacao->ID); ?>">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title nome">
                                                <?php echo $author_data->first_name && $author_data->last_name ?
                                                    $author_data->first_name . ' ' . $author_data->last_name :
                                                    $author_data->display_name ?>
                                            </h5>
                                            <?php
                                            $anuncio_id = get_post_meta($avaliacao->ID, 'wt_avaliacao_anuncio_id', true);
                                            if ($anuncio_id) {
                                                printf('<div class="avaliacao-anuncio">%s</div>', get_the_title($anuncio_id));
                                            }
                                            ?>
                                            <div class="avaliacao-data">
                                                <?php
                                                $dateTimeFormat = get_option('date_format');
                                                echo wp_date($dateTimeFormat, get_post_timestamp($avaliacao->ID));
                                                ?>
                                            </div>
                                            <?php echo wt_display_avaliacao_stars_rating($avaliacao->ID); ?>
                                            <p class="card-text"><?php echo get_the_content(null, null, $avaliacao->ID); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <ul class="pagination"></ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>