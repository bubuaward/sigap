(function($) {
    "use strict";
    $(document).on("ready", function() {

        /* Jquery Lightbox */
        lightbox.option({
            'alwaysShowNavOnTouchDevices': true,
            'wrapAround': true
        });

        // delegate calls to data-toggle="lightbox"
        $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
            });
        });

        // Menu Button Responsive
        $('.bt-mn-res-click').on("click", function() {
            $('.menu-nav-responsive').slideToggle();
        });

        // bt share video page
        $('.bt-share-c-p-block').on("click", function() {
            $('.popup-share-c-p-block').slideToggle();
        });

        // bt donate
        $('#val-don1').on("click", function() {
            var myval = document.getElementById('get-val-don1').value;
            $("#set-val-don").val((myval));
        });
        $('#val-don2').on("click", function() {
            var myval = document.getElementById('get-val-don2').value;
            $("#set-val-don").val((myval));
        });
        $('#val-don3').on("click", function() {
            var myval = document.getElementById('get-val-don3').value;
            $("#set-val-don").val((myval));
        });
        $('#bt-other-don-nom').on("click", function() {
            $("#set-val-don").val("");
        });

        // button donate jumlah
        $('.bt-don-nom').click(function(){
            $('.bt-don-nom').removeClass('current');
            $(this).addClass('current');
        });

        // function bt other
        $('#bt-other-don-nom').click(function(){
            $('.bt-don-nom').removeClass('current');
            $(this).addClass('current');
        });

        // function bt other
        $('#bt-other-don-nom').click(function(){
            $('.wrap-no-kartu-input').addClass('wrap-no-kartu-input-hide');
            $('.wrap-other-bt-donate').addClass('wrap-other-bt-donate-show');
            $('.method-pay2').addClass('method-pay2-show');
            $('.method-pay1').addClass('method-pay1-hide');
            $('.donn2').addClass('donn2-show');
            $('.donn1').addClass('donn1-hide');
        });
        $('.bt-val-don-nom').click(function(){
            $('.wrap-no-kartu-input').removeClass('wrap-no-kartu-input-hide');
            $('.wrap-other-bt-donate').removeClass('wrap-other-bt-donate-show');
            $('.method-pay2').removeClass('method-pay2-show');
            $('.method-pay1').removeClass('method-pay1-hide');
            $('.donn2').removeClass('donn2-show');
            $('.donn1').removeClass('donn1-hide');
        });

        // Slider 1
        var items = $('.slider-header .item');
        if(items.length > 1) {
             $('.slider-header').owlCarousel({
                loop: true,
                autoplayTimeout: 7000,
                autoplay: true,
                touchDrag: true,
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

        // gallery slide content
        var items = $('.gal-content-slide .item');
        if(items.length > 1) {
             $('.gal-content-slide').owlCarousel({
	            loop: true,
	            autoplayTimeout: 7000,
	            autoplay: true,
	            touchDrag: true,
	            mouseDrag: true,
                margin: 10,
	            autoplayHoverPause: false,
	            autoHeight: false,
	            nav: false,
	            dots: true,
	            smartSpeed: 700,
	            items: 1
	        });
        } else {
             $('.gal-content-slide').owlCarousel({
	            loop: false,
	            autoplayTimeout: 7000,
	            autoplay: true,
	            touchDrag: true,
	            mouseDrag: false,
                margin: 10,
	            autoplayHoverPause: false,
	            autoHeight: false,
	            nav: false,
	            dots: true,
	            smartSpeed: 700,
	            items: 1
	        });
        }

        $(".gal-content-slide-left").on("click", function() {
            $(".gal-content-slide").trigger('prev.owl.carousel');
        });

        $(".gal-content-slide-right").on("click", function() {
            $(".gal-content-slide").trigger('next.owl.carousel');
        });

        // Slider image big
        var items = $('.slide-item-big-img .item');
        if(items.length > 1) {
             $('.slide-item-big-img').owlCarousel({
                loop: true,
                autoplayTimeout: 7000,
                autoplay: false,
                touchDrag: true,
                mouseDrag: true,
                autoplayHoverPause: false,
                autoHeight: false,
                nav: false,
                dots: true,
                smartSpeed: 700,
                items: 1
            });
        } else {
             $('.slide-item-big-img').owlCarousel({
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

        $(".nav-slide-i-big-right").on("click", function() {
            $(".slide-item-big-img").trigger('next.owl.carousel');
        });

        $(".nav-slide-i-big-left").on("click", function() {
            $(".slide-item-big-img").trigger('prev.owl.carousel');
        });

        // Slider donate
        var items = $('.slide-donate-form .item');
        if(items.length > 1) {
             $('.slide-donate-form').owlCarousel({
                loop: false,
                autoplayTimeout: 7000,
                autoplay: false,
                touchDrag: false,
                mouseDrag: false,
                autoplayHoverPause: false,
                autoHeight: true,
                nav: false,
                dots: false,
                smartSpeed: 700,
                items: 1
            });
        } else {
             $('.slide-donate-form').owlCarousel({
                loop: false,
                autoplayTimeout: 7000,
                autoplay: false,
                touchDrag: false,
                mouseDrag: false,
                autoplayHoverPause: false,
                autoHeight: true,
                nav: false,
                dots: false,
                smartSpeed: 700,
                items: 1
            });
        }

        $(".bt-next-donate-next").on("click", function() {
            $(".slide-donate-form").trigger('next.owl.carousel');
        });

        $(".bt-next-donate-prev").on("click", function() {
            $(".slide-donate-form").trigger('prev.owl.carousel');
        });

        


        // Responsive Sub Menu Click
        $('ul li.menu-item-has-children > a').on("click", function(e) {
            e.preventDefault();
            $(this).parent().find("> ul").slideToggle(300);
        });

        // link menu landing page
        $('a[href^="#"]').on('click',function (e) {
            e.preventDefault();
            var target = this.hash;
            var $target = $(target);

            $('html, body').stop().animate({
                'scrollTop': $target.offset().top
            }, 900, 'swing', function () {
                window.location.hash = target;
            });
        });
        
        // Video Responsive
        $(".c-p-block-box-vid").fitVids();

        // Wow Js Animate
        new WOW().init();

    });
})(jQuery);
