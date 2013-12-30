<?php
/**
 * Responsive functions and definitions
 *
 * @package Responsive
 */

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

	// Setup the WordPress core custom-header feature.
	add_theme_support( 'custom-header', apply_filters( 'responsive_custom-header_args', array(
		// Header image default
		'default-image'       => get_template_directory_uri() . '/core/images/default-logo.png',
		// Header text display default
		'header-text'         => false,
		// Header image flex width
		'flex-width'          => true,
		// Header image width (in pixels)
		'width'               => 300,
		// Header image flex height
		'flex-height'         => true,
		// Header image height (in pixels)
		'height'              => 100,
		// Admin header style callback
		'admin-head-callback' => 'responsive_admin_header_style'
	) ) );
}
}
add_action( 'after_setup_theme', 'responsive_setup' );

// gets included in the admin header
function responsive_admin_header_style() {
	?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			background-repeat: no-repeat;
			border: none;
		}
	</style><?php
}

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function responsive_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'responsive' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'responsive' ),
		'description'   => __( 'Area 1 - sidebar.php - Displays on Default, Blog, Blog Excerpt page templates', 'responsive' ),
		'id'            => 'main-sidebar',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'responsive' ),
		'description'   => __( 'Area 2 - sidebar-right.php - Displays on Content/Sidebar page templates', 'responsive' ),
		'id'            => 'right-sidebar',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'responsive' ),
		'description'   => __( 'Area 3 - sidebar-left.php - Displays on Sidebar/Content page templates', 'responsive' ),
		'id'            => 'left-sidebar',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Left Sidebar Half Page', 'responsive' ),
		'description'   => __( 'Area 4 - sidebar-left-half.php - Displays on Sidebar Half Page/Content page templates', 'responsive' ),
		'id'            => 'left-sidebar-half',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Right Sidebar Half Page', 'responsive' ),
		'description'   => __( 'Area 5 - sidebar-right-half.php - Displays on Content/Sidebar Half Page page templates', 'responsive' ),
		'id'            => 'right-sidebar-half',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Home Widget 1', 'responsive' ),
		'description'   => __( 'Area 6 - sidebar-home.php - Displays on the Home Page', 'responsive' ),
		'id'            => 'home-widget-1',
		'before_title'  => '<div id="widget-title-one" class="widget-title-home"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Home Widget 2', 'responsive' ),
		'description'   => __( 'Area 7 - sidebar-home.php - Displays on the Home Page', 'responsive' ),
		'id'            => 'home-widget-2',
		'before_title'  => '<div id="widget-title-two" class="widget-title-home"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Home Widget 3', 'responsive' ),
		'description'   => __( 'Area 8 - sidebar-home.php - Displays on the Home Page', 'responsive' ),
		'id'            => 'home-widget-3',
		'before_title'  => '<div id="widget-title-three" class="widget-title-home"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Gallery Sidebar', 'responsive' ),
		'description'   => __( 'Area 9 - sidebar-gallery.php - Displays on the page after an image has been clicked in a Gallery', 'responsive' ),
		'id'            => 'gallery-widget',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Colophon Widget', 'responsive' ),
		'description'   => __( 'Area 10 - sidebar-colophon.php, 100% width Footer widgets', 'responsive' ),
		'id'            => 'colophon-widget',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="colophon-widget widget-wrapper %2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Top Widget', 'responsive' ),
		'description'   => __( 'Area 11 - sidebar-top.php - Displays on the right of the header', 'responsive' ),
		'id'            => 'top-widget',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>'
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget', 'responsive' ),
		'description'   => __( 'Area 12 - sidebar-footer.php - Maximum of 3 widgets per row', 'responsive' ),
		'id'            => 'footer-widget',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>',
		'before_widget' => '<div id="%1$s" class="grid col-300 %2$s"><div class="widget-wrapper">',
		'after_widget'  => '</div></div>'
	) );
}
add_action( 'widgets_init', 'responsive_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function responsive_scripts() {
	wp_enqueue_style( 'responsive-style', get_stylesheet_uri() );

	wp_enqueue_script( 'responsive-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'responsive-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'responsive_scripts' );

/**
 * A safe way of adding stylesheets to a WordPress generated page.
 */
if( !is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'responsive_css' );
}

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

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
if( !is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'responsive_js' );
}

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
	}

}


