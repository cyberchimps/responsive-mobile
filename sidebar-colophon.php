<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Colophon Widget Template
 *
 *
 * @file           sidebar-colophon.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/sidebar-colophon.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.1
 */
/*
 * If this is a full-width page, exit
 */
if( !is_active_sidebar( 'colophon-widget' ) ) {
	return;
}

?>
	<?php responsive_widgets_before(); ?>
	<div id="colophon-widget" class="widget-area grid col-940" role="complementary">
		<?php responsive_widgets(); ?>
		<?php if ( ! dynamic_sidebar( 'colophon-sidebar' ) ) : ?>

			<?php dynamic_sidebar( 'colophon-widget' ); ?>

		<?php endif; // end sidebar widget area ?>
		<?php responsive_widgets_end(); ?>
	</div><!-- #secondary -->
	<?php responsive_widgets_after(); ?>
