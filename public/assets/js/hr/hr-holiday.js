/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/assets/js/hr/hr-holiday.js ***!
  \**********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; // Datepicker

  var _$$DataTable;

  $('.fc-datepicker').datepicker({
    dateFormat: "dd MM yy",
    zIndex: 1
  }); // Datepicker

  $('[data-bs-toggle="modaldatepicker"]').datepicker({
    autoHide: true,
    zIndex: 999998
  }); // Data Table

  $('#hr-holiday').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [4]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); // Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  });
});
/*---- Full Calendar -----*/

document.addEventListener('DOMContentLoaded', function () {
  var _FullCalendar$Calenda;

  var calendarEl = document.getElementById('calendar1');
  var calendar = new FullCalendar.Calendar(calendarEl, (_FullCalendar$Calenda = {
    headerToolbar: {
      left: 'prev',
      center: 'title',
      right: 'next'
    },
    navLinks: true,
    // can click day/week names to navigate views
    businessHours: true,
    // display business hours
    editable: true,
    selectable: true,
    selectMirror: true,
    droppable: true,
    // this allows things to be dropped onto the calendar
    drop: function drop(arg) {
      // is the "remove after drop" checkbox checked?
      if (document.getElementById('drop-remove').checked) {
        // if so, remove the element from the "Draggable Events" list
        arg.draggedEl.parentNode.removeChild(arg.draggedEl);
      }
    },
    select: function select(arg) {
      var title = prompt('Event Title:');

      if (title) {
        calendar.addEvent({
          title: title,
          start: arg.start,
          end: arg.end,
          allDay: arg.allDay
        });
      }

      calendar.unselect();
    },
    eventClick: function eventClick(arg) {
      if (confirm('Are you sure you want to delete this event?')) {
        arg.event.remove();
      }
    }
  }, _defineProperty(_FullCalendar$Calenda, "editable", true), _defineProperty(_FullCalendar$Calenda, "dayMaxEvents", true), _defineProperty(_FullCalendar$Calenda, "eventRender", function eventRender(event, element) {
    debugger;

    if (event.description.toString() == "Halfday") {
      element.find(".fc-event-time").after($("<span class=\"fc-event-icons\"></span>").html("<i class='fe fe-view'></i> "));
    }
  }), _defineProperty(_FullCalendar$Calenda, "events", [{
    title: 'Pongal',
    start: '2021-01-14',
    color: 'rgba(255, 173, 0, 0.1)'
  }, {
    title: 'Republic',
    start: '2021-01-26',
    color: 'rgba(255, 173, 0, 0.1)'
  }]), _FullCalendar$Calenda));
  calendar.render();
});
/******/ })()
;