<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Responsive
 */
?>

<?php responsive_entry_before(); ?>
<section id="post-0" class="error404 no-results not-found">
	<?php responsive_entry_top(); ?>
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'responsive' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() || is_archive() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php _e( 'Ready to publish your first post?', 'responsive' ); ?>
				<?php echo sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'post-new.php' ) ), __( 'Get started here', 'responsive' ) ); ?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php sprintf( __( 'Your search for %s did not match any entries.', 'responsive' ), get_search_query() ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<h1 class="title-404"><?php _e( '404 &#8212; Fancy meeting you here!', 'responsive' ) ?></h1>
			<p><?php _e( 'Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive' ); ?></p>
			<p><?php _e( 'The URL may be misspelled or the page you are looking for is no longer available.', 'responsive' ); ?></p>

			<h6>
				<?php printf(
						__( 'You can return %s or search for the page you were looking for.', 'responsive' ),
						sprintf(
							'<a href="%1$s" title="%2$s">%3$s</a>',
							esc_url( get_home_url() ),
							esc_attr__( 'Home', 'responsive' ),
							esc_attr__( '&larr; Home', 'responsive' )
						)
				); ?>
			</h6>

			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->