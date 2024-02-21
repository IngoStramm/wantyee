<?php
$terms = get_terms(array(
    'taxonomy'   => 'categoria-de-anuncio',
    'hide_empty' => false,
));
// wt_debug($terms);
?>

<form class="" role="search">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="<?php _e('Pesquisar', 'wt'); ?>" aria-label="<?php _e('Pesquisar', 'wt'); ?>" aria-describedby="button-addon2">
        <button class="btn btn-secondary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
    </div>
</form>

<?php echo wt_show_anuncio_terms_nav($terms);
