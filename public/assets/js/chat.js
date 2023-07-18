/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/assets/js/chat.js ***!
  \*************************************/
$(function () {
  'use strict';

  var ps = new PerfectScrollbar('#ChatList', {
    useBothWheelAxes: false,
    suppressScrollX: false
  });
  var ps2 = new PerfectScrollbar('#ChatList2', {
    useBothWheelAxes: false,
    suppressScrollX: false
  });
  var ps1 = new PerfectScrollbar('#ChatBody', {
    useBothWheelAxes: false,
    suppressScrollX: false
  });
  $('[data-toggle="tooltip"]').tooltip();
});
/******/ })()
;