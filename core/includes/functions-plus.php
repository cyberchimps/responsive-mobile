<?php

/**
 * Breadcrumb Lists
 * Allows visitors to quickly navigate back to a previous section or the root page.
 *
 * Adopted from Dimox
 *
 */
if( !function_exists( 'responsive_breadcrumb_lists' ) ) {

	function responsive_breadcrumb_lists() {
		$responsive_options = get_option( 'responsive_theme_options' );

		if ( 0 == $responsive_options['breadcrumb'] && !is_search() ) {

			/* === OPTIONS === */
			$text['home']     = __( 'Home', 'responsive' ); // text for the 'Home' link
			$text['category'] = __( 'Archive for %s', 'responsive' ); // text for a category page
			$text['search']   = __( 'Search results for: %s', 'responsive' ); // text for a search results page
			$text['tag']      = __( 'Posts tagged %s', 'responsive' ); // text for a tag page
			$text['author']   = __( 'View all posts by %s', 'responsive' ); // text for an author page
			$text['404']      = __( 'Error 404', 'responsive' ); // text for the 404 page

			$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
			$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
			$delimiter   = ' <span class="chevron">&#8250;</span> '; // delimiter between crumbs
			$before      = '<span class="breadcrumb-current">'; // tag before the current crumb
			$after       = '</span>'; // tag after the current crumb
			/* === END OF OPTIONS === */

			global $post, $paged, $page;
			$homeLink   = home_url( '/' );
			$linkBefore = '<span class="breadcrumb" typeof="v:Breadcrumb">';
			$linkAfter  = '</span>';
			$linkAttr   = ' rel="v:url" property="v:title"';
			$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

			if( is_front_page() ) {

				if( $showOnHome == 1 ) {
					echo '<div class="breadcrumb-list"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
				}

			} else {

				echo '<div class="breadcrumb-list" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf( $link, $homeLink, $text['home'] ) . $delimiter;

				if( is_home() ) {
					if( $showCurrent == 1 ) {
						echo $before . get_the_title( get_option( 'page_for_posts', true ) ) . $after;
					}

				} elseif( is_category() ) {
					$thisCat = get_category( get_query_var( 'cat' ), false );
					if( $thisCat->parent != 0 ) {
						$cats = get_category_parents( $thisCat->parent, true, $delimiter );
						$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
						$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
						echo $cats;
					}
					echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;

				} elseif( is_search() ) {
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;

				} elseif( is_day() ) {
					echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
					echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
					echo $before . get_the_time( 'd' ) . $after;

				} elseif( is_month() ) {
					echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
					echo $before . get_the_time( 'F' ) . $after;

				} elseif( is_year() ) {
					echo $before . get_the_time( 'Y' ) . $after;

				} elseif( is_single() && !is_attachment() ) {
					if( get_post_type() != 'post' ) {
						$post_type = get_post_type_object( get_post_type() );
						$slug      = $post_type->rewrite;
						printf( $link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
						if( $showCurrent == 1 ) {
							echo $delimiter . $before . get_the_title() . $after;
						}
					} else {
						$cat  = get_the_category();
						$cat  = $cat[0];
						$cats = get_category_parents( $cat, true, $delimiter );
						if( $showCurrent == 0 ) {
							$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
						}
						$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
						$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
						echo $cats;
						if( $showCurrent == 1 ) {
							echo $before . get_the_title() . $after;
						}
					}

				} elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
					$post_type = get_post_type_object( get_post_type() );
					echo $before . $post_type->labels->singular_name . $after;

				} elseif( is_attachment() ) {
					$parent = get_post( $post->post_parent );
					$cat    = get_the_category( $parent->ID );

					if( isset( $cat[0] ) ) {
						$cat = $cat[0];
					}

					if( $cat ) {
						$cats = get_category_parents( $cat, true, $delimiter );
						$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
						$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
						echo $cats;
					}

					printf( $link, get_permalink( $parent ), $parent->post_title );
					if( $showCurrent == 1 ) {
						echo $delimiter . $before . get_the_title() . $after;
					}

				} elseif( is_page() && !$post->post_parent ) {
					if( $showCurrent == 1 ) {
						echo $before . get_the_title() . $after;
					}

				} elseif( is_page() && $post->post_parent ) {
					$parent_id   = $post->post_parent;
					$breadcrumbs = array();
					while( $parent_id ) {
						$page_child    = get_page( $parent_id );
						$breadcrumbs[] = sprintf( $link, get_permalink( $page_child->ID ), get_the_title( $page_child->ID ) );
						$parent_id     = $page_child->post_parent;
					}
					$breadcrumbs = array_reverse( $breadcrumbs );
					for( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
						echo $breadcrumbs[$i];
						if( $i != count( $breadcrumbs ) - 1 ) {
							echo $delimiter;
						}
					}
					if( $showCurrent == 1 ) {
						echo $delimiter . $before . get_the_title() . $after;
					}

				} elseif( is_tag() ) {
					echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

				} elseif( is_author() ) {
					global $author;
					$userdata = get_userdata( $author );
					echo $before . sprintf( $text['author'], $userdata->display_name ) . $after;

				} elseif( is_404() ) {
					echo $before . $text['404'] . $after;

				}
				if( get_query_var( 'paged' ) ) {
					if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
						echo ' (';
					}
					echo $delimiter . sprintf( __( 'Page %s', 'responsive' ), max( $paged, $page ) );
					if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
						echo ')';
					}
				}

				echo '</div>';

			}
		}
	} // end responsive_breadcrumb_lists

}

function responsive_social_icons() {

	$responsive_options = responsive_get_options();

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
		'yelp'         => 'Yelp!',
		'vimeo'        => 'Vimeo',
		'foursquare'   => 'foursquare',
	);

	$html = '<ul class="social-icons">';
	foreach( $sites as $key => $value ) {
		if ( !empty( $responsive_options[$key . '_uid'] ) ) {
			$html .= '<li class="' . esc_attr( $key ) . '-icon"><a href="' . $responsive_options[$key . '_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/' . esc_attr( $key ) . '-icon.png' ) . '" width="24" height="24" alt="' . esc_html( $value ) . '">' . '</a></li>';
		}
	}
	$html .= '</ul><!-- .social-icons -->';

	return $html;

}