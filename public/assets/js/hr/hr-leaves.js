/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/hr/hr-leaves.js ***!
  \*********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; // Data Table

  var _$$DataTable;

  $('#hr-leaves').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [9]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); // Data Table

  $('#hr-leavestypes').DataTable({
    "order": [[0, "desc"]],
    "paging": false,
    searching: false,
    "info": false,
    "ordering": false
  }); // Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  });
});
/******/ })()
;