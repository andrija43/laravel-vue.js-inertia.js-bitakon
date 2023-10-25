/***************************************************
==================== JS INDEX ======================
****************************************************
01. PreLoader Js


****************************************************/

(function ($) {
    "use strict";

    var windowOn = $(window);
    ////////////////////////////////////////////////////
    // 01. PreLoader Js
    windowOn.on("load", function () {
        $("#loading").fadeOut(500);
    });

    $("body").addClass("nft-body-connect");

    $(document).on("click", "#theme-setting-toggle", function () {
        $(".theme__settings").addClass("theme-setting-opened");
    });

    $(document).on("click", "#theme-setting-close", function () {
        $(".theme__settings").removeClass("theme-setting-opened");
    });

    const colorInput = document.querySelector("input[data-color=color]");
    const colorVariable = "--tp-theme-1";
    const colorVariable2 = "--tp-theme-2";

    if (colorInput) {
        colorInput.addEventListener("change", function (e) {
            var clr = e.target.value;
            document.documentElement.style.setProperty(colorVariable, clr);
            document.documentElement.style.setProperty(colorVariable2, clr);
        });
    }

    var styleMode = document.querySelector(
        'meta[name="theme-style-mode"]'
    ).content;
    var cookieKey =
        styleMode == 1
            ? "client_dark_mode_style_cookie"
            : "client_light_mode_style_cookie";
    if (Cookies.get(cookieKey) == "dark") {
        $("body").removeClass("active-light-mode");
        $("body").addClass("active-dark-mode");
    } else if (Cookies.get(cookieKey) == "light") {
        $("body").removeClass("active-dark-mode");
        $("body").addClass("active-light-mode");
    } else {
        if (styleMode == 1) {
            $("body").addClass("active-dark-mode");
        } else {
            $("body").addClass("active-light-mode");
        }
    }
    windowOn.on("load", function () {
        ////////////////////////////////////////////////////
        // 02. Mobile Menu Js
        $("#mobile-menu").meanmenu({
            meanMenuContainer: ".mobile-menu",
            meanScreenWidth: "1199",
            meanExpand: ['<i class="fal fa-plus"></i>'],
        });
    });
    ////////////////////////////////////////////////////
    // 03. Sidebar Js
    $(document).on("click", ".offcanvas-toggle-btn", function () {
        $(".offcanvas__area").addClass("opened");
        $(".body-overlay").addClass("opened");
    });
    $(document).on("click", ".offcanvas__close-btn", function () {
        $(".offcanvas__area").removeClass("opened");
        $(".body-overlay").removeClass("opened");
    });

    ////////////////////////////////////////////////////
    // 04. Body overlay Js
    $(document).on("click", ".body-overlay", function () {
        $(".offcanvas__area").removeClass("opened");
        $(".body-overlay").removeClass("opened");
    });

    ////////////////////////////////////////////////////
    // 05. Search Js
    $(document).on("click", ".search-toggle", function () {
        $(".search__area").addClass("opened");
    });
    $(document).on("click", ".search-close-btn", function () {
        $(".search__area").removeClass("opened");
    });

    ////////////////////////////////////////////////////
    // 06. Sticky Header Js
    windowOn.on("scroll", function () {
        var scroll = $(window).scrollTop();
        if (scroll < 100) {
            $("#header-sticky").removeClass("header-sticky");
        } else {
            $("#header-sticky").addClass("header-sticky");
        }
    });

    ////////////////////////////////////////////////////
    // 07. Data CSS Js
    $("[data-background").each(function () {
        $(this).css(
            "background-image",
            "url( " + $(this).attr("data-background") + "  )"
        );
    });

    $("[data-width]").each(function () {
        $(this).css("width", $(this).attr("data-width"));
    });

    $("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"));
    });

    ////////////////////////////////////////////////////
    // 07. Nice Select Js
    $("select").niceSelect();

    ////////////////////////////////////////////////////
    // 13. Masonary Js
    $(".grid").imagesLoaded(function () {
       

        //for menu active class
        $(".masonary-menu button").on("click", function (event) {
            $(this).siblings(".active").removeClass("active");
            $(this).addClass("active");
            event.preventDefault();
        });
    });

  

    ////////////////////////////////////////////////////
    // 14. Wow Js
    new WOW().init();

    ////////////////////////////////////////////////////
    // 16. Cart Quantity Js
    $(".cart-minus").click(function () {
        var $input = $(this).parent().find("input");
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $(".cart-plus").click(function () {
        var $input = $(this).parent().find("input");
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    ////////////////////////////////////////////////////
    // 17. Show Login Toggle Js
    $("#showlogin").on("click", function () {
        $("#checkout-login").slideToggle(900);
    });

    ////////////////////////////////////////////////////
    // 18. Show Coupon Toggle Js
    $("#showcoupon").on("click", function () {
        $("#checkout_coupon").slideToggle(900);
    });

    ////////////////////////////////////////////////////
    // 19. Create An Account Toggle Js
    $("#cbox").on("click", function () {
        $("#cbox_info").slideToggle(900);
    });

    ////////////////////////////////////////////////////
    // 20. Shipping Box Toggle Js
    $("#ship-box").on("click", function () {
        $("#ship-box-info").slideToggle(1000);
    });

 

    ////////////////////////////////////////////////////
    // 22. Parallax Js
    if ($(".scene").length > 0) {
        $(".scene").parallax({
            scalarX: 10.0,
            scalarY: 15.0,
        });
    }

    ////////////////////////////////////////////////////
    // 23. InHover Active Js
    $(".hover__active").on("mouseenter", function () {
        $(this)
            .addClass("active")
            .parent()
            .siblings()
            .find(".hover__active")
            .removeClass("active");
    });

    function importData() {
        let input = document.createElement("input");
        input.type = "file";
        input.onchange = (_) => {
            // you can use this method to get file and perform respective operations
            let files = Array.from(input.files);
            console.log(files);
        };
        input.click();
    }

    $(".cover-img-popup").change(function () {
        var fileName = $(this).val();
        if (fileName.length > 0) {
            $(this).parent().children("span").html(fileName);
        } else {
            $(this).parent().children("span").html("Choose file");
        }
    });
    //file input preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".tp-img-cover img").attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".cover-img-popup").change(function () {
        readURL(this);
    });

    $(".profile-img-popup").change(function () {
        var fileName = $(this).val();
        if (fileName.length > 0) {
            $(this).parent().children("span").html(fileName);
        } else {
            $(this).parent().children("span").html("Choose file");
        }
    });

    //file input preview
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".tp-img-profile img").attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".profile-img-popup").change(function () {
        readURL2(this);
    });

    if ($("#nft-slider").length > 0) {
        var stepsSlider = document.getElementById("nft-slider");
        var input0 = document.getElementById("input-with-keypress-0");
        var input1 = document.getElementById("input-with-keypress-1");
        var inputs = [input0, input1];

        noUiSlider.create(stepsSlider, {
            start: [0, 4],
            connect: true,
            range: {
                min: [0],
                max: 10,
            },
        });

        stepsSlider.noUiSlider.on("update", function (values, handle) {
            inputs[handle].value = values[handle];
        });
    }
})(jQuery);
