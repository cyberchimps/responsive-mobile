<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Responsive
 */

/*
 * If this is a full-width page, exit
 */
if( 'full-width-page' == responsive_get_layout() ) {
	return;
}

?>
	<?php responsive_widgets_before(); ?>
	<div id="widgets" class="widget-area col-md-4" role="complementary">
		<?php responsive_widgets(); ?>
		<?php if ( ! dynamic_sidebar( 'main-sidebar' ) ) : ?>

			<aside id="archives" class="widget-wrapper">
				<h3 class="widget-title"><?php _e( 'In Archive', 'responsive' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
		<?php responsive_widgets_end(); ?>
	</div><!-- #secondary -->
	<?php responsive_widgets_after(); ?>
