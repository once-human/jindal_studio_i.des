<?php
/**
* Post Type: Portfolios
* Register Custom Post Type
*/

$portfolio_slug = 'portfolio';
$portfolio_cat_slug = 'portfolio-category';

if( function_exists( 'liquid_helper' ) ) {
	$custom_portfolio_slug = liquid_helper()->get_option( 'portfolio-single-slug' );
	if( ! empty( $custom_portfolio_slug ) ) {
		$portfolio_slug = esc_attr( $custom_portfolio_slug );
	}
	$custom_portfolio_cat_slug = liquid_helper()->get_option( 'portfolio-category-slug' );
	if( ! empty( $custom_portfolio_cat_slug ) ) {
		$portfolio_cat_slug = esc_attr( $custom_portfolio_cat_slug );
	}
}

$labels = array(
	'name'                  => esc_html_x( 'Portfolios', 'Post Type General Name', 'archub-portfolio' ),
	'singular_name'         => esc_html_x( 'Portfolio', 'Post Type Singular Name', 'archub-portfolio' ),
	'menu_name'             => esc_html__( 'Portfolio items', 'archub-portfolio' ),
	'name_admin_bar'        => esc_html__( 'Portfolio item', 'archub-portfolio' ),
	'archives'              => esc_html__( 'Portfolio item Archives', 'archub-portfolio' ),
	'parent_item_colon'     => esc_html__( 'Parent Item:', 'archub-portfolio' ),
	'all_items'             => esc_html__( 'All Items', 'archub-portfolio' ),
	'add_new_item'          => esc_html__( 'Add New Portfolio', 'archub-portfolio' ),
	'add_new'               => esc_html__( 'Add New', 'archub-portfolio' ),
	'new_item'              => esc_html__( 'New Portfolio', 'archub-portfolio' ),
	'edit_item'             => esc_html__( 'Edit Portfolio', 'archub-portfolio' ),
	'update_item'           => esc_html__( 'Update Portfolio', 'archub-portfolio' ),
	'view_item'             => esc_html__( 'View Portfolio', 'archub-portfolio' ),
	'search_items'          => esc_html__( 'Search Portfolios', 'archub-portfolio' ),
	'not_found'             => esc_html__( 'Not found', 'archub-portfolio' ),
	'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'archub-portfolio' ),
	'featured_image'        => esc_html__( 'Featured Image', 'archub-portfolio' ),
	'set_featured_image'    => esc_html__( 'Set featured image', 'archub-portfolio' ),
	'remove_featured_image' => esc_html__( 'Remove featured image', 'archub-portfolio' ),
	'use_featured_image'    => esc_html__( 'Use as featured image', 'archub-portfolio' ),
	'insert_into_item'      => esc_html__( 'Insert into Portfolio', 'archub-portfolio' ),
	'uploaded_to_this_item' => esc_html__( 'Uploaded to this Portfolio', 'archub-portfolio' ),
	'items_list'            => esc_html__( 'Items list', 'archub-portfolio' ),
	'items_list_navigation' => esc_html__( 'Items list navigation', 'archub-portfolio' ),
	'filter_items_list'     => esc_html__( 'Filter items list', 'archub-portfolio' ),
);
$rewrite = array(
	'slug'                  => $portfolio_slug,
	'with_front'            => true,
	'pages'                 => true,
	'feeds'                 => false,
);
$args = array(
	'label'                 => esc_html__( 'Portfolio', 'archub-portfolio' ),
	'labels'                => $labels,
	'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'post-formats', 'liquid-post-likes' ),
	'hierarchical'          => false,
	'public'                => true,
	'show_ui'               => true,
	'show_in_menu'          => true,
	'menu_position'         => 25.3,
	'menu_icon'             => 'dashicons-format-image',
	'show_in_admin_bar'     => true,
	'show_in_nav_menus'     => true,
	'can_export'            => true,
	'has_archive'           => 'portfolios',
	'exclude_from_search'   => false,
	'publicly_queryable'    => true,
	'query_var'             => 'portfolios',
	'rewrite'               => $rewrite,
	'capability_type'       => 'page',
);
register_post_type( 'liquid-portfolio', $args );

/**
 * Taxonomy: Portfolio Category
 * Register Custom Taxonomy
 */
$labels = array(
	'name'                       => esc_html_x( 'Portfolio Categories', 'Taxonomy General Name', 'archub-portfolio' ),
	'singular_name'              => esc_html_x( 'Portfolio Category', 'Taxonomy Singular Name', 'archub-portfolio' ),
	'menu_name'                  => esc_html__( 'Categories', 'archub-portfolio' ),
	'all_items'                  => esc_html__( 'All Categories', 'archub-portfolio' ),
	'parent_item'                => esc_html__( 'Parent Category', 'archub-portfolio' ),
	'parent_item_colon'          => esc_html__( 'Parent Category:', 'archub-portfolio' ),
	'new_item_name'              => esc_html__( 'New Category Name', 'archub-portfolio' ),
	'add_new_item'               => esc_html__( 'Add New Category', 'archub-portfolio' ),
	'edit_item'                  => esc_html__( 'Edit Category', 'archub-portfolio' ),
	'update_item'                => esc_html__( 'Update Category', 'archub-portfolio' ),
	'view_item'                  => esc_html__( 'View Category', 'archub-portfolio' ),
	'separate_items_with_commas' => esc_html__( 'Separate Categories with commas', 'archub-portfolio' ),
	'add_or_remove_items'        => esc_html__( 'Add or remove Categories', 'archub-portfolio' ),
	'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'archub-portfolio' ),
	'popular_items'              => esc_html__( 'Popular Categories', 'archub-portfolio' ),
	'search_items'               => esc_html__( 'Search Categories', 'archub-portfolio' ),
	'not_found'                  => esc_html__( 'Not Found', 'archub-portfolio' ),
	'no_terms'                   => esc_html__( 'No Categories', 'archub-portfolio' ),
	'items_list'                 => esc_html__( 'Items list', 'archub-portfolio' ),
	'items_list_navigation'      => esc_html__( 'Items list navigation', 'archub-portfolio' ),
);
$rewrite = array(
	'slug'                       => $portfolio_cat_slug,
	'with_front'                 => true,
	'hierarchical'               => false,
);
$args = array(
	'labels'                     => $labels,
	'hierarchical'               => true,
	'public'                     => true,
	'show_ui'                    => true,
	'show_admin_column'          => true,
	'show_in_nav_menus'          => false,
	'show_tagcloud'              => true,
	'query_var'                  => 'portfolio-category',
	'rewrite'                    => $rewrite,
);
register_taxonomy( 'liquid-portfolio-category', array( 'liquid-portfolio' ), $args );
register_taxonomy_for_object_type( 'post_format', 'liquid-portfolio' );

/**
 * Adjust Post Type
 */
add_action( 'load-post.php','liquid_portfolio_adjust_post_formats' );
add_action( 'load-post-new.php','liquid_portfolio_adjust_post_formats' );
/**
 * [liquid_portfolio_adjust_post_formats description]
 * @method liquid_portfolio_adjust_post_formats
 * @return [type]                              [description]
 */
function liquid_portfolio_adjust_post_formats() {
	if( isset( $_GET['post'] ) ) {
		$post = get_post( $_GET['post'] );
		if ( $post ) {
			$post_type = $post->post_type;
		}
	}
	elseif ( !isset($_GET['post_type']) ) {
		$post_type = 'post';
	}
	elseif ( in_array( $_GET['post_type'], get_post_types( array( 'show_ui' => true ) ) ) ) {
		$post_type = $_GET['post_type'];
	}
	else {
		return; // Page is going to fail anyway
	}

	if ( 'liquid-portfolio' == $post_type ) {
		add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
	}
}
