<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Wantyee
 * @since Twenty Twenty-One 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <header class="entry-header alignwide">

                    <?php if (is_singular()) : ?>

                        <figure class="post-thumbnail">
                            <?php
                            // Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
                            the_post_thumbnail('post-thumbnail', array('loading' => false, 'class' => 'img-fluid rounded'));
                            ?>
                            <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                                <figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
                            <?php endif; ?>
                        </figure><!-- .post-thumbnail -->

                    <?php else : ?>

                        <figure class="post-thumbnail">
                            <a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                <?php the_post_thumbnail('post-thumbnail', array('class' => 'img-fluid rounded')); ?>
                            </a>
                        </figure><!-- .post-thumbnail -->

                    <?php endif; ?>
                </header><!-- .entry-header -->
            </div>
            <div class="col-md-6">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->