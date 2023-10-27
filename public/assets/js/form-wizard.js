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
  (function ($) {
    "use strict";

    $('#wizard1').steps({
      headerTag: 'h3',
      bodyTag: 'section',
      autoFocus: true,
      titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>'
    });
    $('#wizard2').steps({
      headerTag: 'h3',
      bodyTag: 'section',
      autoFocus: true,
      titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
      onStepChanging: function onStepChanging(event, currentIndex, newIndex) {
        if (currentIndex < newIndex) {
          // Step 1 form validation
          if (currentIndex === 0) {
            var fname = $('#firstname').parsley();
            var lname = $('#lastname').parsley();

            if (fname.isValid() && lname.isValid()) {
              return true;
            } else {
              fname.validate();
              lname.validate();
            }
          } // Step 2 form validation


          if (currentIndex === 1) {
            var email = $('#email').parsley();

            if (email.isValid()) {
              return true;
            } else {
              email.validate();
            }
          } // Always allow step back to the previous step even if the current step is not valid.


        } 
        else {
          console.log("SDFs");
          return true;
        }
      }
    });
    $('#wizard').steps({
      headerTag: 'h3',
      bodyTag: 'section',
      autoFocus: true,
      titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
      stepsOrientation: 1
    }); // accordion-wizard

    var options = {
      mode: 'wizard2',
      autoButtonsNextClass: 'btn btn-primary float-end',
      autoButtonsPrevClass: 'btn btn-light',
      stepNumberClass: 'badge badge-pill badge-primary me-1',
      onSubmit: function onSubmit() {
        alert('Form submitted!');
        window.location.reload();
        console.log("chal fir abhe kam kar");
        return true;
      }
    };
    var btnFinish = $('<button></button>').text('Finish')
      .addClass('btn btn-primary')
      .on('click', function () {

        // alert('Finish Clicked');

        window.location.reload();
      });
    var btnCancel = $('<button></button>').text('Cancel')
      .addClass('btn btn-secondary')
      .on('click', function () { $('#smartwizard-3').smartWizard("reset"); });

    $("#form").accWizard(options);

  })(jQuery);
  /******/
})()
  ;
