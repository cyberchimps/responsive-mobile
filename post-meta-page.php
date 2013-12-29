<?php
/**
 * @package Responsive
 */
?>

<header class="entry-header">
	<h1 class="entry-title post-title"><?php the_title(); ?></h1>

	<?php if ( comments_open() ) : ?>
		<div class="post-meta">
			<?php responsive_posted_on(); ?>
			<?php responsive_post_meta_data(); ?>
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link">
					<span class="mdash">&mdash;</span>
					<?php comments_popup_link( __( 'No Comments &darr;', 'responsive' ), __( '1 Comment &darr;', 'responsive' ), __( '% Comments &darr;', 'responsive' ) ); ?>
				</span>
			<?php endif; ?>
		</div><!-- .post-meta -->
	<?php endif; ?>
</header><!-- .entry-header -->