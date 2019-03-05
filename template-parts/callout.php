<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$responsive_mobile_options = responsive_mobile_get_options();
//test for first install no database
$db = get_option( 'responsive_mobile_theme_options' );
//test if all options are empty so we can display default text if they are

$empty                  = ( empty( $responsive_mobile_options['callout_headline'] ) && empty( $responsive_mobile_options['callout_subheadline'] ) && empty( $responsive_mobile_options['callout_content_area'] ) ) ? false : true;
$emtpy_cta              = ( empty( $responsive_mobile_options['callout_cta_text'] ) ) ? false : true;
$callout_text_color     = ! empty( $responsive_mobile_options['callout_text_color'] ) ? $responsive_mobile_options['callout_text_color'] : '';
$callout_btn_text_color = ! empty( $responsive_mobile_options['callout_btn_text_color'] ) ? $responsive_mobile_options['callout_btn_text_color'] : '';
$callout_btn_back_color = ! empty( $responsive_mobile_options['callout_btn_back_color'] ) ? $responsive_mobile_options['callout_btn_back_color'] : '';
$callout_img            = ! empty( $responsive_mobile_options['callout_featured_content'] ) ? $responsive_mobile_options['callout_featured_content'] : '';
$callout_cta_text       = ! empty( $responsive_mobile_options['callout_cta_text'] ) ? $responsive_mobile_options['callout_cta_text'] : '';

if($responsive_mobile_options['callout_toggle_btn'] == 1)
{
?>
<style>
<?php if(strlen($callout_cta_text) > 30)
	{
?>
#callout_content main #featured-content .call-to-action .cta-button, #callout_content main #featured-image .call-to-action .cta-button
{
	font-size:14px;
}
<?php
	}
?>
#callout_content
{
	background:url('<?php echo $callout_img; ?>');
}
</style>
<div id="callout_content" class="content-area" style="background-color:#000;color:<?php echo $callout_text_color; ?>;">
	<main id="featured-area" role="main">

		<div id="featured-content">

			<h2 class="callout-title">
				<?php
				if ( isset( $responsive_mobile_options['callout_headline'] ) && $db && $empty ) {
					echo esc_html( $responsive_mobile_options['callout_headline'] );
				} else {
					_e( 'Hello, World!', 'responsive-mobile' );
				}
				?>
			</h2>
			<p class="callout-text">
				<?php
				if ( isset( $responsive_mobile_options['callout_content_area'] ) && $db && $empty ) {
					echo responsive_mobile_esc_content( do_shortcode( wpautop( $responsive_mobile_options['callout_content_area'] ) ) );
				} else {
					_e( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'responsive-mobile' );
				}
				?>
			</p>





		</div><!-- end of #featured-content -->

		<div id="featured-image">
<div class="call-to-action callout_button" id="callout-cta">
					<?php $callout_cta_url = ! empty( $responsive_mobile_options['callout_cta_url'] ) ? $responsive_mobile_options['callout_cta_url'] : ''; ?>
					<a href="<?php echo esc_url( $callout_cta_url ); ?>" class="btn cta-button" style="color:<?php echo $callout_btn_text_color; ?>; background:<?php echo $callout_btn_back_color; ?>;">
						<?php
						if ( isset( $responsive_mobile_options['callout_cta_text'] ) && $db && $emtpy_cta ) {
							echo esc_html( $responsive_mobile_options['callout_cta_text'] );
						} else {
							_e( 'Call to Action', 'responsive-mobile' );
						}
						?>
					</a>

				</div><!-- end of .call-to-action -->
		</div><!-- end of #featured-image -->

	</main><!-- end of #featured -->
</div><!-- content-area -->
<?php
}
