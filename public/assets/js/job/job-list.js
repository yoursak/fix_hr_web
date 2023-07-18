/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/job/job-list.js ***!
  \*********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; // Data Table

  var _$$DataTable;

  $('#job-list').DataTable((_$$DataTable = {
    "order": [[3, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [7]
  }, {
    orderable: false,
    targets: [0]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); // Datepicker

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