<?php

/**
 * Get recent tweets
 * @param string $username
 * @param string $consumer_key
 * @param string $consumer_secret
 * @param string $access_token
 * @param string $access_token_secret
 * @param int $cache_time cache time in seconds
 * @return array/boolean
 */
function liquid_get_recent_tweets($username, $consumer_key, $consumer_secret, $access_token, $access_token_secret, $cache_time = 3600) {

	if ( empty( $username ) ) {
		return '';
	}
	$cache = get_option('theme-recent-tweets');

	//display from cache, skip cache if username is changed
	if (is_array($cache) && $cache['username'] == $username && ((int)$cache['time'] + intval($cache_time)) > time())
	{
		if (isset($cache['tweets']) && !empty($cache['tweets'])) {
			return $cache;
		}
		return false;
	}
	//get fromt twitter
	else
	{
		require_once liquid_addons()->plugin_dir() .'/extras/class/tmhOAuth.php';
		require_once liquid_addons()->plugin_dir() .'/extras/class/tmhUtilities.php';
		$tmhOAuth = new tmhOAuth(array(
			'consumer_key'    => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'user_token'      => $access_token,
			'user_secret'     => $access_token_secret,
			'curl_ssl_verifypeer'   => false
		));

		$code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), array(
		  'screen_name' => $username));
		$response = $tmhOAuth->response;

		$tweets = null;
		if ($response['code'] == 200 && isset($response['response']) && !empty($response['response'])) {
			$tweets = json_decode($response['response']);
	
		} else {
			$tweets = json_decode($response['response']);

			return array(
				'is_error' => true,
				'error' => (isset($tweets -> errors[0] -> message) ? $tweets -> errors[0] -> message : 'Unknown error')
			);

		}

		if ($response['code'] == 200) {

			if (is_array($tweets) && count($tweets) > 0) {

				$data = array(
						'time' => time(),
						'username' => $username,
						'tweets' => $response['response'],
						'is_error' => false
				);

			} else {

				$data = array(
					'time' => time(),
					'username' => $username,
					'tweets' => '',
					'is_error' => false
				);
			}
			update_option('theme-recent-tweets',$data);
			return $data;
		}
	}
}



/**
 * Get linkedin count of connections
 * @param string $url
 * @return string
 */
function liquid_get_linkedin_connections( $api_key, $api_secret ) {
	
	$redirect = $_SERVER["REQUEST_URI"];
	$state = base64_encode(time());

	$args = array(
				'method'      => 'POST',
				'httpversion' => '1.1',
				'blocking'    => true,
				'body'        => array( 
					'grant_type'    => 'authorization_code',
					'state'         => $state,
					'redirect_uri'  => $redirect,
					'client_id'     => $api_key,
					'client_secret' => $api_secret
				)
			);

	add_filter('https_ssl_verify', '__return_false');
	$response = wp_remote_post( 'https://www.linkedin.com/uas/oauth2/accessToken', $args );

	// Check for error
	if ( is_wp_error( $response ) ) {
		return;
	}

	$keys = json_decode($response['body']);
	
	if( $keys ) {
		$token = isset( $keys->{'access_token'} ) ?  $keys->{'access_token'} : false;
	}
	if($api_key && $api_secret && !$token) {
		$api_url = "https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=$api_key&scope=r_fullprofile&state=$state&redirect_uri=$redirect";
	}

	add_filter('https_ssl_verify', '__return_false');
	$api_url = "https://api.linkedin.com/v1/people/~:(id,num-connections)?oauth2_access_token=$token&format=json";

	$response = wp_remote_get( $api_url );
	$data = json_decode( $response['body'] );

	$in_count = isset( $data->{'numConnections'} ) ? $data->{'numConnections'} : '0';

	return $in_count;

}


/**
 * Replace urls, hashtags, mentions with html tags in tweet
 * @param type $tweet
 * @return null
 */
function liquid_replace_in_tweets($tweet) {
	
	if (!is_object($tweet)) {
		return null;
	}
	
	$tweet_text = $tweet->text;
	
	// check if any entites exist and if so, replace then with hyperlinked versions
	if (!empty($tweet->entities->urls) || !empty($tweet->entities->hashtags) || !empty($tweet->entities->user_mentions)) {
		
		$tweet_text = liquid_replace_urls_with_html($tweet_text);

		foreach ($tweet->entities->hashtags as $hashtag) {
			$find = '#'.$hashtag->text;
			$replace = '<a href="http://twitter.com/#!/search/%23'.$hashtag->text.'" target="_blank">'.$find.'</a>';
			$tweet_text = str_replace($find,$replace,$tweet_text);
		}

		foreach ($tweet->entities->user_mentions as $user_mention) {
			$find = "@".$user_mention->screen_name;
			$replace = '<a href="http://twitter.com/'.$user_mention->screen_name.'" target="_blank">'.$find.'</a>';
			$tweet_text = str_ireplace($find,$replace,$tweet_text);
		}
	}
	
	return html_entity_decode($tweet_text);
}

/**
 * Replace urls with html 
 * @param string $text
 * @return string
 */
function liquid_replace_urls_with_html($text) {
	
	if (!is_string($text)) {
		return $text;
	}
	
	$rexProtocol = '(https?://)?';
	$rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
	$rexPort     = '(:[0-9]{1,5})?';
	$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
	$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
	$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
	
	return preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&", 'liquid_replace_urls_with_html_callback', htmlspecialchars($text));
}

/**
 * Replace urls with html callback
 * @param type $match
 * @return type
 */
function liquid_replace_urls_with_html_callback($match) {
	// Prepend http:// if no protocol specified
	$completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";

	return '<a href="' . esc_url($completeUrl) . '">'
		. $completeUrl . '</a>';
	
}

/**
 * Convert datetime to x hours/months ago
 * @param type $datetime
 * @param type $full
 * @return type
 */
function liquid_time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => esc_html__('year','archub-core'),
		'm' => esc_html__('month','archub-core'),
		'w' => esc_html__('week','archub-core'),
		'd' => esc_html__('day','archub-core'),
		'h' => esc_html__('hour','archub-core'),
		'i' => esc_html__('minute','archub-core'),
		's' => esc_html__('second','archub-core'),
	);

	$plural = array(
		'y' => esc_html__('years','archub-core'),
		'm' => esc_html__('months','archub-core'),
		'w' => esc_html__('weeks','archub-core'),
		'd' => esc_html__('days','archub-core'),
		'h' => esc_html__('hours','archub-core'),
		'i' => esc_html__('minutes','archub-core'),
		's' => esc_html__('seconds','archub-core'),
	);

	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . ($diff->$k > 1 ? $plural[$k] : $v);
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' '.esc_html__('ago', 'archub-core') : esc_html__('just now', 'archub-core');
}

/**
 * get remote HTML
 * @param string $url
 * @return string
 */
function liquid_get_remote_html( $url = '' ) {

	// Check for transient, if none, grab remote HTML file
	if ( false === ( $html = get_transient( 'liquid_remote_html' ) ) ) {

		// Get remote HTML file
		add_filter('https_ssl_verify', '__return_false');
		$response = wp_remote_get( esc_url( $url ) );

		// Check for error
		if ( is_wp_error( $response ) ) {
			return;
		}

		// Parse remote HTML file
		$data = wp_remote_retrieve_body( $response );

		// Check for error
		if ( is_wp_error( $data ) ) {
			return;
		}

		// Store remote HTML file in transient, expire after 24 hours
		set_transient( 'liquid_remote_html', $data, 24 * HOUR_IN_SECONDS );

	}

	return $html;

}

/**
 * get twitter count of followers
 * @param string $screenName
 * @param string $consumerKey
 * @param string $consumerSecret
 * @return number
 */
function liquid_get_twitter_followers( $screenName = '', $consumerKey= '', $consumerSecret= '' ) {

	$token = get_option('cfTwitterToken');

	// get follower count from cache
	$numberOfFollowers = get_transient('cfTwitterFollowers');

	// cache version does not exist or expired
	if (false === $numberOfFollowers) {
		// getting new auth bearer only if we don't have one
		if(!$token) {
			// preparing credentials
			$credentials = $consumerKey . ':' . $consumerSecret;
			$toSend = base64_encode( $credentials );

			// http post arguments
			$args = array(
				'method' => 'POST',
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array(
					'Authorization' => 'Basic ' . $toSend,
					'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
				),
				'body' => array( 'grant_type' => 'client_credentials' )
			);
 
			add_filter('https_ssl_verify', '__return_false');
			$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
 
			$keys = json_decode(wp_remote_retrieve_body($response));
 
			if($keys) {
				// saving token to wp_options table
				update_option('cfTwitterToken', $keys->access_token);
				$token = $keys->access_token;
			}
		}
		// we have bearer token wether we obtained it from API or from options
		$args = array(
			'httpversion' => '1.1',
			'blocking' => true,
			'headers' => array(
				'Authorization' => "Bearer $token"
			)
		);

		add_filter('https_ssl_verify', '__return_false');
		$api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$screenName";
		$response = wp_remote_get($api_url, $args);

		if (!is_wp_error($response)) {
			$followers = json_decode(wp_remote_retrieve_body($response));
			$numberOfFollowers = $followers->followers_count;
		} else {
			// get old value and break
			$numberOfFollowers = get_option('cfNumberOfFollowers');
			// uncomment below to debug
			//die($response->get_error_message());
	}

		// cache for an hour
		set_transient('cfTwitterFollowers', $numberOfFollowers, 1*60*60);
		update_option('cfNumberOfFollowers', $numberOfFollowers);
	}

	return $numberOfFollowers;
}

/**
 * Convert numbers format
 * @param string $num
 * @param string $precision
 * @return string
 */
function liquid_format_num( $num, $precision = 2 ) {
	
	if ( $num >= 1000 && $num < 1000000 ) {
		$n_format = number_format( $num/1000, $precision) . 'K';
	} else if ( $num >= 1000000 && $num < 1000000000 ) {
		$n_format = number_format( $num/1000000,$precision ) . 'M';
	} else if ( $num >= 1000000000 ) {
		$n_format = number_format( $num/1000000000,$precision ) . 'B';
	} else {
		$n_format = $num;
	}

	return $n_format;
}

/**
 * Get facebook count of likes
 * @param string $page_link
 * @param string $facebook_access_token
 * @return string
 */
function liquid_get_facebook_likes( $page_link, $facebook_access_token ){

	// Check for transient, if none, grab number of likes
	if ( false === ( $fb_likes = get_transient( 'liquid_facebook_likes' ) ) ) {

		$f_id     = $page_link;
		$f_access = $facebook_access_token;
		$url      = str_replace('https://www.facebook.com/', '', $page_link);
	
		$get_url  = 'https://graph.facebook.com/v2.2/' . $url . '?access_token=' . $f_access;
	
		// Get remote file
		add_filter('https_ssl_verify', '__return_false');
		$response = wp_remote_get( $get_url );

		// Check for error
		if ( is_wp_error( $response ) ) {
			return;
		}
	
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		// Check for error
		if ( is_wp_error( $data ) ) {
			return;
		}

		$data_likes = $data['likes'];

		// Store number of facebook likes, expire after 24 hours
		set_transient( 'liquid_facebook_likes', $data_likes, 24 * HOUR_IN_SECONDS );

	}

	return $fb_likes;

}

/**
 * Get google plus count of followers
 * @param string $page_id
 * @param string $google_apu_key
 * @return string
 */
function liquid_get_google_plus_followers( $page_id = '', $google_api_key = '' ) {

	// Check for transient, if none, grab number of followers
	if ( false === ( $gplus_followers = get_transient( 'liquid_gplus_followers' ) ) ) {

		$url = 'https://www.googleapis.com/plus/v1/people/' . $page_id . '?key=' . $google_api_key . '';
	
		// Get remote HTML file
		add_filter('https_ssl_verify', '__return_false');
		$response = wp_remote_get( $url );

		// Check for error
		if ( is_wp_error( $response ) ) {
			return;
		}
	
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		// Check for error
		if ( is_wp_error( $data ) ) {
			return;
		}

		$data_circled = $data['circledByCount'];

		// Store number of googleplus followers, expire after 24 hours
		set_transient( 'liquid_gplus_followers', $data_circled, 24 * HOUR_IN_SECONDS );
	
	}

	return $gplus_followers;
}



/**
 * Get behance count of followers
 * @param string $page_id
 * @param string $behance_api_key
 * @return string
 */
function liquid_get_behance_followers( $page_link, $behance_api_key = '' ) {

	// Check for transient, if none, grab number of followers
	if ( false === ( $b_followers = get_transient( 'liquid_behance_followers' ) ) ) {

		$user_id = str_replace( 'https://www.behance.net/', '', $page_link );
		$url     = 'https://www.behance.net/v2/users/' . $user_id .'?api_key=' . $behance_api_key;
	
		// Get remote HTML file
		add_filter('https_ssl_verify', '__return_false');
		$response = wp_remote_get( $url );

		// Check for error
		if ( is_wp_error( $response ) ) {
			return;
		}
	
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		// Check for error
		if ( is_wp_error( $data ) ) {
			return;
		}
	
		$data_followers = $data['user']['stats']['followers'];

		// Store number of behance followers, expire after 24 hours
		set_transient( 'liquid_behance_followers', $data_followers, 24 * HOUR_IN_SECONDS );

	}

	return $b_followers;
}

/**
 * Get dribble count of followers
 * @param string $dribbble_access_token
 * @return string
 */
function liquid_get_dribbble_followers( $dribbble_access_token ) {

	// Check for transient, if none, grab number of followers
	if ( false === ( $drbbb_followers = get_transient( 'liquid_dribbble_followers' ) ) ) {

		$dribbble_at = $dribbble_access_token;
		$url         = 'https://api.dribbble.com/v1/user?access_token=' . $dribbble_at;
	
		// Get remote HTML file
		add_filter('https_ssl_verify', '__return_false');
		$response = wp_remote_get( $url );
	
		// Check for error
		if ( is_wp_error( $response ) ) {
			return;
		}
	
		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		
		// Check for error
		if ( is_wp_error( $data ) ) {
			return;
		}
	
		$data_followers = $data['followers_count'];
		
		// Check for error
		if ( is_wp_error( $data_followers ) ) {
			return;
		}

		// Store number of dribbble followers, expire after 24 hours
		set_transient( 'liquid_dribbble_followers', $data_followers, 24 * HOUR_IN_SECONDS );

	}

	return $drbbb_followers;

}

/**
 * Get pinterest count of followers
 * @param string $url
 * @return string
 */
function liquid_get_pinterest_followers( $url ) {

	// Check for transient, if none, grab number of followers
	if ( false === ( $pinterest_followers = get_transient( 'liquid_pinterest_followers' ) ) ) {

		$metas = get_meta_tags( $url );
		$meta_followers = $metas['pinterestapp:followers'];
		
		// Check for error
		if ( is_wp_error( $meta_followers ) ) {
			return;
		}

		// Store number of pinterest followers, expire after 24 hours
		set_transient( 'liquid_pinterest_followers', $meta_followers, 24 * HOUR_IN_SECONDS );

	}

	return $pinterest_followers;

}

/**
 * Get instagram count of followers
 * @param string $url
 * @return string
 */
function liquid_get_instagram_followers( $url ) {

	// Check for transient, if none, grab number of followers
	if ( false === ( $instagram_followers = get_transient( 'liquid_instagram_followers' ) ) ) {

		$raw = liquid_get_remote_html( $url ); 
		preg_match( '/\"followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/', $raw, $m );
		$instagram_count = $m[1];

		// Check for error
		if ( is_wp_error( $instagram_count ) ) {
			return;
		}

		// Store number of instagram followers, expire after 24 hours
		set_transient( 'liquid_instagram_followers', $instagram_count, 24 * HOUR_IN_SECONDS );

	}

	return $instagram_followers;

}

/**
 * [liquid_woo_share description]
 * @method liquid_woo_share
 * @return [type] [description]
 */
function liquid_woo_share( ) { 

	if ( ! class_exists( 'ReduxFramework' ) ) { 
		return;
	}	
	
	if( 'off' === liquid_helper()->get_option( 'wc-share-enable' ) ) {
		return;
	}
	
	$crunchifyURL       = urlencode( get_permalink() );
	$crunchifyTitle     = str_replace( ' ', '%20', get_the_title());
	$crunchifyThumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );

	// Construct sharing URL without using any script
	$facebookURL  = 'https://www.facebook.com/sharer/sharer.php?u=' . $crunchifyURL . '&amp;t=' . $crunchifyTitle;
	$twitterURL   = 'https://twitter.com/intent/tweet?text=' . $crunchifyTitle . '&amp;url=' . $crunchifyURL;
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $crunchifyURL . '&amp;media=' . $crunchifyThumbnail . '&amp;description=' . $crunchifyTitle;
?>
<ul class="social-icon scheme-dark reset-ul inline-nav">
	<li class="me-3"><a rel="nofollow" href="<?php echo esc_url( $facebookURL ); ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg></a></li>
	<li class="me-3"><a rel="nofollow" href="<?php echo esc_url( $twitterURL ); ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg></a></li>
	<li><a rel="nofollow" href="<?php echo esc_url( $pinterestURL ); ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"/></svg></a></li>
</ul>
<?php
}
add_action( 'woocommerce_share', 'liquid_woo_share' );

if( ! function_exists( 'liquid_portfolio_share' ) ) {
	/**
	 * [liquid_portfolio_share description]
	 * @method liquid_portfolio_share
	 * @return [type]                [description]
	 */
	function liquid_portfolio_share( $post_type = 'post', $args = array(), $echo = true ) {
		
		if ( ! class_exists( 'ReduxFramework' ) ) { 
			return;
		}

		if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' ) ){
			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
			$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		
			$post_social_box_enable = $page_settings_model->get_settings( 'post_social_box_enable' );

			if ( !$post_social_box_enable ){
				$option_name = str_replace( 'liquid-', '', $post_type ) . '-social-box-';
				$post_social_box_enable = liquid_helper()->get_option( $option_name . 'enable' );
			}
		} else {
			$option_name = str_replace( 'liquid-', '', $post_type ) . '-social-box-';
			$post_social_box_enable = liquid_helper()->get_option( $option_name . 'enable' );
		}
		
		$out = '';
		
		if( 'off' ===  $post_social_box_enable ) {
			return;
		}
	
		$defaults = array(
			'class' => 'social-icon d-flex align-items-center reset-ul',
			'before' => '',
			'after' => '',
			'style' => 'icon'
		);
		extract( wp_parse_args( $args, $defaults ) );
	
		$hash = array(
			'fb' => array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>',
				'label' => 'Facebook'
			),
			'tw' => array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>',
				'label' => 'Twitter'
			),
			'pin' => array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"/></svg>',
				'label' => 'Pinterest'
			),
			'go' => array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>',
				'label' => 'Google'
			),
			'li' => array(
				'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>',
				'label' => 'Linkedin'
			)
		);
	
		$url = esc_url( get_the_permalink() );
		$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );

		if( $echo ) {
			echo $before; 
		} else {
			$out = $before; 	
		}
		
		if( $echo ) {
		?>
		<ul class="<?php echo $class ?>">
			<li class="me-3"><a rel="nofollow" target="_blank" href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u='. $url ); ?>"><?php echo $hash['fb'][$style] ?></a></li>
			<li class="me-3"><a rel="nofollow" target="_blank" href="<?php echo esc_url('https://twitter.com/intent/tweet?text=' . get_the_title() .'&amp;url='. $url ); ?>"><?php echo $hash['tw'][$style] ?></a></li>
			<?php if( ! empty( $pinterest_image ) ):?>
			<li class="me-3"><a rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/button/?url=&amp;media=<?php echo esc_url( $pinterest_image ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>"><?php echo $hash['pin'][$style] ?></a></li>
			<?php endif; ?>
			<li><a rel="nofollow" target="_blank" href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&amp;title=' . get_the_title() . '&amp;source=' . get_bloginfo( "name" ) ); ?>"><?php echo $hash['li'][$style] ?></a></li>
		</ul>
		<?php
		}
		else {
			$out .= '<ul class="' . $class . '">
			<li class="me-3"><a rel="nofollow" target="_blank" href="' . esc_url("https://www.facebook.com/sharer/sharer.php?u=" . $url ) .'">' . $hash['fb'][$style] . '</a></li>
			<li class="me-3"><a rel="nofollow" target="_blank" href="' . esc_url("https://twitter.com/intent/tweet?text=" . get_the_title() . "&amp;url=" . $url ) . '">' . $hash['tw'][$style] . '</a></li>
			<li class="me-3"><a rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/button/?url=&amp;media=' . esc_url( $pinterest_image ) . '&amp;description=' . urlencode( get_the_title() ) . '">' . $hash['pin'][$style] . '</a></li>
			<li><a rel="nofollow" target="_blank" href="' . esc_url("https://www.linkedin.com/shareArticle?mini=true&url=" . $url . "&amp;title=" . get_the_title() . "&amp;source=" . get_bloginfo( "name" ) ) . '">' . $hash['li'][$style] . '</a></li></ul>';
		}

		if( $echo ) {	
			echo $after;
		} else {
			$out .= $after;
			return $out;
		}
		
	}
}