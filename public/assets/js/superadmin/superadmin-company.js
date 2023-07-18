/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************************!*\
  !*** ./resources/assets/js/superadmin/superadmin-company.js ***!
  \**************************************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; // Data Table

  var _$$DataTable;

  $('#company-list').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [0, 6]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); // Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  }); // Datepicker

  $('.fc-datepicker').datepicker({
    dateFormat: "dd M yy",
    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
    zIndex: 999998
  }); // Sidebar

  $(document).ready(function () {
    $('.dismiss').on('click', function () {
      $('.sidebar-modal').removeClass('active');
      $('body').removeClass('overlay-open');
    });
    $('.sidebarmodal-collpase').on('click', function () {
      $('.sidebar-modal').addClass('active');
      $('body').addClass('overlay-open');
    });
    $('body').append('<div class="overlay"></div>');
    $('.overlay').on('click touchstart', function () {
      $('body').removeClass('overlay-open');
      $('.sidebar-modal').removeClass('active');
    });
  });
});
/******/ })()
;