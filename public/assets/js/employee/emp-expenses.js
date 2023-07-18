/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./resources/assets/js/employee/emp-expenses.js ***!
  \******************************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict';
  /* Data Table */

  var _$$DataTable;

  $('#emp-attendance').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [0, 5]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable));
  /* End Data Table */

  /* Select2 */

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  }); //Daterangepicker with Callback

  $('input[name="singledaterange"]').daterangepicker({
    singleDatePicker: true
  }); //Input file-browser

  $(document).on('change', '.file-browserinput', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  }); // We can watch for our custom `fileselect` event like this

  $(document).ready(function () {
    $('.file-browserinput').on('fileselect', function (event, numFiles, label) {
      var input = $(this).parents('.input-group').find(':text'),
          log = numFiles > 1 ? numFiles + ' files selected' : label;

      if (input.length) {
        input.val(log);
      } else {
        if (log) alert(log);
      }
    });
  });
});
/******/ })()
;