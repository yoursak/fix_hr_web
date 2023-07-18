/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./resources/assets/js/employee/emp-payslips.js ***!
  \******************************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; //Data-Table

  var _$$DataTable;

  $('#emp-attendance').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [0, 5]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); //Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  });
});
/******/ })()
;