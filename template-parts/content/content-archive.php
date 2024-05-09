<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 */

?>

<?php
$wt_anuncio_preco = get_post_meta(get_the_ID(), 'wt_anuncio_preco', true);
$formatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
$price = $wt_anuncio_preco ? $formatter->format(floatval($wt_anuncio_preco)) : 'R$ 0,00';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="card shadow-sm">
        <a href="<?php echo get_permalink(); ?>">
            <?php the_post_thumbnail('medium-large', array('loading' => false, 'class' => 'img-fluid mx-auto d-block')); ?>
        </a>
        <div class="card-body">
            <h5><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h5>
            <div class="d-flex align-items-center align-content-center gap-3">
                <small><i class="bi bi-calendar-week-fill"></i> <?php echo get_the_date('', get_the_ID()); ?></small>
                <small><i class="bi bi-person-fill"></i> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></small>
            </div>
            <p class="card-text"><?php the_excerpt(); ?></p>
            <div class="d-flex justify-content-between align-items-center">
                <?php if ($price) { ?>
                    <div class="price"><?php echo $price; ?></div>
                <?php } ?>
                <div class="btn-group">
                    <a href="<?php echo get_permalink(); ?>" class="btn btn-sm btn-outline-secondary"><?php _e('Ver mais', 'wt'); ?></a>
                </div>
            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->