<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Content/Sidebar Half Template
 *
Template Name:  Content/Sidebar Half Page
 *
 * @file           content-sidebar-half-page.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2011 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/content-sidebar-half-page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

	<div id="content" class="content-area">
		<main id="main" class="site-main grid col-460" role="main">

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

		</main><!-- #main -->
	</div><!-- #content -->

<?php get_sidebar( 'right-half' ); ?>
<?php get_footer(); ?>