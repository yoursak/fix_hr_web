/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/assets/js/task/task-board.js ***!
  \************************************************/
$(function (e) {
  'use strict'; // Datepicker

  $('.fc-datepicker').datepicker({
    dateFormat: "dd M yy",
    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
    zIndex: 999998
  }); // Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  }); // P-scroll-task-in

  var ps11 = new PerfectScrollbar('.task-in', {
    useBothWheelAxes: true,
    suppressScrollX: true
  }); //  P-scroll- task-hold

  var ps12 = new PerfectScrollbar('.task-hold', {
    useBothWheelAxes: true,
    suppressScrollX: true
  }); //  P-scroll- task-on

  var ps13 = new PerfectScrollbar('.task-on', {
    useBothWheelAxes: true,
    suppressScrollX: true
  }); // P-scroll- task-complete

  var ps14 = new PerfectScrollbar('.task-complete', {
    useBothWheelAxes: true,
    suppressScrollX: true
  });
});
/******/ })()
;