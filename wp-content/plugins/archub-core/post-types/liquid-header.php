<?php

/**
 * Post Type: Header
 * Register Custom Post Type
 */

$labels = array(
	'name'                  => esc_html_x( 'Headers', 'Post Type General Name', 'archub-core' ),
	'singular_name'         => esc_html_x( 'Header', 'Post Type Singular Name', 'archub-core' ),
	'menu_name'             => esc_html__( 'Headers', 'archub-core' ),
	'name_admin_bar'        => esc_html__( 'Headers', 'archub-core' ),
	'archives'              => esc_html__( 'Item Archives', 'archub-core' ),
	'parent_item_colon'     => esc_html__( 'Parent Item:', 'archub-core' ),
	'all_items'             => esc_html__( 'All Items', 'archub-core' ),
	'add_new_item'          => esc_html__( 'Add New Header', 'archub-core' ),
	'add_new'               => esc_html__( 'Add New', 'archub-core' ),
	'new_item'              => esc_html__( 'New Header', 'archub-core' ),
	'edit_item'             => esc_html__( 'Edit Header', 'archub-core' ),
	'update_item'           => esc_html__( 'Update Header', 'archub-core' ),
	'view_item'             => esc_html__( 'View Header', 'archub-core' ),
	'search_items'          => esc_html__( 'Search Header', 'archub-core' ),
	'not_found'             => esc_html__( 'Not found', 'archub-core' ),
	'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'archub-core' ),
	'featured_image'        => esc_html__( 'Featured Image', 'archub-core' ),
	'set_featured_image'    => esc_html__( 'Set featured image', 'archub-core' ),
	'remove_featured_image' => esc_html__( 'Remove featured image', 'archub-core' ),
	'use_featured_image'    => esc_html__( 'Use as featured image', 'archub-core' ),
	'insert_into_item'      => esc_html__( 'Insert into item', 'archub-core' ),
	'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'archub-core' ),
	'items_list'            => esc_html__( 'Items list', 'archub-core' ),
	'items_list_navigation' => esc_html__( 'Items list navigation', 'archub-core' ),
	'filter_items_list'     => esc_html__( 'Filter items list', 'archub-core' ),
);
$args = array(
	'label'                 => esc_html__( 'Header', 'archub-core' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor', 'revisions', ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 25,
	'menu_icon'             => 'dashicons-align-center',
	'show_in_admin_bar'     => true,
	'show_in_nav_menus'     => false,
	'can_export'            => true,
	'has_archive'           => false,
	'exclude_from_search'   => true,
	'publicly_queryable'    => true,
	'rewrite'               => false,
	'capability_type'       => 'page',
);
register_post_type( 'liquid-header', $args );
