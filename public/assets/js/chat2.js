/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*------------------------------------------------------------------

Project        :   FixHr
Version        :   V.1
Create Date    :   18 july 2023
Copyright      :   Fixing Dots
Author         :   Aman Sahu
Support	       :   support@spruko.com

-------------------------------------------------------------------*/
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
