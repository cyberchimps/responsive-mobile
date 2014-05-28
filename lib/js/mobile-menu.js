///*!
// * Mobile Menu
// */
(function ($) {
    var obj = {

        onReady: function () {
            $("#main-menu").prepend(obj.render());
        },

        render: function () {
            var show = obj.display(obj.menuTitle());

            return show;
        },

        display: function (title) {
            var html = '<div id="mobile-current-item">' + title + '</div>';

            return html;
        },

        menuTitle: function () {
            var title = $(".current_page_item > a, .current-menu-item > a").first().text();

            return title;
        },

        onClick: function () {
            $("#site-navigation").toggleClass("menu-open");
            $("#mobile-current-item").css("display", "none");
        }

    };

    $(document).ready(obj.onReady);
    $("#mobile-nav-button").on("click", obj.onClick);
})(jQuery);