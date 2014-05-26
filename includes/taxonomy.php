<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Custom Taxonomy
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2014, Kerry Kline
 * 	@link		http://www.bluenotesentertainment.com
 *
*/



function bne_testimonials_taxonomy() {

	// Taxonomy Labels      
	$labels = array(
		'name'                       => __( 'Testimonial Categories' ),
		'singular_name'              => __( 'Category' ),
		'search_items'               => __( 'Search Categories' ),
		'popular_items'              => __( 'Popular Categories' ),
		'all_items'                  => __( 'All Categories' ),
		'parent_item'                => __( 'Parent Category' ),
		'parent_item_colon'          => __( 'Parent: Category' ),
		'edit_item'                  => __( 'Edit Category' ),
		'view_item'                  => __( 'View Category' ),
		'update_item'                => __( 'Update Category' ),
		'add_new_item'               => __( 'Add New Category' ),
		'new_item_name'              => __( 'New Category Name' ),
		'add_or_remove_items'        => __( 'Add or remove Categories' ),
		'choose_from_most_used'      => __( 'Choose from the most used Categories' ),
		'separate_items_with_commas' => __( 'Separate Categories with commas' ),
		'menu_name'                  => __( 'Categories' ),
	);
	
	// Linked Custom Post Type
	$cpts = array('bne_testimonials');
	
	// Taxonomy Arguments  
	$args = array(
	    'labels'             => $labels,
	    'hierarchical'       => true,
	    'description'        => 'place each testimonial into a category.',
	    'public'             => true,
	    'show_ui'            => true,
	    'show_tagcloud'      => false,
	    'show_in_nav_menus'  => false,
	    'show_admin_column'  => true,
	    'query_var'          => true,
	    'rewrite'            => false,
	);
	register_taxonomy( 'bne-testimonials-taxonomy', $cpts, $args );

}
add_action( 'init', 'bne_testimonials_taxonomy' );