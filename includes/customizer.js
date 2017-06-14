/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
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
			$( '#callout-content > p' ).text( to );
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
			$( '#callout_content' ).css( 'background-url',to );
		} );
	} );

} )( jQuery );

jQuery(document).ready(function ($) {
	//doesn't wait for images, style sheets etc..
	//is called after the DOM has been initialized
	var _custom_media = true,
		_orig_send_attachment = wp.media.editor.send.attachment;

	$('.media-upload .button.upload').click(function (e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		var id = button.attr('id').replace('_upload', '');
		_custom_media = true;
		wp.media.editor.send.attachment = function (props, attachment) {

			if (_custom_media) {
				$("#" + id).val(attachment.url);
			} else {
				return _orig_send_attachment.apply(this, [props, attachment]);
			}
			;
		}

		wp.media.editor.open(button);
		return false;
	});

	$('.add_media').on('click', function () {
		_custom_media = false;
	});

	jQuery('.responsive-layouts-wrapper img').click(function(e){

		jQuery('.grid.col-620.fit').find('img').removeClass('selected-grid');
		jQuery(this).addClass('selected-grid');
	});
});
