<?php
/**
 * Responsive functions and definitions
 *
 * @package Responsive
 */

/**
 * Retrieve Theme option settings
 *
 */
function responsive_get_options() {

	// Parse array of option defaults against user-configured Theme options
	$responsive_options = wp_parse_args( get_option( 'responsive_theme_options', array() ), responsive_get_option_defaults() );

	// Return parsed args array
	return $responsive_options;
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'responsive_setup' ) ) {
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function responsive_setup() {

	/*
	 * Responsive is available for translations.
	 * The translation files are in the /languages/ directory.
	 * Translations are pulled from the WordPress default lanaguge folder
	 * then from the child theme and then lastly from the parent theme.
	 * @link http://codex.wordpress.org/Function_Reference/load_theme_textdomain
	 */
	$domain = 'responsive';

	load_theme_textdomain( $domain, WP_LANG_DIR . '/responsive/' );
	load_theme_textdomain( $domain, get_stylesheet_directory() . '/languages/' );
	load_theme_textdomain( $domain, get_template_directory() . '/languages/' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This feature enables woocommerce support for a theme.
	 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/#section-2
	 */
	add_theme_support( 'woocommerce' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top-menu'        => __( 'Top Menu', 'responsive' ),
		'header-menu'     => __( 'Header Menu', 'responsive' ),
		'sub-header-menu' => __( 'Sub-Header Menu', 'responsive' ),
		'footer-menu'     => __( 'Footer Menu', 'responsive' )
	) );

	// Enable support for Post Formats.
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'responsive_custom_background_args', array(
		// Background default color
		'default-color'       => '#efefef',
	) ) );

}
}
add_action( 'after_setup_theme', 'responsive_setup' );

/**
 * Enqueue scripts and styles.
 */
function responsive_scripts() {
	wp_enqueue_style( 'responsive-style', get_stylesheet_uri() );

	wp_enqueue_script( 'responsive-navigation', get_template_directory_uri() . '/core/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'responsive-skip-link-focus-fix', get_template_directory_uri() . '/core/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'responsive_scripts' );

/**
 * A safe way of adding stylesheets to a WordPress generated page.
 */
if( !function_exists( 'responsive_css' ) ) {

	function responsive_css() {
		$theme  = wp_get_theme();
		$responsive  = wp_get_theme( 'responsive' );
		wp_enqueue_style( 'responsive-style', get_template_directory_uri() . '/style.css', false, $responsive['Version'] );
		wp_enqueue_style( 'responsive-media-queries', get_template_directory_uri() . '/core/css/style.css', false, $responsive['Version'] );
		if( is_rtl() ) {
			wp_enqueue_style( 'responsive-rtl-style', get_template_directory_uri() . '/rtl.css', false, $responsive['Version'] );
		}
		if( is_child_theme() ) {
			wp_enqueue_style( 'responsive-child-style', get_stylesheet_uri(), false, $theme['Version'] );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'responsive_css' );

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
if( !function_exists( 'responsive_js' ) ) {

	function responsive_js() {

		$suffix = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';
		$directory = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? 'js-dev' : 'js';
		$template_directory_uri = get_template_directory_uri();

		// JS at the bottom for fast page loading.
		// except for Modernizr which enables HTML5 elements & feature detects.
		wp_enqueue_script( 'modernizr', $template_directory_uri . '/core/' . $directory . '/responsive-modernizr' . $suffix . '.js', array( 'jquery' ), '2.6.1', false );
		wp_enqueue_script( 'responsive-scripts', $template_directory_uri . '/core/' . $directory . '/responsive-scripts' . $suffix . '.js', array( 'jquery' ), '1.2.5', true );
		if ( ! wp_script_is( 'tribe-placeholder' ) ) {
			wp_enqueue_script( 'jquery-placeholder', $template_directory_uri . '/core/' . $directory . '/jquery.placeholder' . $suffix . '.js', array( 'jquery' ), '2.0.7', true );
		}

		if( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

}
add_action( 'wp_enqueue_scripts', 'responsive_js' );
