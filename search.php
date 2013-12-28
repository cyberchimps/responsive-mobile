<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Responsive
 */

get_header(); ?>

	<section id="content-search" class="content-area">
		<main id="main" class="site-main<?php echo implode( ' ', responsive_get_content_classes() ); ?>" role="main">

		<?php if ( have_posts() ) : ?>

			<?php get_template_part( 'loop-header' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php get_template_part( 'loop-nav' ); ?>

		<?php else : ?>

			<?php get_template_part( 'loop-no-posts' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #content-search -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>