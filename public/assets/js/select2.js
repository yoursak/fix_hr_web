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
$(document).ready(function () {
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
