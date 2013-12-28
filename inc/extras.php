<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Responsive
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function responsive_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'responsive_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function responsive_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'responsive_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function responsive_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'responsive' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'responsive_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function responsive_setup_author() {
		global $wp_query;

		if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
				$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
		}
}
add_action( 'wp', 'responsive_setup_author' );

function responsive_social_icons() {

	echo '<ul class="social-icons">';

	if( !empty( $responsive_options['twitter_uid'] ) ) {
		echo '<li class="twitter-icon"><a href="' . $responsive_options['twitter_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/twitter-icon.png' ) . '" width="24" height="24" alt="Twitter">' . '</a></li>';
	}

	if( !empty( $responsive_options['facebook_uid'] ) ) {
		echo '<li class="facebook-icon"><a href="' . $responsive_options['facebook_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/facebook-icon.png' ) . '" width="24" height="24" alt="Facebook">' . '</a></li>';
	}

	if( !empty( $responsive_options['linkedin_uid'] ) ) {
		echo '<li class="linkedin-icon"><a href="' . $responsive_options['linkedin_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/linkedin-icon.png' ) . '" width="24" height="24" alt="LinkedIn">' . '</a></li>';
	}

	if( !empty( $responsive_options['youtube_uid'] ) ) {
		echo '<li class="youtube-icon"><a href="' . $responsive_options['youtube_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/youtube-icon.png' ) . '" width="24" height="24" alt="YouTube">' . '</a></li>';
	}

	if( !empty( $responsive_options['stumble_uid'] ) ) {
		echo '<li class="stumble-upon-icon"><a href="' . $responsive_options['stumble_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/stumble-upon-icon.png' ) . '" width="24" height="24" alt="StumbleUpon">' . '</a></li>';
	}

	if( !empty( $responsive_options['rss_uid'] ) ) {
		echo '<li class="rss-feed-icon"><a href="' . $responsive_options['rss_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/rss-feed-icon.png' ) . '" width="24" height="24" alt="RSS Feed">' . '</a></li>';
	}

	if( !empty( $responsive_options['google_plus_uid'] ) ) {
		echo '<li class="google-plus-icon"><a href="' . $responsive_options['google_plus_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/googleplus-icon.png' ) . '" width="24" height="24" alt="Google Plus">' . '</a></li>';
	}

	if( !empty( $responsive_options['instagram_uid'] ) ) {
		echo '<li class="instagram-icon"><a href="' . $responsive_options['instagram_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/instagram-icon.png' ) . '" width="24" height="24" alt="Instagram">' . '</a></li>';
	}

	if( !empty( $responsive_options['pinterest_uid'] ) ) {
		echo '<li class="pinterest-icon"><a href="' . $responsive_options['pinterest_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/pinterest-icon.png' ) . '" width="24" height="24" alt="Pinterest">' . '</a></li>';
	}

	if( !empty( $responsive_options['yelp_uid'] ) ) {
		echo '<li class="yelp-icon"><a href="' . $responsive_options['yelp_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/yelp-icon.png' ) . '" width="24" height="24" alt="Yelp!">' . '</a></li>';
	}

	if( !empty( $responsive_options['vimeo_uid'] ) ) {
		echo '<li class="vimeo-icon"><a href="' . $responsive_options['vimeo_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/vimeo-icon.png' ) . '" width="24" height="24" alt="Vimeo">' . '</a></li>';
	}

	if( !empty( $responsive_options['foursquare_uid'] ) ) {
		echo '<li class="foursquare-icon"><a href="' . $responsive_options['foursquare_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/foursquare-icon.png' ) . '" width="24" height="24" alt="foursquare">' . '</a></li>';
	}

	echo '</ul><!-- end of .social-icons -->';
}
