<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */

global $post;

?>

<article <?php liquid_helper()->attr('post', array('class' => 'lqd-lp-style-11 lqd-lp-hover-img-zoom text-start pos-rel')) ?>>

    <?php if (is_singular()) : ?>

        <?php if ('' !== get_the_post_thumbnail()) : ?>
            <figure class="post-image hmedia lqd-lp-img overflow-hidden border-radius-5 mb-5 d-inline-flex w-auto">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            </figure>
        <?php endif; ?>

        <header class="entry-header">

            <?php the_title('<h1 ' . liquid_helper()->get_attr('entry-title') . '>', '</h1>'); ?>

            <?php get_template_part('templates/entry', 'meta') ?>

        </header>

        <div <?php liquid_helper()->attr('entry-content') ?>>
            <?php
            the_content(sprintf(
                esc_html__('Continue reading %s', 'archub'),
                the_title('<span class="screen-reader-text">', '</span>', false)
            ));

            wp_link_pages(array(
                'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'archub') . '</span>',
                'after' => '</div>',
                'link_before' => '<span>',
                'link_after' => '</span>',
                'pagelink' => '<span class="screen-reader-text">' . esc_html__('Page', 'archub') . ' </span>%',
                'separator' => '<span class="screen-reader-text">, </span>',
            ));
            ?>
        </div>

        <footer class="entry-footer lqd-lp-footer d-flex flex-wrap">
            <?php liquid_post_terms(array('taxonomy' => 'category', 'text' => esc_html__('Posted in: %s', 'archub'), 'solid' => true)); ?>
            <?php liquid_post_terms(array('taxonomy' => 'post_tag', 'text' => esc_html__('Tagged: %s', 'archub'), 'before' => ' | ', 'solid' => true)); ?>
        </footer>

    <?php else: ?>

        
        <?php if ('' !== get_the_post_thumbnail()) : ?>
            <div class="lqd-lp-img pos-rel mb-3 overflow-hidden">
                <figure>
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size = 'post-thumbnail', ['class' => 'w-100']); ?></a>
                </figure>
            </div>
        <?php endif; ?>


        <div class="lqd-lp-meta mb-3">
            <div class="entry-meta d-flex flex-wrap align-items-center text-center">
                <div class="byline">
                    <span class="d-flex flex-column">
                        <span class="screen-reader-text"><?php esc_html_e( 'Author', 'archub' ); ?></span>
                        <?php liquid_author_link() ?>
                    </span>
                </div>

                <div class="posted-on">
                    <span class="screen-reader-text"><?php esc_html_e( 'Published on:', 'archub' ); ?></span>
                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                        <?php
                            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
                            printf( $time_string,
                                esc_attr( get_the_date( 'c' ) ),
                                get_the_date()
                            );
                        ?>
                    </a>
                </div>
                
                <?php liquid_post_terms(array('taxonomy' => 'category', 'text' => esc_html__('%s', 'archub'), 'solid' => false)); ?>
            </div>
        </div>
        <header class="lqd-lp-header mb-2">
            <h2 class="lqd-lp-title h5 m-0">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
        </header>

        <div <?php liquid_helper()->attr( 'lqd-lp-excerpt mb-3' ) ?>>
            <?php

            $page_content = apply_filters('the_content', $post->post_content);
            if (strpos($post->post_content, '<!--more-->')) :
                the_content(sprintf(
                    esc_html__('Continue reading %s', 'archub'),
                    the_title('<span class="screen-reader-text">', '</span>', false)
                ));
            ?>
            <?php else: ?>

                <?php the_excerpt() ?>

            <?php endif; ?>

        </div>

    <?php endif; ?>

    <?php
    // Author bio.
    if (is_single() && get_the_author_meta('description')) :
        get_template_part('templates/author', 'bio');
    endif;
    ?>

</article>