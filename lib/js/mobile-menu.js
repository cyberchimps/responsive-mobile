/*!
 * Mobile Menu
 */
(function ($) {
	var current = $('.main-nav li.current-menu-item a').html();
	current = $('.main-nav li.current_page_item a').html();
	if ($('span').hasClass('custom-mobile-menu-title')) {
		current = $('span.custom-mobile-menu-title').html();
	}
	else if (typeof current == 'undefined' || current === null) {
		if ($('body').hasClass('home')) {
			if ($('#logo span').hasClass('site-name')) {
				current = $('#logo .site-name a').html();
			}
			else {
				current = $('#logo img').attr('alt');
			}
		}
		else {
			if ($('body').hasClass('woocommerce') && $('h1').hasClass('page-title')) {
				current = $('h1.page-title').html();
			}
			else if ($('body').hasClass('woocommerce') && $('h1').hasClass('entry-title')) {
				current = $('h1.entry-title').html();
			}
			else if ($('body').hasClass('archive') && $('h6').hasClass('title-archive')) {
				current = $('h6.title-archive').html();
			}
			else if ($('body').hasClass('search-results') && $('h6').hasClass('title-search-results')) {
				current = $('h6.title-search-results').html();
			}
			else if ($('body').hasClass('page-template-blog-excerpt-php') && $('li').hasClass('current_page_item')) {
				current = $('li.current_page_item').text();
			}
			else if ($('body').hasClass('page-template-blog-php') && $('li').hasClass('current_page_item')) {
				current = $('li.current_page_item').text();
			}
			else if ($('h1').hasClass('post-title')) {
				current = $('h1.post-title').html();
			}
			else {
				current = '&nbsp;';
			}
		}
	}
	;
	$('.main-nav').append('<a id="responsive_menu_button"></a>');
	$('.main-nav').prepend('<div id="responsive_current_menu_item">' + current + '</div>');
	$('a#responsive_menu_button, #responsive_current_menu_item').click(function () {
		$('.js .main-nav .menu').slideToggle(function () {
			if ($(this).is(':visible')) {
				$('a#responsive_menu_button').addClass('responsive-toggle-open');
			}
			else {
				$('a#responsive_menu_button').removeClass('responsive-toggle-open');
				$('.js .main-nav .menu').removeAttr('style');
			}
		});
	});
})(jQuery);

// Close the mobile menu when clicked outside of it.
(function ($) {
	$('html').click(function () {

		// Check if the menu is open, close in that case.
		if ($('a#responsive_menu_button').hasClass('responsive-toggle-open')) {
			$('.js .main-nav .menu').slideToggle(function () {
				$('a#responsive_menu_button').removeClass('responsive-toggle-open');
				$('.js .main-nav .menu').removeAttr('style');
			});
		}
	})
})(jQuery);/*!
 * Mobile Menu
 */
(function ($) {
	var current = $('.main-nav li.current-menu-item a').html();
	current = $('.main-nav li.current_page_item a').html();
	if ($('span').hasClass('custom-mobile-menu-title')) {
		current = $('span.custom-mobile-menu-title').html();
	}
	else if (typeof current == 'undefined' || current === null) {
		if ($('body').hasClass('home')) {
			if ($('#logo span').hasClass('site-name')) {
				current = $('#logo .site-name a').html();
			}
			else {
				current = $('#logo img').attr('alt');
			}
		}
		else {
			if ($('body').hasClass('woocommerce') && $('h1').hasClass('page-title')) {
				current = $('h1.page-title').html();
			}
			else if ($('body').hasClass('woocommerce') && $('h1').hasClass('entry-title')) {
				current = $('h1.entry-title').html();
			}
			else if ($('body').hasClass('archive') && $('h6').hasClass('title-archive')) {
				current = $('h6.title-archive').html();
			}
			else if ($('body').hasClass('search-results') && $('h6').hasClass('title-search-results')) {
				current = $('h6.title-search-results').html();
			}
			else if ($('body').hasClass('page-template-blog-excerpt-php') && $('li').hasClass('current_page_item')) {
				current = $('li.current_page_item').text();
			}
			else if ($('body').hasClass('page-template-blog-php') && $('li').hasClass('current_page_item')) {
				current = $('li.current_page_item').text();
			}
			else if ($('h1').hasClass('post-title')) {
				current = $('h1.post-title').html();
			}
			else {
				current = '&nbsp;';
			}
		}
	}
	;
	$('.main-nav').append('<a id="responsive_menu_button"></a>');
	$('.main-nav').prepend('<div id="responsive_current_menu_item">' + current + '</div>');
	$('a#responsive_menu_button, #responsive_current_menu_item').click(function () {
		$('.js .main-nav .menu').slideToggle(function () {
			if ($(this).is(':visible')) {
				$('a#responsive_menu_button').addClass('responsive-toggle-open');
			}
			else {
				$('a#responsive_menu_button').removeClass('responsive-toggle-open');
				$('.js .main-nav .menu').removeAttr('style');
			}
		});
	});
})(jQuery);

// Close the mobile menu when clicked outside of it.
(function ($) {
	$('html').click(function () {

		// Check if the menu is open, close in that case.
		if ($('a#responsive_menu_button').hasClass('responsive-toggle-open')) {
			$('.js .main-nav .menu').slideToggle(function () {
				$('a#responsive_menu_button').removeClass('responsive-toggle-open');
				$('.js .main-nav .menu').removeAttr('style');
			});
		}
	})
})(jQuery);

// Stop propagation on click on menu.
jQuery('.main-nav').click(function (event) {
	var pathname = window.location.pathname;
	if (pathname != '/wp-admin/customize.php') {
		event.stopPropagation();
	}
});

// Stop propagation on click on menu.
jQuery('.main-nav').click(function (event) {
	var pathname = window.location.pathname;
	if (pathname != '/wp-admin/customize.php') {
		event.stopPropagation();
	}
});
