<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Listing post type.
 */
function dxadult_register_listing_post_type() {
	$labels = array(
		'name'                  => _x( 'Listings', 'Post Type General Name', 'directoryx-adult' ),
		'singular_name'         => _x( 'Listing', 'Post Type Singular Name', 'directoryx-adult' ),
		'menu_name'             => __( 'Listings', 'directoryx-adult' ),
		'name_admin_bar'        => __( 'Listing', 'directoryx-adult' ),
		'archives'              => __( 'Listing Archives', 'directoryx-adult' ),
		'all_items'             => __( 'All Listings', 'directoryx-adult' ),
		'add_new_item'          => __( 'Add New Listing', 'directoryx-adult' ),
		'add_new'               => __( 'Add New', 'directoryx-adult' ),
		'new_item'              => __( 'New Listing', 'directoryx-adult' ),
		'edit_item'             => __( 'Edit Listing', 'directoryx-adult' ),
		'update_item'           => __( 'Update Listing', 'directoryx-adult' ),
		'view_item'             => __( 'View Listing', 'directoryx-adult' ),
		'search_items'          => __( 'Search Listings', 'directoryx-adult' ),
		'not_found'             => __( 'Not found', 'directoryx-adult' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'directoryx-adult' ),
	);

	$args = array(
		'label'               => __( 'Listing', 'directoryx-adult' ),
		'description'         => __( 'Directory listings', 'directoryx-adult' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
		'taxonomies'          => array( 'listing_category' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-admin-links',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
		'rewrite'             => array( 'slug' => 'listing' ),
	);

	register_post_type( 'listing', $args );
}
add_action( 'init', 'dxadult_register_listing_post_type' );

/**
 * Register the Listing Category taxonomy.
 */
function dxadult_register_listing_category_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Listing Categories', 'Taxonomy General Name', 'directoryx-adult' ),
		'singular_name'              => _x( 'Listing Category', 'Taxonomy Singular Name', 'directoryx-adult' ),
		'menu_name'                  => __( 'Categories', 'directoryx-adult' ),
		'all_items'                  => __( 'All Categories', 'directoryx-adult' ),
		'parent_item'                => __( 'Parent Category', 'directoryx-adult' ),
		'parent_item_colon'          => __( 'Parent Category:', 'directoryx-adult' ),
		'new_item_name'              => __( 'New Category Name', 'directoryx-adult' ),
		'add_new_item'               => __( 'Add New Category', 'directoryx-adult' ),
		'edit_item'                  => __( 'Edit Category', 'directoryx-adult' ),
		'update_item'                => __( 'Update Category', 'directoryx-adult' ),
		'view_item'                  => __( 'View Category', 'directoryx-adult' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'directoryx-adult' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'directoryx-adult' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'directoryx-adult' ),
		'popular_items'              => __( 'Popular Categories', 'directoryx-adult' ),
		'search_items'               => __( 'Search Categories', 'directoryx-adult' ),
		'not_found'                  => __( 'Not Found', 'directoryx-adult' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => false,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'category' ),
	);

	register_taxonomy( 'listing_category', array( 'listing' ), $args );
}
add_action( 'init', 'dxadult_register_listing_category_taxonomy' );

/**
 * Flush rewrite rules on theme activation.
 */
function dxadult_rewrite_flush() {
	dxadult_register_listing_post_type();
	dxadult_register_listing_category_taxonomy();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'dxadult_rewrite_flush' );
