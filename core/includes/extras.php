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

	$responsive_options = responsive_get_options();

	$sites = array (
		'twitter'      => 'Twitter',
		'facebook'     => 'Facebook',
		'linkedin'     => 'LinkedIn',
		'youtube'      => 'YouTube',
		'stumbleupon' => 'StumbleUpon',
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

/**
 * Helps file locations in child themes. If the file is not being overwritten by the child theme then
 * return the parent theme location of the file. Great for images.
 *
 * @param $dir string directory
 *
 * @return string complete uri
 */
function responsive_child_uri( $dir ) {
	if( is_child_theme() ) {
		$directory = get_stylesheet_directory() . $dir;
		$test      = is_file( $directory );
		if( is_file( $directory ) ) {
			$file = get_stylesheet_directory_uri() . $dir;
		}
		else {
			$file = get_template_directory_uri() . $dir;
		}
	}
	else {
		$file = get_template_directory_uri() . $dir;
	}

	return $file;
}

/**
 * This function removes .menu class from custom menus
 * in widgets only and fallback's on default widget lists
 * and assigns new unique class called .menu-widget
 *
 * Marko Heijnen Contribution
 *
 */
class responsive_widget_menu_class {
	public function __construct() {
		add_action( 'widget_display_callback', array( $this, 'menu_different_class' ), 10, 2 );
	}

	public function menu_different_class( $settings, $widget ) {
		if( $widget instanceof WP_Nav_Menu_Widget ) {
			add_filter( 'wp_nav_menu_args', array( $this, 'wp_nav_menu_args' ) );
		}

		return $settings;
	}

	public function wp_nav_menu_args( $args ) {
		remove_filter( 'wp_nav_menu_args', array( $this, 'wp_nav_menu_args' ) );

		if( 'menu' == $args['menu_class'] ) {
			$args['menu_class'] = apply_filters( 'responsive_menu_widget_class', 'menu_widget');
		}

		return $args;
	}
}
$GLOBALS['nav_menu_widget_classname'] = new responsive_widget_menu_class();

/**
 * wp_title() Filter for better SEO.
 *
 * Adopted from Twenty Twelve
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_title
 *
 */
if( !function_exists( 'responsive_wp_title' ) && !defined( 'AIOSEOP_VERSION' ) ) {

	function responsive_wp_title( $title, $sep ) {
		global $page, $paged;

		if( is_feed() ) {
			return $title;
		}

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary.
		if( $paged >= 2 || $page >= 2 ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'responsive' ), max( $paged, $page ) );
		}

		return $title;
	}

}
add_filter( 'wp_title', 'responsive_wp_title', 10, 2 );

/**
 * Filter 'get_comments_number'
 *
 * Filter 'get_comments_number' to display correct
 * number of comments (count only comments, not
 * trackbacks/pingbacks)
 *
 * Chip Bennett Contribution
 */
function responsive_comment_count( $count ) {
	if( !is_admin() ) {
		global $id;
		$comments         = get_comments( 'status=approve&post_id=' . $id );
		$comments_by_type = separate_comments( $comments );

		return count( $comments_by_type['comment'] );
	}
	else {
		return $count;
	}
}

add_filter( 'get_comments_number', 'responsive_comment_count', 0 );

/**
 * Breadcrumb Lists
 * Allows visitors to quickly navigate back to a previous section or the root page.
 *
 * Adopted from Dimox
 *
 */
if( !function_exists( 'responsive_breadcrumb_lists' ) ) :

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

			}
			else {

				echo '<div class="breadcrumb-list" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf( $link, $homeLink, $text['home'] ) . $delimiter;

				if( is_home() ) {
					if( $showCurrent == 1 ) {
						echo $before . get_the_title( get_option( 'page_for_posts', true ) ) . $after;
					}

				}
				elseif( is_category() ) {
					$thisCat = get_category( get_query_var( 'cat' ), false );
					if( $thisCat->parent != 0 ) {
						$cats = get_category_parents( $thisCat->parent, true, $delimiter );
						$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
						$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
						echo $cats;
					}
					echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;

				}
				elseif( is_search() ) {
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;

				}
				elseif( is_day() ) {
					echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
					echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
					echo $before . get_the_time( 'd' ) . $after;

				}
				elseif( is_month() ) {
					echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
					echo $before . get_the_time( 'F' ) . $after;

				}
				elseif( is_year() ) {
					echo $before . get_the_time( 'Y' ) . $after;

				}
				elseif( is_single() && !is_attachment() ) {
					if( get_post_type() != 'post' ) {
						$post_type = get_post_type_object( get_post_type() );
						$slug      = $post_type->rewrite;
						printf( $link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
						if( $showCurrent == 1 ) {
							echo $delimiter . $before . get_the_title() . $after;
						}
					}
					else {
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

				}
				elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
					$post_type = get_post_type_object( get_post_type() );
					echo $before . $post_type->labels->singular_name . $after;

				}
				elseif( is_attachment() ) {
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

				}
				elseif( is_page() && !$post->post_parent ) {
					if( $showCurrent == 1 ) {
						echo $before . get_the_title() . $after;
					}

				}
				elseif( is_page() && $post->post_parent ) {
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

				}
				elseif( is_tag() ) {
					echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

				}
				elseif( is_author() ) {
					global $author;
					$userdata = get_userdata( $author );
					echo $before . sprintf( $text['author'], $userdata->display_name ) . $after;

				}
				elseif( is_404() ) {
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

endif;

/**
 * Set a fallback menu that will show a home link.
 */
function responsive_fallback_menu() {
	$args    = array(
		'depth'       => 0,
		'sort_column' => 'menu_order, post_title',
		'menu_class'  => 'menu',
		'include'     => '',
		'exclude'     => '',
		'echo'        => false,
		'show_home'   => true,
		'link_before' => '',
		'link_after'  => ''
	);
	$pages   = wp_page_menu( $args );
	$prepend = '<div class="main-nav">';
	$append  = '</div>';
	$output  = $prepend . $pages . $append;
	echo $output;
}

/**
 * Removes div from wp_page_menu() and replace with ul.
 */
function responsive_wp_page_menu( $page_markup ) {
	preg_match( '/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches );
	$divclass   = $matches[1];
	$replace    = array( '<div class="' . $divclass . '">', '</div>' );
	$new_markup = str_replace( $replace, '', $page_markup );
	$new_markup = preg_replace( '/^<ul>/i', '<ul class="' . $divclass . '">', $new_markup );

	return $new_markup;
}

add_filter( 'wp_page_menu', 'responsive_wp_page_menu' );

/**
 * wp_list_comments() Pings Callback
 *
 * wp_list_comments() Callback function for
 * Pings (Trackbacks/Pingbacks)
 */
function responsive_comment_list_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php
}

/**
 * Sets the post excerpt length to 40 words.
 * Adopted from Coraline
 */
function responsive_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'responsive_excerpt_length' );

/**
 * Returns a "Read more" link for excerpts
 */
function responsive_read_more() {
	return '<div class="read-more"><a href="' . get_permalink() . '">' . __( 'Read more &#8250;', 'responsive' ) . '</a></div><!-- end of .read-more -->';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and responsive_read_more_link().
 */
function responsive_auto_excerpt_more( $more ) {
	return '<span class="ellipsis">&hellip;</span>' . responsive_read_more();
}
add_filter( 'excerpt_more', 'responsive_auto_excerpt_more' );

/**
 * Adds a pretty "Read more" link to custom post excerpts.
 */
function responsive_custom_excerpt_more( $output ) {
	if( has_excerpt() && !is_attachment() ) {
		$output .= responsive_read_more();
	}

	return $output;
}
add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );

/**
 * This function removes inline styles set by WordPress gallery.
 */
function responsive_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}

add_filter( 'gallery_style', 'responsive_remove_gallery_css' );

/**
 * This function removes default styles set by WordPress recent comments widget.
 */
function responsive_remove_recent_comments_style() {
	global $wp_widget_factory;
	if( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

add_action( 'widgets_init', 'responsive_remove_recent_comments_style' );

/**
 * This function removes WordPress generated category and tag atributes.
 * For W3C validation purposes only.
 *
 */
function responsive_category_rel_removal( $output ) {
	$output = str_replace( ' rel="category tag"', '', $output );

	return $output;
}

add_filter( 'wp_list_categories', 'responsive_category_rel_removal' );
add_filter( 'the_category', 'responsive_category_rel_removal' );

/**
 * A comment reply.
 */
function responsive_enqueue_comment_reply() {
	if( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'responsive_enqueue_comment_reply' );

/* Add fit class to third footer widget */
function footer_widgets( $params ) {

	global $footer_widget_num; //Our widget counter variable

	//Check if we are displaying "Footer Sidebar"
	if( $params[0]['id'] == 'footer-widget' ){
		$footer_widget_num++;
		$divider = 3; //This is number of widgets that should fit in one row

		//If it's third widget, add last class to it
		if( $footer_widget_num % $divider == 0 ){
			$class = 'class="fit ';
			$params[0]['before_widget'] = str_replace( 'class="', $class, $params[0]['before_widget'] );
		}

	}

	return $params;
}
add_filter( 'dynamic_sidebar_params', 'footer_widgets' );

/**
 * Front Page function starts here. The Front page overides WP's show_on_front option. So when show_on_front option changes it sets the themes front_page to 0 therefore displaying the new option
 */

function responsive_front_page_override( $new, $orig ) {
	global $responsive_options;

	if( $orig !== $new ) {
		$responsive_options['front_page'] = 0;

		update_option( 'responsive_theme_options', $responsive_options );
	}

	return $new;
}

add_filter( 'pre_update_option_show_on_front', 'responsive_front_page_override', 10, 2 );

/**
 * Funtion to add CSS class to body
 */
function responsive_add_class( $classes ) {

	// Get Responsive theme option.
	global $responsive_options;
	if( $responsive_options['front_page'] == 1 && is_front_page() ) {
		$classes[] = 'front-page';
	}

	return $classes;
}

add_filter( 'body_class', 'responsive_add_class' );
