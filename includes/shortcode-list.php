<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Shortcode List Function
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2014, Kerry Kline
 * 	@link		http://www.bluenotesentertainment.com
 *
 *	@updated: December 27, 2013
*/



/* ===========================================================
 *	Shortcode to display Testimonials as a Post List
 *	Example: [bne_testimonials_list]
 *	Accepts param: post, image, name, image_style, class, lightbox_rel
 * ======================================================== */

function bne_testimonials_list_shortcode( $atts ) {
	
	extract(shortcode_atts(array(
		'post' 				=> '-1',		// Number of post
		'order' 			=> 'date',		// Display Post Order (date / rand / title)
		'order_direction'	=> 'DESC',		// Display the order ascending or descending
		'name' 				=> 'true',		// Post Title
		'image' 			=> 'true',		// Featured Image
		'image_style' 		=> 'square',	// Profile image styles ( circle / square / flat-circle / flat-square )
		'category' 			=> '',			// Category (Taxonomy)
		'class'				=> '',			// Add Custom Class
		'lightbox_rel'		=> ''			// Allows the use of a lightbox rel command on the featured image.
	),$atts));

	$query_args = array(
		'post_type' 		=> 'bne_testimonials',
		'order'				=> $order_direction,
		'orderby' 			=> $order,
		'posts_per_page'	=> $post,
		'taxonomy' 			=> 'bne-testimonials-taxonomy',
		'term' 				=> $category
	);


	// Get Shortocde Parameters 
	$featured_image_class = 'bne-testimonial-featured-image '.$image_style;	
	
	// Enqueue our Scripts & Styles
	bne_testimonials_list_enqueue_scripts();
	
	// Setup the Query
	$bne_testimonials = new WP_Query( $query_args );
	if( $bne_testimonials->have_posts() ) {
		
		// BNE Element Wrapper
		$shortcode_output = '<div class="bne-element-container '.$class.'">';

			// Above List Filter
			$shortcode_output .= apply_filters('bne_testimonials_list_above', '');
			
			// Testimonial Wrapper
			$shortcode_output .= '<div class="bne-testimonial-list-wrapper">';
			
				// The Loop
				while ( $bne_testimonials->have_posts() ) : $bne_testimonials->the_post();
	
					// Setup the Post Meta Information 
					$bne_testimonials_id = get_the_ID();
					$tagline =  sanitize_text_field( get_post_meta( $bne_testimonials_id, 'tagline', true ) );
					$website_url = esc_url( get_post_meta( $bne_testimonials_id, 'website-url', true ) );
					
					// Setup Lightbox
					$lightbox_url = wp_get_attachment_image_src( get_post_thumbnail_id($bne_testimonials->post->ID), 'large');
					$lightbox_title = the_title_attribute('echo=0');
					
					// Setup Featured Image
					$featured_image = get_the_post_thumbnail( $bne_testimonials->post->ID, 'thumbnail', array( 'class' => $featured_image_class, 'alt' => " " ) );
					
					// Setup an Array to pass shortcode variables into the build function
					// which allows for filters and customizations to each content area
					// Use Example: $options['key']
					$options = array (
						'bne_testimonials' 	=> $bne_testimonials,	// Query
						'lightbox_rel' 		=> $lightbox_rel,		// Lightbox Rel
						'lightbox_url' 		=> $lightbox_url[0],	// Lightbox URL
						'lightbox_title' 	=> $lightbox_title,		// Lightbox Title
						'featured_image' 	=> $featured_image,		// Testimonial Featured Image
						'image' 			=> $image,				// Image
						'name' 				=> $name,				// Name
						'tagline'			=> $tagline,			// Tagline
						'website_url'		=> $website_url			// Website URL
					);
					

					// Build Single Testimonial
					$shortcode_output .= '<div class="single-bne-testimonial">';

						// Above Single List Filter
						$shortcode_output .= apply_filters('bne_testimonials_list_single_above', '');

						// Single Testimonial Setup Function
						$shortcode_output .= bne_testimonials_single_structure( $options );

						// Below Single List Filter
						$shortcode_output .= apply_filters('bne_testimonials_list_single_below', '');
						
						$shortcode_output .= '<div class="clear"></div>';

					$shortcode_output .= '</div><!-- .single-bne-testimonial (end) -->';
					// END Single Testimonial
					
					
				endwhile;
			
			$shortcode_output .= '</div><!-- .bne-testimonial-list-wrapper (end) -->';


			// Below List Filter
			$shortcode_output .= apply_filters('bne_testimonials_list_below', '');
			
			
		$shortcode_output .= '</div><!-- .bne-element-container (end) -->';
		$shortcode_output .= '<div class="clear"></div>';
	
	// If No Testimonials, display warning message
	} else {
		$shortcode_output = '<div class="bne-testimonial-warning">No testimonials were found.</div>';
	}
	
	wp_reset_postdata();
	return $shortcode_output;
	
}
add_shortcode( 'bne_testimonials_list', 'bne_testimonials_list_shortcode' );