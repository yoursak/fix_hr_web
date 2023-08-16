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
  'use strict'; // Vertical-scroll

  $(".item-list-scroll").bootstrapNews({
    newsPerPage: 4,
    autoplay: true,
    pauseOnHover: true,
    navigation: false,
    direction: 'down',
    newsTickerInterval: 2500,
    onToDo: function onToDo() {}
  });
});
/******/ })()
;
