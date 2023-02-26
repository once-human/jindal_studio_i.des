<?php
global $post;
?>

<header class="entry-header lqd-lp-header mb-3">

    <div class="lqd-lp-meta text-uppercase ltr-sp-1 font-weight-bold">
        <?php $this->entry_tags('lqd-lp-cat d-flex flex-wrap align-items-center reset-ul inline-nav pos-rel z-index-2 lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored'); ?>
    </div>

    <?php $this->entry_title('mt-2 mb-3 h5'); ?>

    <div class="lqd-lp-meta lqd-lp-meta-dot-between d-flex flex-wrap text-uppercase font-weight-bold text-uppercase ltr-sp-1">
        <div class="lqd-lp-author pos-rel z-index-3">
            <div class="lqd-lp-author-info">
                <h3 class="mt-0 mb-0"><?php the_author_posts_link(); ?></h3>
            </div>
        </div>
        <span class="lqd-lp-date">
            <a href="<?php the_permalink() ?>"><?php echo liquid_helper()->liquid_post_date(); ?></a>
        </span>
    </div>

</header>

<?php if ('' !== get_the_post_thumbnail()) : ?>
<div class="lqd-lp-img overflow-hidden border-radius-5 mt-4 mb-5">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
        <?php $this->entry_thumbnail(); ?>
    </a>
</div>
<?php endif; ?>

<?php $this->entry_content('entry-summary lqd-lp-excerpt mb-3'); ?>

<?php $this->overlay_link(); ?>
