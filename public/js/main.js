//main.js
$(function () {
    $("#showmenu").click(function () {
        if ($(".side-menu").width() > "60") {
            $(".side-menu").animate({
                width: '-=205px'
            });
            $(".main-section").animate({
                'margin-left': '-=205px'
            });
            $(".ch1").text("TC");
            $(".cp").text("______");
            $("span.text").hide();
            $(".menu i").show();
        } else {
            $(".side-menu").animate({
                width: '+=205px'
            });
            $(".main-section").animate({
                'margin-left': '+=205px'
            });
            $(".ch1").text("Teluk Coding");
            $(".cp").text("Admin Panel | Dashboard");
            $("span.text").show("slow");
        }
    });
});

jQuery(function ($) {
    $(".sidebar-dropdown > a").click(function () {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
            .parent()
            .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").click(function () {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function () {
        $(".page-wrapper").addClass("toggled");
    });

});
