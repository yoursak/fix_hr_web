/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*------------------------------------------------------------------

Project        :   FixHr
Version        :   V.1
Create Date    :   18 july 2023
Copyright      :   Fixing Dots
Author         :   Aman Sahu
Support	       :   support@spruko.com

-------------------------------------------------------------------*/
$(function (e) {
  'use strict'; // Select2

  $('.select2-show-search').select2({
    minimumResultsForSearch: '',
    placeholder: "Search",
    width: '100%'
  }); // Timepicker

  $('.timepicker').timepicker({
    showInputs: false
  }); // Color-Picker

  $('#colorpicker').spectrum({
    color: '#000'
  });
  $("#showAlpha").spectrum({
    showPalette: true,
    showSelectionPalette: true,
    showInput: true,
    preferredFormat: "hex",
    color: '#ff0000'
  });
});
/******/ })()
;
