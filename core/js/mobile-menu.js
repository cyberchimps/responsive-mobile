/*!
 * Mobile Menu
 */
(function ($) {
    var obj = {

        onClick: function () {
            $("#site-navigation").toggleClass("menu-open");
        }

    };

    $("#mobile-nav-button").on("click", obj.onClick);
})(jQuery);
