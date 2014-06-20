// JavaScript Document
jQuery(document).ready(function ($) {

	$(".rwd-container").hide();

	$("h3.rwd-toggle").click(function () {
		$(this).toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});


	setTimeout(function () {
		$(".fade").fadeOut("slow", function () {
			$(".fade").remove();
		});

	}, 2000);
	
	// Initilise color picker.
	jQuery('.wp-color-picker').wpColorPicker();
});

(function ($) {
	var dragDrop = {
		onReady: function() {
			dragDrop.drag();
		},

		drag: function() {
			$(".sortable").sortable( {
				'connectWith': $(".sortable"),
				'containment': $(".drag-drop-container"),
				'items': $(".sortable li"),
				'placeholder': 'drag-drop-placeholder',
				'update': function( event, ui ) {
					dragDrop.idArray(ui.item.parent().parent().parent().attr('id'));

				}
			});
		},

		idArray: function(id) {
			var optionsArray = [];
			var liveArray = [];
			$("#" + id).find(".sortable").each(function(i){
				// don't save the list items
				if ( 0 !== i ) {
					$(this).children().each(function(y){
						liveArray[y] = $(this).attr("id");
					});
					optionsArray[i] = liveArray;
				}

			})
			console.log(optionsArray);

		}

	};

	$( document).ready( dragDrop.onReady );
})(jQuery);