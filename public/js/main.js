/*  ---------------------------------------------------
Template Name: Ashion
Description: Ashion ecommerce template
Author: Colorib
Author URI: https://colorlib.com/
Version: 1.0
Created: Colorib
---------------------------------------------------------  */

"use strict";
$(document).ready(function() {
    $('.login-drop').on('mouseenter mouseleave click', function(e) {
        e.stopPropagation();
        if (e.type === 'click' || $(this).is(':hover')) {
            $(this).toggleClass('show');
            $(this).find('.login-dropdown').toggleClass('show');
        } else {
            $(this).removeClass('show');
            $(this).find('.login-dropdown').removeClass('show');
        }
    });
});

function getCheckedValues(selector) {
    let values = [];
    $(selector + ':checked').each(function() {
        values.push($(this).val());
    });
    return values;
}

function parseCurrency(value) {
    let numericValue = value.replace(/[^0-9.]/g, '');
    return parseFloat(numericValue);
}

(function ($) {
    /*------------------
        Preloader
    --------------------*/
    $(window).on("load", function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Product filter
        --------------------*/
        $(".filter__controls li").on("click", function () {
            $(".filter__controls li").removeClass("active");
            $(this).addClass("active");
        });
        if ($(".property__gallery").length > 0) {
            var containerEl = document.querySelector(".property__gallery");
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $(".set-bg").each(function () {
        var bg = $(this).data("setbg");
        $(this).css("background-image", "url(" + bg + ")");
    });

    //Search Switch
    $(".search-switch").on("click", function () {
        $(".search-model").fadeIn(400);
    });

    $(".search-close-switch").on("click", function () {
        $(".search-model").fadeOut(400, function () {
            $("#search-input").val("");
        });
    });

    //Canvas Menu
    $(".canvas__open").on("click", function () {
        $(".offcanvas-menu-wrapper").addClass("active");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".offcanvas-menu-overlay, .offcanvas__close").on("click", function () {
        $(".offcanvas-menu-wrapper").removeClass("active");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".header__menu").slicknav({
        prependTo: "#mobile-menu-wrap",
        allowParentLinks: true,
    });

    /*------------------
        Accordin Active
    --------------------*/
    $(".collapse").on("shown.bs.collapse", function () {
        $(this).prev().addClass("active");
    });

    $(".collapse").on("hidden.bs.collapse", function () {
        $(this).prev().removeClass("active");
    });

    /*--------------------------
        Banner Slider
    ----------------------------*/
    $(".banner__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*--------------------------
        Product Details Slider
    ----------------------------*/
    $(".product__details__pic__slider")
        .owlCarousel({
            loop: false,
            margin: 0,
            items: 1,
            dots: false,
            nav: true,
            navText: [
                "<i class='arrow_carrot-left'></i>",
                "<i class='arrow_carrot-right'></i>",
            ],
            smartSpeed: 1200,
            autoHeight: false,
            autoplay: false,
            mouseDrag: false,
            startPosition: "URLHash",
        })
        .on("changed.owl.carousel", function (event) {
            var indexNum = event.item.index + 1;
            product_thumbs(indexNum);
        });

    function product_thumbs(num) {
        var thumbs = document.querySelectorAll(".product__thumb a");
        thumbs.forEach(function (e) {
            e.classList.remove("active");
            if (e.hash.split("-")[1] == num) {
                e.classList.add("active");
            }
        });
    }

    /*------------------
		Magnific
    --------------------*/
    $(".image-popup").magnificPopup({
        type: "image",
    });

    $(".nice-scroll").niceScroll({
        cursorborder: "",
        cursorcolor: "#dddddd",
        boxzoom: false,
        cursorwidth: 5,
        background: "rgba(0, 0, 0, 0.2)",
        cursorborderradius: 50,
        horizrailenabled: false,
    });

    /*------------------
        CountDown
    --------------------*/
    // For demo preview start
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, "0");
    var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
    var yyyy = today.getFullYear();

    if (mm == 12) {
        mm = "01";
        yyyy = yyyy + 1;
    } else {
        mm = parseInt(mm) + 1;
        mm = String(mm).padStart(2, "0");
    }
    var timerdate = mm + "/" + dd + "/" + yyyy;
    // For demo preview end
    // For demo preview start
    document.addEventListener("DOMContentLoaded", function () {
        // Thời gian còn lại ban đầu lấy từ server
        var days = parseInt(document.getElementById("days").innerText);
        var hours = parseInt(document.getElementById("hours").innerText);
        var minutes = parseInt(document.getElementById("minutes").innerText);
        var seconds = parseInt(document.getElementById("seconds").innerText);

        // Hàm cập nhật thời gian còn lại
        function updateCountdown() {
            if (seconds > 0) {
                seconds--;
            } else {
                if (minutes > 0) {
                    minutes--;
                    seconds = 59;
                } else {
                    if (hours > 0) {
                        hours--;
                        minutes = 59;
                        seconds = 59;
                    } else {
                        if (days > 0) {
                            days--;
                            hours = 23;
                            minutes = 59;
                            seconds = 59;
                        }
                    }
                }
            }

            // Cập nhật giá trị hiển thị
            document.getElementById("days").innerText = days;
            document.getElementById("hours").innerText = hours;
            document.getElementById("minutes").innerText = minutes;
            document.getElementById("seconds").innerText = seconds;
        }

        // Cập nhật đếm ngược mỗi giây
        setInterval(updateCountdown, 1000);
    });

    // Uncomment below and use your date //

    /* var timerdate = "2020/12/30" */

    // $("#countdown-time").countdown(timerdate, function (event) {
    //     $(this).html(
    //         event.strftime(
    //             "<div class='countdown__item'><span>%D</span> <p>Day</p> </div>" +
    //                 "<div class='countdown__item'><span>%H</span> <p>Hour</p> </div>" +
    //                 "<div class='countdown__item'><span>%M</span> <p>Min</p> </div>" +
    //                 "<div class='countdown__item'><span>%S</span> <p>Sec</p> </div>"
    //         )
    //     );
    // });

    /*-------------------
		Range Slider
	--------------------- */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data("min"),
        maxPrice = rangeSlider.data("max");
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val("¥" + ui.values[0]);
            maxamount.val("¥" + ui.values[1]);
        },
    });
    minamount.val("¥" + rangeSlider.slider("values", 0));
    maxamount.val("¥" + rangeSlider.slider("values", 1));

    /*------------------
		Single Product
	--------------------*/
    $(".product__thumb .pt").on("click", function () {
        var imgurl = $(this).data("imgbigurl");
        var bigImg = $(".product__big__img").attr("src");
        if (imgurl != bigImg) {
            $(".product__big__img").attr({ src: imgurl });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $(".pro-qty");
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on("click", ".qtybtn", function () {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.hasClass("inc")) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });

    /*-------------------
		Radio Btn
	--------------------- */
    $(".size__btn label").on("click", function () {
        $(".size__btn label").removeClass("active");
        $(this).addClass("active");
    });

    // $(document).ready(function () {
    //     // Function to get selected filters
    //     function getFilters() {
    //         return {
    //             parentCategory: $(".filter__controls .active a").data(
    //                 "parentcategory"
    //             ),
    //             childCategory: $(".filter__controls .active a").data(
    //                 "childcategory"
    //             ),
    //             colors: $(".color-filter:checked")
    //                 .map(function () {
    //                     return $(this).val();
    //                 })
    //                 .get(),
    //             sizes: $(".size-filter:checked")
    //                 .map(function () {
    //                     return $(this).val();
    //                 })
    //                 .get(),
    //             minPrice: parseInt($("#minamount").val()),
    //             maxPrice: parseInt($("#maxamount").val()),
    //         };
    //     }

    //     // Function to send AJAX request
    //     function applyFilters() {
    //         var filters = getFilters();

    //         $.ajax({
    //             url: "/shop/filter-products", // URL to your controller
    //             type: "GET",
    //             data: filters,
    //             success: function (response) {
    //                 // Handle success, e.g., update the product list
    //                 $("#product-list").html(response);
    //             },
    //             error: function (xhr, status, error) {
    //                 // Handle error
    //                 console.error("Error:", error);
    //             },
    //         });
    //     }

    //     // Event handlers for filters
    //     $(".filter__controls li").on("click", function () {
    //         // Handle category selection
    //         $(".filter__controls li").removeClass("active");
    //         $(this).addClass("active");
    //         applyFilters();
    //     });

    //     $(".size-filter").on("change", function () {
    //         // Handle size filter change
    //         applyFilters();
    //     });

    //     $(".color-filter").on("change", function () {
    //         // Handle color filter change
    //         applyFilters();
    //     });

    //     $("#minamount, #maxamount").on("change", function () {
    //         // Handle price range change
    //         applyFilters();
    //     });
    // });


})(jQuery);
