/*!
 * Mobile Menu
 */
(function ($) {
    var obj = {

        onClick: function () {
            $("#site-navigation").toggleClass("menu-open");
        }

    };

    $(document).ready(obj.onReady);
    $("#mobile-nav-button").on("click", obj.onClick);
})(jQuery);
