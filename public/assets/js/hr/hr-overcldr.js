/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./resources/assets/js/hr/hr-overcldr.js ***!
  \***********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; // Datepicker

  $(".fc-datepicker").datepicker({
    dateFormat: "dd MM yy",
    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"]
  });
}); // FullCalendar

document.addEventListener('DOMContentLoaded', function () {
  var _FullCalendar$Calenda;

  var calendarEl = document.getElementById('calendar1');
  var calendar = new FullCalendar.Calendar(calendarEl, (_FullCalendar$Calenda = {
    headerToolbar: {
      left: 'prev',
      center: 'title',
      right: 'next'
    },
    initialDate: '2022-03',
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
    title: 'Halfday',
    start: '2021-01-06',
    constraint: 'Halfday',
    display: 'rgba(240, 74, 32, 9)',
    color: 'rgba(240, 74, 32, 9)'
  }, {
    title: 'Absent',
    start: '2021-01-13',
    end: '2021-01-16',
    display: 'rgba(241, 21, 65,9)',
    color: 'rgba(241, 21, 65, 9)'
  }, {
    title: 'Republic Day',
    start: '2021-01-26',
    display: 'background'
  }, {
    title: 'Late',
    start: '2021-01-08',
    display: '#d8fbfd',
    color: '#d8fbfd'
  }, {
    title: 'Late',
    start: '2021-01-20',
    display: '#d8fbfd',
    color: '#d8fbfd'
  }]), _FullCalendar$Calenda));
  calendar.render();
});
/******/ })()
;