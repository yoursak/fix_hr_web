/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/assets/js/hr/hr-award.js ***!
  \********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; //Data Table

  var _$$DataTable;

  $('#hr-award').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [0, 7, 9]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); // Daterangepicker with Callback

  $('input[name="singledaterange"]').daterangepicker({
    singleDatePicker: true
  }); //Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  });
});
/******/ })()
;