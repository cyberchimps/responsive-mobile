<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Options
 *
 *
 * @file           theme-options.php
 * @package        Responsive
 * @author         CyberChimps
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.9.6
 * @filesource     wp-content/themes/responsive/includes/theme-options.php
 * @link           http://themeshaper.com/2010/06/03/sample-theme-options/
 * @since          available since Release 1.0
 */

/**
 * Call the options class
 */
require( get_template_directory() . '/core/includes/theme-options/class-responsive-options.php' );

/**
 * Retrieve Theme option settings
 */
function responsive_get_options() {

	// Parse array of option defaults against user-configured Theme options
	$responsive_options = wp_parse_args( get_option( 'responsive_theme_options', array() ), responsive_get_option_defaults() );

	// Return parsed args array
	return $responsive_options;
}

/**
 * Responsive Theme option defaults
 */
function responsive_get_option_defaults() {
	$defaults = array(
		'compatibility'                   => 0,
		'breadcrumb'                      => false,
		'cta_button'                      => false,
		'front_page'                      => 1,
		'home_headline'                   => null,
		'home_subheadline'                => null,
		'home_content_area'               => null,
		'cta_text'                        => null,
		'cta_url'                         => null,
		'featured_content'                => null,
		'google_site_verification'        => '',
		'bing_site_verification'          => '',
		'yahoo_site_verification'         => '',
		'site_statistics_tracker'         => '',
		'twitter_uid'                     => '',
		'facebook_uid'                    => '',
		'linkedin_uid'                    => '',
		'youtube_uid'                     => '',
		'stumble_uid'                     => '',
		'rss_uid'                         => '',
		'google_plus_uid'                 => '',
		'instagram_uid'                   => '',
		'pinterest_uid'                   => '',
		'yelp_uid'                        => '',
		'vimeo_uid'                       => '',
		'foursquare_uid'                  => '',
		'responsive_inline_css'           => '',
		'responsive_inline_js_head'       => '',
		'responsive_inline_css_js_footer' => '',
		'static_page_layout_default'      => 'content-sidebar-page',
		'single_post_layout_default'      => 'content-sidebar-page',
		'blog_posts_index_layout_default' => 'content-sidebar-page',
	);

	return apply_filters( 'responsive_option_defaults', $defaults );
}


function responsive_theme_options_sections_array() {
	/**
	 * Create array of option sections
	 *
	 * @Title The display title
	 * @id The id that the option array references so the options display in the correct section
	 */
	$sections = apply_filters( 'responsive_option_sections_filter', array(
		array(
			'title' => __( 'Theme Elements', 'responsive' ),
			'id'    => 'theme_elements'
		),
		array(
			'title' => __( 'Logo Upload', 'responsive' ),
			'id'    => 'logo_upload'
		),
		array(
			'title' => __( 'Home Page', 'responsive' ),
			'id'    => 'home_page'
		),
		array(
			'title' => __( 'Default Layouts', 'responsive' ),
			'id'    => 'layouts'
		),
		array(
			'title' => __( 'Social Icons', 'responsive' ),
			'id'    => 'social'
		),
		array(
			'title' => __( 'CSS Styles', 'responsive' ),
			'id'    => 'css'
		),
		array(
			'title' => __( 'Scripts', 'responsive' ),
			'id'    => 'scripts'
		)
	) );

	return $sections;
}


function responsive_theme_options_array() {
	/**
	 * Creates and array of options that get added to the relevant sections
	 *
	 * @key This must match the id of the section you want the options to appear in
	 *
	 * @title Title on the left hand side of the options
	 * @subtitle Displays underneath main title on left hand side
	 * @heading Right hand side above input
	 * @type The type of input e.g. text, textarea, checkbox
	 * @id The options id
	 * @description Instructions on what to enter in input
	 * @placeholder The placeholder for text and textarea
	 * @options array used by select dropdown lists
	 */
	$options = apply_filters( 'responsive_options_filter', array(
		'theme_elements' => array(
			array(
				'title'       => __( 'Backward Compatibility', 'responsive' ),
				'type'        => 'checkbox',
				'id'          => 'compatibility',
				'description' => __( 'check to enable', 'responsive' ),
				'validate'    => 'checkbox'
			),
			array(
				'title'       => __( 'Disable breadcrumb list?', 'responsive' ),
				'type'        => 'checkbox',
				'id'          => 'breadcrumb',
				'description' => __( 'check to disable', 'responsive' ),
				'validate'    => 'checkbox'
			),
			array(
				'title'       => __( 'Disable Call to Action Button?', 'responsive' ),
				'type'        => 'checkbox',
				'id'          => 'cta_button',
				'description' => __( 'check to disable', 'responsive' ),
				'validate'    => 'checkbox'
			),
			array(
				'title'       => __( 'Blog Title Toggle', 'responsive' ),
				'type'        => 'checkbox',
				'id'          => 'blog_post_title_toggle',
				'description' => __( 'check to enable', 'responsive' ),
				'validate'    => 'checkbox'
			),
			array(
				'title'       => __( 'Title Text', 'responsive' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'blog_post_title_text',
				'description' => '',
				'placeholder' => __( 'Blog', 'responsive' ),
				'validate'    => 'text'
			)
		),
		'logo_upload' => array(
			array(
				'title'       => __( 'Custom Header', 'responsive' ),
				'type'        => 'description',
				'description' => __( 'Need to replace or remove default logo?', 'responsive' ) . sprintf( __( ' <a href="%s">Click here</a>.', 'responsive' ), admin_url( 'themes.php?page=custom-header' ) ),
			)
		),
		'home_page' => array(
			array(
				'title'       => __( 'Enable Custom Front Page', 'responsive' ),
				'type'        => 'checkbox',
				'id'          => 'front_page',
				'description' => sprintf( __( 'Overrides the WordPress %1sfront page option%2s', 'responsive' ), '<a href="options-reading.php">', '</a>' ),
				'validate'    => 'checkbox'
			),
			array(
				'title'       => __( 'Headline', 'responsive' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'home_headline',
				'description' => __( 'Enter your headline', 'responsive' ),
				'placeholder' => __( 'Hello, World!', 'responsive' ),
				'validate'    => 'text'
			),
			array(
				'title'       => __( 'Subheadline', 'responsive' ),
				'type'        => 'text',
				'id'          => 'home_subheadline',
				'description' => __( 'Enter your subheadline', 'responsive' ),
				'placeholder' => __( 'Your H2 subheadline here', 'responsive' ),
				'validate'    => 'text'
			),
			array(
				'title'       => __( 'Content Area', 'responsive' ),
				'type'        => 'editor',
				'id'          => 'home_content_area',
				'description' => __( 'Enter your content', 'responsive' ),
				'placeholder' => __( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'responsive' ),
				'validate'    => 'editor'
			),
			array(
				'title'       => __( 'Call to Action (URL)', 'responsive' ),
				'type'        => 'text',
				'id'          => 'cta_url',
				'description' => __( 'Enter your call to action URL', 'responsive' ),
				'placeholder' => '#nogo',
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'Call to Action (Text)', 'responsive' ),
				'type'        => 'text',
				'id'          => 'cta_text',
				'description' => __( 'Enter your call to action text', 'responsive' ),
				'placeholder' => __( 'Call to Action', 'responsive' ),
				'validate'    => 'text'
			),
			array(
				'title'       => __( 'Featured Content', 'responsive' ),
				'subtitle'    => '<a class="help-links" href="' . esc_url( 'http://cyberchimps.com/guide/responsive/' ) . '" title="' . esc_attr__( 'See Docs', 'responsive' ) . '" target="_blank">' .
				__( 'See Docs', 'responsive' ) . '</a>',
				'type'        => 'editor',
				'id'          => 'featured_content',
				'description' => __( 'Paste your shortcode, video or image source', 'responsive' ),
				'placeholder' => '<img class="aligncenter" src="' . get_template_directory_uri() . '"/core/images/featured-image.png" width="440" height="300" alt="" />',
				'validate'    => 'editor'
			)
		),
		'layouts' => array(
			array(
				'title'       => __( 'Default Static Page Layout', 'responsive' ),
				'type'        => 'select',
				'id'          => 'static_page_layout_default',
				'options'     => Responsive_Options::valid_layouts(),
				'validate'    => 'layouts'
			),
			array(
				'title'       => __( 'Default Single Blog Post Layout', 'responsive' ),
				'type'        => 'select',
				'id'          => 'single_post_layout_default',
				'options'     => Responsive_Options::valid_layouts(),
				'validate'    => 'layouts'
			),
			array(
				'title'       => __( 'Default Blog Posts Index Layout', 'responsive' ),
				'type'        => 'select',
				'id'          => 'blog_posts_index_layout_default',
				'options'     => Responsive_Options::valid_layouts(),
				'validate'    => 'layouts'
			)
		),
		'social' => array(
			array(
				'title'       => __( 'Twitter', 'responsive' ),
				'type'        => 'text',
				'id'          => 'twitter_uid',
				'description' => __( 'Enter your Twitter URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'Facebook', 'responsive' ),
				'type'        => 'text',
				'id'          => 'facebook_uid',
				'description' => __( 'Enter your Facebook URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'LinkedIn', 'responsive' ),
				'type'        => 'text',
				'id'          => 'linkedin_uid',
				'description' => __( 'Enter your LinkedIn URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'YouTube', 'responsive' ),
				'type'        => 'text',
				'id'          => 'youtube_uid',
				'description' => __( 'Enter your YouTube URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'StumbleUpon', 'responsive' ),
				'type'        => 'text',
				'id'          => 'stumbleupon_uid',
				'description' => __( 'Enter your StumbleUpon URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'RSS Feed', 'responsive' ),
				'type'        => 'text',
				'id'          => 'rss_uid',
				'description' => __( 'Enter your RSS Feed URL', 'responsive' ),
				'validate'    => 'checkbox'
			),
			array(
				'title'       => __( 'Google+', 'responsive' ),
				'type'        => 'text',
				'id'          => 'googleplus_uid',
				'description' => __( 'Enter your Google+ URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'Instagram', 'responsive' ),
				'type'        => 'text',
				'id'          => 'instagram_uid',
				'description' => __( 'Enter your Instagram URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'Pinterest', 'responsive' ),
				'type'        => 'text',
				'id'          => 'pinterest_uid',
				'description' => __( 'Enter your Pinterest URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'Yelp!', 'responsive' ),
				'type'        => 'text',
				'id'          => 'yelp_uid',
				'description' => __( 'Enter your Yelp! URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'Vimeo', 'responsive' ),
				'type'        => 'text',
				'id'          => 'vimeo_uid',
				'description' => __( 'Enter your Vimeo URL', 'responsive' ),
				'validate'    => 'url'
			),
			array(
				'title'       => __( 'foursquare', 'responsive' ),
				'type'        => 'text',
				'id'          => 'foursquare_uid',
				'description' => __( 'Enter your foursquare URL', 'responsive' ),
				'validate'    => 'url'
			)
		),
		'css' => array(
			array(
				'title'       => __( 'Custom CSS Styles', 'responsive' ),
				'subtitle'    => '<a class="help-links" href="https://developer.mozilla.org/en/CSS" title="CSS Tutorial" target="_blank">' . __( 'CSS Tutorial', 'responsive' ) . '</a>',
				'type'        => 'textarea',
				'id'          => 'responsive_inline_css',
				'description' => __( 'Enter your custom CSS styles.', 'responsive' ),
				'validate'    => 'css'
			)
		),
		'scripts' => array(
			array(
				'title'       => __( 'Custom Scripts for Header and Footer', 'responsive' ),
				'subtitle'    => '<a class="help-links" href="http://codex.wordpress.org/Using_Javascript" title="Quick Tutorial" target="_blank">' . __( 'Quick Tutorial', 'responsive' ) . '</a>',
				'heading'     => __( 'Embeds to header.php &darr;', 'responsive' ),
				'type'        => 'textarea',
				'id'          => 'responsive_inline_js_head',
				'description' => __( 'Enter your custom header script.', 'responsive' ),
				'validate'    => 'js'
			),
			array(
				'heading'     => __( 'Embeds to footer.php &darr;', 'responsive' ),
				'type'        => 'textarea',
				'id'          => 'responsive_inline_js_footer',
				'description' => __( 'Enter your custom footer script.', 'responsive' ),
				'validate'    => 'js'
			)
		)
	) );

	return $options;
}
