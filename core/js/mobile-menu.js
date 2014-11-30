/*!
 * Mobile Menu
 *
 * GPL V2 License (c) CyberChimps
 */
(function ($) {
    var obj = {

        onClick: function () {
            $("#main-navigation").toggleClass("menu-open");
        }

    };

    $("nav#main-navigation").on("click", obj.onClick);
})(jQuery);
