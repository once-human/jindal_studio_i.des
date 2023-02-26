<?php
/**
 * Latest posts widget
 *
 * @package Ave
 */

class Liquid_Latest_Posts_Widget extends WP_Widget {

	/**
	 * Sets up a new Liquid latests posts carousel widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	function __construct() {

		$widget_ops = array('classname' => 'ld_widget_recent_entries', 'description' => esc_html__( "Displays the most latest posts", 'archub-core' ) );
		parent::__construct('liquid-latest-posts', esc_html__( 'LiquidThemes: Latest Posts', 'archub-core' ), $widget_ops);

		$this-> alt_option_name = 'widget_latest_posts_entries';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	/**
	 * Outputs the content for the current Liquid latests posts carousel widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Liquid latests posts carousel widget instance.
	 */
	 
	function widget( $args, $instance ) {
		global $post;

		$cache = wp_cache_get('widget_latest_posts_entries', 'widget');

		if ( !is_array($cache) ) {
			$cache = array();
		}
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
			$number = 10;
		}

		$r = new WP_Query( apply_filters( 'widget_posts_args', array('orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true) ) );

		if ($r->have_posts()) : ?>

			<?php if( !empty( $title ) ) { ?>
				<?php echo $before_title . esc_html( $title ) . $after_title;  ?>
			<?php } ?>

			<ul>

				<?php  while ( $r->have_posts() ) : $r->the_post(); ?>

					<li class="pos-rel">
					<?php if( has_post_thumbnail() ) { ?>
						<figure>
							<?php liquid_the_post_thumbnail( 'liquid-widget' ); ?>
						</figure>
					<?php } ?>
						<div class="ld_entries_contents">
							<a class="h2 mt-0" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
							<?php
								$time_string = '<span class="post-date">%s</span>';
								printf( $time_string,
									get_the_date( get_option( 'date_time' ) )
								);
							?>
						</div><!-- /.contents -->
						<a href="<?php echo get_permalink(); ?>" class="lqd-overlay"></a>
					</li>

				<?php endwhile; ?>

				<?php
					// Reset the global $the_post as this query will have stomped on it
					wp_reset_postdata(); ?>

			</ul>

			<?php endif; //have_posts()

		echo $after_widget;

		wp_enqueue_script( 'flickity' );	
		
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_latest_posts_entries', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_latest_posts_entries']) ) {
			delete_option('widget_latest_posts_entries');
		}
		return $instance;
	}

	function flush_widget_cache() {

		wp_cache_delete('widget_latest_posts_entries', 'widget');

	}

	function form( $instance ) {

		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$number = isset( $instance['number'] ) ? $instance['number'] : 5;

		?>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'archub-core' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'pasific-addons' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

		<?php
	}
}