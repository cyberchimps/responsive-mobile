<?php
/*
Simple class to let themes add dependencies on plugins
@link http://ottopress.com/2012/themeplugin-dependencies/
@author Otto
*/
class Theme_Plugin_Dependency {

	// input information from the theme
	var $slug;
	var $uri;

	// installed plugins and uris of them
	private $plugins; // holds the list of plugins and their info
	private $uris; // holds just the URIs for quick and easy searching

	// both slug and PluginURI are required for checking things
	public function __construct( $slug, $uri ) {
		$this->slug = $slug;
		$this->uri = $uri;
		if ( empty( $this->plugins ) )
			$this->plugins = get_plugins();
		if ( empty( $this->uris ) )
			$this->uris = wp_list_pluck( $this->plugins, 'PluginURI' );
	}

	// return true if installed, false if not
	public function check() {
		return in_array( $this->uri, $this->uris );
	}

	// return true if installed and activated, false if not
	public function check_active() {
		$plugin_file = $this->get_plugin_file();
		if ( $plugin_file ) {
			return is_plugin_active( $plugin_file );
		} else {
			return false;
		}
	}

	// gives a link to activate the plugin
	public function activate_link() {
		$plugin_file = $this->get_plugin_file();
		if ( $plugin_file ) {
			return wp_nonce_url( self_admin_url('plugins.php?action=activate&plugin=' . $plugin_file ), 'activate-plugin_' . $plugin_file );
		} else {
			return false;
		}
	}

	// return a nonced installation link for the plugin. checks wordpress.org to make sure it's there first.
	public function install_link() {
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$info = plugins_api('plugin_information', array('slug' => $this->slug ));

		if ( is_wp_error( $info ) ) {
			return false; // plugin not available from wordpress.org
		} else {
			return wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $this->slug ), 'install-plugin_' . $this->slug );
		}
	}

	// return array key of plugin if installed, false if not, private because this isn't needed for themes, generally
	private function get_plugin_file() {
		return array_search( $this->uri, $this->uris );
	}
}
