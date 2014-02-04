<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Responsive
 */

get_header(); ?>

	<div id="content" class="content-area">
		<div class="row">
			<main id="main" class="site-main col-md-8" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php responsive_comments_before(); ?>
					<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template( '', true );
					endif;
					?>
					<?php responsive_comments_after(); ?>

				<?php endwhile; // end of the loop. ?>

			</main>
			<!-- #main -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- #content -->
<?php get_footer(); ?>