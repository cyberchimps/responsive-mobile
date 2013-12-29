<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Widget Template
 *
 *
 * @file           sidebar-half.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/sidebar.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */
?>
<?php responsive_widgets_before(); ?>
	<div id="widgets" class="widget-area grid-right col-300" role="complementary">
		<?php responsive_widgets(); // above widgets hook ?>

		<?php if( !dynamic_sidebar( 'right-left' ) ) : ?>
			<aside id="archives" class="widget-wrapper">
				<h1 class="widget-title"><?php _e( 'In Archive', 'responsive' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>
		<?php endif; //end of right-left ?>

		<?php responsive_widgets_end(); ?>
	</div><!-- end of #widgets -->
<?php responsive_widgets_after(); ?>