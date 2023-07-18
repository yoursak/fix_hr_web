/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./resources/assets/js/admin/admin-role.js ***!
  \*************************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; //________ Data Table

  var _$$DataTable;

  $('#role-list').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [0]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); //________ Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  }); //______________

  $(".role").on("click", function (e) {
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this file!",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(function (willDelete) {
      if (willDelete) {
        swal({
          title: "Success",
          text: "Successfully Updated",
          icon: "success"
        });
      } else {
        swal("Your  file is safe!");
      }
    });
  });
});
/******/ })()
;