<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Admin Help Page
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2013-2015, Kerry Kline
 * 	@link		http://www.bluenotesentertainment.com
 *
 *	@updated:	February 7, 2015
*/



/* ===========================================================
 *	Setup The submenu under "Testimonials"
 * ======================================================== */

function bne_testimonial_help_menu_link() {
    add_submenu_page(
    	'edit.php?post_type=bne_testimonials',		// Post Type
    	'BNE Testimonial Instructions',				// Page Title
    	'Help',										// Menu Title
    	'edit_posts',								// User Role
    	'bne-testimonial-help',						// Page slug
    	'bne_testimonial_admin_help_page'			// Function call
    );
}
add_action('admin_menu' , 'bne_testimonial_help_menu_link');


/* ===========================================================
 *	Add a Plugin Link to Help Page
 * ======================================================== */

function bne_testimonials_help_plugin_link( $links ) {
    $help_page_link = '<a href="edit.php?post_type=bne_testimonials&page=bne-testimonial-help">' . __( 'Help', 'bne-testimonials' ) . '</a>';
  	array_push( $links, $help_page_link );
  	return $links;
}
add_filter( 'plugin_action_links_'. BNE_TESTIMONIALS_BASENAME, 'bne_testimonials_help_plugin_link' );



/* ===========================================================
 *	Build the Admin Help Page
 * ======================================================== */


function bne_testimonial_admin_help_page() {

	// Load BNE Admin CSS
	wp_enqueue_style('bne-admin-styles', BNE_TESTIMONIALS_URI . '/assets/css/bne-admin.css');

	// Load Thickbox
	add_thickbox();
	?>

	<div id="bne-admin-wrapper" class="wrap">
		<div class="bne-inner">

			<img src="<?php echo BNE_TESTIMONIALS_URI . '/assets/images/help-icon.png';?>"  class="alignleft image-75"  />
			<h1><?php echo __('Testimonial Instructions'); ?></h1>
			<div class="clear"></div>

			<div class="canvas">
				<div class="row">
					<div class="span-two-thirds">

						<div class="widget">
							<h3 class="widget-title">Display Testimonials as a List (shortcode)</h3>
							<p><strong>Shortcode:</strong> [bne_testimonials_list]</p>
							<p>To change the default behavior of this shortcode, include any of the available arguments below. You only need to include them if changing the default behavior.</p>

							<div class="table-responsive">
								<table class="table table-bordered table-responsive">
									<thead>
										<tr>
											<th>Argument</th>
											<th>Default</th>
											<th>Options</th>
											<th style="width: 50%;">Description</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>post="-1"</td>
											<td>-1</td>
											<td>Any numerical value</td>
											<td>Number determines amount of testimonials to display.</td>
										</tr>
										<tr>
											<td>order="date"</td>
											<td>date</td>
											<td>date, rand, or title</td>
											<td>Displays the order of the testimonials based on publish date, random order or alphabetically by title.</td>
										</tr>
										<tr>
											<td>order_direction="DESC"</td>
											<td>DESC</td>
											<td>DESC or ASC</td>
											<td>Displays the testimonials based on the order parameter in either ascending or descending direction.</td>
										</tr>
										<tr>
											<td>name="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>Display the testimonial name/title.</td>
										</tr>
										<tr>
											<td>image="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>Display the testimonial featured image or not.</td>
										</tr>
										<tr>
											<td>image_style="square"</td>
											<td>square</td>
											<td>square, circle, flat-square, flat-circle</td>
											<td>Styles the featured image using one of the four built in styles. Square and Circle will give the image a border, frame and shadow. flat-square and flat-circle will show no border, no frame, and no shadow.</td>
										</tr>
										<tr>
											<td>category="name-of-category"</td>
											<td></td>
											<td></td>
											<td>If you created categories, add the slug you wish to only display. Ex: If the category is "San Diego", the slug will be "san-diego".</td>
										</tr>
										<tr>
											<td>class="name_of_class"</td>
											<td></td>
											<td></td>
											<td>Allows you to add a custom class name to the main shortcode div. This way you can easily style each list/slider testimonial individually based on the class used.</td>
										</tr>
										<tr>
											<td>lightbox_rel="prettyPhoto"</td>
											<td></td>
											<td></td>
											<td>If your theme or another plugin provides a lightbox, you can utilize it here with your testimonial featured images. This only works if the lightbox uses the "rel" attribute on the anchor tag. For example, prettyPhoto uses rel="prettyPhoto".</td>
										</tr>
									</tbody>
								</table>
							</div>

							<p><strong>Example Use:</strong> [bne_testimonials_list post="3" image_style="circle"]</p>
							<p>The above will display only 3 testimonials using the circle featured image style.</p>
						</div><!-- .widget (end) -->

						<div class="widget">
							<h3 class="widget-title">Display Testimonials as a Slider (shortcode)</h3>
							<p><strong>Shortcode:</strong> [bne_testimonials_slider]</p>
							<p>To change the default behavior of this shortcode, include any of the available arguments below. You only need to include them if changing the default behavior.</p>

							<div class="table-responsive">
								<table class="table table-bordered table-responsive">
									<thead>
										<tr>
											<th>Argument</th>
											<th>Default</th>
											<th>Options</th>
											<th style="width: 50%;">Description</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>post="-1"</td>
											<td>-1</td>
											<td>Any numerical value</td>
											<td>Number determines amount of testimonials to display.</td>
										</tr>
										<tr>
											<td>order="date"</td>
											<td>date</td>
											<td>date, rand, or title</td>
											<td>Displays the order of the testimonials based on publish date, random order or alphabetically by title.</td>
										</tr>
										<tr>
											<td>order_direction="DESC"</td>
											<td>DESC</td>
											<td>DESC or ASC</td>
											<td>Displays the testimonials based on the order parameter in either ascending or descending direction.</td>
										</tr>
										<tr>
											<td>name="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>Display the testimonial name/title.</td>
										</tr>
										<tr>
											<td>image="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>Display the testimonial featured image or not.</td>
										</tr>
										<tr>
											<td>image_style="square"</td>
											<td>square</td>
											<td>square, circle, flat-square, flat-circle</td>
											<td>Styles the featured image using one of the four built in styles. Square and Circle will give the image a border, frame and shadow. flat-square and flat-circle will show no border, no frame, and no shadow.</td>
										</tr>
										<tr>
											<td>category="name-of-category"</td>
											<td></td>
											<td></td>
											<td>If you created categories, add the slug you wish to only display. Ex: If the category is "San Diego", the slug will be "san-diego".</td>
										</tr>
										<tr>
											<td>class="name_of_class"</td>
											<td></td>
											<td></td>
											<td>Allows you to add a custom class name to the main shortcode div. This way you can easily style each list/slider testimonial individually based on the class used.</td>
										</tr>
										<tr>
											<td>lightbox_rel="prettyPhoto"</td>
											<td></td>
											<td></td>
											<td>If your theme or another plugin provides a lightbox, you can utilize it here with your testimonial featured images. This only works if the lightbox uses the "rel" attribute on the anchor tag. For example, prettyPhoto uses rel="prettyPhoto".</td>
										</tr>
										<tr>
											<td>animation="slide"</td>
											<td>slide</td>
											<td>slide or fade</td>
											<td>The transition of each testimonial.</td>
										</tr>
										<tr>
											<td>animation_speed="1000"</td>
											<td>700</td>
											<td>Any numerical value</td>
											<td>This determines the speed of the transition, in milliseconds. "1000" would equal to 1 seconds.</td>
										</tr>
										<tr>
											<td>nav="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>Display the pagination buttons.</td>
										</tr>
										<tr>
											<td>arrows="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>Display the directional arrows.</td>
										</tr>
										<tr>
											<td>smooth="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>Height will adjust with a smooth animation based on the amount of content.</td>
										</tr>
										<tr>
											<td>pause="true"</td>
											<td>true</td>
											<td>true or false</td>
											<td>If mouse cursor hovers over slider, slideshow will pause.</td>
										</tr>
										<tr>
											<td>speed="7000"</td>
											<td>7000</td>
											<td>Any numerical value</td>
											<td>This determines the speed of the slideshow cycling, in milliseconds. "7000" would equal to 7 seconds.</td>
										</tr>
									</tbody>
								</table>
							</div>

							<p><strong>Example Use:</strong> [bne_testimonials_slider animation="fade" arrows="false" image_style="flat-circle"]</p>
							<p>The above will transition each testimonial using Fade, not show navigation arrows, and use the flat circle featured image style.</p>
						</div><!-- .widget (end) -->

					</div><!-- .span-two-third (end) -->
					<div class="span-one-third">


						<div class="widget">
							<h3 class="widget-title"><?php echo _e( 'Check out the Pro Version!','bne-testimonials'); ?></h3>
							<a href="http://www.bluenotesentertainment.com/products/testimonials-wordpress-pro/" target="_blank"><img src="<?php echo BNE_TESTIMONIALS_URI . '/assets/images/testimonials-pro-cover.jpg'; ?>" style="max-width: 100%;" class="pretty aligncenter" /></a>
							<p><?php echo _e('Thanks for using the FREE version of BNE Testimonials. Did you know there is a <strong>PRO</strong> version that adds a front-end user submission form and Masonry display grid for your testimonials?', 'bne-testimonials' );?></p>
							 <a href="http://www.bluenotesentertainment.com/products/testimonials-wordpress-pro/" class="button-primary" target="_blank">View Details and Demo</a>
						</div>

						<div class="widget">
							<h3 class="widget-title">Change Log: v<?php echo BNE_TESTIMONIALS_VERSION; ?></h3>
							<div id="changelog">

								<a href="#TB_inline?width=600&height=450&inlineId=changelog_notes" class="thickbox button-primary" title="BNE Testimonials Changelog">View Log</a>

								<div id="changelog_notes" style="display:none;"><br>




									<strong>1.7.0 ( February 7, 2015 )</strong>
									<ul style="list-style:disc;margin-left:20px;">
										<li>IMPORTANT CHANGE: The flexslider html div is now called bne-flexslider. This was done to prevent theme's or other plugins who also use flexslider to not throw their css onto our instance of flexslider and vice versa. Note because of this, any custom CSS edits you may have done to specifically ".bne-testimonial-slider.flexslider {...}" will need to be adjusted to match the new schema. If you used, ".bne-testimonial-slider" only, then you should be fine.</li>
										<li>Updated internal flexslider.js to v2.2.2</li>
										<li>New: Added Animation Speed option to slider shortcode, Ex: [bne_testimonials_slider animation_speed="500"] and to slider widget options.</li>
										<li>New: Now localization Ready!</li>
										<li>Tweak: Cleanup CSS</li>
										<li>Tweak: Admin menu icon now uses the default dashicon call within register_post_type() instead of using css to output the icon.</li>
										<li>Note: Support is only provided for WP 3.8+.</li>
									</ul>


									<strong>August 27, 2014 (1.6.4)</strong>
									<ul style="list-style:disc;margin-left:20px;">
										<li>Fix: An issue would arise on the testimonial post list where if an image was placed in the editor the table columns would shift.</li>
										<li>Add: Sanitize the data output of the website url and tagline fields.</li>
										<li>Compatibility Check: Works great in WP 4.0</li>
									</ul>

									<strong>May 25, 2014 (v1.6.3)</strong>
									<ul style="list-style:disc;margin-left:20px;">
										<li>Removed html tag limitations on get_the_content. All html tags and styles will now output normally from the visual/text editor.</li>
										<li>Adjusted featured image support for themes that don't provide or limit certain post types from using it.</li>
									</ul>

									<p><strong><i>Previous version logs can be viewed on the plugin readme.txt file.</i></strong></p>

								</div>
							</div>
						</div><!-- .widget (end) -->


						<div class="widget">
							<h3 class="widget-title">Style Classes</h3>
							<p>If you know CSS, you can use the below classes to customize the appearance of the testimonials. They would be added to your theme's custom css area or style.css file.</p>
							<p><strong>Global Container:</strong><br>
								.bne-element-container
							</p>
							<p><strong>List View Only:</strong><br>
								.bne-testimonial-list-wrapper<br>
							</p>
							<p>
							<strong>Slider View Only:</strong><br>
								.bne-testimonial-slider-wrapper<br>
							</p>
							<p>
							<strong>Image:</strong><br>
								.bne-testimonial-featured-image<br>
								.bne-testimonial-featured-image.circle<br>
								.bne-testimonial-featured-image.square<br>
								.bne-testimonial-featured-image.flat-circle<br>
								.bne-testimonial-featured-image.flat-square<br>
							</p>
							<p>
							<strong>Heading, Content, Custom Fields:</strong><br>
								.bne-testimonial-heading<br>
								.bne-testimonial-tagline<br>
								.bne-testimonial-website-url<br>
								.bne-testimonial-description
							</p>
						</div><!-- .widget (end) -->

						<div class="widget">
							<h3 class="widget-title">Available Filters</h3>
							<p>Use the following filters to add content above and/or below both the list view and slider views including above and/or below individual (single) testimonials. You would add these into your theme's functions.php file.</p>
							<p><strong>Filters:</strong>:<br>
							"bne_testimonials_list_above"<br>
							"bne_testimonials_list_below"<br>
							"bne_testimonials_list_single_above"<br>
							"bne_testimonials_list_single_below"<br>
							"bne_testimonials_slider_above"<br>
							"bne_testimonials_slider_below"<br>
							"bne_testimonials_slider_single_above"<br>
							"bne_testimonials_slider_single_below"<br>
							"bne_testimonials_featured_image"<br>
							"bne_testimonials_title"<br>
							"bne_testimonials_details"<br>
							"bne_testimonials_the_content"<br>
							"bne_testimonials_single_structure"
							</p>

							<p><strong>Example1:</strong></p>
							<div style="background:#eee; padding: 2px 5px;">
								function my_above_list() {<br>
								&nbsp;&nbsp;&nbsp;$shortcode_output = '&lt;p>My new content.&lt;p>';<br>
								&nbsp;&nbsp;&nbsp;return $shortcode_output;<br>
								}<br>
								add_filter( 'bne_testimonials_list_above', 'my_above_list' );
							</div>


							<p><strong>Example2:</strong></p>
							<div style="background:#eee; padding: 2px 5px;">
								function my_testimonial_the_content( $shortcode_output, $options ) {<br>
								&nbsp;&nbsp;&nbsp;$shortcode_output = '&lt;p>My new content.&lt;p>';<br>
								&nbsp;&nbsp;&nbsp;return $shortcode_output;<br>
								}<br>
								add_filter( 'bne_testimonials_the_content', 'my_testimonial_the_content' );
							</div>

							<p>View the <a href="http://codex.wordpress.org/Function_Reference/add_filter" target="_blank">WP Codex</a> on how to use filters.</p>
							<p><a href="http://www.bluenotesentertainment.com/blog/bne-testimonials-filters/" class="button-primary" target="_blank">View Additional Filters</a></p>
						</div><!-- .widget (end) -->

					</div><!-- .span-one-third (end) -->
				</div><!-- .row (end) -->
			</div><!-- .canvas (end) -->
		</div><!-- .bne-inner (end) -->
	</div><!-- .bne-admin-wrapper.wrap (end) -->

	<?php
} // END Admin Help Page