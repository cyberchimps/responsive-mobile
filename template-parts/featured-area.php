<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$responsive_II_options = responsive_II_get_options();
//test for first install no database
$db = get_option( 'responsive_II_theme_options' );
//test if all options are empty so we can display default text if they are
$empty = ( empty( $responsive_II_options['home_headline'] ) && empty( $responsive_II_options['home_subheadline'] ) && empty( $responsive_II_options['home_content_area'] ) ) ? false : true;
$emtpy_cta = ( empty( $responsive_II_options['cta_text'] ) ) ? false : true;

?>
<div id="content" class="content-area">
	<main id="featured-area" role="main">

		<div id="featured-content">

			<h1 class="featured-title">
				<?php
				if ( isset( $responsive_II_options['home_headline'] ) && $db && $empty ) {
					echo $responsive_II_options['home_headline'];
				} else {
					_e( 'Hello, World!', 'responsive-II' );
				}
				?>
			</h1>

			<h2 class="featured-subtitle">
				<?php
				if ( isset( $responsive_II_options['home_subheadline'] ) && $db && $empty ) {
					echo $responsive_II_options['home_subheadline'];
				} else {
					_e( 'Your H2 subheadline here', 'responsive-II' );
				}
				?>
			</h2>

			<p>
				<?php
				if ( isset( $responsive_II_options['home_content_area'] ) && $db && $empty ) {
					echo do_shortcode( wpautop( $responsive_II_options['home_content_area'] ) );
				} else {
					_e( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'responsive-II' );
				}
				?>
			</p>

			<?php if ( $responsive_II_options['cta_button'] == 0 ): ?>

				<div class="call-to-action">

					<a href="<?php echo $responsive_II_options['cta_url']; ?>" class="btn cta-button">
						<?php
						if ( isset( $responsive_II_options['cta_text'] ) && $db && $emtpy_cta ) {
							echo $responsive_II_options['cta_text'];
						} else {
							_e( 'Call to Action', 'responsive-II' );
						}
						?>
					</a>

				</div><!-- end of .call-to-action -->

			<?php endif; ?>

		</div><!-- end of #featured-content -->

		<div id="featured-image">

			<?php $featured_content = ( !empty( $responsive_II_options['featured_content'] ) ) ? $responsive_II_options['featured_content'] : '<img class="aligncenter" src="' . get_template_directory_uri() . '/images/featured-image.png" width="497" height="297" alt="" />'; ?>

			<?php echo do_shortcode( wpautop( $featured_content ) ); ?>

		</div><!-- end of #featured-image -->

	</main><!-- end of #featured -->
</div><!-- content-area -->