/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/assets/js/select2.js ***!
  \****************************************/
$(function () {
  'use strict'; // Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  }); // Select2 by showing the search

  $('.select2-show-search').select2({
    minimumResultsForSearch: '',
    placeholder: "Search",
    width: '100%'
  });
  $('.select2').on('click', function () {
    var selectField = document.querySelectorAll('.select2-search__field');
    selectField.forEach(function (element, index) {
      element === null || element === void 0 ? void 0 : element.focus();
    });
  });
});
/******/ })()
;