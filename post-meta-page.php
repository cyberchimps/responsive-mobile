<?php
/**
 * @package Responsive
 */
?>

<header class="entry-header">
	<h1 class="entry-title post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

	<?php if ( 'post' == get_post_type() ) : ?>
		<div class="post-meta">
			<?php responsive_posted_on(); ?>
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link">
					<?php comments_popup_link( __( 'No Comments &darr;', 'responsive' ), __( '1 Comment &darr;', 'responsive' ), __( '% Comments &darr;', 'responsive' ) ); ?>
				</span>
			<?php endif; ?>
		</div><!-- .post-meta -->
	<?php endif; ?>
</header><!-- .entry-header -->