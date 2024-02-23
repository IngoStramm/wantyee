<?php
$wt_add_form_sort_anuncio_nonce = wp_create_nonce('wt_form_sort_anuncio_nonce');
$selected = isset($_POST['orderby']) && $_POST['orderby'] ? $_POST['orderby'] : 'date_desc';
$order_options = array(
    'date_desc'             => __('Mais recentes primeiro', 'wt'),
    'date_asc'              => __('Mais antigos primeiro', 'wt'),
    'title_asc'             => __('Ordem alfabética (A-Z)', 'wt'),
    'title_desc'            => __('Ordem alfabética reversa (Z-A)', 'wt'),
);
?>
<div class="d-md-flex justify-content-end mb-3">
    <form class="sort-anuncio-form" name="sort-anuncio-form" method="post">
        <div class="d-flex gap-3 align-items-center">
            <select class="form-select" name="orderby" aria-label="<?php _e('Ordenar anúncios', 'wt'); ?>">
                <?php foreach ($order_options as $value => $text) { ?>
                    <option value="<?php echo $value; ?>" <?php echo $selected === $value ? 'selected=""' : '' ?>><?php echo $text; ?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="action" value="wt_sort_anuncio_form">
            <input type="hidden" name="wt_form_sort_anuncio_nonce" value="<?php echo $wt_add_form_sort_anuncio_nonce; ?>">
            <i class="bi bi-arrow-down-up"></i>
        </div>
    </form>
</div>