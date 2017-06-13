<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$responsive_mobile_options = responsive_mobile_get_options();
//test for first install no database
$db = get_option( 'responsive_mobile_theme_options' );
//test if all options are empty so we can display default text if they are
$empty = ( empty( $responsive_mobile_options['callout_headline'] ) && empty( $responsive_mobile_options['callout_subheadline'] ) && empty( $responsive_mobile_options['callout_content_area'] ) ) ? false : true;
$emtpy_cta = ( empty( $responsive_mobile_options['callout_cta_text'] ) ) ? false : true;

$callout_text_color=$responsive_mobile_options['callout_text_color'];
$callout_btn_text_color=$responsive_mobile_options['callout_btn_text_color'];
$callout_btn_back_color=$responsive_mobile_options['callout_btn_back_color'];

$src="";
$html = $responsive_mobile_options['callout_featured_content'];
if($html)
{
$doc = new DOMDocument();
$doc->loadHTML($html);
$xpath = new DOMXPath($doc);
$src = $xpath->evaluate("string(//img/@src)"); 
}
$img_callout= get_template_directory_uri() . "/images/background.jpg";

$img_call = $src == "" ? $img_callout : $src;

if($responsive_mobile_options['callout_toggle_btn'] == 1)
{
?>
<style>
#callout_content
{
	background:url('<?php echo $img_call; ?>');
}
</style>
<div id="callout_content" class="content-area" style="color:<?php echo $callout_text_color; ?>;">
	<main id="featured-area" role="main">

		<div id="featured-content">

			<h1 class="callout-title">
				<?php
				if ( isset( $responsive_mobile_options['callout_headline'] ) && $db && $empty ) {
					echo esc_html( $responsive_mobile_options['callout_headline'] );
				} else {
					_e( 'Hello, World!', 'responsive-mobile' );
				}
				?>
			</h1>
			<p>
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
<div class="call-to-action callout_button">

					<a href="<?php echo esc_url( $responsive_mobile_options['callout_cta_url'] ); ?>" class="btn cta-button" style="color:<?php echo $callout_btn_text_color; ?>; background:<?php echo $callout_btn_back_color; ?>;">
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
