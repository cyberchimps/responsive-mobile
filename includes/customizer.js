/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	wp.customize( 'responsive_mobile_theme_options[front_page]', function( value ) {
		value.bind( function( to ) {
			$( '#content' ).toggle();
		} );
	} );

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-name a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	wp.customize( 'responsive_mobile_theme_options[home_headline]', function( value ) {
		value.bind( function( to ) {
			$( '.featured-title' ).text( to );
		} );
	} );
	wp.customize( 'responsive_mobile_theme_options[home_subheadline]', function( value ) {
		value.bind( function( to ) {
			$( '.featured-subtitle' ).text( to );
		} );
	} );
	wp.customize( 'responsive_mobile_theme_options[home_content_area]', function( value ) {
		value.bind( function( to ) {
			$( '#featured-content > p' ).text( to );
		} );
	} );
	wp.customize( 'responsive_mobile_theme_options[cta_url]', function( value ) {
		value.bind( function( to ) {
			$( '.call-to-action > a' ).attr('href', to );
		} );
	} );
	wp.customize( 'responsive_mobile_theme_options[cta_text]', function( value ) {
		value.bind( function( to ) {
			$( '.call-to-action > a' ).text( to );
		} );
	} );
        /******************  Services ************************************/
        wp.customize( 'responsive_mobile_theme_options[services_toggle_btn]', function( value ) {
		value.bind( function( to ) {
			$( '#services_section' ).toggle();
		} );
	} );
        wp.customize( 'responsive_mobile_theme_options[services_title]', function( value ) {
		value.bind( function( to ) {
			$( '.service_section_title' ).text( to );
		} );
	} );
      /******************  Testimonial ************************************/
        wp.customize( 'responsive_mobile_theme_options[testimonial_toggle_btn]', function( value ) {
		value.bind( function( to ) {
			$( '#testimonial_section' ).toggle();
		} );
	} );
        wp.customize( 'responsive_mobile_theme_options[testimonial_title]', function( value ) {
		value.bind( function( to ) {
			$( '.testimonial_section_title' ).text( to );
		} );
	} );
         /******************  Contact US ************************************/
          wp.customize( 'responsive_mobile_theme_options[enable_contact]', function( value ) {
		value.bind( function( to ) {
			$( '#contact_us_section' ).toggle();
		} );
	} );
        wp.customize( 'responsive_mobile_theme_options[contact_title]', function( value ) {
		value.bind( function( to ) {
			$( '.contact_section_title' ).text( to );
		} );
	} );
        wp.customize( 'responsive_mobile_theme_options[contact_address]', function( value ) {
		value.bind( function( to ) {
			$( '.contact_adr' ).text( to );
		} );
	} );
         wp.customize( 'responsive_mobile_theme_options[contact_number]', function( value ) {
		value.bind( function( to ) {
			$( '.contact_no' ).text( to );
		} );
	} );
        wp.customize( 'responsive_mobile_theme_options[contact_email]', function( value ) {
		value.bind( function( to ) {
			$( '.contact_emailid' ).text( to );
		} );
	} );
          
/* Callout */
	wp.customize( 'responsive_mobile_theme_options[callout_toggle_btn]', function( value ) {
		value.bind( function( to ) {
			$( '#callout_content' ).toggle();
		} );
	} );

	wp.customize( 'responsive_mobile_theme_options[callout_headline]', function( value ) {
		value.bind( function( to ) {
			$( '.callout-title' ).text( to );
		} );
	} );

	wp.customize( 'responsive_mobile_theme_options[callout_content_area]', function( value ) {
		value.bind( function( to ) {
			$( '.callout-text' ).text( to );
		} );
	} );

	wp.customize( 'responsive_mobile_theme_options[callout_text_color]', function( value ) {
		value.bind( function( to ) {
			$( '#callout_content').css( 'color',to );
		} );
	} );

	wp.customize( 'responsive_mobile_theme_options[callout_cta_url]', function( value ) {
		value.bind( function( to ) {
			$( '.callout_button > a' ).attr('href', to );
		} );
	} );
	wp.customize( 'responsive_mobile_theme_options[callout_cta_text]', function( value ) {
		value.bind( function( to ) {
			$( '.callout_button > a' ).text( to );
		} );
	} );

	wp.customize( 'responsive_mobile_theme_options[callout_btn_text_color]', function( value ) {
		value.bind( function( to ) {
			$( '.callout_button > a' ).css( 'color',to );
		} );
	} );

	wp.customize( 'responsive_mobile_theme_options[callout_btn_back_color]', function( value ) {
		value.bind( function( to ) {
			$( '.callout_button > a' ).css( 'background',to );
		} );
	} );

	wp.customize( 'responsive_mobile_theme_options[callout_featured_content]', function( value ) {
		value.bind( function( to ) {
			$( '#callout_content' ).css( 'background','url(' + to + ')' );
		} );
	} );
        wp.customize( 'responsive_mobile_theme_options[services_featured_image]', function( value ) {
		value.bind( function( to ) {
			$( '.services_featured_img' ).attr( 'src',to );
		} );
	} );
	
	wp.customize( 'responsive_mobile_theme_options[team]', function( value ) {
		value.bind( function( to ) {
			$( '#team_inner_div' ).toggle();
		} );
	} );

} )( jQuery );

