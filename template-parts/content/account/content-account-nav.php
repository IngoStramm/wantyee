<?php
$curr_page = $args['curr-page'];
$user_type = $args['user-type'];
$links = [];
$links[] = $args['account'];
$links[] = $user_type === 'comprador' ? $args['edit-anuncio'] : $args['cat-config'];
?>
<nav class="nav nav-pills nav-fill mb-4">
    <?php
    foreach ($links as $link) {
        echo '<a class="nav-link';
        if ($curr_page === $link) {
            echo ' active" aria-current="page"';
        } else {
            echo '"';
        }
        echo ' href="' . get_page_link($link) . '">' . get_the_title($link) . '</a>';
    }
    ?>
</nav>