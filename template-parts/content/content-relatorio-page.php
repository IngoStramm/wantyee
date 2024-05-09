<?php

/**
 * Template part for displaying Relatório page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */

?>

<?php
$start_date = isset($_GET['start-date']) && $_GET['start-date'] ? $_GET['start-date'] : null;
$end_date = isset($_GET['end-date']) && $_GET['end-date'] ? $_GET['end-date'] : null;
$subtitle = __('Resultados para todo o período.', 'wt');
if ($start_date) {
    $start_time = strtotime($start_date);
    $fomatted_start_date = date('d/m/Y', $start_time);
}
if ($end_date) {
    $end_time = strtotime($end_date);
    $fomatted_end_date = date('d/m/Y', $end_time);
}
if ($start_date && $end_date) {
    $subtitle = sprintf(__('Resultados para o período entre %s e %s.', 'wt'), $fomatted_start_date, $fomatted_end_date);
} else if ($start_date) {
    $subtitle = sprintf(__('Resultados para o período a partir de %s.', 'wt'), $fomatted_start_date);
} else if ($end_date) {
    $subtitle = sprintf(__('Resultados para o período até %s.', 'wt'), $fomatted_end_date);
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="container">
        <div class="row">
            <div class="col">
                <header class="entry-header mb-5">
                    <?php the_title('<h1 class="entry-title default-max-width">', '</h1>'); ?>
                    <h3><?php echo $subtitle; ?></h3>
                </header><!-- .entry-header -->

                <div class="row">

                    <form class="filters-form d-md-flex align-items-center justify-content-start gap-3 mb-3 w-100" name="filters-form" method="get">

                        <label class="form-label flex-shrink-0 mb-md-0" for="start-date">
                            <?php _e('Data inicial', 'wt'); ?>
                        </label>
                        <span class="d-flex align-items-start mb-3 mb-md-0">
                            <input type="date" class="form-control" name="start-date" id="start-date" value="<?php echo $start_date ? $start_date : ''; ?>" />
                            <a href="#" class="clear-input-value link-danger ms-1" data-input="start-date"><i class="bi bi-x"></i></a>
                        </span>

                        <label class="form-label flex-shrink-0 mb-md-0" for="end-date">
                            <?php _e('Data final', 'wt'); ?>
                        </label>
                        <span class="d-flex align-items-start mb-3 mb-md-0">
                            <input type="date" class="form-control" name="end-date" id="end-date" value="<?php echo $end_date ? $end_date : ''; ?>" />
                            <a href="#" class="clear-input-value link-danger ms-1" data-input="end-date"><i class="bi bi-x"></i></a>
                        </span>

                        <input type="hidden" name="action" value="wt_filter_relatorio_form">
                        <button class="btn btn-primary"><?php _e('Filtrar', 'wt'); ?></button>
                        <a href="<?php echo get_permalink(get_the_ID()); ?>" class="btn btn-secondary"><?php _e('Resetar filtros', 'wt'); ?></a>
                    </form>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3"><?php _e('Anúncios', 'wt') ?></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php _e('Total de anúncios cadastrados', 'wt'); ?></th>
                                        <td><?php echo count(wt_get_all_anuncios()); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php _e('Total de anúncios ativos', 'wt'); ?></th>
                                        <td><?php echo count(wt_get_all_anuncios_ativos()); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php _e('Total de anúncios encerrados', 'wt'); ?></th>
                                        <td><?php echo count(wt_get_all_anuncios_fechados()); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php _e('Valor mínimo dos anúncios', 'wt'); ?></th>
                                        <td><?php
                                            $min_price = wt_get_all_anuncios_min_price();
                                            $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                            $formatted_min_price = $min_price ? $formatter->format(floatval($min_price)) : 'R$ 0,00';
                                            echo $formatted_min_price;
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php _e('Valor máximo dos anúncios', 'wt'); ?></th>
                                        <td><?php
                                            $max_price = wt_get_all_anuncios_max_price();
                                            $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                            $formatted_max_price = $max_price ? $formatter->format(floatval($max_price)) : 'R$ 0,00';
                                            echo $formatted_max_price;
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php _e('Valor médio dos anúncios', 'wt'); ?></th>
                                        <td><?php
                                            $media_price = wt_get_all_anuncios_media_price();
                                            $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                            $formatted_media_price = $media_price ? $formatter->format(floatval($media_price)) : 'R$ 0,00';
                                            echo $formatted_media_price;
                                            ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-3"><?php _e('Usuários', 'wt') ?></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php _e('Total de usuários compradores', 'wt'); ?></th>
                                        <td><?php echo count(wt_get_all_users_compradores()); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php _e('Total de usuários vendedores', 'wt'); ?></th>
                                        <td><?php echo count(wt_get_all_users_vendedores()); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php _e('Total de usuários (compradores e vendedores)', 'wt'); ?></th>
                                        <td><?php echo count(wt_get_all_users()); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="clearfix mb-5"></div>

                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="mb-3 text-center"><?php _e('Total de anúncios', 'wt'); ?></h5>
                        <div class="chart-wrapper">
                            <canvas id="chart-total-anuncios"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="mb-3 text-center"><?php _e('Valores dos anúncios', 'wt'); ?></h5>
                        <div class="chart-wrapper">
                            <canvas id="chart-valores-anuncios"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="mb-3 text-center"><?php _e('Total de usuários', 'wt'); ?></h5>
                        <div class="chart-wrapper">
                            <canvas id="chart-total-usuarios"></canvas>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3"><?php _e('Valor dos anúncios por categoria', 'wt') ?></h4>

                <div id="table-relatorio-cat">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="search" class="form-control form-control-sm search" id="table-search-input" placeholder="<?php _e('Pesquisar', 'wt'); ?>">
                                <label for="table-search-input"><?php _e('Pesquisar', 'wt'); ?></label>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive sort-table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="order"># <i class="bi bi-arrow-down-up"></i></th>
                                    <th scope="col" class="sort" data-sort="nome"><?php _e('Nome', 'wt'); ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th scope="col" class="sort" data-sort="minval"><?php _e('Valor mínimo', 'wt') ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th scope="col" class="sort" data-sort="maxval"><?php _e('Valor máximo', 'wt') ?> <i class="bi bi-arrow-down-up"></i></th>
                                    <th scope="col" class="sort" data-sort="midval"><?php _e('Valor médio', 'wt') ?> <i class="bi bi-arrow-down-up"></i></th>
                                </tr>
                            </thead>

                            <tbody class="list checkbox-terms-list">
                                <?php
                                $terms = get_terms(array(
                                    'taxonomy'   => 'categoria-de-anuncio',
                                    'hide_empty' => false,
                                ));
                                ?>
                                <?php
                                $count_1 = 1;
                                foreach ($terms as $term) { ?>
                                    <?php if (!$term->parent) { ?>
                                        <tr>
                                            <td class="order"><?php echo $count_1; ?></td>
                                            <td class="nome">
                                                <?php echo $term->name; ?>
                                            </td>
                                            <td class="minval"><?php
                                                                $min_price = wt_get_term_anuncios_min_price($term->term_id);
                                                                $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                                                $formatted_min_price = $min_price ? $formatter->format(floatval($min_price)) : 'R$ 0,00';
                                                                echo $formatted_min_price;
                                                                ?></td>
                                            <td class="maxval"><?php
                                                                $min_price = wt_get_term_anuncios_max_price($term->term_id);
                                                                $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                                                $formatted_min_price = $min_price ? $formatter->format(floatval($min_price)) : 'R$ 0,00';
                                                                echo $formatted_min_price;
                                                                ?></td>
                                            <td class="midval"><?php
                                                                $min_price = wt_get_term_anuncios_media_price($term->term_id);
                                                                $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                                                $formatted_min_price = $min_price ? $formatter->format(floatval($min_price)) : 'R$ 0,00';
                                                                echo $formatted_min_price;
                                                                ?></td>
                                        </tr>
                                        <?php $count_2 = 1; ?>
                                        <?php foreach ($terms as $term2) { ?>
                                            <?php if ($term2->parent === $term->term_id) { ?>
                                                <tr>
                                                    <td class="order"><?php echo $count_1 . '.' . $count_2; ?></td>
                                                    <td class="child-term">
                                                        <span class="nome"><?php echo $term2->name; ?></span> — <span class="parent-term-name"><?php echo $term->name; ?></span>
                                                    </td>
                                                    <td class="minval"><?php
                                                                        $min_price = wt_get_term_anuncios_min_price($term2->term_id);
                                                                        $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                                                        $formatted_min_price = $min_price ? $formatter->format(floatval($min_price)) : 'R$ 0,00';
                                                                        echo $formatted_min_price;
                                                                        ?></td>
                                                    <td class="maxval"><?php
                                                                        $min_price = wt_get_term_anuncios_max_price($term2->term_id);
                                                                        $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                                                        $formatted_min_price = $min_price ? $formatter->format(floatval($min_price)) : 'R$ 0,00';
                                                                        echo $formatted_min_price;
                                                                        ?></td>
                                                    <td class="midval"><?php
                                                                        $min_price = wt_get_term_anuncios_media_price($term2->term_id);
                                                                        $formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
                                                                        $formatted_min_price = $min_price ? $formatter->format(floatval($min_price)) : 'R$ 0,00';
                                                                        echo $formatted_min_price;
                                                                        ?></td>
                                                </tr>
                                                <?php $count_2++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                        </tr>
                                        <?php $count_1++; ?>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <ul class="pagination"></ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-5">
                        <h5 class="mb-3 text-center"><?php _e('Valor mínimo dos anúncios por categoria', 'wt'); ?></h5>
                        <div class="chart-wrapper">
                            <canvas id="chart-categorias-minval"></canvas>
                        </div>
                    </div>
                    <div class="col-md-12 mb-5">
                        <h5 class="mb-3 text-center"><?php _e('Valor máximo dos anúncios por categoria', 'wt'); ?></h5>
                        <div class="chart-wrapper">
                            <canvas id="chart-categorias-maxval"></canvas>
                        </div>
                    </div>
                    <div class="col-md-12 mb-5">
                        <h5 class="mb-3 text-center"><?php _e('Valor médio dos anúncios por categoria', 'wt'); ?></h5>
                        <div class="chart-wrapper">
                            <canvas id="chart-categorias-midval"></canvas>
                        </div>
                    </div>
                </div>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->

            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->