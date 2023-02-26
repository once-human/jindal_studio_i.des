<?php
/*
 * Api keys Section
*/
//APP Api Keys
$this->sections[] = array(
	'title'      => esc_html__( 'API Keys', 'archub' ),
	'icon'   => 'el el-key',
	'fields'     => array(
		array(
			'id'       => 'google-api-key',
			'type'     => 'text',
			'title'    => esc_html__( 'Google Maps API Key', 'archub' ),
			'desc'     => wp_kses( __( 'Follow the steps in <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key#key">the Google docs</a> to get the API key. This key applies to the google map element.', 'archub' ), 'a' )
		),
		array(
			'id'       => 'mailchimp-api-key',
			'type'     => 'text',
			'title'    => esc_html__( 'Mailchimp API Key', 'archub' ),
			'desc'     => wp_kses( __( 'Follow the steps <a href="https://mailchimp.com/help/about-api-keys/">MailChimp</a> to get the API key. This key applies to the newsletter element.', 'archub' ), 'a' ), 
		),
		array(
			'id'       => 'instagram-token',
			'type'     => 'text',
			'title'    => esc_html__( 'Instagram Access Token', 'archub' ),
			'desc'     => wp_kses( __( 'Follow the link <a target="_blank" href="https://instagram.com/oauth/authorize/?app_id=1801706479953402&scope=user_profile,user_media&response_type=code&redirect_uri=https://api.liquid-themes.com/instagram/instagram-auth.php">to generate the access token and user ID.</a>', 'archub' ), 'a' ),
		),
	)
);
