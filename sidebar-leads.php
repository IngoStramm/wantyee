<form class="" role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
    <div class="input-group mb-3">
        <input type="text" name="s" class="form-control" placeholder="<?php _e('Pesquisar', 'wt'); ?>" aria-label="<?php _e('Pesquisar', 'wt'); ?>" aria-describedby="button-addon2">
        <input type="hidden" name="post_type" value="leads" />
        <button class="btn btn-secondary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
    </div>
</form>