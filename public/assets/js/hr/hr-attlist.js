/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/assets/js/hr/hr-attlist.js ***!
  \**********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; // DataTable

  var _$$DataTable;

  var table = $('#hr-attendance').DataTable({
    rowReorder: true,
    columnDefs: [{
      orderable: true,
      className: 'reorder',
      targets: 0
    }, {
      orderable: false,
      targets: '_all'
    }]
  }); // DataTable

  $('#emp-attendance').DataTable((_$$DataTable = {
    "order": [[0, "asec"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [5, 6]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); //Timepicker

  $('.timepicker').timepicker({
    showInputs: false
  }); // Datepicker

  $(".fc-datepicker").datepicker({
    dateFormat: "dd MM yy",
    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"]
  });
  $('.fc-datepicker').datepicker('setDate', 'today'); //Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  });
});
/******/ })()
;