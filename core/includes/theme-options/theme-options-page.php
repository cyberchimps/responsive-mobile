<?php
/**
 * Theme Options
 *
 *
 * @file           theme-options.php
 * @package        Responsive
 * @author         CyberChimps
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.9.6
 * @filesource     wp-content/themes/responsive/includes/theme-options.php
 * @link           http://themeshaper.com/2010/06/03/sample-theme-options/
 * @since          available since Release 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
function responsive_admin_enqueue_scripts( $hook_suffix ) {
	$template_directory_uri = get_template_directory_uri();

	wp_enqueue_style( 'responsive-theme-options', $template_directory_uri . '/core/includes/theme-options/theme-options.css', false, '1.0' );
	wp_enqueue_script( 'responsive-theme-options', $template_directory_uri . '/core/includes/theme-options/theme-options.js', array( 'jquery' ), '1.0' );
}

add_action( 'admin_print_styles-appearance_page_theme_options', 'responsive_admin_enqueue_scripts' );

/**
 * Load up the menu page
 */
function responsive_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'responsive' ),
		__( 'Theme Options', 'responsive' ),
		'edit_theme_options',
		'theme_options',
		'responsive_theme_options_do_page'
	);
}
add_action( 'admin_menu', 'responsive_theme_options_add_page' );

/**
 * Create the options page
 */
function responsive_theme_options_do_page() {

	if( !isset( $_REQUEST['settings-updated'] ) ) {
		$_REQUEST['settings-updated'] = false;
	}

	// Set confirmaton text for restore default option as attributes of submit_button().
	$attributes['onclick'] = 'return confirm("' . __( 'Do you want to restore? \nAll theme settings will be lost! \nClick OK to Restore.', 'responsive' ) . '")';
	?>

	<div class="wrap">
	<?php
	/**
	 * < 3.4 Backward Compatibility
	 */
	?>
	<?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
	<?php screen_icon();
	echo "<h2>" . $theme_name . " " . __( 'Theme Options', 'responsive' ) . "</h2>"; ?>


	<?php if( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options Saved', 'responsive' ); ?></strong></p></div>
	<?php endif; ?>

	<?php responsive_theme_options(); // Theme Options Hook ?>

	<?php

	$sections = responsive_theme_options_sections_array();
	$options = responsive_theme_options_array();

	if( class_exists( 'Responsive_Pro_Options' ) ) {
		$display = new Responsive_Pro_Options( $sections, $options );
	} else {
		$display = new Responsive_Options( $sections, $options );
	}

	?>
	<form method="post" action="options.php">
		<?php settings_fields( 'responsive_options' ); ?>
		<?php $responsive_options = responsive_get_options(); ?>

		<div id="rwd" class="grid col-940">
			<?php
			$display->render_display();
			?>
		</div><!-- .grid col-940 -->
	</form>
	</div><!-- wrap -->
<?php
}

/**
 * Theme options upgrade bar
 */
function responsive_upgrade_bar() {
	?>

	<div class="upgrade-callout">
		<p><img src="<?php echo get_template_directory_uri(); ?>/core/includes/theme-options/images/chimp.png" alt="CyberChimps"/>
			<?php printf( __( 'Welcome to %1$s! Upgrade to %2$s today.', 'responsive' ),
				'Responsive',
				' <a href="http://cyberchimps.com/store/responsivepro/" target="_blank" title="Responsive Pro">Responsive Pro</a> '
			); ?>
		</p>

		<div class="social-container">
			<div class="social">
				<a href="https://twitter.com/cyberchimps" class="twitter-follow-button" data-show-count="false" data-size="small">Follow @cyberchimps</a>
				<script>!function (d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (!d.getElementById(id)) {
							js = d.createElement(s);
							js.id = id;
							js.src = "//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js, fjs);
						}
					}(document, "script", "twitter-wjs");</script>
			</div>
			<div class="social">
				<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fcyberchimps.com%2F&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>
			</div>
		</div>
	</div>

<?php
}

add_action( 'responsive_theme_options', 'responsive_upgrade_bar', 1 );

/**
 * Theme Options Support and Information
 */
function responsive_theme_support() {
	?>

	<div id="info-box-wrapper" class="grid col-940">
		<div class="info-box notice">

			<a class="button" href="<?php echo esc_url( 'http://cyberchimps.com/guides/r-free/' ); ?>" title="<?php esc_attr_e( 'Guides', 'responsive' ); ?>" target="_blank">
				<?php _e( 'Instructions', 'responsive' ); ?></a>

			<a class="button button-primary" href="<?php echo esc_url( 'http://cyberchimps.com/forum/free/responsive/' ); ?>" title="<?php esc_attr_e( 'Help', 'responsive' ); ?>" target="_blank">
				<?php _e( 'Help', 'responsive' ); ?></a>

			<a class="button" href="<?php echo esc_url( 'https://webtranslateit.com/en/projects/3598-Responsive-Theme' ); ?>" title="<?php esc_attr_e( 'Translate', 'responsive' ); ?>" target="_blank">
				<?php _e( 'Translate', 'responsive' ); ?></a>

			<a class="button" href="<?php echo esc_url( 'http://cyberchimps.com/showcase/' ); ?>" title="<?php esc_attr_e( 'Showcase', 'responsive' ); ?>" target="_blank">
				<?php _e( 'Showcase', 'responsive' ); ?></a>

			<a class="button" href="<?php echo esc_url( 'http://cyberchimps.com/store/' ); ?>" title="<?php esc_attr_e( 'More Themes', 'responsive' ); ?>" target="_blank">
				<?php _e( 'More Themes', 'responsive' ); ?></a>

		</div>
	</div>

<?php
}

add_action( 'responsive_theme_options', 'responsive_theme_support', 2 );

/*
 * Add notification to Reading Settings page to notify if Custom Front Page is enabled.
 *
 * @since    1.9.4.0
 */
function responsive_front_page_reading_notice() {
	$screen = get_current_screen();
	$responsive_options = responsive_get_options();
	if ( 'options-reading' == $screen->id ) {
		$html = '<div class="updated">';
			if ( 1 == $responsive_options['front_page'] ) {
				$html .= '<p>' . sprintf( __( 'The Custom Front Page is enabled. You can disable it in the <a href="%1$s">theme settings</a>.', 'responsive' ), admin_url( 'themes.php?page=theme_options' ) ) . '</p>';
			} else {
				$html .= '<p>' . sprintf( __( 'The Custom Front Page is disabled. You can enable it in the <a href="%1$s">theme settings</a>.', 'responsive' ), admin_url( 'themes.php?page=theme_options' ) ) . '</p>';
			}
		$html .= '</div>';
		echo $html;
	}
}
add_action( 'admin_notices', 'responsive_front_page_reading_notice' );
