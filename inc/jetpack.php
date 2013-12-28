<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Responsive
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function responsive_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'responsive_jetpack_setup' );
