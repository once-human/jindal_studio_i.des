<?php
/**
* Liquid Social Followers Widget
*
* @package Ave
*/
 
class Liquid_Social_Followers_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'ld_widget_social_icons', 'description' => esc_html__( "Display socials sites links", 'archub-core' ) );
		parent::__construct( 'social-followers', esc_html__( 'LiquidThemes: Social Site Links', 'archub-core' ), $widget_ops);

		$this-> alt_option_name = 'widget_social_followers';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget( $args, $instance ) {

		global $post;

		$cache = wp_cache_get('widget_social_followers', 'widget');

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
		
		$social_one      = ! empty( $instance['social_one'] ) ? $instance['social_one'] : '';
		$social_one_link = ! empty( $instance['social_one_link'] ) ? $instance['social_one_link'] : '#';
		
		$social_two      = ! empty( $instance['social_two'] ) ? $instance['social_two'] : '';
		$social_two_link = ! empty( $instance['social_two_link'] ) ? $instance['social_two_link'] : '#';
		
		$social_three      = ! empty( $instance['social_three'] ) ? $instance['social_three'] : '';
		$social_three_link = ! empty( $instance['social_three_link'] ) ? $instance['social_three_link'] : '#';
		
		$social_four      = ! empty( $instance['social_four'] ) ? $instance['social_four'] : '';
		$social_four_link = ! empty( $instance['social_four_link'] ) ? $instance['social_four_link'] : '#';
		
		$social_five      = ! empty( $instance['social_five'] ) ? $instance['social_five'] : '';
		$social_five_link = ! empty( $instance['social_five_link'] ) ? $instance['social_five_link'] : '';


		ob_start();
		extract( $args );

		echo $before_widget; 
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	
	?>
	
	<?php if( !empty( $title ) ) { ?>
		<?php echo $before_title . esc_html( $title ) . $after_title;  ?>
	<?php } ?>
	
	<ul class="social-icon branded social-icon-shaped social-icon-circle social-icon-sm">
	
	<?php 
		if( !empty( $social_one ) ) {
		$icon = liquid_get_network_class( $social_one );
		$i_class = $icon['icon'];
		
	?>	
		<li>
			<a target="_blank" href="<?php echo esc_url( $social_one_link ) ?>">
				<i class="<?php echo $i_class ?>"></i>
			</a>
		</li>

	<?php 
		}
		if( !empty( $social_two ) ) {
		$icon = liquid_get_network_class( $social_two );
		$i_class = $icon['icon'];
		
	?>
		<li>
			<a target="_blank" href="<?php echo esc_url( $social_two_link ) ?>">
				<i class="<?php echo $i_class ?>"></i>
			</a>
		</li>
	
	<?php 
		}
		if( !empty( $social_three ) ) {
		$icon = liquid_get_network_class( $social_three );
		$i_class = $icon['icon'];
		
	?>
		<li>
			<a target="_blank" href="<?php echo esc_url( $social_three_link ) ?>">
				<i class="<?php echo $i_class ?>"></i>
			</a>
		</li>
		
	<?php 
		}
		if( !empty( $social_four ) ) {
		$icon = liquid_get_network_class( $social_four );
		$i_class = $icon['icon'];
		
	?>
		<li>
			<a target="_blank" href="<?php echo esc_url( $social_four_link ) ?>">
				<i class="<?php echo $i_class ?>"></i>
			</a>
		</li>
		
	<?php 
		}
		if( !empty( $social_five ) ) {
		$icon = liquid_get_network_class( $social_five );
		$i_class = $icon['icon'];
		
	?>
		<li>
			<a target="_blank" href="<?php echo esc_url( $social_five_link ) ?>">
				<i class="<?php echo $i_class ?>"></i>
			</a>
		</li>
	<?php } ?>
	</ul>

	<?php
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_social_followers', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		
		$instance['social_one']      = strip_tags( $new_instance['social_one'] );
		$instance['social_one_link'] = strip_tags( $new_instance['social_one_link'] );
		
		$instance['social_two']      = strip_tags( $new_instance['social_two'] );
		$instance['social_two_link'] = strip_tags( $new_instance['social_two_link'] );
		
		$instance['social_three']      = strip_tags( $new_instance['social_three'] );
		$instance['social_three_link'] = strip_tags( $new_instance['social_three_link'] );
		
		$instance['social_four']      = strip_tags( $new_instance['social_four'] );
		$instance['social_four_link'] = strip_tags( $new_instance['social_four_link'] );
		
		$instance['social_five']      = strip_tags( $new_instance['social_five'] );
		$instance['social_five_link'] = strip_tags( $new_instance['social_five_link'] );

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_social_followers'] ) ) {

			delete_option('widget_social_followers');

		}
		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_social_followers', 'widget' );
	}

	function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, array( 'social_one' => '', 'social_one_link' => '', 'social_two' => '', 'social_two_link' => '', 'social_three' => '', 'social_three_link' => '', 'social_four' => '', 'social_four_link' => '', 'social_five' => '', 'social_five_link' => '' ) );
		
		$socials = array(
			esc_html__( 'None', 'archub-core' )   => '',
			esc_html__( 'Behance', 'archub-core' )         => 'fa-behance',
			esc_html__( 'Behance Square', 'archub-core' )  => 'fa-behance-square',
			esc_html__( 'Codepen', 'archub-core' )         => 'fa-codepen',
			esc_html__( 'Deviantart', 'archub-core' )      => 'fa-deviantart',
			esc_html__( 'Digg', 'archub-core' )            => 'fa-digg',
			esc_html__( 'Dribbble', 'archub-core' )        => 'fa-dribbble',
			esc_html__( 'Facebook', 'archub-core' )        => 'fa-facebook',
			esc_html__( 'Facebook Square', 'archub-core' ) => 'fa-facebook-square',
			esc_html__( 'Flickr', 'archub-core' )          => 'fa-flickr',
			esc_html__( 'Github', 'archub-core' )         => 'fa-github',
			esc_html__( 'Google', 'archub-core' )         => 'fa-google',
			esc_html__( 'Google Plus', 'archub-core' )    => 'fa-google-plus',
			esc_html__( 'Instagram', 'archub-core' )      => 'fa-instagram',
			esc_html__( 'Jsfiddle', 'archub-core' )       => 'fa-jsfiddle',
			esc_html__( 'Line', 'archub-core' )       		=> 'fa-line',
			esc_html__( 'Linkedin', 'archub-core' )       => 'fa-linkedin',
			esc_html__( 'Medium', 'archub-core' )         => 'fa-medium',
			esc_html__( 'Paypal', 'archub-core' )         => 'fa-paypal',
			esc_html__( 'Pinterest', 'archub-core' )      => 'fa-pinterest',
			esc_html__( 'Pinterest P', 'archub-core' )    => 'fa-pinterest-p',
			esc_html__( 'Reddit', 'archub-core' )         => 'fa-reddit',
			esc_html__( 'Reddit Square', 'archub-core' )  => 'fa-reddit-square',
			esc_html__( 'Skype', 'archub-core' )          => 'fa-skype',
			esc_html__( 'Slack', 'archub-core' )          => 'fa-slack',
			esc_html__( 'Snapchat', 'archub-core' )       => 'fa-snapchat',
			esc_html__( 'Sound Cloud', 'archub-core' )    => 'fa-soundcloud',
			esc_html__( 'Spotify', 'archub-core' )        => 'fa-spotify',
			esc_html__( 'Stack Overflow', 'archub-core' ) => 'fa-stack-overflow',
			esc_html__( 'Telegram', 'archub-core' )       => 'fa-telegram',
			esc_html__( 'Trello', 'archub-core' )         => 'fa-trello',
			esc_html__( 'Tumblr', 'archub-core' )         => 'fa-tumblr',
			esc_html__( 'Twitch', 'archub-core' )         => 'fa-twitch',
			esc_html__( 'Twitter', 'archub-core' )        => 'fa-twitter',
			esc_html__( 'Twitter Square', 'archub-core' ) => 'fa-twitter-square',
			esc_html__( 'Vimeo', 'archub-core' )          => 'fa-vimeo',
			esc_html__( 'WhatsApp', 'archub-core' )      	=> 'fa-whatsapp',
			esc_html__( 'Wordpress', 'archub-core' )      => 'fa-wordpress',
			esc_html__( 'Youtube Play', 'archub-core' )   => 'fa-youtube-play',
		);
		
		$title  = isset( $instance['title'] ) ? $instance['title'] : '';

		$social_one       = isset( $instance['social_one'] ) ? $instance['social_one'] : '';
		$social_one_link  = isset( $instance['social_one_link'] ) ? $instance['social_one_link'] : '#';

		$social_two       = isset( $instance['social_two'] ) ? $instance['social_two'] : '';
		$social_two_link  = isset( $instance['social_two_link'] ) ? $instance['social_two_link'] : '#';
		
		$social_three       = isset( $instance['social_three'] ) ? $instance['social_three'] : '';
		$social_three_link  = isset( $instance['social_three_link'] ) ? $instance['social_three_link'] : '#';
		
		$social_four       = isset( $instance['social_four'] ) ? $instance['social_four'] : '';
		$social_four_link  = isset( $instance['social_four_link'] ) ? $instance['social_four_link'] : '#';
		
		$social_five       = isset( $instance['social_five'] ) ? $instance['social_five'] : '';
		$social_five_link  = isset( $instance['social_five_link'] ) ? $instance['social_five_link'] : '#';
		

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'archub-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_one' ) ); ?>"><?php esc_html_e( 'Social Site:', 'archub-core' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'social_one' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_one' ) ); ?>" class="widefat">
			<?php foreach( $socials as $key => $value ) { ?>
				<option value="<?php echo esc_attr( $value ) ?>"<?php selected( $instance['social_one'], $value ); ?>><?php esc_html_e( $key ); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_one_link' ) ); ?>"><?php esc_html_e( 'Social URL:', 'archub-core' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['social_one_link'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_one_link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_one_link' ) ); ?>" class="widefat" />
			<br />
			<small><?php esc_html_e( 'Add Social Site Link', 'archub-core' ); ?></small>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_two' ) ); ?>"><?php esc_html_e( 'Social Site - 2:', 'archub-core' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'social_two' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_two' ) ); ?>" class="widefat">
			<?php foreach( $socials as $key => $value ) { ?>
				<option value="<?php echo esc_attr( $value ) ?>"<?php selected( $instance['social_two'], $value ); ?>><?php esc_html_e( $key ); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_two_link' ) ); ?>"><?php esc_html_e( 'Social URL - 2:', 'archub-core' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['social_two_link'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_two_link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_two_link' ) ); ?>" class="widefat" />
			<br />
			<small><?php esc_html_e( 'Add Social Two Site Link', 'archub-core' ); ?></small>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_three' ) ); ?>"><?php esc_html_e( 'Social Site - 3:', 'archub-core' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'social_three' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_three' ) ); ?>" class="widefat">
			<?php foreach( $socials as $key => $value ) { ?>
				<option value="<?php echo esc_attr( $value ) ?>"<?php selected( $instance['social_three'], $value ); ?>><?php esc_html_e( $key ); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_three_link' ) ); ?>"><?php esc_html_e( 'Social URL - 3:', 'archub-core' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['social_three_link'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_three_link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_three_link' ) ); ?>" class="widefat" />
			<br />
			<small><?php esc_html_e( 'Add Social Three Site Link', 'archub-core' ); ?></small>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_four' ) ); ?>"><?php esc_html_e( 'Social Site - 4:', 'archub-core' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'social_four' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_four' ) ); ?>" class="widefat">
			<?php foreach( $socials as $key => $value ) { ?>
				<option value="<?php echo esc_attr( $value ) ?>"<?php selected( $instance['social_four'], $value ); ?>><?php esc_html_e( $key ); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_four_link' ) ); ?>"><?php esc_html_e( 'Social URL - 4:', 'archub-core' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['social_four_link'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_four_link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_four_link' ) ); ?>" class="widefat" />
			<br />
			<small><?php esc_html_e( 'Add Social Four Site Link', 'archub-core' ); ?></small>
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_five' ) ); ?>"><?php esc_html_e( 'Social Site - 5:', 'archub-core' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'social_five' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_five' ) ); ?>" class="widefat">
			<?php foreach( $socials as $key => $value ) { ?>
				<option value="<?php echo esc_attr( $value ) ?>"<?php selected( $instance['social_five'], $value ); ?>><?php esc_html_e( $key ); ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'social_five_link' ) ); ?>"><?php esc_html_e( 'Social URL - 5:', 'archub-core' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['social_five_link'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_five_link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'social_five_link' ) ); ?>" class="widefat" />
			<br />
			<small><?php esc_html_e( 'Add Social Five Site Link', 'archub-core' ); ?></small>
		</p>

		<?php
	}
}