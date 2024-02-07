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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <header class="entry-header">
                    <?php if (is_singular()) : ?>
                        <?php the_title('<h1 class="entry-title default-max-width">', '</h1>'); ?>
                    <?php else : ?>
                        <?php the_title(sprintf('<h2 class="entry-title default-max-width"><a href="%s">', esc_url(get_permalink())), '</a></h2>'); ?>
                    <?php endif; ?>

                </header><!-- .entry-header -->
            </div>
            <div class="col-md-12">
                <div class="entry-content">
                    <?php
                    the_content();
                    ?>
                </div><!-- .entry-content -->
            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->