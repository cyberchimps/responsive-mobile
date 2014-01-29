<?php

// TODO Add docs

function responsive_activation_notice() {
	if ( isset( $_GET['activated'] ) ) {
		if ( ! isset( $_GET['previewed'] ) ) {
			$my_theme = wp_get_theme();
			$return = '<div class="updated activation"><p><strong>';
			$return .= sprintf( __( '%s activated successfuly.' ), $my_theme->get( 'Name' ) );
			$return .= '</strong> <a href="' . home_url( '/' ) . '">' . __( 'Visit site', 'responsive' ) . '</a>';
			$return .= '</p><p>';
			$return .= '<a class="button button-primary customize load-customize" href="' . admin_url( 'customize.php?theme=' . get_stylesheet() ) . '">' . __( 'Customize', 'responsive' ) . '</a>';
			$return .= ' <a class="button button-primary theme-options" href="' . admin_url( 'themes.php?page=theme_options' ) . '">' . __( 'Theme Options', 'responsive' ) . '</a>';
			$return .= ' <a class="button button-primary help" href="http://cyberchimps.com/">' . __( 'Help', 'responsive' ) . '</a>';
			$return .= '</p></div>';
		}
		echo $return;
	}
}
add_action( 'admin_notices', 'responsive_activation_notice' );

function responsive_admin_css() { ?>
	<style>
	.themes-php #message2 {
		display: none;
	}
	.themes-php div.activation a {
		text-decoration: none;
	}
	.themes-php div.activation {
		margin: 0;
	}
	</style>
<?php }
add_action( 'admin_head', 'responsive_admin_css' );


/**
 * Add plugin automation file
 */
if ( ! class_exists( 'Theme_Plugin_Dependency' ) ) {
	require_once( dirname( __FILE__ ) . '/classes/class-theme-plugin-dependency.php' );
}

/**
 * Ignore admin notice
 *
 * @since     0.1.0
 */
function responsive_nag_ignore() {
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset( $_GET[ 'responsive_nag_ignore'] ) && 'true' == $_GET[ 'responsive_ignore_notice'] ) {
		update_user_meta( $user_id, 'responsive_ignore_notice', 'true', true );
	}
	if ( isset( $_GET[ 'responsive_nag_ignore'] ) && 'false' == $_GET[ 'responsive_ignore_notice'] ) {
		delete_user_meta( $user_id, 'responsive_ignore_notice' );
	}
}
add_action( 'admin_init', 'responsive_nag_ignore' );

function display_install() {
	//$screen = get_current_screen();  && 'themes' == $screen->parent_base
	if ( current_user_can( 'manage_options' ) && current_user_can( 'install_plugins' ) ) {
		return true;
	} else {
		return false;
	}

}

// @TODO fix dismiss link and link to plugin as info.
function responsive_plugin_notice() {
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	/* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta( $user_id, 'responsive_ignore_notice' ) ) {

		$responsive_add_ons = new Theme_Plugin_Dependency( 'responsive-add-ons', 'http://wordpress.org/plugins/responsive-add-ons/' );
		if ( $responsive_add_ons->check_active() ) {
			$msg =  __( 'Responsive Add Ons is installed and activated!', 'responsive' );
		} elseif ( $responsive_add_ons->check() ) {
			$msg =  __( 'Responsive Add Ons is installed, but not activated.', 'responsive' ) . ' <a href="' . $responsive_add_ons->activate_link() . '">' . __( 'Activate Responsive Add Ons.', 'responsive' ) . '</a>';
		} elseif ( $install_link = $responsive_add_ons->install_link() ) {
			$msg =  __( 'Responsive Add Ons is not installed.', 'responsive' ) . ' <a href="' . $install_link . '">' . __( 'Install Responsive Add Ons.', 'responsive' ) . '</a>';
		} else {
			$msg = __( 'Responsive Add Ons is not installed. Please install this plugin manually.', 'responsive' );
		}
		$return = '<div class="updated"><p>';
		$msg .= ' <a href="?responsive_ignore_notice=true">' . __( 'Hide Notice' ) . '</a>';
		$return .= $msg;
		$return .= '</p></div>';
		echo $return;
	}

}

// @TODO restrict to display_install()
if ( display_install() ) {
	add_action( 'admin_notices', 'responsive_plugin_notice' );
}
