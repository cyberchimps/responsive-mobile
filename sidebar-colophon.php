<?php
/**
 * Colophon Sidebar
 *
 * Displays below the normal footer widgets and above the copyright text
 *
 * @package            ${PACKAGE}
 * @license            license.txt
 * @copyright          ${YEAR} ${COMPANY}
 * @since              ${VERSION}
 *
 * Please do not edit this file. This file is part of the ${PACKAGE} Framework and all modifications
 * should be made in a child theme.
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * If the widget contains nothing, exit
 */
if ( !is_active_sidebar( 'colophon-widget' ) ) {
	return;
}
?>

<?php responsive_widgets_before(); ?>
<div class="row">
	<div id="colophon-widget" class="widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
		<?php responsive_widgets(); ?>
		<?php if ( !dynamic_sidebar( 'colophon-sidebar' ) ) : ?>

			<?php dynamic_sidebar( 'colophon-widget' ); ?>

		<?php endif; // end sidebar widget area ?>
		<?php responsive_widgets_end(); ?>
	</div>
	<!-- #colophon widget -->
</div>
<!-- row -->
<?php responsive_widgets_after(); ?>
