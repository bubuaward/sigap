(function($) {
    "use strict";
    $(document).on("ready", function() {

        // Menu Button Responsive
        $('.bt-mn-res-click').on("click", function() {
            $('.menu-nav-responsive').slideToggle();
        });

        // bt share video page
        $('.bt-share-c-p-block').on("click", function() {
            $('.popup-share-c-p-block').slideToggle();
        });


        // Slider 1
        var items = $('.slider-header .item');
        if(items.length > 1) {
             $('.slider-header').owlCarousel({
	            loop: true,
	            autoplayTimeout: 7000,
	            autoplay: true,
	            touchDrag: false,
	            mouseDrag: true,
	            autoplayHoverPause: false,
	            autoHeight: false,
	            nav: false,
	            dots: true,
	            smartSpeed: 700,
	            items: 1
	        });
        } else {
             $('.slider-header').owlCarousel({
	            loop: false,
	            autoplayTimeout: 7000,
	            autoplay: true,
	            touchDrag: true,
	            mouseDrag: false,
	            autoplayHoverPause: false,
	            autoHeight: false,
	            nav: false,
	            dots: true,
	            smartSpeed: 700,
	            items: 1
	        });
        }

        $(".slider-1-nav-left").on("click", function() {
            $(".slider-header").trigger('next.owl.carousel');
        });

        $(".slider-1-nav-right").on("click", function() {
            $(".slider-header").trigger('prev.owl.carousel');
        });

        // delegate calls to data-toggle="lightbox"
        $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
            });
        });


        // Responsive Sub Menu Click
        $('ul li.menu-item-has-children > a').on("click", function(e) {
            e.preventDefault();
            $(this).parent().find("> ul").slideToggle(300);
        });

        /* Jquery Lightbox */
        lightbox.option({
            'alwaysShowNavOnTouchDevices': true,
            'wrapAround': true
        });
        
        // Video Responsive
        $(".c-p-block-box-vid").fitVids();


        // Wow Js Animate
        new WOW().init();

    });
})(jQuery);
