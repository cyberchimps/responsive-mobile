<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Responsive
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php responsive_entry_top(); ?>
	<?php get_template_part( 'post-meta-page' ); ?>

	<div class="post-entry">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'responsive' ),
				'after'  => '</div>',
			) );
		?>
		<?php get_template_part( 'post-data' ); ?>
		<?php responsive_entry_bottom(); ?>
	</div><!-- .post-entry -->
	<?php responsive_entry_after(); ?>
</article><!-- #post-## -->
