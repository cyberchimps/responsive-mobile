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

	<footer id="footer" class="site-footer clearfix" role="contentinfo">
		<?php responsive_footer_top(); ?>
		<div id="footer-wrapper" class="row">
			<?php get_sidebar( 'footer' ); ?>
			<div class="<?php echo responsive_get_grid( 'col-12' ); ?>">
				<div class="row">
					<div class="<?php echo responsive_get_grid( 'col-7' ); ?>">
						<?php if( has_nav_menu( 'footer-menu', 'responsive' ) ) {
							wp_nav_menu(
								array(
									'container'      => '',
									'fallback_cb'    => false,
									'menu_class'     => 'footer-menu',
									'theme_location' => 'footer-menu'
									)
							);
						} ?>
					</div><!-- .col-540 -->
					<div class="<?php echo responsive_get_grid( 'col-5', true ); ?>">
					<?php echo responsive_social_icons() ?>
					</div><!-- .col-380 fit -->
				</div>
			</div><!-- .col-940 -->
			<?php get_sidebar( 'colophon' ); ?>
			<div class="<?php echo responsive_get_grid( 'col-4' ); ?> copyright">
				<?php esc_attr_e( '&copy;', 'responsive' ); ?> <?php _e( date( 'Y' ) ); ?><a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?>
				</a>
			</div><!-- .copyright -->

			<div class="<?php echo responsive_get_grid( 'col-4' ); ?> scroll-top">
				<a href="#scroll-top" title="<?php esc_attr_e( 'scroll to top', 'responsive' ); ?>"><?php _e( '&uarr;', 'responsive' ); ?></a>
			</div><!-- .scroll-top -->

			<div class="<?php echo responsive_get_grid( 'col-4', true ); ?> powered">
				<a href="<?php echo esc_url( 'http://cyberchimps.com/responsive-theme/' ); ?>" title="<?php esc_attr_e( 'Responsive Theme', 'responsive' ); ?>">Responsive Theme</a><?php esc_attr_e( 'powered by', 'responsive' ); ?> <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" title="<?php esc_attr_e( 'WordPress', 'responsive' ); ?>">
					WordPress</a>
			</div><!-- end .powered -->
		</div><!-- #footer-wrapper -->
		<?php responsive_footer_bottom(); ?>
	</footer><!-- #footer -->
	<?php responsive_footer_after(); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
