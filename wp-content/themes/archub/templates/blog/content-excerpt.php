<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */
?>

<article <?php liquid_helper()->attr( 'post', array('class' => 'lqd-lp-style-11 lqd-lp-hover-img-zoom text-start pos-rel') ) ?>>

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
        <?php the_excerpt() ?>
    </div>

</article>