<?php
/**
 * @package Responsive
 */
?>

<?php responsive_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php responsive_entry_top(); ?>

	<?php get_template_part( 'post-meta-page' ); ?>

	<div class="post-entry">
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php if( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( apply_filters( responsive_filter_the_post_thumbnail, '', $size, $attr  ); ); ?></a>
			<?php endif; ?>
			<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php endif; ?>
	</div><!-- .post-entry -->

	<?php get_template_part( 'post-data' ); ?>

<?php responsive_entry_bottom(); ?>
</article><!-- #post-## -->
<?php responsive_entry_after(); ?>