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