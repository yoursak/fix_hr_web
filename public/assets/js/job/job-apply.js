/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/assets/js/job/job-apply.js ***!
  \**********************************************/
$(function (e) {
  'use strict'; // Datepicker

  $('.fc-datepicker').datepicker({
    dateFormat: "dd M yy",
    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
    zIndex: 999998
  }); // Select2 

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  });
});
/******/ })()
;