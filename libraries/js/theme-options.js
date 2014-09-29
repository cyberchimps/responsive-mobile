// JavaScript Document
jQuery( document ).ready( function ( $ ) {

	$( ".rwd-container" ).hide();

	$( "h3.rwd-toggle" ).click( function () {
		$( this ).toggleClass( "active" ).next().slideToggle( "fast" );
		return false; //Prevent the browser jump to the link anchor
	} );


	setTimeout( function () {
		$( ".fade" ).fadeOut( "slow", function () {
			$( ".fade" ).remove();
		} );

	}, 2000 );

	// Initilise color picker.
	jQuery( '.wp-color-picker' ).wpColorPicker();
} );

(function ( $ ) {
	var dragDrop = {
		onReady: function () {
			dragDrop.drag();
		},

		drag: function () {
			var dragID;

			$( ".sortable" ).sortable( {
				'connectWith': $( ".sortable" ),
				'items': $( ".sortable li" ),
				'placeholder': 'drag-drop-placeholder',
				'stop': function ( event, ui ) {
					dragID = ui.item.parents(".drag-drop-container");
					dragID = dragID.attr("id");
					dragDrop.idArray( dragID );

				}

			} );
		},

		idArray: function ( id ) {
			var optionsArray = [];
			$( "#" + id ).find( ".sortable" ).each( function ( i ) {
				optionsArray[i] = [];
				// If there are items in the list then loop through them and add them to the array
				if ( 0 < $(this ).has("li" ).length ) {
					$( this ).children().each( function( y ) {
							optionsArray[i][y] = $( this ).attr( "id" );

					} );
				}

			} );

			// Make the array a JSON string to pass to the hidden text field and save to the database
			var stringJson = JSON.stringify(optionsArray);

			$("#responsive_mobile_theme_options\\[" + id + "\\]").val( stringJson );

		}

	};

	$( document ).ready( dragDrop.onReady );
})( jQuery );