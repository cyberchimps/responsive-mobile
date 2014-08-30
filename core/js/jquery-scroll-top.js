/**
 * jQuery Scroll Top Plugin 1.0.0
 *
 * GPL V2 License (c) CyberChimps
 */
jQuery(document).ready(function ($) {
	$('a[href=#scroll-top]').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 'slow');
		return false;
	});
});