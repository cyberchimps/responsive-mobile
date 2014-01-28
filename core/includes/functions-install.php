<?php
/**
 * Add plugin automation file
 */
if ( ! class_exists( 'Theme_Plugin_Dependency' ) ) {
	require_once( dirname( __FILE__ ) . '/classes/class-theme-plugin-dependency.php' );
}

// @TODO add dismiss link and link to plugin as info.
function responsive_plugin_notice() {

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
	$return .= $msg;
	$return .= '</p></div>';
	echo $return;

}

function display_install() {
	$screen = get_current_screen();
	if ( current_user_can( 'manage_options' ) && current_user_can( 'install_plugins' ) && 'themes' == $screen->parent_base ) {
		return true;
	} else {
		return false;
	}

}

// @TODO restrict to display_install()
add_action( 'admin_notices', 'responsive_plugin_notice' );
