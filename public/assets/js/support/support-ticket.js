/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************************!*\
  !*** ./resources/assets/js/support/support-ticket.js ***!
  \*******************************************************/
$(function (e) {
  'use strict'; // Vertical-scroll

  $(".item-list-scroll").bootstrapNews({
    newsPerPage: 4,
    autoplay: true,
    pauseOnHover: true,
    navigation: false,
    direction: 'down',
    newsTickerInterval: 2500,
    onToDo: function onToDo() {}
  });
});
/******/ })()
;