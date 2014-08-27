<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	CPT Settings and Admin Functions
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2014, Kerry Kline
 * 	@link		http://www.bluenotesentertainment.com
 *
 *	@updated: May 24, 2014
*/



/* ===========================================================
 *	Register Testimonials Custom Post Type
 *	@since v1.0
 * ======================================================== */


function bne_testimonials_post_type() {
	// Custom Post Type Labels      
	$labels = array(
		'name'               => __( 'Testimonials' ),
		'singular_name'      => __( 'Testimonial' ),
		'add_new'            => __( 'Add new testimonial' ),
		'add_new_item'       => __( 'Add new Testimonial' ),
		'edit_item'          => __( 'Edit Testimonial' ),
		'new_item'           => __( 'New Testimonial' ),
		'all_items'          => __( 'All Testimonials' ),
		'view_item'          => __( 'View Testimonial' ),
		'search_items'       => __( 'Search Testimonials' ),
		'not_found'          => __( 'No Testimonial found' ),
		'not_found_in_trash' => __( 'No Testimonial found in trash' ),
		'parent_item_colon'  => __( 'Parent Testimonial' ),
		'menu_name'          => __( 'Testimonials' )
	);
	
	// Custom Post Type Supports  
	$supports = array('title', 'editor', 'thumbnail');
	
	// Custom Post Type Arguments  
	$args = array(
	    'labels'             	=> $labels,
	    'hierarchical'       	=> false,
	    'description'        	=> '',
	    'public'             	=> false,
	    'publicly_queryable' 	=> true,
	    'show_ui'            	=> true,
	    'show_in_menu'       	=> true,
	    'show_in_nav_menus'  	=> false,
	    'show_in_admin_bar'  	=> true,
	    'exclude_from_search'	=> true,
	    'query_var'          	=> true,
	    'rewrite'            	=> false,
	    'can_export'         	=> true,
	    'has_archive'        	=> false,
	    //'menu_position'      	=> 5,
	    'supports'           	=> $supports,
	    'capability_type'    	=> 'post'
	);
	
	register_post_type( 'bne_testimonials', $args );

}
add_action( 'init', 'bne_testimonials_post_type' );





/* ===========================================================
 *	BNE Testimonials Menu icon
 *	@since v1.0
 * ======================================================== */


function bne_testimonials_admin_styles() {
	global $wp_version;
	?>
	<style type="text/css" media="screen">
		/* BNE Testimonials Menu/Page Icon CSS */
		#menu-posts-bne_testimonials .wp-menu-image {
			background: none;
			background-image: url(<?php echo BNE_TESTIMONIALS_URI . '/assets/images/menu-icon.png';?>);
			background-repeat: no-repeat;
			background-position: 1px -4px !important;
			background-size: 105px 190px;
		}
		#menu-posts-bne_testimonials.wp-menu-open .wp-menu-image,
		#menu-posts-bne_testimonials:hover .wp-menu-image {
			background-position: -49px -4px !important;
		}
		#icon-edit.icon32-posts-bne_testimonials {
			background: none;
			background-image: url(<?php echo BNE_TESTIMONIALS_URI . '/assets/images/menu-icon.png';?>);
			background-repeat: no-repeat;
			background-position: -54px -36px !important;
			background-size: 105px 190px;
		}
		@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (min-device-pixel-ratio: 2) {

			#menu-posts-bne_testimonials .wp-menu-image {
				background-position: 4px -12px !important;
				background-size: 55px 90px;
			}
			#menu-posts-bne_testimonials.wp-menu-open .wp-menu-image,
			#menu-posts-bne_testimonials:hover .wp-menu-image {
				background-position: -22px -12px !important;
			}
			#icon-edit.icon32-posts-bne_testimonials {
				background-position: -1px -47px !important;
				background-size: 55px 96px;
			}
		}
		
		/* WP 3.8+ - Use WP Builtin Dashicons */
		<?php if ( $wp_version >= 3.8 ) { ?>
		#adminmenu #menu-posts-bne_testimonials.menu-icon-post div.wp-menu-image:before {
			content: '\f337';
		}
		<?php } ?>
			
		
    </style>
    <?php
}
add_action( 'admin_head', 'bne_testimonials_admin_styles' );



/* ===========================================================
 *	CPT Messages
 * ======================================================== */

/*
 *	CPT Update Messages when creating/editing a Testimonial on the
 *	post edit screen.
 *	@since v1.6.3
*/
function bne_testimonials_updated_messages( $messages ) {
	global $post, $post_ID;

    $screen = get_current_screen();
    if ( 'bne_testimonials' == $screen->post_type ){
	
		$messages["post"][1] 	= __( 'Testimonial updated! ');
		$messages["post"][6] 	= __( 'Testimonial published! ');
		$messages["post"][10] 	= __( 'Testimonial draft updated! ');
	
		return $messages;
	}
	
	return $messages;
}
add_filter( 'post_updated_messages', 'bne_testimonials_updated_messages' );



/* ===========================================================
 *	Testimonial Post List/Edit Admin Screens
 * ======================================================== */


/*
 *	Setup Post List Columns 
 *	@since v1.1
*/
if (function_exists( 'add_theme_support' )){
    add_filter( 'manage_edit-bne_testimonials_columns', 'bne_testimonials_posts_columns', 5 );
    add_action( 'manage_posts_custom_column', 'bne_testimonials_posts_custom_columns', 10, 2 );
}


/*
 *	Remove/Add Columns
 *	@since v1.1
*/
function bne_testimonials_posts_columns( $columns ){
    unset( $columns['date'] );
   
    $columns['title'] = __( 'Name' );
    $columns['taxonomy-bne-testimonials-taxonomy'] = __( 'Category' );
    $columns['bne_testimonials_message'] = __( 'Message' );
    $columns['bne_testimonials_post_list_thumbs'] = __( 'Image' );
    $columns['date'] = __( 'Date' );
    return $columns;
}


/*
 *	Add Content to the Columns
 *	@since v1.1
*/
function bne_testimonials_posts_custom_columns( $column_name, $id ) {
	if( $column_name === 'bne_testimonials_post_list_thumbs' ) {
		echo the_post_thumbnail( array( 80, 80 ) );
    }
	if( $column_name === 'bne_testimonials_message' ) {
		echo substr( get_the_excerpt(), 0, 80 ) . '...';
    }
}


/*
 *	Alter Title Placeholder Text on Post Edit Screen
 *	@since v1.1
*/
function bne_testimonials_post_title( $title ){
    $screen = get_current_screen();
    if ( 'bne_testimonials' == $screen->post_type ) {
        $title = __( 'Enter the person\'s name here' );
    } 
    return $title;
}
add_filter( 'enter_title_here', 'bne_testimonials_post_title' );


/*
 *	Featured Image Widget Title
 *	@since v1.1
*/
function bne_testimonials_admin_featured_image_text() {
    remove_meta_box( 'postimagediv', 'bne_testimonials', 'side' );
    add_meta_box( 'postimagediv', __( 'Set Testimonial Thumbnail' ), 'bne_testimonials_featured_image_box', 'bne_testimonials', 'side', 'default' );
}
add_action( 'do_meta_boxes', 'bne_testimonials_admin_featured_image_text' );


/*
 *	Featured Image Widget Text
 *	@since v1.1
*/
function bne_testimonials_featured_image_box( $post ) {
	$thumbnail_id = get_post_meta( $post->ID, '_thumbnail_id', true );
	echo _wp_post_thumbnail_html( $thumbnail_id, $post->ID );
	echo __( 'Add an optional featured image for this testimonial.' );
}


/*
 *	Check if Theme supports Post Thumbnails
 *	@since v1.5
 *	@updated v1.6.3
*/
function bne_testimonials_add_thumbnail_support() {
	
	// Remove default support which may limit certain
    // post-types not specified from the active theme.
	remove_theme_support( 'post-thumbnails' );

	// Re-Add support for ALL post-types to ensure that
	// post-thumbnails work correctly.
	if( !current_theme_supports( 'post-thumbnails' ) ) {
		add_theme_support( 'post-thumbnails' );
	}
}

add_action( 'after_setup_theme', 'bne_testimonials_add_thumbnail_support', 11 );



/* ===========================================================
 *	Register Custom Fields Meta Boxe for BNE Testimonials
 * ======================================================== */


/*
 *	Registers the 'testimonial_details' metabox
 *	@since v1.0
*/
function bne_testimonials_details_metabox() {
	add_meta_box( 'testimonial_details', __( 'Optional Testimonial Details' ), 'bne_testimonials_details_metabox_fields', 'bne_testimonials', 'normal', 'high' );
        
}
add_action( 'add_meta_boxes', 'bne_testimonials_details_metabox' ); 


/*
 *	Creates the 'testimonial_details' metabox content
 *	@since v1.0
*/
function bne_testimonials_details_metabox_fields() {
	
	global $post;
	
	?>
	<table class="form-table" id="rc_wctg_metabox">
		<tbody>
			<tr class="form-field">
				<th scope="row" valign="top" style="width: 30%;">
					<label for="tagline"><?php echo __('Tagline or Company Name:');?></label>
				</th>
				<?php $tagline = ( get_post_meta($post->ID, 'tagline', true) ) ? get_post_meta($post->ID, 'tagline', true) : ''; ?>
				<td>
					<input type="text" id="tagline" name="rc_wctg_meta_field[tagline]" value="<?php echo $tagline; ?>" title="Enter a tagline for the person giving this testimonial (for example: ">
					<span class="description" style="display:block;">
						<?php echo __('Enter a tagline or Company Name of this testimonial. This field is also used as the website anchor text if a url is entered below. Example: "Owner of Cat\'s Town".');?>
					</span>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top" style="width: 30%;">
					<label for="website-url"><?php echo __('Website URL:');?></label>
				</th>
				<?php $website_url = ( get_post_meta($post->ID, 'website-url', true) ) ? get_post_meta($post->ID, 'website-url', true) : ''; ?>
				<td>
					<input type="text" id="website-url" name="rc_wctg_meta_field[website-url]" value="<?php echo $website_url; ?>" title="Enter a URL that applies to this customer (for example: http://google.com/).">
					<span class="description" style="display:block;">
						<?php echo __('Enter a URL that applies to this testimonial. Ex: http://www.google.com/')?>
					</span>
				</td>
			</tr>
		</tbody>
	</table>

	<?php
}


/*
 *	Creates the 'save' function
 *	@since v1.0
*/
function bne_testimonials_save_post_meta( $post_id, $post ) {

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
		
	$post_meta =  array();
	
	// place all meta fields into a single array
	if( isset($_POST['rc_wctg_meta_field'] ) ) {
		$meta_fields = $_POST['rc_wctg_meta_field'];
		foreach( $meta_fields as $meta_key => $meta_value ) {
			$post_meta[$meta_key] = $meta_value;
		}
	}
	
	// Add values of $post_meta as custom fields
	foreach ($post_meta as $key => $value) {
		if( $post->post_type == 'revision' ) return;
		$value = implode(',', (array)$value);
		if(get_post_meta($post->ID, $key, FALSE)) {
			update_post_meta($post->ID, $key, $value);
		} else {
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key);
	}
}
add_action('save_post', 'bne_testimonials_save_post_meta', 1, 2); // save the custom fields