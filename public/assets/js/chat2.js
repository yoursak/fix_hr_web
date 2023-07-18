/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/assets/js/chat2.js ***!
  \**************************************/
$(function () {
  'use strict';

  $('#chatActiveContacts').lightSlider({
    autoWidth: true,
    controls: false,
    pager: false,
    slideMargin: 12
  });
  var ps7 = new PerfectScrollbar('.main-chat-contacts-slider', {
    useBothWheelAxes: true,
    suppressScrollY: true,
    suppressScrollX: false
  });
  var ps = new PerfectScrollbar('#ChatList', {
    useBothWheelAxes: false,
    suppressScrollX: true
  });
  var ps1 = new PerfectScrollbar('#ChatBody', {
    useBothWheelAxes: false,
    suppressScrollX: true
  });
  $('[data-bs-toggle="tooltip"]').tooltip();
});
/******/ })()
;