/******/ () => {
    // webpackBootstrap
    var __webpack_exports__ = {};
    /*------------------------------------------------------------------

Project        :   FixHr
Version        :   V.1
Create Date    :   18 july 2023
Copyright      :   Fixing Dots
Author         :   Aman Sahu
Support	       :   support@spruko.com

-------------------------------------------------------------------*/
    $(document).ready(function () {
        "use strict"; //  Modal

        $("#myModal").modal("show");
        setTimeout(function (e) {
            $("#myModal").modal("hide");
        }, 20000000);
        setInterval(function () {
            var progress = document.getElementById("custom-bar");

            if (progress.value < progress.max) {
                progress.value += 10;
            }
        }, 1000);
    });
};
