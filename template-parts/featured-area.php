<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$responsive_mobile_options = responsive_mobile_get_options();
//test for first install no database
$db = get_option( 'responsive_mobile_theme_options' );
//test if all options are empty so we can display default text if they are
$empty = ( empty( $responsive_mobile_options['home_headline'] ) && empty( $responsive_mobile_options['home_subheadline'] ) && empty( $responsive_mobile_options['home_content_area'] ) ) ? false : true;
$emtpy_cta = ( empty( $responsive_mobile_options['cta_text'] ) ) ? false : true;

?>
<div id="content" class="content-area">
	<main id="featured-area" role="main">

		<div id="featured-content">

			<h1 class="featured-title">
				<?php
				if ( isset( $responsive_mobile_options['home_headline'] ) && $db && $empty ) {
					echo esc_html( $responsive_mobile_options['home_headline'] );
				} else {
					_e( 'Hello, World!', 'responsive-mobile' );
				}
				?>
			</h1>

			<h2 class="featured-subtitle">
				<?php
				if ( isset( $responsive_mobile_options['home_subheadline'] ) && $db && $empty ) {
					echo esc_html( $responsive_mobile_options['home_subheadline'] );
				} else {
					_e( 'Your H2 subheadline here', 'responsive-mobile' );
				}
				?>
			</h2>

			<p>
				<?php
				if ( isset( $responsive_mobile_options['home_content_area'] ) && $db && $empty ) {
					echo responsive_mobile_esc_content( do_shortcode( wpautop( $responsive_mobile_options['home_content_area'] ) ) );
				} else {
					_e( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'responsive-mobile' );
				}
				?>
			</p>

			<?php if ( $responsive_mobile_options['cta_button'] == 0 ): ?>

				<div class="call-to-action">

					<a href="<?php echo esc_url( $responsive_mobile_options['cta_url'] ); ?>" class="btn cta-button">
						<?php
						if ( isset( $responsive_mobile_options['cta_text'] ) && $db && $emtpy_cta ) {
							echo esc_html( $responsive_mobile_options['cta_text'] );
						} else {
							_e( 'Call to Action', 'responsive-mobile' );
						}
						?>
					</a>

				</div><!-- end of .call-to-action -->

			<?php endif; ?>

		</div><!-- end of #featured-content -->

		<div id="featured-image">

			<?php $featured_content = ( ! empty( $responsive_mobile_options['featured_content'] ) ) ? $responsive_mobile_options['featured_content'] : '<img class="aligncenter" src="' . responsive_mobile_child_uri( '/images/featured-image.png' ) . '" width="497" height="297" alt="" />'; ?>

			<?php echo responsive_mobile_esc_content( do_shortcode( wpautop( $featured_content ) ) ); ?>

		</div><!-- end of #featured-image -->

	</main><!-- end of #featured -->
</div><!-- content-area -->