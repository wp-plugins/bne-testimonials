<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Shortcode Slider Function
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2013-2015, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *
 *	@updated: February 7, 2015
*/



/* ===========================================================
 *	Shortcode to display Testimonials using Flexslider
 *	Example: [bne_testimonials_slider]
 *	Accepts param: post, image, image_style, nav, arrows, pause,
 *	animation, smooth, class, speed, lightbox_rel
 * ======================================================== */


function bne_testimonials_slider_shortcode( $atts ) {

	extract(shortcode_atts(array(
		'post' 				=> '-1',		// Number of post
		'order' 			=> 'date',		// Display Post Order (date / rand / title)
		'order_direction'	=> 'DESC',		// Display the order ascending or descending
		'category' 			=> '',			// The Testimonial Category
		'name' 				=> 'true',		// Post Title
		'image' 			=> 'true',		// Featured Image
		'image_style' 		=> 'square',	// Profile image styles ( circle / square / flat-circle / flat-square )
		'lightbox_rel'		=> '',			// Allows the use of a lightbox rel command on the featured image.
		'class'				=> '',			// Add Custom Class to this particular slider
		'nav' 				=> 'true',		// Flexslider: controlNav
		'arrows' 			=> 'true',		// Flexslider: directionNav
		'pause' 			=> 'true',		// Flexslider: pauseOnHover
		'animation' 		=> 'slide',		// Flexslider: animation
		'animation_speed'	=> '700',		// Flexslider: animationSpeed
		'smooth' 			=> 'true',		// Flexslider: smoothHeight
		'speed'				=> '7000'		// Flexsliser: slideshowSpeed
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
	$featured_image_class = 'bne-testimonial-featured-image ' . $image_style;

	// Enqueue our Scripts & Styles
	bne_testimonials_slider_enqueue_scripts();

	// Setup the Query
	$bne_testimonials = new WP_Query( $query_args );
	if( $bne_testimonials->have_posts() ) {

		// Setup a Random ID to accomidate multiple sliders on the same page.
		$slider_random_id = rand(1,1000);

		// Load Flexslider API
		$shortcode_output = '<script type="text/javascript">
								jQuery(document).ready(function($) {
									$(\'#bne-slider-id-'.$slider_random_id.' .bne-testimonial-slider\').flexslider({
										animation:     "'.$animation.'",
										animationSpeed: '.$animation_speed.',
										smoothHeight: 	'.$smooth.',
										pauseOnHover: 	'.$pause.',
										controlNav:   	'.$nav.',
										directionNav: 	'.$arrows.',
										slideshowSpeed: '.$speed.'
									});
								});
							</script>';

		// Build Slider
		$shortcode_output .= '<div class="bne-element-container '.$class.'">';

			// Above Slider Filter
			$shortcode_output .= apply_filters('bne_testimonials_slider_above', '');

			$shortcode_output .= '<div id="bne-slider-id-'.$slider_random_id.'" class="bne-testimonial-slider-wrapper">';
				$shortcode_output .= '<div class="slides-inner">';

					// Build Flexslider
					$shortcode_output .= '<div class="bne-testimonial-slider bne-flexslider">';
						$shortcode_output .= '<ul class="slides">';

							// The Loop
							while ( $bne_testimonials->have_posts() ) : $bne_testimonials->the_post();

								// Pull in Plugin Options
								$options = bne_testimonials_options_array( $image_style, $lightbox_rel, $image, $name );

								// Build Single Testimonial
								$shortcode_output .= '<li class="single-bne-testimonial">';
									$shortcode_output .='<div class="flex-content">';

										// Above Single Slider Filter
										$shortcode_output .= apply_filters('bne_testimonials_slider_single_above', '');

										// Single Testimonial Setup Function
										$shortcode_output .= bne_testimonials_single_structure( $options );

										// Below Single Slider Filter
										$shortcode_output .= apply_filters('bne_testimonials_slider_single_below', '');

										$shortcode_output .= '<div class="clear"></div>';
									$shortcode_output .= '</div><!-- .flex-content (end) -->';
								$shortcode_output .= '</li><!-- .single-bne-testimonial (end) -->';

							endwhile;
							// End Loop

						$shortcode_output .= '</ul><!-- .slides (end) -->';
					$shortcode_output .= '</div><!-- bne-testimonial-slider.bne-flexslider (end) -->';
				$shortcode_output .= '</div><!-- .slides-inner (end) -->';
			$shortcode_output .= '</div><!-- bne-testimonial-wrapper (end) -->';

			// Below Slider Filter
			$shortcode_output .= apply_filters('bne_testimonials_slider_below', '');

		$shortcode_output .= '</div><!-- bne-element-container (end) -->';
		$shortcode_output .= '<div class="clear"></div>';

	// If No Testimonials, display warning message
	} else {
		$shortcode_output = '<div class="bne-testimonial-warning">No testimonials were found.</div>';
	}

	wp_reset_postdata();
	return $shortcode_output;

}
add_shortcode( 'bne_testimonials_slider', 'bne_testimonials_slider_shortcode' );