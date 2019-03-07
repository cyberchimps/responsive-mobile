<?php
/**
 * Responsive Mobile Theme Customizer
 *
 * @package responsive
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function responsive_mobile_load_customize_controls() {

    require_once( trailingslashit( get_template_directory() ) . 'core/control-checkbox-multiple.php' );
}
add_action( 'customize_register', 'responsive_mobile_load_customize_controls', 0 );

function responsive_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

/*--------------------------------------------------------------
	// Theme Elements
--------------------------------------------------------------*/
	$wp_customize->add_section( 'rate_us', array(
		'title'                 => __( 'Rate Us', 'responsive-mobile' ),
		'description'		=> 'Description'
	) );

	$wp_customize->add_section( 'theme_elements', array(
		'title'                 => __( 'Theme Elements', 'responsive-mobile' ),
		'description'		=> 'Description',
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[featured_images]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_featured_images', array(
		'label'                 => __( 'Enable featured images?', 'responsive-mobile' ),
		'section'               => 'theme_elements',
		'settings'              => 'responsive_mobile_theme_options[featured_images]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[breadcrumb]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_breadcrumb', array(
		'label'                 => __( 'Disable breadcrumb list?', 'responsive-mobile' ),
		'section'               => 'theme_elements',
		'settings'              => 'responsive_mobile_theme_options[breadcrumb]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[cta_button]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_cta_button', array(
		'label'                 => __( 'Disable Call to Action Button?', 'responsive-mobile' ),
		'section'               => 'theme_elements',
		'settings'              => 'responsive_mobile_theme_options[cta_button]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[minified_css]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_minified_css', array(
		'label'                 => __( 'Enable minified css?', 'responsive-mobile' ),
		'section'               => 'theme_elements',
		'settings'              => 'responsive_mobile_theme_options[minified_css]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[blog_post_title_toggle]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_blog_post_title_toggle', array(
		'label'                 => __( 'Enable Blog Title', 'responsive-mobile' ),
		'section'               => 'theme_elements',
		'settings'              => 'responsive_mobile_theme_options[blog_post_title_toggle]',
		'type'                  => 'checkbox'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[blog_post_title_text]', array( 'sanitize_callback' => 'sanitize_text_field', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_blog_post_title_text', array(
		'label'                 => __( 'Title Text', 'responsive-mobile' ),
		'section'               => 'theme_elements',
		'settings'              => 'responsive_mobile_theme_options[blog_post_title_text]',
		'type'                  => 'text'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[sticky_header]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_sticky_header', array(
		'label'                 => __( 'Enable Sticky Header', 'responsive-mobile' ),
		'section'               => 'theme_elements',
		'settings'              => 'responsive_mobile_theme_options[sticky_header]',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[footer_widget_layout]', array( 'sanitize_callback' => 'responsive_sanitize_default_footer_layouts', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_static_page_footer_layout_default', array(
			'label'                 => __( 'Choose Footer Widget Layout', 'responsive-mobile' ),
			'section'               => 'theme_elements',
			'settings'              => 'responsive_mobile_theme_options[footer_widget_layout]',
			'type'                  => 'select',
			'choices'               => responsive_mobile_footer_layouts()
	) );



	$option_categories = array();
	$category_lists = get_categories();
	$option_categories[''] = esc_html(__( 'Choose Category', 'responsive-mobile' ));
	foreach( $category_lists as $category ){
		$option_categories[$category->term_id] = $category->name;
	}

	$option_all_post_cat = array();
	foreach( $category_lists as $category ){
		$option_all_post_cat[$category->term_id] = $category->name;
	}

/*--------------------------------------------------------------
	// Home Page
--------------------------------------------------------------*/

	$wp_customize->add_section( 'home_page', array(
		'title'                 => __( 'Home Page', 'responsive-mobile' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[front_page]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_front_page', array(
		'label'                 => __( 'Enable Custom Front Page', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[front_page]',
		'type'                  => 'checkbox',
		'description'           => __( 'Overrides the WordPress front page option', 'responsive-mobile' )
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[home_headline]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'HAPPINESS', 'responsive-mobile' ), 'placeholder' => __( 'HAPPINESS', 'responsive-mobile' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_home_headline', array(
		'label'                 => __( 'Headline', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[home_headline]',
		'type'                  => 'text'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[home_subheadline]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'IS A WARM CUP', 'responsive-mobile' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_home_subheadline', array(
		'label'                 => __( 'Subheadline', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[home_subheadline]',
		'type'                  => 'text'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[home_content_area]',array( 'sanitize_callback' => 'responsive_sanitize_textarea', 'default' => __( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'responsive-mobile' ), 'transport' => 'postMessage', 'type' => 'option') );
	$wp_customize->add_control( 'res_home_content_area', array(
		'label'                 => __( 'Content Area', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[home_content_area]',
		'type'                  => 'textarea'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[cta_url]', array( 'sanitize_callback' => 'esc_url_raw','default' => '#nogo','transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_cta_url', array(
		'label'                 => __( 'Call to Action (URL)', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[cta_url]',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[cta_text]', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Call to Action', 'placeholder' => '123' ,'transport' => 'postMessage', 'type' => 'option') );
	$wp_customize->add_control( 'res_cta_text', array(
		'label'                 => __( 'Call to Action (Text)', 'responsive-mobile' ),
		'content'		=> 'asdf',
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[cta_text]',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[featured_content]', array( 'sanitize_callback' => 'responsive_sanitize_textarea', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_featured_content', array(
		'label'                 => __( 'Featured Content', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[featured_content]',
		'type'                  => 'textarea',
		'description'           => __( 'Paste your shortcode, video or image source', 'responsive-mobile' )
	) );

/************************Services******************************/
        $wp_customize->add_setting( 'responsive_mobile_theme_options[services_toggle_btn]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_services_toggle_btn', array(
		'label'                 => __( 'Enable Services Section', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[services_toggle_btn]',
		'type'                  => 'checkbox'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[services_title]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'Our Services', 'responsive-mobile' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_services_title_text', array(
		'label'                 => __( 'Services Section Title', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[services_title]',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[services_cat]', array( 'sanitize_callback' => 'absint', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_default_category_services', array(
		'label'                 => __( 'Select posts category', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[services_cat]',
		'type'                  => 'select',
		'description'           => __( 'The featured image, title and content from the selected post caategory will be used. Recommended image size for the featured images: 164 x 164px', 'responsive-mobile' ),
		'choices'               => $option_categories
	) );

        $wp_customize->add_setting( 'responsive_mobile_theme_options[services_featured_image]', array( 'sanitize_callback' => 'esc_url_raw','transport' => 'refresh', 'type' => 'option' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'responsive_mobile_theme_options[services_featured_image]', array(
    'label'    => __( 'Services Featured Image ', 'responsive-mobile' ),
    'description' => 'Recommended Image size is 1366px X 273px.',
    'section'  => 'home_page',
    'settings' => 'responsive_mobile_theme_options[services_featured_image]',
) ) );
/************************Callout******************************/

	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_toggle_btn]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_callout_toggle_btn', array(
		'label'                 => __( 'Enable Callout Element', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[callout_toggle_btn]',
		'type'                  => 'checkbox'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_headline]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'HAPPINESS', 'responsive-mobile' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_callout_headline', array(
		'label'                 => __( 'Headline', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[callout_headline]',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_content_area]',array( 'sanitize_callback' => 'responsive_sanitize_textarea', 'default' => __( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'responsive-mobile' ), 'transport' => 'postMessage', 'type' => 'option') );
	$wp_customize->add_control( 'res_callout_content_area', array(
		'label'                 => __( 'Content Area', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[callout_content_area]',
		'type'                  => 'textarea'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_text_color]', array(
			'sanitize_callback' => 'sanitize_text_field',
			'type' => 'option',
			'transport' => 'postMessage',
			'default' => ''
		    ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'responsive_mobile_theme_options[callout_text_color]', array(
			'label' => __( 'Callout Text (Color)', 'responsive-mobile' ),
			'section' => 'home_page',
			'settings' => 'responsive_mobile_theme_options[callout_text_color]',
		) ) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_cta_url]', array( 'sanitize_callback' => 'esc_url_raw','default' => '#nogo','transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_callout_cta_url', array(
		'label'                 => __( 'Callout Button (URL)', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[callout_cta_url]',
		'type'                  => 'text'
	) );


	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_cta_text]', array( 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Call to Action', 'transport' => 'postMessage', 'type' => 'option') );
	$wp_customize->add_control( 'res_callout_cta_text', array(
		'label'                 => __( 'Callout Button (Text)', 'responsive-mobile' ),
		'content'		=> 'asdf',
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[callout_cta_text]',
		'type'                  => 'text'
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_btn_text_color]', array(
			'sanitize_callback' => 'sanitize_text_field',
			'type' => 'option',
			'transport' => 'postMessage',
			'default' => ''
		    ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'responsive_mobile_theme_options[callout_btn_text_color]', array(
			'label' => __( 'Callout Button ( Text Color)', 'responsive-mobile' ),
			'section' => 'home_page',
			'settings' => 'responsive_mobile_theme_options[callout_btn_text_color]',
		) ) );


	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_btn_back_color]', array(
			'sanitize_callback' => 'sanitize_text_field',
			'type' => 'option',
			'transport' => 'postMessage',
			'default' => ''
		    ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'responsive_mobile_theme_options[callout_btn_back_color]', array(
			'label' => __( 'Callout Button ( Background Color)', 'responsive-mobile' ),
			'section' => 'home_page',
			'settings' => 'responsive_mobile_theme_options[callout_btn_back_color]',
		) ) );



	$wp_customize->add_setting( 'responsive_mobile_theme_options[callout_featured_content]', array( 'sanitize_callback' => 'esc_url_raw','transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'responsive_mobile_theme_options[callout_featured_content]', array(
    'label'    => __( 'Callout background', 'responsive-mobile' ),
    'description' => 'Recommended Image size is 1366px X 273px.',
    'section'  => 'home_page',
    'settings' => 'responsive_mobile_theme_options[callout_featured_content]',
) ) );
         $wp_customize->add_setting( 'responsive_mobile_theme_options[callout_featured_content]', array( 'sanitize_callback' => 'esc_url_raw','transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'responsive_mobile_theme_options[callout_featured_content]', array(
        'label'    => __( 'Callout background', 'responsive-mobile' ),
        'description' => 'Recommended Image size is 1366px X 273px.',
        'section'  => 'home_page',
        'settings' => 'responsive_mobile_theme_options[callout_featured_content]',
        ) ) );

/************************   Testimonial  ******************************/
        $wp_customize->add_setting( 'responsive_mobile_theme_options[testimonial_toggle_btn]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_testimonial_toggle_btn', array(
		'label'                 => __( 'Enable Testimonial Section', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[testimonial_toggle_btn]',
		'type'                  => 'checkbox'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[testimonial_title]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'Testimonial', 'responsive-mobile' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_testimonial_title', array(
		'label'                 => __( 'Testimonial Section Title', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[testimonial_title]',
		'type'                  => 'text'
	) );

        $wp_customize->add_setting( 'responsive_mobile_theme_options[testimonial_cat]', array( 'sanitize_callback' => 'absint', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_testimonial_cat', array(
		'label'                 => __( 'Select posts category', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[testimonial_cat]',
		'type'                  => 'select',
		'description'           => __( 'The featured image, title and content from the selected post caategory will be used. Recommended image size for the featured images: 164 x 164px', 'responsive-mobile' ),
		'choices'               => $option_categories
	) );

    /************************   Team Section  ******************************/

	$wp_customize->add_setting( 'responsive_mobile_theme_options[team]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_team_seaction_toggle', array(
		'label'                 => __( 'Enable Team Section(on homepage)', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[team]',
		'type'                  => 'checkbox'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[team_title]', array( 'sanitize_callback' => 'sanitize_text_field', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_team_title_text', array(
		'label'                 => __( 'Title Text', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[team_title]',
		'type'                  => 'text'
	) );
         $wp_customize->add_setting( 'responsive_mobile_theme_options[team_val]', array( 'sanitize_callback' => 'absint', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_default_category_team', array(
		'label'                 => __( 'Select posts category', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[team_val]',
		'type'                  => 'select',
		'description'           => __( 'The featured image, title and content from the selected post caategory will be used. Recommended image size for the featured images: 164 x 164px', 'responsive-mobile' ),
		'choices'               => $option_categories
	) );

/************************   Contact Us Section  ******************************/
// Code commented by Manju as contact section is alreasy there in Pro Features plugin

        /* $wp_customize->add_setting( 'responsive_mobile_theme_options[enable_contact]', array( 'sanitize_callback' => 'responsive_sanitize_checkbox', 'transport' => 'postMessage', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_enable_contact', array(
		'label'                 => __( 'Enable Contact Section', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[enable_contact]',
		'type'                  => 'checkbox'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[contact_title]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','default' => __( 'Get In Touch', 'responsive-mobile' ), 'type' => 'option' ));
	$wp_customize->add_control( 'res_contact_title', array(
		'label'                 => __( 'Contact Section Title', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[contact_title]',
		'type'                  => 'text'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[contact_address]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','type' => 'option' ));
	$wp_customize->add_control( 'res_contact_address', array(
		'label'                 => __( 'Contact Address', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[contact_address]',
		'type'                  => 'text'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[contact_number]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage', 'type' => 'option' ));
	$wp_customize->add_control( 'res_contact_number', array(
		'label'                 => __( 'Contact Number', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[contact_number]',
		'type'                  => 'text'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[contact_email]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage', 'type' => 'option' ));
	$wp_customize->add_control( 'res_contact_email', array(
		'label'                 => __( 'Contact Email', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[contact_email]',
		'type'                  => 'text'
	) );
        $wp_customize->add_setting( 'responsive_mobile_theme_options[contact_form]', array( 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage','type' => 'option' ));
	$wp_customize->add_control( 'res_contact_form', array(
		'label'                 => __( 'Additional Data', 'responsive-mobile' ),
		'section'               => 'home_page',
		'settings'              => 'responsive_mobile_theme_options[contact_form]',
		'type'                  => 'text'
	) ); */

/*--------------------------------------------------------------
	// Default Layouts
--------------------------------------------------------------*/

	$wp_customize->add_section( 'blog_page', array(
			'title'    => __( 'Blog page Settings', 'responsive-mobile' ),
			'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_mobile_exclude_post_cat', array( 'sanitize_callback' => 'responsive_sanitize_multiple_checkboxes') );
	$wp_customize->add_control(
			new responsive_mobile_Customize_Control_Checkbox_Multiple(
					$wp_customize,
					'responsive_mobile_exclude_post_cat',
					array(
							'section'       => 'blog_page',
							'label'         => __( 'Exclude Categories from Blog page', 'responsive-mobile' ),
							'description'   => __( 'Please choose the post categories that should not be displayed on the blog page', 'responsive-mobile' ),
							'settings'      => 'responsive_mobile_exclude_post_cat',
							'choices'       => $option_all_post_cat
					)
			)
	);

	$wp_customize->add_section( 'default_layouts', array(
		'title'                 => __( 'Default Layouts', 'responsive-mobile' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[static_page_layout_default]', array( 'sanitize_callback' => 'responsive_sanitize_default_layouts', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_static_page_layout_default', array(
		'label'                 => __( 'Default Static Page Layout', 'responsive-mobile' ),
		'section'               => 'default_layouts',
		'settings'              => 'responsive_mobile_theme_options[static_page_layout_default]',
		'type'                  => 'select',
		'choices'               => responsive_mobile_valid_layouts()
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[single_post_layout_default]', array( 'sanitize_callback' => 'responsive_sanitize_default_layouts', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_single_post_layout_default', array(
		'label'                 => __( 'Default Single Blog Post Layout', 'responsive-mobile' ),
		'section'               => 'default_layouts',
		'settings'              => 'responsive_mobile_theme_options[single_post_layout_default]',
		'type'                  => 'select',
		'choices'               => responsive_mobile_valid_layouts()
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[blog_posts_index_layout_default]', array( 'sanitize_callback' => 'responsive_sanitize_blog_layouts', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_hblog_posts_index_layout_default', array(
		'label'                 => __( 'Default Blog Posts Index Layout', 'responsive-mobile' ),
		'section'               => 'default_layouts',
		'settings'              => 'responsive_mobile_theme_options[blog_posts_index_layout_default]',
		'type'                  => 'select',
		'choices'               => responsive_mobile_valid_blog_layouts()
	) );

/*--------------------------------------------------------------
	// SOCIAL MEDIA SECTION
--------------------------------------------------------------*/

	$wp_customize->add_section( 'responsive_social_media', array(
		'title'             => __( 'Social Icons', 'responsive-mobile' ),
		'priority'          => 40,
		'description'       => __( 'Enter the URL to your account for each service for the icon to appear in the header.', 'responsive-mobile' ),
	) );

	// Add Twitter Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[twitter_uid]', array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_twitter', array(
		'label'             => __( 'Twitter', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[twitter_uid]'
	) ) );

	// Add Facebook Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[facebook_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_facebook', array(
		'label'             => __( 'Facebook', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[facebook_uid]'
	) ) );

	// Add LinkedIn Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[linkedin_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_linkedin', array(
		'label'             => __( 'LinkedIn', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[linkedin_uid]'
	) ) );

	// Add Youtube Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[youtube_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_youtube', array(
		'label'             => __( 'YouTube', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[youtube_uid]'
	) ) );

	// Add Google+ Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[googleplus_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_googleplus', array(
		'label'             => __( 'Google+', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[googleplus_uid]'
	) ) );

	// Add RSS Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[rss_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_rss', array(
		'label'             => __( 'RSS Feed', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[rss_uid]'
	) ) );

	// Add Instagram Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[instagram_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_instagram', array(
		'label'             => __( 'Instagram', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[instagram_uid]'
	) ) );

	// Add Pinterest Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[pinterest_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_pinterest', array(
		'label'             => __( 'Pinterest', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[pinterest_uid]'
	) ) );

	// Add StumbleUpon Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[stumbleupon_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_stumble', array(
		'label'             => __( 'StumbleUpon', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[stumbleupon_uid]'
	) ) );

	// Add Vimeo Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[vimeo_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_vimeo', array(
		'label'             => __( 'Vimeo', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[vimeo_uid]'
	) ) );

	// Add SoundCloud Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[yelp_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_yelp', array(
		'label'             => __( 'Yelp', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[yelp_uid]'
	) ) );

	// Add Foursquare Setting

	$wp_customize->add_setting( 'responsive_mobile_theme_options[foursquare_uid]' , array( 'sanitize_callback' => 'esc_url_raw', 'type' => 'option' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'res_foursquare', array(
		'label'             => __( 'Foursquare', 'responsive-mobile' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'responsive_mobile_theme_options[foursquare_uid]'
	) ) );

        /**
 * Validates the Call to Action Button styles
 *
 * @param $input select
 *
 * @return string
 */
function responsive_pro_button_style_validate( $input ) {
	// An array of valid results
	//$valid = responsive_get_valid_featured_area_layouts();
         $valid = array(
             'default' => 'Gradient',
             'flat_style' => 'Flat'
         );

	if( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/*--------------------------------------------------------------
	// CSS Styles
--------------------------------------------------------------*/
$wp_version = get_bloginfo('version');
if (!($wp_version >= 4.7))
{
	$wp_customize->add_section( 'css_styles', array(
		'title'                 => __( 'CSS Styles', 'responsive-mobile' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[responsive_inline_css]' ,array( 'sanitize_callback' => 'wp_filter_nohtml_kses', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_responsive_inline_css', array(
		'label'                 => __( 'Custom CSS Styles', 'responsive-mobile' ),
		'section'               => 'css_styles',
		'settings'              => 'responsive_mobile_theme_options[responsive_inline_css]',
		'type'                  => 'textarea'
	) );
}

/*--------------------------------------------------------------
	// Scripts
--------------------------------------------------------------*/

	$wp_customize->add_section( 'scripts', array(
		'title'                 => __( 'Scripts', 'responsive-mobile' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_mobile_theme_options[responsive_inline_js_head]',array( 'sanitize_callback' => 'wp_kses_stripslashes', 'type' => 'option' ) );
	$wp_customize->add_control( 'res_responsive_inline_js_head', array(
		'label'                 => __( 'Embeds to header.php', 'responsive-mobile' ),
		'section'               => 'scripts',
		'settings'              => 'responsive_mobile_theme_options[responsive_inline_js_head]',
		'type'                  => 'textarea'
	) );

	$wp_customize->add_setting( 'responsive_mobile_theme_options[responsive_inline_js_footer]',array( 'sanitize_callback' => 'wp_kses_stripslashes', 'type' => 'option' ));
	$wp_customize->add_control( 'res_responsive_inline_js_footer', array(
		'label'                 => __( 'Embeds to footer.php', 'responsive-mobile' ),
		'section'               => 'scripts',
		'settings'              => 'responsive_mobile_theme_options[responsive_inline_js_footer]',
		'type'                  => 'textarea'
	) );

}
add_action( 'customize_register', 'responsive_customize_register' );

function responsive_sanitize_checkbox( $input ) {
		if ( $input ) {
		$output = '1';
	} else {
		$output = false;
	}
	return $output;
}

function responsive_sanitize_textarea( $input ) {
	global $allowedposttags;
	$output = wp_kses( $input, $allowedposttags);
	return $output;
}

function responsive_sanitize_default_layouts( $input ) {
	$output = '';
	$option = responsive_mobile_valid_layouts();
	if ( array_key_exists( $input, $option ) ) {
		$output = $input;
	}
	return $output;
}
function responsive_sanitize_default_footer_layouts( $input ) {
	$output = '';
	$option = responsive_mobile_footer_layouts();
	if ( array_key_exists( $input, $option ) ) {
		$output = $input;
	}
	return $output;
}
function responsive_sanitize_multiple_checkboxes( $values ) {

	$multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

	return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}
function responsive_sanitize_blog_layouts( $input ) {
	$output = '';
	$option = responsive_mobile_valid_blog_layouts();
	if ( array_key_exists( $input, $option ) ) {
		$output = $input;
	}
	return $output;
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function responsive_customize_preview_js() {
	wp_enqueue_script( 'responsive_customizer', get_template_directory_uri() . '/includes/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'responsive_customize_preview_js' );
