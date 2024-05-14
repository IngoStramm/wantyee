<?php
$post_type = isset($args['post_type']) && $args['post_type'] ? $args['post_type'] : null;
$wt_add_form_sort_anuncio_nonce = wp_create_nonce('wt_form_sort_anuncio_nonce');
$selected = isset($_GET['orderby']) && $_GET['orderby'] ? $_GET['orderby'] : 'date_desc';
$order_options = array(
    'date_desc'             => __('Mais recentes primeiro', 'wt'),
    'date_asc'              => __('Mais antigos primeiro', 'wt'),
    'title_asc'             => __('Ordem alfabética (A-Z)', 'wt'),
    'title_desc'            => __('Ordem alfabética reversa (Z-A)', 'wt'),
);
$start_date = isset($_GET['start-date']) && $_GET['start-date'] ? $_GET['start-date'] : null;
$end_date = isset($_GET['end-date']) && $_GET['end-date'] ? $_GET['end-date'] : null;

$prices = wt_get_anuncios_by_price();
// wt_debug($prices);
$css_display = 'flex';
if ($post_type === 'anuncios' && ($prices && count($prices) > 0)) {
    $css_display = 'block';
    $max = max($prices);
    $min = min($prices);
}

?>
<form class="filters-form d-md-<?php echo $css_display; ?> align-items-center justify-content-between gap-3 mb-3 w-100" name="filters-form" method="get">

    <div class="d-flex justify-content-end  align-items-center gap-3 mb-3">
        <select class="form-select" name="orderby" aria-label="<?php _e('Ordenar anúncios', 'wt'); ?>">
            <?php foreach ($order_options as $value => $text) { ?>
                <option value="<?php echo $value; ?>" <?php echo $selected === $value ? 'selected=""' : '' ?>><?php echo $text; ?></option>
            <?php } ?>
        </select>
        <i class="bi bi-arrow-down-up"></i>
    </div>

    <div class="d-md-<?php echo $css_display; ?> justify-content-start align-items-center gap-3 mb-4 mb-md-0">

        <label class="form-label flex-shrink-0 mb-2" for="start-date">
            <?php _e('Data inicial', 'wt'); ?>
        </label>
        <span class="d-flex align-items-start mb-3">
            <input type="date" class="form-control mb-3 mb-md-0" name="start-date" id="start-date" value="<?php echo $start_date ? $start_date : ''; ?>" />
            <a href="#" class="clear-input-value link-danger ms-1" data-input="start-date"><i class="bi bi-x"></i></a>
        </span>

        <label class="form-label flex-shrink-0 mb-2" for="end-date">
            <?php _e('Data final', 'wt'); ?>
        </label>
        <span class="d-flex align-items-start mb-3">
            <input type="date" class="form-control" name="end-date" id="end-date" value="<?php echo $end_date ? $end_date : ''; ?>" />
            <a href="#" class="clear-input-value link-danger ms-1" data-input="end-date"><i class="bi bi-x"></i></a>
        </span>

    </div>

    <?php
    if ($post_type === 'anuncios' && $prices && count($prices) > 0) {
        echo '<h6 class="mb-2">' . __('Filtrar por preço', 'wt') . '</h6>';
        echo wt_filter_by_price();
        echo wt_dual_range_filter($min, $max);
    }
    ?>
    <a class="btn btn-secondary" href="<?php echo get_site_url(); ?>"><?php _e('Resetar filtro', ' wt') ?></a>
    <input type="hidden" name="action" value="wt_sort_anuncio_form">
    <?php /* ?><input type="hidden" name="wt_form_sort_anuncio_nonce" value="<?php echo $wt_add_form_sort_anuncio_nonce; ?>"><?php */ ?>
    <button class="btn btn-primary"><?php _e('Filtrar', 'wt'); ?></button>

</form>