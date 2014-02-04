<?php
/**
 * Blog Template
 *
 * @file           home.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/home.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

	<div id="content-blog" class="content-area">
		<div class="row">
			<main id="main" class="site-main col-md-8" role="main">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php get_template_part( 'loop-nav' ); ?>

				<?php else : ?>

					<?php get_template_part( 'loop-no-posts' ); ?>

				<?php endif; ?>

			</main>
			<!-- #main -->
			<?php get_sidebar(); ?>
		</div>
	</div><!-- #content-blog -->

<?php get_footer(); ?>