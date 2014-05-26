<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Widget Slider Class
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2014, Kerry Kline
 * 	@link		http://www.bluenotesentertainment.com
 *
 *	@updated: December 27, 2013
*/


/*
 * @since v1.1
*/
class bne_testimonials_slider_widget extends WP_Widget {

	// Constructor
	function bne_testimonials_slider_widget() {
		parent::WP_Widget(
			false,
			$name = __('BNE Testimonial Slider', 'bne_testimonials_slider_widget'),
			array( 'description' => __('Display your testimonials using as a slider.', 'bne_testimonials_slider_widget') ),
			$control_ops = array('width' => 350)
		);
	}



	// Widget Form Creation
	function form($instance) {
	
		// Check values
		if( $instance) {
			$title = esc_attr($instance['title']);
			$number_of_post = esc_attr($instance['number_of_post']);
			$order = esc_attr($instance['order']);
			$order_direction = esc_attr($instance['order_direction']);
			$category = esc_attr($instance['category']);
			$name = esc_attr($instance['name']);
			$image = esc_attr($instance['image']);
			$image_style = esc_attr($instance['image_style']);
			$animation = esc_attr($instance['animation']);
			$nav = esc_attr($instance['nav']);
			$arrows = esc_attr($instance['arrows']);
			$smooth = esc_attr($instance['smooth']);
			$pause = esc_attr($instance['pause']);
			$speed = esc_attr($instance['speed']);
			$lightbox_rel = esc_attr($instance['lightbox_rel']);
			$class = esc_attr($instance['class']);
		
		} else {
			$title = 'Testimonials';
			$number_of_post = '-1';
			$order = 'date';
			$order_direction = 'DESC';
			$category = '';	//Show All
			$name = 'true';
			$image = 'true';
			$image_style = 'square';
			$animation = 'slide';
			$nav = 'true';
			$arrows = 'true';
			$smooth = 'true';
			$pause = 'true';
			$speed = '7000';
			$lightbox_rel = '';
			$class = '';

		}
		?>
			<!-- Widget Title -->
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'bne_testimonials_slider_widget'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			
			<!-- Query Options -->
			<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">		
				<h4 style="margin:2px 0px;"><?php echo _e('Query Options'); ?></h4>
			
				<!-- Number of Post to Display -->
				<p>
					<label for="<?php echo $this->get_field_id('number_of_post'); ?>"><?php _e('Number of Testimonials', 'bne_testimonials_slider_widget'); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('number_of_post'); ?>" name="<?php echo $this->get_field_name('number_of_post'); ?>" type="text" value="<?php echo $number_of_post; ?>" />
					<span style="display:block;padding:2px 0" class="description">A numerical value. Use "-1" to show all.</span>
				</p>
				
				<!-- Testimonial Orderby -->
				<p>
					<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Testimonial Order (orderby query)', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
						<?php
							echo '<option value="date" id="date"', $order == 'date' ? ' selected="selected"' : '', '>By Published Date</option>';
							echo '<option value="rand" id="rand"', $order == 'rand' ? ' selected="selected"' : '', '>In a Random Order</option>';
							echo '<option value="title" id="title"', $order == 'title' ? ' selected="selected"' : '', '>By Name (alphabetical order)</option>';
						?>
					</select>
				</p>

				<!-- Testimonial Order Direction -->
				<p>
					<label for="<?php echo $this->get_field_id('order_direction'); ?>"><?php _e('Order Direction', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('order_direction'); ?>" id="<?php echo $this->get_field_id('order_direction'); ?>" class="widefat">
						<?php
							echo '<option value="DESC" id="DESC"', $order_direction == 'DESC' ? ' selected="selected"' : '', '>Descending Order</option>';
							echo '<option value="ASC" id="ASC"', $order_direction == 'ASC' ? ' selected="selected"' : '', '>Ascending Order</option>';
						?>
					</select>
					<span style="display:block;padding:2px 0" class="description">Does not apply if the testimonial order is set to random.</span>
				</p>
	
				<!-- Taxonomy Options -->
				<p>
					<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Testimonial Category', 'bne_testimonials_list_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>" class="widefat">
						<?php
						
							// Option to show all taxonomies of this post type (returns empty)
							echo '<option value="" id="show_all"', $category == '' ? ' selected="selected"' : '', '>All Categories</option>';
		
							// Get the ID's of Custom Taxonomies
							$taxonomy_name = "bne-testimonials-taxonomy";
							$tax_args = array(
								'orderby' 		=> 'name',
								'hide_empty' 	=> 1,
								'hierarchical' 	=> 1
							);
							
							$terms = get_terms($taxonomy_name,$tax_args);
							
							foreach($terms as $term) {
								echo '<option value="' . $term->name . '" id="' . $term->name . '"', $category == $term->name ? ' selected="selected"' : '', '>', $term->name, '</option>';
							}
						?>
					</select>
				</p>
			
			</div><!-- Query Options (end) -->

			<!-- Individual Options -->
			<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">		
				<h4 style="margin:2px 0px;"><?php echo _e('Individual Testimonial Options'); ?></h4>

				<!-- Testimonial Name -->
				<p>
					<label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Show Person\'s Name (Testimonial Title)', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('name'); ?>" id="<?php echo $this->get_field_id('name'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $name == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $name == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>
	
				<!-- Testimonial Featured Image -->
				<p>
					<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Show Featured Testimonial Image', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('image'); ?>" id="<?php echo $this->get_field_id('image'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $image == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $image == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>
	
				<!-- Testimonial Featured Image Style -->
				<p>
					<label for="<?php echo $this->get_field_id('image_style'); ?>"><?php _e('Featured Testimonial Image Style', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('image_style'); ?>" id="<?php echo $this->get_field_id('image_style'); ?>" class="widefat">
						<?php
							echo '<option value="square" id="square"', $image_style == 'square' ? ' selected="selected"' : '', '>Square</option>';
							echo '<option value="circle" id="circle"', $image_style == 'circle' ? ' selected="selected"' : '', '>Circle</option>';
							echo '<option value="flat-square" id="flat-square"', $image_style == 'flat-square' ? ' selected="selected"' : '', '>Flat Square</option>';
							echo '<option value="flat-circle" id="flat-circle"', $image_style == 'flat-circle' ? ' selected="selected"' : '', '>Flat Circle</option>';
						?>
					</select>
				</p>
			
			</div><!-- Individual options (end) -->

			<!-- Slider Options -->
			<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">		
				<h4 style="margin:2px 0px;"><?php echo _e('Slider Options'); ?></h4>

				<!-- Slider Animation -->
				<p>
					<label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e('Slider Animation', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('animation'); ?>" id="<?php echo $this->get_field_id('animation'); ?>" class="widefat">
						<?php
							echo '<option value="slide" id="slide"', $animation == 'slide' ? ' selected="selected"' : '', '>Slide</option>';
							echo '<option value="fade" id="fade"', $animation == 'fade' ? ' selected="selected"' : '', '>Fade</option>';
						?>
					</select>
				</p>
				
				<!-- Slider Nav Buttons -->
				<p>
					<label for="<?php echo $this->get_field_id('nav'); ?>"><?php _e('Show Nav Buttons', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('nav'); ?>" id="<?php echo $this->get_field_id('nav'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $nav == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $nav == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>
				
				<!-- Slider Nav Arrows -->
				<p>
					<label for="<?php echo $this->get_field_id('arrows'); ?>"><?php _e('Show Nav Arrows', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('arrows'); ?>" id="<?php echo $this->get_field_id('arrows'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $arrows == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $arrows == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>
				
				<!-- Slider Smooth Height -->
				<p>
					<label for="<?php echo $this->get_field_id('smooth'); ?>"><?php _e('Smooth Height', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('smooth'); ?>" id="<?php echo $this->get_field_id('smooth'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $smooth == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $smooth == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>
	
				<!-- Slider Hover Pause -->
				<p>
					<label for="<?php echo $this->get_field_id('pause'); ?>"><?php _e('Pause on Hover', 'bne_testimonials_slider_widget'); ?>:</label>
					<select name="<?php echo $this->get_field_name('pause'); ?>" id="<?php echo $this->get_field_id('pause'); ?>" class="widefat">
						<?php
							echo '<option value="true" id="true"', $pause == 'true' ? ' selected="selected"' : '', '>Yes</option>';
							echo '<option value="false" id="false"', $pause == 'false' ? ' selected="selected"' : '', '>No</option>';
						?>
					</select>
				</p>
	
				<!-- Slider Cylce Speed -->
				<p>
					<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Time per Slide', 'bne_testimonials_slider_widget'); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" type="text" value="<?php echo $speed; ?>" />
					<span style="display:block;padding:5px 0" class="description">In Milliseconds. (7000 will equal 7 second)</span>
				</p>

			</div><!-- Slider Options (end) -->

			<!-- Advanced Options -->
			<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">		
				<h4 style="margin:2px 0px;"><?php echo _e('Advanced Options'); ?></h4>
				<!-- Lightbox Rel Setting -->
				<p>
					<label for="<?php echo $this->get_field_id('lightbox_rel'); ?>"><?php _e('Featured Image Lightbox', 'bne_testimonials_slider_widget'); ?>: </label>
					<span> rel="</span>
					<input class="widefat" id="<?php echo $this->get_field_id('lightbox_rel'); ?>" name="<?php echo $this->get_field_name('lightbox_rel'); ?>" type="text" value="<?php echo $lightbox_rel; ?>" style="display:inline-block; width: 100px;"/>
					<span>"</span>
					<span style="display:block;padding:5px 0" class="description">Only works if a lightbox plugin is installed or your theme provides one which uses the "rel" attribute on the anchor tag. For example, prettyPhoto uses rel="prettyPhoto".</span>
				</p>
					
				<!-- Custom Class -->
				<p>
					<label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Optional CSS Class Name', 'bne_testimonials_slider_widget'); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo $class; ?>" />
					<span style="display:block;padding:5px 0" class="description">Allows you to target this testimonial widget with a unique class for further css customizations.</span>
				</p>
			</div><!-- Advanced Options (end) -->

		<?php
	}

	
	
	// Update the Widget Settings
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number_of_post'] = strip_tags($new_instance['number_of_post']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['order_direction'] = strip_tags($new_instance['order_direction']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['name'] = strip_tags($new_instance['name']);
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['image_style'] = strip_tags($new_instance['image_style']);
		$instance['animation'] = strip_tags($new_instance['animation']);
		$instance['nav'] = strip_tags($new_instance['nav']);
		$instance['arrows'] = strip_tags($new_instance['arrows']);
		$instance['smooth'] = strip_tags($new_instance['smooth']);
		$instance['pause'] = strip_tags($new_instance['pause']);
		$instance['speed'] = strip_tags($new_instance['speed']);
		$instance['lightbox_rel'] = strip_tags($new_instance['lightbox_rel']);
		$instance['class'] = strip_tags($new_instance['class']);

		return $instance;
	}



	// Display the Widget on the Frontend
	function widget($args, $instance) {
		extract( $args );
			// these are the widget options
			$title = apply_filters('widget_title', $instance['title']);
			$number_of_post = $instance['number_of_post'];
			$order = $instance['order'];
			$order_direction = $instance['order_direction'];
			$category = $instance['category'];
			$name = $instance['name'];
			$image = $instance['image'];
			$image_style = $instance['image_style'];
			$animation = $instance['animation'];
			$nav = $instance['nav'];
			$arrows = $instance['arrows'];
			$smooth = $instance['smooth'];
			$pause = $instance['pause'];
			$speed = $instance['speed'];
			$lightbox_rel = $instance['lightbox_rel'];
			$class = $instance['class'];
	   
		// Before Widget
		echo $before_widget;

		// Testimonial Loop Args 
		$query_args = array(
			'post_type' 		=> 'bne_testimonials',
			'posts_per_page'	=> $number_of_post,
			'order'				=> $order_direction,
			'orderby' 			=> $order,
			'taxonomy' 			=> 'bne-testimonials-taxonomy',
			'term' 				=> $category
		);

		// Set Image Class from Widget Option
		$featured_image_class = 'bne-testimonial-featured-image ' . $image_style;	
	
		// Enqueue our Scripts & Styles
		bne_testimonials_slider_enqueue_scripts();

		// Display the widget
		echo '<div class="bne_testimonial_slider_widget">';

		// Check if Widget title is set
		if ( $title ) {
		  echo $before_title . $title . $after_title;
		}
		
		
		// Begin the Query
		$bne_testimonials = new WP_Query( $query_args );
		if( $bne_testimonials->have_posts() ) {
			
			// Setup a Random ID to accomidate multiple sliders on the same page.
			$slider_random_id = rand(10,100);
			
			// Load Flexslider API Options
			echo '<script type="text/javascript">
						jQuery(document).ready(function($) {
							$(\'#bne-slider-id-'.$slider_random_id.' .bne-testimonial-slider\').flexslider({
								animation:   "'.$animation.'",  					
								smoothHeight: '.$smooth.',
								pauseOnHover: '.$pause.',
								controlNav:   '.$nav.',
								directionNav: '.$arrows.',
								slideshowSpeed: '.$speed.'
							});
						});
					</script>';
	
			// Build Slider
			echo '<div class="bne-element-container '.$class.'">';

				// Above Slider Filter
				echo apply_filters('bne_testimonials_slider_above', '');

				echo '<div id="bne-slider-id-'.$slider_random_id.'" class="bne-testimonial-slider-wrapper">';
					echo '<div class="slides-inner">';
						
						// Build Flexslider
						echo '<div class="bne-testimonial-slider flexslider">';
							echo '<ul class="slides">';
				
								// The Loop
								while ( $bne_testimonials->have_posts() ) : $bne_testimonials->the_post();
						
									// Setup the Post Meta Information 
									$bne_testimonials_id = get_the_ID();
									$tagline = get_post_meta( $bne_testimonials_id, 'tagline', true );
									$website_url = get_post_meta( $bne_testimonials_id, 'website-url', true );
									
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
									echo '<li class="single-bne-testimonial">';
										echo'<div class="flex-content">';

											// Above Single Slider Filter
											echo apply_filters('bne_testimonials_slider_single_above', '');
											
											// Single Testimonial Setup Function
											echo bne_testimonials_single_structure( $options );
									
											// Below Single Slider Filter
											echo apply_filters('bne_testimonials_slider_single_below', '');

											echo '<div class="clear"></div>';
										echo '</div><!-- .flex-content (end) -->';
									echo '</li><!-- .single-bne-testimonial (end) -->';
									// END Single Testimonial
									
								endwhile;
					
							echo '</ul><!-- .slides (end) -->';
						echo '</div><!-- bne-testimonial-slider.flexslider (end) -->';
					echo '</div><!-- .slides-inner (end) -->';
				echo '</div><!-- bne-testimonial-wrapper (end) -->';

				// Below Slider Filter
				echo apply_filters('bne_testimonials_slider_below', '');


			echo '</div><!-- bne-element-container (end) -->';
			echo '<div class="clear"></div>';
		
		// If No Testimonials, display warning message
		} else {
			echo '<div class="bne-testimonial-warning">No testimonials were found.</div>';
		}
		
		wp_reset_postdata();

		echo '</div><!-- bne_testimonial_slider_widget (end) -->';
		echo $after_widget;
	}

}

// Register Widget
add_action('widgets_init', create_function('', 'return register_widget("bne_testimonials_slider_widget");'));