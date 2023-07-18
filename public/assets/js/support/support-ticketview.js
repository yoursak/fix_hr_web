/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************************!*\
  !*** ./resources/assets/js/support/support-ticketview.js ***!
  \***********************************************************/
$(function (e) {
  'use strict'; //  Attach Remove

  $(document).on('click', '[data-bs-toggle="remove"]', function (e) {
    var $a = $(this).closest(".attach-supportfiles");
    $a.remove();
    e.preventDefault();
    return false;
  }); // Edit Summernote

  $(document).on("click", '.supportnote-icon', function () {
    $('body').toggleClass('add-supportnote');
  });
  $(document).on("click", '.dismiss-btn', function () {
    $('body').removeClass('add-supportnote');
  }); // Edit Summernote

  $(document).on("click", '.reopen-button', function () {
    $('body').toggleClass('add-reopencard');
  });
});
/******/ })()
;