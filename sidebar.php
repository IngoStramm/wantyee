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

<?php if ($terms) { ?>
    <div class="terms-menu">
        <ul class="list-unstyled ps-0">
            <?php foreach ($terms as $term) {
                $term_id = $term->term_id;
                $term_name = $term->name;
                $term_slug = $term->slug;
                $term_link = get_term_link($term);
            ?>
                <?php if ($term->parent === 0) { ?>
                    <li class="mb-1">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#<?php echo $term_slug; ?>" aria-expanded="false"></button>
                        <a href="<?php echo $term_link; ?>" class="parent-term-name"><?php echo $term_name; ?></a>

                        <div class="collapse" id="<?php echo $term_slug; ?>">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <?php foreach ($terms as $term_child) { ?>
                                    <?php if ($term_child->parent === $term_id) { ?>
                                        <?php
                                        $term_child_id = $term_child->term_id;
                                        $term_child_name = $term_child->name;
                                        $term_child_slug = $term_child->slug;
                                        $term_child_link = get_term_link($term_child);
                                        ?>
                                        <li><a href="<?php echo $term_child_link; ?>" class="link-body-emphasis d-inline-flex text-decoration-none rounded"><?php echo $term_child_name; ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>

                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
<?php } ?>