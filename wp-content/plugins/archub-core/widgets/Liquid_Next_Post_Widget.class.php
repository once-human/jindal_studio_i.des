<?php
/**
 * Next Post widget
 *
 * @package ArcHub
 */

class Liquid_Next_Post_Widget extends WP_Widget {

	/**
	 * Sets up a new Liquid latests posts carousel widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	function __construct() {

		$widget_ops = array('classname' => 'ld_widget_next_post', 'description' => esc_html__( "Displays the next post", 'archub-core' ) );
		parent::__construct('liquid-next-post', esc_html__( 'LiquidThemes: Next Post', 'archub-core' ), $widget_ops);

		$this-> alt_option_name = 'widget_next_post_entries';

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

		$cache = wp_cache_get('widget_next_post_entries', 'widget');

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
		
		$next_post = get_next_post();
		if( empty( $next_post ) ) {
			return;
		}
		$next_post_id = $next_post->ID;
		
		$category_detail = get_the_category( $next_post_id );

		echo $before_widget;

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if( !empty( $title ) ) { ?>
			<?php echo $before_title . esc_html( $title ) . $after_title;  ?>
		<?php } ?>

		<article class="pos-rel">
	
			<figure>
				<?php echo get_the_post_thumbnail( $next_post_id ); ?>
			</figure>
			
			<span class="ld_entries_contents">
				<?php if( $category_detail ) {  ?>
				<a href="<?php echo get_category_link( $category_detail[0]->term_id ); ?>" class="ld_entries_cat text-uppercase ltr-sp-1 pos-rel z-index-2"><?php echo $category_detail[0]->cat_name; ?></a>
				<?php } ?>
				<span class="ld_entries_title h2"><?php echo get_the_title( $next_post_id ); ?></span>
			</span><!-- /.contents -->
	
			<a href="<?php echo  get_permalink( $next_post_id ); ?>" class="lqd-overlay"></a>
	
		</article>


		<?php 
		echo $after_widget;
		
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_next_post_entries', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_next_post_entries']) ) {
			delete_option('widget_next_post_entries');
		}
		return $instance;
	}

	function flush_widget_cache() {

		wp_cache_delete('widget_next_post_entries', 'widget');

	}

	function form( $instance ) {

		$title = isset( $instance['title'] ) ? $instance['title'] : '';

		?>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'archub-core' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<?php
	}
}