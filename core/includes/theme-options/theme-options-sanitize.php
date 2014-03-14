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
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function responsive_theme_options_validate( $input ) {

	$responsive_options = responsive_get_options();
	$defaults = responsive_get_option_defaults();
	if( isset( $input['reset'] ) ) {

		$input = $defaults;

	} else {
		$settings    = responsive_theme_options_array();

		// Loop through each section
		foreach( $settings as $section ) {

			$input      = $input ? $input : array();
			$input      = apply_filters( 'responsive_settings_sanitize', $input );

			// Loop through each setting being saved and pass it through a sanitization filter
			foreach( $input as $key => $value ) {

//				@TODO @grappler the $section[ $key ]['validate'] is returning an undefined index as $key does not exist in $section so it is returning false and just continuing to save
//				so we need to make it work but we also need to not save if it does not exist as unvalidated data would be saved
				// Get the setting type (checkbox, select, etc)
				$type = isset( $section[ $key ]['validate'] ) ? $section[ $key ]['validate'] : false;

				if( $type ) {
					// Field type specific filter
//					@TODO @grappler $validate is not set anywhere
					$input[ $key ] = apply_filters( 'responsive_options_validate_' . $validate, $value, $key );
				}

				// General filter
				$input[ $key ] = apply_filters( 'responsive_options_validate', $value, $key );
			}

		}

		$input['responsive_inline_css']       = wp_kses_stripslashes( $input['responsive_inline_css'] );
		$input['responsive_inline_js_head']   = wp_kses_stripslashes( $input['responsive_inline_js_head'] );
		$input['responsive_inline_js_footer'] = wp_kses_stripslashes( $input['responsive_inline_js_footer'] );

	}

	return $input;
}

function responsive_settings_sanitize_checkbox( $input ) {
	foreach( $input as $checkbox ) {
		if( !isset( $input[$checkbox] ) ) {
			$input[$checkbox] = null;
		}
		$input[$checkbox] = ( 1 == $input[$checkbox] ? 1 : 0 );
	}
	return $input;
}
add_filter( 'responsive_options_validate_checkbox', 'responsive_settings_sanitize_checkbox' );

function responsive_settings_sanitize_layout( $input ) {
	foreach( $input as $layout ) {
		$input[ $layout ] = ( isset( $input[$layout] ) && array_key_exists( $input[$layout], responsive_get_valid_layouts() ) ? $input[$layout] : $responsive_options[$layout] );
	}
	return $input;
}
add_filter( 'responsive_options_validate_layout', 'responsive_settings_sanitize_layout' );

function responsive_settings_sanitize_editor( $input ) {
	foreach( $input as $content ) {
		$input[ $content ] = ( in_array( $input[$content], array( $defaults[$content], '' ) ) ? $defaults[$content] : wp_kses_stripslashes( $input[$content] ) );
	}
	return $input;
}
add_filter( 'responsive_options_validate_editor', 'responsive_settings_sanitize_editor' );

function responsive_settings_sanitize_url( $input ) {
	foreach( $input as $content ) {
		$input[ $content ] = esc_url_raw( $input[ $content ] );
	}
	return $input;
}
add_filter( 'responsive_options_validate_url', 'responsive_settings_sanitize_url' );

function responsive_settings_sanitize_text( $input ) {
	foreach( $input as $text ) {
		$input[ $content ] = sanitize_text_field( $input[ $text ] );
	}
	return $input;
}
add_filter( 'responsive_options_validate_text', 'responsive_settings_sanitize_text' );
