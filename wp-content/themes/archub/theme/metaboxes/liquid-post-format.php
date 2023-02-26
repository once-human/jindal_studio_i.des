<?php
/*
 * Post
*/

// Audio
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Audio', 'archub' ),
	'post_types'   => array( 'post', 'liquid-portfolio' ),
	'post_format'  => array( 'audio' ),
	'icon'         => 'el-icon-screen',
	'fields' => array(

		array(
			'id' => 'post-audio',
			'type' => 'text',
			'title' => esc_html__( 'Audio URL', 'archub' ),
			'desc' => esc_html__( 'Audio file URL in format: mp3, ogg, wav.', 'archub' )
		)
	)
);

// Gallery
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Gallery', 'archub' ),
	'post_types'   => array( 'post', 'liquid-portfolio' ),
	'post_format'  => array( 'gallery' ),
	'icon'         => 'el-icon-screen',
	'fields' => array(

		array(
			'id'        => 'post-gallery-lightbox',
			'type'      => 'button_set',
			'title'     => esc_html__( 'Lightbox?', 'archub' ),
			'subtitle'  => esc_html__( 'Enable lightbox for gallery images', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'off'
		),

		array(
			'id'        => 'post-gallery',
			'type'      => 'slides',
			'title'     => esc_html__( 'Gallery Slider', 'archub' ),
			'subtitle'  => esc_html__( 'Upload images or add from media library.', 'archub' ),
			'placeholder'   => array(
				'title'     => esc_html__( 'Title', 'archub' ),
			),
			'show' => array(
				'title' => true,
				'description' => false,
				'url' => false,
			)
		)
	)
);

// Link
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Link', 'archub' ),
	'post_types' => array( 'post' ),
	'post_format' => array( 'link' ),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id'        => 'post-link-url',
			'type'      => 'text',
			'title'     => esc_html__( 'URL', 'archub' )
		)
	)
);

// Quote
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Quote', 'archub' ),
	'post_types' => array( 'post' ),
	'post_format' => array( 'quote' ),
	'icon' => 'el-icon-screen',
	'fields' => array(
		array(
			'id'        => 'post-quote-url',
			'type'      => 'text',
			'title'     => esc_html__( 'Cite', 'archub' )
		)
	)
);

// Video
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Video', 'archub' ),
	'post_types' => array( 'post' ),
	'post_format' => array( 'video' ),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id'        => 'post-video-url',
			'type'      => 'text',
			'title'     => esc_html__( 'Video URL', 'archub' ),
			'desc'  => esc_html__( 'YouTube or Vimeo video URL', 'archub' )
		),

		array(
			'id'        => 'post-video-file',
			'type'      => 'editor',
			'title'     => esc_html__( 'Video Upload', 'archub' ),
			'desc'  => esc_html__( 'Upload video file', 'archub' )
		),

		array(
			'id'        => 'post-video-html',
			'type'      => 'textarea',
			'title'     => esc_html__( 'Embadded video', 'archub' ),
			'desc'  => esc_html__( 'Use this option when the video does not come from YouTube or Vimeo', 'archub' )
		)
	)
);