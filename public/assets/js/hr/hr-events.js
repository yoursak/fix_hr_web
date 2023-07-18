/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/hr/hr-events.js ***!
  \*********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function (e) {
  'use strict'; // Select2 

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  }); //Datepicker

  $('.fc-datepicker').datepicker({
    dateFormat: "dd MM yy",
    zIndex: 999998
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
    title: 'Anniversary',
    start: '2021-02-22',
    display: '#e2ffe3',
    color: '#e2ffe3'
  }, {
    title: 'Vanessa Birthday',
    start: '2021-02-16',
    display: 'rgba(118, 124, 246, 0.15)',
    color: 'rgba(118, 124, 246, 0.15)'
  }, {
    title: 'Trade Shows',
    start: '2021-02-18',
    display: '#ffede7',
    color: '#ffede7'
  }, {
    title: 'Holiday Party',
    start: '2021-03-06',
    display: '#fff6e5',
    color: '#fff6e5'
  }, {
    title: 'Team-Building',
    start: '2021-03-13',
    display: '#ffe3f1',
    color: '#ffe3f1'
  }, {
    title: 'Faith work Anniversary',
    start: '2021-03-24',
    display: '#e2ffe3',
    color: '#e2ffe3'
  }, {
    title: 'Austin Birthday',
    start: '2021-04-16',
    display: 'rgba(118, 124, 246, 0.15)',
    color: 'rgba(118, 124, 246, 0.15)'
  }, {
    title: 'Board Meeting',
    start: '2021-04-25',
    display: '#d8fbfd',
    color: '#d8fbfd'
  }, {
    title: 'Maria Birthday',
    start: '2021-05-01',
    display: 'rgba(118, 124, 246, 0.15)',
    color: 'rgba(118, 124, 246, 0.15)'
  }, {
    title: 'Max work Anniversary',
    start: '2021-05-21',
    display: '#e2ffe3',
    color: '#e2ffe3'
  }]), _FullCalendar$Calenda));
  calendar.render();
});
/******/ })()
;