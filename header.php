<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Responsive
 */
?>
	<!DOCTYPE html>
	<!--[if !IE]>
	<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7 ]>
	<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8 ]>
	<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 9 ]>
	<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 9]><!-->
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php wp_title( '&#124;', true, 'right' ); ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>
	</head>

<body <?php body_class(); ?>>
<?php responsive_container(); // before container hook ?>
<div id="container" class="hfeed site">
<?php do_action( 'before' ); ?>
	<nav id="top-menu" class="container-full-width">
		<div class="container">
			<?php responsive_header_top(); // before header content hook ?>
			<?php if ( has_nav_menu( 'top-menu', 'responsive' ) ) {
				wp_nav_menu(
					array(
						'container'      => '',
						'fallback_cb'    => false,
						'menu_class'     => 'top-menu',
						'theme_location' => 'top-menu',
						'depth'          => 1
					)
				);
			} ?>
		</div>
	</nav>
<?php responsive_header(); // before header hook ?>
	<header id="header" class="container-full-width site-header" role="banner">
		<div class="container">
			<?php responsive_in_header(); // header hook ?>
			<div id="logo" class="site-branding">
				<?php if ( get_header_image() ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
					</a>
				<?php endif; // End header image check. ?>
			</div>
			<div id="site-header-text" class="site-branding">
				<?php if ( display_header_text() ) : ?>
					<h2 class="site-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
					<h3 class="site-description"><?php bloginfo( 'description' ); ?></h3>
				<?php endif; // End header text check. ?>
			</div>
		</div>

		<?php get_sidebar( 'top' ); ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menu', 'responsive' ); ?></h1>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'responsive' ); ?></a>

			<?php wp_nav_menu(
				array(
					'container'       => 'div',
					'container_class' => 'main-nav',
					'fallback_cb'     => 'responsive_fallback_menu',
					'theme_location'  => 'header-menu'
				)
			); ?>
		</nav>
		<!-- #site-navigation -->
		<?php responsive_header_bottom(); // after header content hook ?>
	</header><!-- #header -->
<?php responsive_header_end(); // after header container hook ?>

<?php responsive_wrapper(); // before wrapper container hook ?>
	<div id="wrapper" class="row site-content">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>