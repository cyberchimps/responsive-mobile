<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Responsive
 */

if ( !function_exists( 'responsive_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @return void
	 */
	function responsive_paging_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'responsive' ); ?></h1>

			<div class="nav-links">

				<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'responsive' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'responsive' ) ); ?></div>
				<?php endif; ?>

			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
}

if ( !function_exists( 'responsive_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @return void
	 */
	function responsive_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( !$next && !$previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'responsive' ); ?></h1>

			<div class="nav-links">

				<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'responsive' ) ); ?>
				<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'responsive' ) ); ?>

			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
}

if ( !function_exists( 'responsive_post_thumbnail' ) ) {
	/**
	 * Creates the post thumbnail used throughout the templates
	 * 
	 * @param string $size
	 * @param null $attr
	 */
	function responsive_post_thumbnail( $size = 'post-thumbnail', $attr = null ) {
		$size = apply_filters( 'responsive_filter_the_post_thumbnail_size', $size );
		$attr = apply_filters( 'responsive_filter_the_post_thumbnail_attr', $attr );
		?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( $size, $attr ); ?>
		</a>
	<?php
	}
}

if ( !function_exists( 'responsive_comment' ) ) {
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function responsive_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:', 'responsive' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'responsive' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) {
							echo get_avatar( $comment, $args['avatar_size'] );
						} ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'responsive' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div>
					<!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'responsive' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'responsive' ), '<span class="edit-link">', '</span>' ); ?>
					</div>
					<!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'responsive' ); ?></p>
					<?php endif; ?>
				</footer>
				<!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
				<!-- .comment-content -->

				<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
				?>
			</article>
			<!-- .comment-body -->

		<?php
		endif;
	}
}

/**
 * This function prints post meta data.
 *
 * Ulrich Pogson Contribution
 *
 */
if ( !function_exists( 'responsive_post_meta_data' ) ) {

	function responsive_post_meta_data() {
		printf( __( '<span class="%1$s">Posted on </span>%2$s<span class="%3$s"> by </span>%4$s', 'responsive' ),
		        'meta-prep meta-prep-author posted',
		        sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="timestamp updated">%3$s</span></a>',
		                 esc_url( get_permalink() ),
		                 esc_attr( get_the_time() ),
		                 esc_html( get_the_date() )
		        ),
		        'byline',
		        sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
		                 get_author_posts_url( get_the_author_meta( 'ID' ) ),
		                 sprintf( esc_attr__( 'View all posts by %s', 'responsive' ), get_the_author() ),
		                 esc_attr( get_the_author() )
		        )
		);
	}
}

if ( !function_exists( 'responsive_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function responsive_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
		                        esc_attr( get_the_date( 'c' ) ),
		                        esc_html( get_the_date() ),
		                        esc_attr( get_the_modified_date( 'c' ) ),
		                        esc_html( get_the_modified_date() )
		);

		printf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'responsive' ),
		        sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
		                 esc_url( get_permalink() ),
		                 $time_string
		        ),
		        sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
		                 esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		                 esc_html( get_the_author() )
		        )
		);
	}
}

/**
 * Returns true if a blog has more than 1 category.
 */
function responsive_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			                                     'hide_empty' => 1,
		                                     ) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so responsive_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so responsive_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in responsive_categorized_blog.
 */
function responsive_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}

add_action( 'edit_category', 'responsive_category_transient_flusher' );
add_action( 'save_post', 'responsive_category_transient_flusher' );

if ( !function_exists( 'responsive_archive_title' ) ) {
	/**
	 * Prints respective title for the archive page.
	 */
	function responsive_archive_title() {
		if ( is_category() ) {
			single_cat_title();

		} elseif ( is_tag() ) {
			single_tag_title();

		} elseif ( is_author() ) {
			printf( __( 'Author: %s', 'responsive' ), '<span class="vcard">' . get_the_author() . '</span>' );

		} elseif ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'responsive' ), '<span>' . get_the_date() . '</span>' );

		} elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'responsive' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'responsive' ) ) . '</span>' );

		} elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'responsive' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'responsive' ) ) . '</span>' );

		} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
			_e( 'Asides', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			_e( 'Galleries', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			_e( 'Images', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			_e( 'Videos', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			_e( 'Quotes', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			_e( 'Links', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			_e( 'Statuses', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			_e( 'Audios', 'responsive' );

		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			_e( 'Chats', 'responsive' );

		} else {
			_e( 'Archives', 'responsive' );

		}
	}
}