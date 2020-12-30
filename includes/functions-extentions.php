<?php
/**
 * Extentions
 *
 * Small extentions e.g. Breadcrumbs, Social Icons
 *
 * @package      responsive_mobile
 * @license      license.txt
 * @copyright    2014 CyberChimps Inc
 * @since        0.0.1
 *
 * Please do not edit this file. This file is part of the responsive_mobile Framework and all modifications
 * should be made in a child theme.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Breadcrumb Lists
 * Load the plugin from the plugin that is installed.
 *
 */
function responsive_mobile_get_breadcrumb_lists() {
	$responsive_mobile_options = get_option( 'responsive_mobile_theme_options' );
	$yoast_options = get_option( 'wpseo_internallinks' );
	if ( 1 == $responsive_mobile_options['breadcrumb'] ) {
		return;
	} elseif ( function_exists( 'bcn_display' ) ) {
		bcn_display();
	} elseif ( function_exists( 'breadcrumb_trail' ) ) {
		breadcrumb_trail();
	} elseif ( function_exists( 'yoast_breadcrumb' )) {
		yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
	} elseif ( ! is_search() ) {
		responsive_mobile_breadcrumb_lists();
	}
}

/**
 * Breadcrumb Lists
 * Allows visitors to quickly navigate back to a previous section or the root page.
 *
 * Adopted from Dimox
 *
 */
if ( !function_exists( 'responsive_mobile_breadcrumb_lists' ) ) {

	/**
	 * Breadcrumb Lists
	 * Allows visitors to quickly navigate back to a previous section or the root page.
	 */
	function responsive_mobile_breadcrumb_lists() {

		/* === OPTIONS === */
		$text['home'] = _x( 'Home', 'Text for Home link Breadcrumb', 'responsive-mobile' ); // text for the 'Home' link.
		/* translators: %s: Categories */
		$text['category'] = _x( 'Archive for %s', 'Text for a Category page Breadcrumb', 'responsive-mobile' ); // text for a category page.
		/* translators: %s: Search result page */
		$text['search'] = _x( 'Search results for: %s', 'Text for a Serch Results Breadcrumb', 'responsive-mobile' ); // text for a search results page.
		/* translators: %s: Post Pages */
		$text['tag'] = _x( 'Posts tagged %s', 'Text for a Tag page Breadcrumb', 'responsive-mobile' ); // text for a tag page.
		/* translators: %s: Author pages */
		$text['author'] = _x( 'View all posts by %s', 'Text for an Author page Breadcrumb', 'responsive-mobile' ); // text for an author page.
		$text['404']    = _x( 'Error 404', 'Text for a 404 page Breadcrumb', 'responsive-mobile' ); // text for the 404 page.

		$show['current'] = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show.
		$show['home']    = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show.

		$delimiter = ' <span class="chevron">&#8250;</span> '; // delimiter between crumbs.
		$before    = '<span class="breadcrumb-current">'; // tag before the current crumb.
		$after     = '</span>'; // t    ag after the current crumb.
		/* === END OF OPTIONS === */

		$home_link   = home_url( '/' );
		$before_link = '<span class="breadcrumb" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		$after_link  = '</span>';
		$link_att    = '';
		$link        = $before_link . '<a itemprop="item"' . $link_att . ' href="%1$s"><span itemprop="name">%2$s</span></a>' . $after_link;

		$post      = get_queried_object();
		$parent_id = isset( $post->post_parent ) ? $post->post_parent : '';

		$html_output = '';

		if ( is_front_page() ) {
			if ( 1 == $show['home'] ) {
				$html_output .= '<div class="breadcrumb-list"><a itemprop="item" href="' . $home_link . '"><span itemprop="name">' . $text['home'] . '</span></a></div>';
			}
		} else {
			$html_output .= '<div class="breadcrumb-list">' . sprintf( $link, $home_link, $text['home'] ) . $delimiter;

			if ( is_home() ) {
				if ( 1 == $show['current'] ) {
					$html_output .= $before . get_the_title( get_option( 'page_for_posts', true ) ) . $after;
				}
			} elseif ( is_category() ) {
				$this_cat = get_category( get_query_var( 'cat' ), false );
				if ( 0 != $this_cat->parent ) {
					$parent       = get_category( $this_cat->parent );
					$cats         = get_category_parents( $this_cat->parent, true, $delimiter );
					$cats         = str_replace( '<a', $before_link . '<a itemprop="item"' . $link_att, $cats );
					$cats         = str_replace( '</a>', '</a>' . $after_link, $cats );
					$cats         = str_replace( $parent->name, '<span itemprop="name">' . $parent->name . '</span>' . $after_link, $cats );
					$html_output .= $cats;

				}
				$html_output .= $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;

			} elseif ( is_search() ) {
				$html_output .= $before . sprintf( $text['search'], get_search_query() ) . $after;

			} elseif ( is_day() ) {
				$html_output .= sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				$html_output .= sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
				$html_output .= $before . get_the_time( 'd' ) . $after;

			} elseif ( is_month() ) {
				$html_output .= sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				$html_output .= $before . get_the_time( 'F' ) . $after;

			} elseif ( is_year() ) {
				$html_output .= $before . get_the_time( 'Y' ) . $after;

			} elseif ( is_single() && ! is_attachment() ) {
				if ( 'post' != get_post_type() ) {
					$post_type    = get_post_type_object( get_post_type() );
					$archive_link = get_post_type_archive_link( $post_type->name );
					$html_output .= sprintf( $link, $archive_link, $post_type->labels->singular_name );
					if ( 1 == $show['current'] ) {
						$html_output .= $delimiter . $before . get_the_title() . $after;
					}
				} else {
					$cat  = get_the_category();
					$cat  = $cat[0];
					$cats = get_category_parents( $cat, true, $delimiter );
					if ( 0 == $show['current'] ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", '$1', $cats );
					}
					$cats         = str_replace( '<a', $before_link . '<a itemprop="item"' . $link_att, $cats );
					$cats         = str_replace( '</a>', '</a>' . $after_link, $cats );
					$cats         = str_replace( $cat->name, '<span itemprop="name">' . $cat->name . '</span>' . $after_link, $cats );
					$html_output .= $cats;
					if ( 1 == $show['current'] ) {
						$html_output .= $before . get_the_title() . $after;
					}
				}
			} elseif ( ! is_single() && ! is_page() && ! is_404() && 'post' != get_post_type() ) {
				$post_type    = get_post_type_object( get_post_type() );
				$html_output .= $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post( $parent_id );
				$cat    = get_the_category( $parent->ID );

				if ( isset( $cat[0] ) ) {
					$cat = $cat[0];
				}

				if ( $cat ) {
					$cats         = get_category_parents( $cat, true, $delimiter );
					$cats         = str_replace( '<a', $before_link . '<a itemprop="item"' . $link_att, $cats );
					$cats         = str_replace( '</a>', '</a>' . $after_link, $cats );
					$cats         = str_replace( $cat->name, '<span itemprop="name">' . $cat->name . '</span>' . $after_link, $cats );
					$html_output .= $cats;
				}

				$html_output .= sprintf( $link, get_permalink( $parent ), $parent->post_title );
				if ( 1 == $show['current'] ) {
					$html_output .= $delimiter . $before . get_the_title() . $after;
				}
			} elseif ( is_page() && ! $parent_id ) {
				if ( 1 == $show['current'] ) {
					$html_output .= $before . get_the_title() . $after;
				}
			} elseif ( is_page() && $parent_id ) {
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page_child    = get_post( $parent_id );
					$breadcrumbs[] = sprintf( $link, get_permalink( $page_child->ID ), get_the_title( $page_child->ID ) );
					$parent_id     = $page_child->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					$html_output .= $breadcrumbs[ $i ];
					if ( $i != count( $breadcrumbs ) - 1 ) {
						$html_output .= $delimiter;
					}
				}
				if ( 1 == $show['current'] ) {
					$html_output .= $delimiter . $before . get_the_title() . $after;
				}
			} elseif ( is_tag() ) {
				$html_output .= $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

			} elseif ( is_author() ) {
				$user_id      = get_query_var( 'author' );
				$userdata     = get_the_author_meta( 'display_name', $user_id );
				$html_output .= $before . sprintf( $text['author'], $userdata ) . $after;

			} elseif ( is_404() ) {
				$html_output .= $before . $text['404'] . $after;

			}

			if ( get_query_var( 'paged' ) || get_query_var( 'page' ) ) {
				$page_num = get_query_var( 'page' ) ? get_query_var( 'page' ) : get_query_var( 'paged' );
				/* translators: %s: Page Number */
				$html_output .= $delimiter . sprintf( _x( 'Page %s', 'Text for a page Breadcrumb', 'responsive-mobile' ), $page_num );

			}

			$html_output .= '</div>';

		}
		libxml_use_internal_errors( true );
		$doc = new DOMDocument();
		$doc->loadHTML( '<?xml encoding="UTF-8">' . $html_output );
		$finder    = new DomXPath( $doc );
		$classname = 'breadcrumb';
		$nodes     = $finder->query( "//span[contains(@class, '$classname')]" );
		$position  = 1;
		foreach ( $nodes as $node ) {
			if ( $position != $nodes->length ) {
				$fragment = $doc->createDocumentFragment();
				$fragment->appendXML( '<meta itemprop="position" content="' . $position . '" />' );
				$node->appendChild( $fragment );
				$position++;
			}
		}
        echo $doc->saveHTML(); // phpcs:ignore

	} // End responsive_mobile_breadcrumb_lists.
}

function responsive_mobile_get_social_icons() {

	$responsive_mobile_options = responsive_mobile_get_options();

	$sites = array (
		'twitter'      => 'Twitter',
		'facebook'     => 'Facebook',
		'linkedin'     => 'LinkedIn',
		'youtube'      => 'YouTube',
		'stumbleupon'  => 'StumbleUpon',
		'rss'          => 'RSS Feed',
		'googleplus'   => 'Google+',
		'instagram'    => 'Instagram',
		'pinterest'    => 'Pinterest',
//		'yelp'         => 'Yelp!', TODO no font icon for yelp yet
		'vimeo'        => 'Vimeo',
		'foursquare'   => 'foursquare',
	);

	$html = '<ul class="social-icons">';
	foreach( $sites as $key => $value ) {
		if ( !empty( $responsive_mobile_options[$key . '_uid'] ) ) {
			$html .= '<li class="' . esc_attr( $key ) . '-icon"><a href="' . $responsive_mobile_options[$key . '_uid'] . '"></a></li>';
		}
	}
	$html .= '</ul><!-- .social-icons -->';

	return $html;

}

/**
 * Use shortcode_atts_gallery filter to add new defaults to the WordPress gallery shortcode.
 * Allows user input in the post gallery shortcode.
 *
 */
function responsive_mobile_gallery_atts( $out, $pairs, $atts ) {

	$full_width = is_page_template( 'full-width-page.php' ) || is_page_template( 'landing-page.php' ) || is_page_template( 'three-column-posts.php' );

	// Check if the size attribute has been set, if so use it and skip the responsive sizes
	if ( array_key_exists( 'size', $atts ) ) {
		$size = $atts['size'];
	} else {

		if ( $full_width ) {
			switch ( $out['columns'] ) {
				case 1:
					$size = 'responsive-900'; //900
					break;
				case 2:
					$size = 'responsive-450'; //450
					break;
				case 3:
					$size = 'responsive-300'; //300
					break;
				case 4:
					$size = 'responsive-200'; //225
					break;
				case 5:
					$size = 'responsive-200'; //180
					break;
				case 6:
					$size = 'responsive-150'; //150
					break;
				case 7:
					$size = 'responsive-150'; //125
					break;
				case 8:
					$size = 'responsive-150'; //112
					break;
				case 9:
					$size = 'responsive-100'; //100
					break;
			}
		} else {
			switch ( $out['columns'] ) {
				case 1:
					$size = 'responsive-600'; //600
					break;
				case 2:
					$size = 'responsive-300'; //300
					break;
				case 3:
					$size = 'responsive-200'; //200
					break;
				case 4:
					$size = 'responsive-150'; //150
					break;
				case 5:
					$size = 'responsive-150'; //120
					break;
				case 6:
					$size = 'responsive-100'; //100
					break;
				case 7:
					$size = 'responsive-100'; //85
					break;
				case 8:
					$size = 'responsive-100'; //75
					break;
				case 9:
					$size = 'responsive-100'; //66
					break;
			}
		}

	}

	$atts = shortcode_atts(
		array(
			'size' => $size,
		),
		$atts
	);

	$out['size'] = $atts['size'];

	return $out;

}
add_filter( 'shortcode_atts_gallery', 'responsive_mobile_gallery_atts', 10, 3 );

/*
 * Create image sizes for the galley
 */
add_image_size( 'responsive-100', 100, 9999 );
add_image_size( 'responsive-150', 150, 9999 );
add_image_size( 'responsive-200', 200, 9999 );
add_image_size( 'responsive-300', 300, 9999 );
add_image_size( 'responsive-450', 450, 9999 );
add_image_size( 'responsive-600', 600, 9999 );
add_image_size( 'responsive-900', 900, 9999 );
