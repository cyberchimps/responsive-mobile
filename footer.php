<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Responsive
 */
?>

</div><!-- #content -->

<footer id="footer" class="site-footer container-full-width" role="contentinfo">
	<?php responsive_footer_top(); ?>
	<div id="footer-wrapper" class="container">

		<div id="footer-widgets-container" class="row">
			<?php get_sidebar( 'footer' ); ?>
		</div>
		<!-- #footer-widgets-container-->

		<div id="menu-social-container" class="row">
			<nav id="footer-menu-container" class="col-md-7">
				<?php if ( has_nav_menu( 'footer-menu', 'responsive' ) ) {
					wp_nav_menu(
						array(
							'container'      => '',
							'fallback_cb'    => false,
							'menu_class'     => 'footer-menu',
							'theme_location' => 'footer-menu',
							'depth'          => 1
						)
					);
				} ?>
			</nav>
			<!-- #footer-menu -->
			<div id="social-icons-container" class="col-md-5">
				<?php echo responsive_get_social_icons() ?>
			</div>
			<!-- #social-icons-container-->
		</div>
		<!-- #menu-social-container -->

		<?php get_sidebar( 'colophon' ); ?>

		<div id="footer-base" class="row">
			<div class="col-md-4 copyright">
				<?php esc_attr_e( '&copy;', 'responsive' ); ?> <?php _e( date( 'Y' ) ); ?> <a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</div>
			<!-- .copyright -->

			<div class="col-md-4 scroll-top">
				<a href="#scroll-top" title="<?php esc_attr_e( 'scroll to top', 'responsive' ); ?>"><?php _e( '&uarr;', 'responsive' ); ?></a>
			</div>
			<!-- .scroll-top -->

			<div class="col-md-4 powered">
			<?php sprintf(
				/* Translators: Responsive Theme powered by WordPress */
				__( '%1$s powered by %2$s', 'responsive' ),
				'<a href="' . esc_url( 'http://cyberchimps.com/responsive-theme/' ) . '">' . __( 'Responsive Theme', 'responsive' ) . '</a>',
				'<a href="' . esc_url( 'http://wordpress.org/' ) . '">' . __( 'WordPress', 'responsive' ) . '</a>'
			) ?>
			</div>
			<!-- end .powered -->
		</div>
		<!-- #footer-base -->
	</div>
	<!-- #footer-wrapper -->
	<?php responsive_footer_bottom(); ?>
</footer><!-- #footer -->
<?php responsive_footer_after(); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
