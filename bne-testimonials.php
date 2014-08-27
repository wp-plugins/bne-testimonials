<?php
/*
 * Plugin Name: BNE Testimonials
 * Version: 1.6.4
 * Plugin URI: http://www.bluenotesentertainment.com/blog/new-testimonial-plugin-for-wordpress/
 * Description: Adds a Custom Post Type to display Testimonials on any page, post, or sidebar. Display the testimonials as a list or slider powered by Flexslider. Shortcodes: [bne_testimonials_list] & [bne_testimonials_slider]. Includes corresponding widget options.
 * Author: Kerry Kline, Bluenotes Entertainment
 * Author URI: http://www.bluenotesentertainment.com
 * Requires at least: 3.7
 * License: GPL2

    Copyright 2013-2014  Bluenotes Entertainment

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/


// Exit if accessed directly
if ( !defined('ABSPATH') ) exit;



/* ===========================================================
 *	Plugin Constants
 * ======================================================== */

define( 'BNE_TESTIMONIALS_VERSION', '1.6.4' );
define( 'BNE_TESTIMONIALS_DIR', dirname( __FILE__ ) );
define( 'BNE_TESTIMONIALS_URI', plugins_url( '', __FILE__ ) );
define( 'BNE_TESTIMONIALS_BASENAME', plugin_basename( __FILE__ ) );



/* ===========================================================
 *	Plugin Includes
 * ======================================================== */


// CPT Settings and Admin Plugin Functions
include_once( BNE_TESTIMONIALS_DIR . '/includes/cpt.php' );

// Taxonomy
include_once( BNE_TESTIMONIALS_DIR . '/includes/taxonomy.php' );

// Shortcodes
include_once( BNE_TESTIMONIALS_DIR . '/includes/shortcode-list.php' );
include_once( BNE_TESTIMONIALS_DIR . '/includes/shortcode-slider.php' );

// Widgets
include_once( BNE_TESTIMONIALS_DIR . '/includes/widget-slider.php' );
include_once( BNE_TESTIMONIALS_DIR . '/includes/widget-list.php' );

// Admin Help Page
include_once( BNE_TESTIMONIALS_DIR . '/includes/help.php' );



/* ===========================================================
 *	Scripts and Styles
 * ======================================================== */


/*
 *	Register Plugin CSS and JS
 *	@since v1.5
 *	@updated Dec 27 2013
*/
function bne_testimonials_register_scripts() {
	
	// Register the CSS DEV version
	//wp_register_style( 'bne-testimonial-styles', BNE_TESTIMONIALS_URI . '/assets/css/bne-testimonials.css', '', BNE_TESTIMONIALS_VERSION, 'all' );

	// Register the CSS MIN Production version
	wp_register_style( 'bne-testimonial-styles', BNE_TESTIMONIALS_URI . '/assets/css/bne-testimonials.min.css', '', BNE_TESTIMONIALS_VERSION, 'all' );

	// Register the JS
	wp_register_script( 'flexslider', BNE_TESTIMONIALS_URI . '/assets/js/flexslider.min-v2.2.0.js', array('jquery'), '2.2.0', true );
	
	// Load the plugin CSS
	wp_enqueue_style( 'bne-testimonial-styles' );
			
}
add_action( 'wp_enqueue_scripts', 'bne_testimonials_register_scripts' );



/*
 *	Testimonial List Script Enqueue (Called from shortcode/widget)
 *	@since v1.5
 *	@updated Dec 27 2013
*/
function bne_testimonials_list_enqueue_scripts() {
	//wp_enqueue_style( 'bne-testimonial-styles');				
}



/*
 *	Testimonial Slider Script Enqueue (Called from shortcode/widget)
 *	@since v1.5
 *	@updated Dec 20 2013
*/
function bne_testimonials_slider_enqueue_scripts() {
	wp_enqueue_script( 'jquery' ); // just in case...
	wp_enqueue_script( 'flexslider' );
	//wp_enqueue_style( 'bne-testimonial-styles');				
}



/* ===========================================================
 *	Testimonial Output Functions
 * ======================================================== */


/*
 *	Testimonial Single Structure and Layout Order
 *
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Dec 27 2013
*/
function bne_testimonials_single_structure( $options ) {
	
	// Empty String
	$shortcode_output = '';

	// Testimonial Thumbnail
	if ( $options['image'] != 'false' ) {
		$shortcode_output .= bne_testimonials_featured_image( $options );
	}
	
	// Testimonial Title
	if ( $options['name'] != 'false' ) {
		$shortcode_output .= bne_testimonials_title( $options );
	}

	// Testimonial Tagline and Website URL
	if ( !empty( $options['tagline'] ) || !empty( $options['website_url'] ) ) {
		$shortcode_output .= bne_testimonials_details( $options );
	}

	// Testimonial Content												
	$shortcode_output .= bne_testimonials_the_content( $options );

	return apply_filters( 'bne_testimonials_single_structure', $shortcode_output, $options );
}



/*
 *	Testimonial Featured Image
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Dec 27 2013
*/
function bne_testimonials_featured_image( $options ) {
	
	// If Lightbox Rel is set, apply it to the featured image
	if ($options['lightbox_rel']) {
		$shortcode_output = '<a href="'.$options['lightbox_url'].'" rel="'.$options['lightbox_rel'].'" title="'.$options['lightbox_title'].'">';
			$shortcode_output .= $options['featured_image'];
		$shortcode_output .= '</a>';
	}
	
	// No Lightbox Rel is set, only display the featured image (normal)
	else {
		$shortcode_output = $options['featured_image'];
	}
	
	return apply_filters( 'bne_testimonials_featured_image', $shortcode_output, $options );
}



/*
 *	Testimonial Title 
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Dec 20 2013
*/
function bne_testimonials_title( $options ) {
	
	$shortcode_output = '<h3 class="bne-testimonial-heading">'.get_the_title().'</h3>';
	
	return apply_filters( 'bne_testimonials_title', $shortcode_output, $options );
}



/*
 *	Testimonial Tagline and Website URL Ouput
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Dec 27 2013
*/
function bne_testimonials_details( $options ) {
	
	$shortcode_output = '<div class="bne-testimonial-details">';
	
		// Tagline/Company Name Only
		if ( empty( $options['website_url'] ) ) {
			$shortcode_output .= '<span class="bne-testimonial-tagline">'.$options['tagline'].'</span>';
		}
		
		// Website URL Only
		if ( empty( $options['tagline'] ) ) {
			$shortcode_output .= '<span class="bne-testimonial-website-url"><a href="'.$options['website_url'].'" target="_blank">'.$options['website_url'].'</a></span>';
		}
		
		// Tagline/Company Name and Website URL
		if ( !empty( $options['tagline'] ) && !empty( $options['website_url'] ) ) {
			$shortcode_output .= '<span class="bne-testimonial-website-url"><a href="'.$options['website_url'].'" target="_blank" title="'.$options['tagline'].'">'.$options['tagline'].'</a></span>';
		}
	
	$shortcode_output .= '</div><!-- bne-testimonial-details (end) -->';
	
	return apply_filters( 'bne_testimonials_details', $shortcode_output, $options );
}



/*
 *	Testimonial Post Content Output
 *
 *	@param $options - Pulls in Array
 *
 *	@since v1.1
 *	@updated May 23 2014
*/
function bne_testimonials_the_content( $options ) {
	
	// Format the Content
	$get_content = wpautop( get_the_content() ); 
	
	$shortcode_output = '<div class="bne-testimonial-description">'.$get_content.'</div>';
	
	return apply_filters( 'bne_testimonials_the_content', $shortcode_output, $options );
}