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
		<div id="widgets">

			<div class="grid col-300">
				<h3 class="widget-title"><?php _e( 'Categories', 'responsive' ); ?></h1>
				<ul><?php wp_list_categories( array(
					'sort_column'  => 'name',
					'optioncount'  => 1,
					'hierarchical' => 0,
					'title_li'     => ''
					) ); ?></ul>
			</div><!-- end of .col-300 -->

			<div class="grid col-300">
				<h1 class="widget-title"><?php _e( 'Latest Posts', 'responsive' ); ?></h1>
				<ul><?php $archive_query = new WP_Query( array( 'posts_per_page' => -1 ) ); ?>
					<?php while( $archive_query->have_posts() ) : $archive_query->the_post(); ?>
						<li>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __( 'Permanent Link to %s', 'responsive' ), the_title_attribute( array( 'echo' => 0 ) ) ); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; ?>
				</ul>
			</div><!-- end of .col-300 -->

			<div class="grid col-300 fit">
				<div class="widget-title"><h3><?php _e( 'Pages', 'responsive' ); ?></h3></div>
				<ul><?php wp_list_pages( array( 'title_li' => '' ) ); ?></ul>
			</div><!-- end of .col-300 fit -->

		</div><!-- end of #widgets -->
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
