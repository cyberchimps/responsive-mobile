// Meta Box drag and drop

jQuery(document).ready(function ($) {
	var initialize = function (id) {
		var el = $("#" + id);

		function update(base) {
			var value_set = base.find("#values");
			var val = '';
			base.find('.right-list .list-items span').each(function () {
				val += '<input type="hidden" name="' + id + '[]" value="' + $(this).data('key') + '" />';
			});
			value_set.html(val);

			el.find('.right-list .action').show();
			el.find('.left-list .action').hide();

			/* To hide subsections when element is removed from active list */
			var hidden = base.find("input[class='section-order-tracker']");
			var val = [];
			base.find('.right-list .list-items span').each(function () {
				val.push($(this).data('key'));
			})
			hidden.val(val.join(",")).change();
			$('.right-list .action').show();
			$('.left-list .action').hide();

		}

		el.find(".left-list .list-items").delegate(".action", "click", function () {
			var item = $(this).closest('.list-item');
			$(this).closest('.section-order').children('.right-list').children('.list-items').append(item);
			update($(this).closest(".section-order"));
		});
		el.find(".right-list .list-items").delegate(".action", "click", function () {
			var item = $(this).closest('.list-item');
			$(this).val('Add');
			$(this).closest('.section-order').children('.left-list').children('.list-items').append(item);
			$(this).hide();
			update($(this).closest(".section-order"));
		});
		el.find(".right-list .list-items").sortable({
			update: function () {
				update($(this).closest(".section-order"));
			},
			connectWith: '#' + id + ' .left-list .list-items',
			placeholder: 'sortable-placeholder'
		});

		el.find(".left-list .list-items").sortable({
			connectWith: '#' + id + ' .right-list .list-items',
			placeholder: 'sortable-placeholder'
		});

		update(el);
	}

	$('.section-order').each(function () {
		initialize($(this).attr('id'));

	});

	/* ****************** validation of portfolio-lite custom-link starts ***************/

	jQuery("#publish").click(function () {
		return ( validate_portfolio_link_one() && validate_portfolio_link_two() && validate_portfolio_link_three() && validate_portfolio_link_four() );
	});

	jQuery("#cyberchimps_portfolio_link_url_one").blur(function () {
		return validate_portfolio_link_one();
	});

	jQuery("#cyberchimps_portfolio_link_url_two").blur(function () {
		return validate_portfolio_link_two();
	});

	jQuery("#cyberchimps_portfolio_link_url_three").blur(function () {
		return validate_portfolio_link_three();
	});

	jQuery("#cyberchimps_portfolio_link_url_four").blur(function () {
		return validate_portfolio_link_four();
	});

	function validate_portfolio_link_one() {
		// For portfolio one
		if (jQuery('#checkbox-cyberchimps_portfolio_link_toggle_one').is(":checked")) {
			jQuery("tr.cyberchimps_portfolio_link_url_one td").append("<lable class='validation_error' id='url_validation_msg1'></lable>");
			var reg_url = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			var custom_url = jQuery("#cyberchimps_portfolio_link_url_one").val();
			if ((custom_url.search(reg_url)) == -1 || custom_url == "") {
				jQuery("#url_validation_msg1").html("Please enter a valid URL");
				alert("Please enter a valid URL for Portfolio Lite Options")
				return false;
			}
			else {
				jQuery("#url_validation_msg1").html("");
			}
		}
		return true;
	}

// For portfolio two
	function validate_portfolio_link_two() {
		if (jQuery('#checkbox-cyberchimps_portfolio_link_toggle_two').is(":checked")) {
			jQuery("tr.cyberchimps_portfolio_link_url_two td").append("<lable class='validation_error' id='url_validation_msg2'></lable>");
			var reg_url = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			var custom_url = jQuery("#cyberchimps_portfolio_link_url_two").val();
			if ((custom_url.search(reg_url)) == -1 || custom_url == "") {
				jQuery("#url_validation_msg2").html("Please enter a valid URL");
				alert("Please enter a valid URL for Portfolio Lite Options")
				return false;
			}
			else {
				jQuery("#url_validation_msg2").html("");
			}
		}
		return true;
	}

// For portfolio three
	function validate_portfolio_link_three() {
		if (jQuery('#checkbox-cyberchimps_portfolio_link_toggle_three').is(":checked")) {
			jQuery("tr.cyberchimps_portfolio_link_url_three td").append("<lable class='validation_error' id='url_validation_msg3'></lable>");
			var reg_url = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			var custom_url = jQuery("#cyberchimps_portfolio_link_url_three").val();
			if ((custom_url.search(reg_url)) == -1 || custom_url == "") {
				jQuery("#url_validation_msg3").html("Please enter a valid URL");
				alert("Please enter a valid URL for Portfolio Lite Options")
				return false;
			}
			else {
				jQuery("#url_validation_msg3").html("");
			}
		}
		return true;
	}

// For portfolio four
	function validate_portfolio_link_four() {
		if (jQuery('#checkbox-cyberchimps_portfolio_link_toggle_four').is(":checked")) {
			jQuery("tr.cyberchimps_portfolio_link_url_four td").append("<lable class='validation_error' id='url_validation_msg4'></lable>");
			var reg_url = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			var custom_url = jQuery("#cyberchimps_portfolio_link_url_four").val();
			if ((custom_url.search(reg_url)) == -1 || custom_url == "") {
				jQuery("#url_validation_msg4").html("Please enter a valid URL");
				alert("Please enter a valid URL for Portfolio Lite Options")
				return false;
			}
			else {
				jQuery("#url_validation_msg4").html("");
			}
		}
		return true;
	}
});

/* ****************** validation of portfolio-lite custom-link ends ***************/

jQuery(document).ready(function ($) {

	/**
	 * Show or hide element option boxes depending on what is displayed on the right selection
	 * of the drag and drop
	 *
	 */

	// Create an array of all the drag and drop options
	var page_subsection_map = Array;
	$('#cyberchimps_page_section_order .list-item span').each(function (i) {
		page_subsection_map[i] = $(this).data('key');
	});

	// Compare which items are selected and display them and hide all other drag and drop options on change
	$(".section-order-tracker").change(function () {
		var array = $(this).val().split(",");
		$.each(page_subsection_map, function (key, value) {
			if ($.inArray(value, array) != -1) {
				// Makes sure the element box is displayed after the page options container
				$('#' + value + '_options').insertAfter('#cyberchimps_page_options');
				$('#' + value + '_options').show(function () {
					$(this).addClass('closed');
				});

			} else {
				$("#" + value + '_options').hide();
			}
		});
	}).change();


	// image_select
	$(".image-select").each(function () {
		$(this).find("img").click(function () {
			if ($(this).hasClass('selected')) return;
			$(this).siblings("img").removeClass('selected');
			$(this).addClass('selected');
			$(this).siblings("input").val($(this).data("key"));
		});
		if ($(this).find("img.selected").length) {
			$(this).find("input").val($(this).find("img.selected").data("key"));
		}
	});

	/*
	 Add toggle switch after each checkbox.  If checked, then toggle the switch.
	 */
	$('.checkbox, .checkbox-toggle').after(function () {
		if ($(this).is(":checked")) {
			return "<a href='#' class='toggle checked' ref='" + $(this).attr("id") + "'></a>";
		} else {
			return "<a href='#' class='toggle' ref='" + $(this).attr("id") + "'></a>";
		}

	});

	/*
	 When the toggle switch is clicked, check off / de-select the associated checkbox
	 */
	$('.toggle').click(function (e) {
		var checkboxID = $(this).attr("ref");
		var checkbox = $('#' + checkboxID);

		if (checkbox.is(":checked")) {
			checkbox.removeAttr("checked").change();
		} else {
			checkbox.attr("checked", "checked").change();
		}
		$(this).toggleClass("checked");

		e.preventDefault();

	});

});

/**
 * function to allow a toggle button to hide options.
 *
 * Give the button a class of .checkbox-toggle.
 * Give the items you want hidden a class of the toggle button's id suffixed with -toggle
 *
 * e.g. a toggle button with the id of #i_am_toggle any field with a class of .i_am_toggle-toggle
 * will get shown or hidden by that toggle switch
 *
 */
(function ($) {
	var toggle_hide = function (event) {
		var id = event.data.id;
		var checked = $('#' + id).is(':checked');
		$('.' + id + '-toggle-container').each(function () {
			if ($('#' + id).is(':checked')) {
				$('.' + id + '-toggle-container').show();
			}
			else {
				$('.' + id + '-toggle-container').hide();
			}
		});
	};


	$('.at-field .checkbox-toggle').each(function () {
		$(this).on('change', {id: $(this).attr('id')}, toggle_hide);
	}).change();
})(jQuery);


/**
 * function to allow select/dropdown inputs to hide and show conditional form elements
 *
 * Give the select a class of .select-hide
 * Give the sections you want hidden the class of the key/index of the option suffixed with -select
 *
 * e.g. a select input with the options (opt1 => 'Option 1', opt2 => 'Option 2') any field with the class of
 * opt1-select will get shown when opt1 is selected and hidden when opt2 is selected.
 */
(function ($) {
	var select_hide = function (option, selected) {
		$.each(option, function (index, value) {
			$('.' + value + '-select-container').hide();
		});
		$('.' + selected + '-select-container').show();
	};

	$('.at-field .select-hide').each(function () {
		$(this).on('change',function () {
			var option = Array;
			var selected = '';
			$(this).children('option').each(function (i) {
				if ($(this).is(':selected')) {
					selected += $(this).val();
				}
				else {
					option[i] = $(this).val();
				}
			})
			select_hide(option, selected);

		}).change();
	});
})(jQuery);