<?php

/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_lead_topic' ); ?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic">

	<li class="bbp-header">

		<div class="bbp-topic-author"><?php  esc_html_e( 'Creator',  'archub' ); ?></div>

		<div class="bbp-topic-content">

			<?php esc_html_e( 'Topic', 'archub' ); ?>

			<?php bbp_topic_subscription_link(); ?>

			<?php bbp_topic_favorite_link(); ?>

		</div>

	</li>

	<li class="bbp-body">

		<div class="bbp-topic-header">

			<div class="bbp-meta">

				<span class="bbp-topic-post-date"><?php bbp_topic_post_date(); ?></span>

				<a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>

				<?php do_action( 'bbp_theme_before_topic_admin_links' ); ?>

				<?php bbp_topic_admin_links(); ?>

				<?php do_action( 'bbp_theme_after_topic_admin_links' ); ?>

			</div>

		</div>

		<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

			<div class="bbp-topic-author">

				<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

				<?php bbp_topic_author_link( array( 'sep' => '<br />', 'show_role' => true ) ); ?>

				<?php if ( bbp_is_user_keymaster() ) : ?>

					<?php do_action( 'bbp_theme_before_topic_author_admin_details' ); ?>

					<div class="bbp-topic-ip"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>

					<?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>

				<?php endif; ?>

				<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

			</div>

			<div class="bbp-topic-content">

				<?php do_action( 'bbp_theme_before_topic_content' ); ?>

				<?php bbp_topic_content(); ?>

				<?php do_action( 'bbp_theme_after_topic_content' ); ?>

			</div>

		</div><!-- #post-<?php bbp_topic_id(); ?> -->

	</li>

	<li class="bbp-footer">

		<div class="bbp-topic-author"><?php  esc_html_e( 'Creator',  'archub' ); ?></div>

		<div class="bbp-topic-content">

			<?php esc_html_e( 'Topic', 'archub' ); ?>

		</div>

	</li>

</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?>-lead -->

<?php do_action( 'bbp_template_after_lead_topic' ); ?>
