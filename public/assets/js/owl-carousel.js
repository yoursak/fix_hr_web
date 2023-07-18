/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/owl-carousel.js ***!
  \*********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

(function ($) {
  'use strict';

  var _owl$owlCarousel;

  var owl = $('.owl-carousel-icons2');
  owl.owlCarousel((_owl$owlCarousel = {
    loop: true,
    rewind: false,
    margin: 25,
    animateIn: 'fadeInDowm',
    animateOut: 'fadeOutDown',
    autoplay: false,
    autoplayTimeout: 5000,
    // set value to change speed
    autoplayHoverPause: true,
    dots: false,
    nav: true
  }, _defineProperty(_owl$owlCarousel, "autoplay", true), _defineProperty(_owl$owlCarousel, "responsiveClass", true), _defineProperty(_owl$owlCarousel, "responsive", {
    0: {
      items: 1,
      nav: true
    },
    600: {
      items: 2,
      nav: true
    },
    1300: {
      items: 4,
      nav: true
    }
  }), _owl$owlCarousel));
  owlRtl();
})(jQuery);

function owlRtl() {
  var carousel = $('.rtl .owl-carousel');
  $.each(carousel, function (index, element) {
    var carouselData = $(element).data('owl.carousel');
    carouselData.settings.rtl = true; //don't know if both are necessary

    carouselData.options.rtl = true;
    $(element).trigger('refresh.owl.carousel');
  });
}
/******/ })()
;