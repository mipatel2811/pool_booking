<?php
/**
 * WP Fanzone Theme Customizer
 *
 * @package WP Fanzone
 */

/*******************************************************************
* These are settings for the Theme Customizer in the admin panel. 
*******************************************************************/
if ( ! function_exists( 'wp_fanzone_theme_customizer' ) ) :
	function wp_fanzone_theme_customizer( $wp_customize ) {
		
		$wp_customize->remove_section( 'title_tagline');

		
		/* logo option */
		$wp_customize->add_section( 'wp_fanzone_logo_section' , array(
			'title'       => __( 'Site Logo', 'wp-fanzone' ),
			'priority'    => 29,
			'description' => __( 'Upload a logo to replace the default site name in the header', 'wp-fanzone' ),
		) );
		
		$wp_customize->add_setting( 'wp_fanzone_logo', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wp_fanzone_logo', array(
			'label'    => __( 'Choose your logo (ideal width is 100-300px and ideal height is 40-100px)', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_logo_section',
			'settings' => 'wp_fanzone_logo',
		) ) );
		
		
		/* color theme */
		$wp_customize->add_setting( 'wp_fanzone_theme_color', array (
			'default' => '#339390',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wp_fanzone_theme_color', array(
			'label'    => __( 'Theme Color Option', 'wp-fanzone' ),
			'section'  => 'colors',
			'settings' => 'wp_fanzone_theme_color',
			'priority' => 31,
		) ) );
	
		
		/* social media option */
		$wp_customize->add_section( 'wp_fanzone_social_section' , array(
			'title'       => __( 'Social Media Icons', 'wp-fanzone' ),
			'priority'    => 32,
			'description' => __( 'Optional social media buttons in the header', 'wp-fanzone' ),
		) );
		
		$wp_customize->add_setting( 'wp_fanzone_facebook', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_facebook', array(
			'label'    => __( 'Enter your Facebook url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_facebook',
			'priority'    => 101,
		) ) );
	
		$wp_customize->add_setting( 'wp_fanzone_twitter', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_twitter', array(
			'label'    => __( 'Enter your Twitter url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_twitter',
			'priority'    => 102,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_google', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_google', array(
			'label'    => __( 'Enter your Google+ url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_google',
			'priority'    => 103,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_pinterest', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_pinterest', array(
			'label'    => __( 'Enter your Pinterest url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_pinterest',
			'priority'    => 104,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_linkedin', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_linkedin', array(
			'label'    => __( 'Enter your Linkedin url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_linkedin',
			'priority'    => 105,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_youtube', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_youtube', array(
			'label'    => __( 'Enter your Youtube url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_youtube',
			'priority'    => 106,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_tumblr', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_tumblr', array(
			'label'    => __( 'Enter your Tumblr url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_tumblr',
			'priority'    => 107,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_instagram', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_instagram', array(
			'label'    => __( 'Enter your Instagram url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_instagram',
			'priority'    => 108,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_flickr', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_flickr', array(
			'label'    => __( 'Enter your Flickr url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_flickr',
			'priority'    => 109,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_vimeo', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_vimeo', array(
			'label'    => __( 'Enter your Vimeo url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_vimeo',
			'priority'    => 110,
		) ) );
		
			
		$wp_customize->add_setting( 'wp_fanzone_rss', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_rss', array(
			'label'    => __( 'Enter your RSS url', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_rss',
			'priority'    => 111,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_email', array (			
			'sanitize_callback' => 'sanitize_email',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_email', array(
			'label'    => __( 'Enter your email address', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_social_section',
			'settings' => 'wp_fanzone_email',
			'priority'    => 112,
		) ) );
		
		// author bio in posts option 
		$wp_customize->add_section( 'wp_fanzone_author_bio_section' , array(
			'title'       => __( 'Display Author Bio', 'wp-fanzone' ),
			'priority'    => 113,
			'description' => __( 'Option to show/hide the author bio in the posts.', 'wp-fanzone' ),
		) );
		
		$wp_customize->add_setting( 'wp_fanzone_author_bio', array (
			'default'        => '1',
			'sanitize_callback' => 'wp_fanzone_sanitize_checkbox',
		) );
		
		 $wp_customize->add_control('wp_fanzone_author_bio', array(
			'settings' => 'wp_fanzone_author_bio',
			'label' => __('Show the author bio in posts?', 'wp-fanzone'),
			'section' => 'wp_fanzone_author_bio_section',
			'type' => 'checkbox',
		));
		
		
		//slider
		
		
		$categories = get_categories();
				$cats = array();
				$i = 0;
				foreach($categories as $category){
					if($i==0){
						$default = $category->slug;
						$i++;
					}
					$cats[$category->slug] = $category->name;
				}	
		
		
		//  Select Box               
		$wp_customize->add_section('wp_fanzone_slider', array(
        'title'    => __('Slider Option', 'wp-fanzone'),
        'priority' => 114,
		));
		$wp_customize->add_setting('wp_fanzone_disable_slider', array(
			'default'        => 0,
			'sanitize_callback' => 'wp_fanzone_sanitize_checkbox',
		));
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_disable_slider', array(
			'label'    => __( 'Disable Slider', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_slider',
			'settings' => 'wp_fanzone_disable_slider',
			'type'     => 'checkbox',
			'priority'    => 115,
		) ) );
		 
		
		$wp_customize->add_setting(
			'wp_fanzone_category',
			array(
				'default' => '1',
				'sanitize_callback' => 'wp_fanzone_sanitize_category',
			)
		);
		 
		$wp_customize->add_control(
			'wp_fanzone_category',
			array(
				'type' => 'select',
				'label' => 'Select Category:',
				'section' => 'wp_fanzone_slider',
				'choices' => $cats,
				'priority'    => 116,
			)
		);
		
		$wp_customize->add_setting('wp_fanzone_hide_slider_thumb', array(
			'default'        => 0,
			'sanitize_callback' => 'wp_fanzone_sanitize_checkbox',
		));
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_hide_slider_thumb', array(
			'label'    => __( 'Hide Slider Thumbnails', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_slider',
			'settings' => 'wp_fanzone_hide_slider_thumb',
			'type'     => 'checkbox',
			'priority'    => 117,
		) ) );
		
		$wp_customize->add_setting( 'wp_fanzone_slider_speed', array (
			'default' => '6000',
			'sanitize_callback' => 'wp_fanzone_sanitize_integer',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_fanzone_slider_speed', array(
			'label'    => __( 'Slider Speed (milliseconds)', 'wp-fanzone' ),
			'section'  => 'wp_fanzone_slider',
			'settings' => 'wp_fanzone_slider_speed',
			'priority'    => 118,
		) ) );
				
		
		
	}
endif;
add_action('customize_register', 'wp_fanzone_theme_customizer');



if ( ! function_exists( 'wp_fanzone_sanitize_category' ) ){
	function wp_fanzone_sanitize_category( $input ) {
		$categories = get_categories();
		$cats = array();
		$i = 0;
		foreach($categories as $category){
			if($i==0){
				$default = $category->slug;
				$i++;
			}
			$cats[$category->slug] = $category->name;
		}
		$valid = $cats;
	 
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
}
/**
 * Sanitize integer input
 */
if ( ! function_exists( 'wp_fanzone_sanitize_integer' ) ) :
	function wp_fanzone_sanitize_integer( $input ) {		
		return absint($input);
	}
endif;

/**
 * Sanitize checkbox
 */
if ( ! function_exists( 'wp_fanzone_sanitize_checkbox' ) ) :
	function wp_fanzone_sanitize_checkbox( $input ) {
		if ( $input != 1 ) {
			return 0;
		} else {
			return 1;
		}
	}
endif;

/**
* Apply Color Scheme
*/
if ( ! function_exists( 'wp_fanzone_apply_color' ) ) :
  function wp_fanzone_apply_color() {
	 if ( get_theme_mod('wp_fanzone_theme_color') ) {
	?>
	<style id="color-settings">
	<?php if ( get_theme_mod('wp_fanzone_theme_color') ) : ?>
		.btn-info, .btn-default, .main-navigation li:hover > a, .main-navigation ul ul a, .main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .navbar-toggle .icon-bar, .main-navigation .current_page_ancestor > a, #copyright, #respond #submit, .post-content form input[type=submit], .post-content form input[type=button], .widget-title h4, .pagination .fa, #footer .widget_calendar thead tr, .site-info, footer .widget_calendar thead tr{
			background-color:<?php echo esc_url(get_theme_mod('wp_fanzone_theme_color')); ?>;
			}
		.top-bar, .btn-info, .nav_container, #footer, .navbar-default .navbar-toggle, footer#colophon{
			border-color:<?php echo esc_url(get_theme_mod('wp_fanzone_theme_color')); ?>;
		}
		aside ul li a, .pagination a, h4.author-title a, .author-info a, cite.fn, a.comment-reply-link, comment-meta a, a.comment-edit-link, .logged-in-as a, .widget_tag_cloud a, .widget_calendar td a, .widget_calendar td a, footer .meta-info span, footer .meta-info a, footer ul li a:hover, .meta-info a:hover, ul li.recentcomments, .post_box a.meta-comment:hover, .entry a:hover, .entry a:focus, .entry a, #breadcrumbs a, #breadcrumbs a:hover, .meta-info, .post a{
		color:<?php echo esc_attr(get_theme_mod('wp_fanzone_theme_color')); ?>;
		}
		.arrow-right{
			border-left: 10px solid <?php echo esc_attr(get_theme_mod('wp_fanzone_theme_color')); ?>;
		}
	<?php endif; ?>
	</style>
	<?php	  
	} 
  }
endif;
add_action( 'wp_head', 'wp_fanzone_apply_color' );

if ( ! function_exists( 'wp_fanzone_hide_slide_thumb' ) ) :
	function wp_fanzone_hide_slide_thumb() {
		if (get_theme_mod('wp_fanzone_hide_slider_thumb') ) {
		?>
        <style>
			ul.pgwSlider{display:none;}
			.pgwSlider .ps-current{width:100%;}			
		</style>
		<?php
		}
	}
endif;
add_action( 'wp_head', 'wp_fanzone_hide_slide_thumb' );