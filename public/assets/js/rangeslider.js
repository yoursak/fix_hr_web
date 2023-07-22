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
$(function () {
  'use strict';

  $('.rangeslider1').ionRangeSlider();
  $('.rangeslider2').ionRangeSlider({
    min: 100,
    max: 1000,
    from: 550
  });
  $('.rangeslider3').ionRangeSlider({
    type: 'double',
    grid: true,
    min: 0,
    max: 1000,
    from: 200,
    to: 800,
    prefix: '$'
  });
  $('.rangeslider4').ionRangeSlider({
    type: 'double',
    grid: true,
    min: -1000,
    max: 1000,
    from: -500,
    to: 500,
    step: 250
  });
});
/******/ })()
;
