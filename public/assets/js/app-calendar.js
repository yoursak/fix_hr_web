/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/app-calendar.js ***!
  \*********************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//________ FullCalendar
var curYear = moment().format('YYYY');
var curMonth = moment().format('MM'); // Calendar Event Source

var sptCalendarEvents = {
  id: 1,
  events: [{
    id: '1',
    start: curYear + '-' + curMonth + '-02T09:00:00',
    end: curYear + '-' + curMonth + '-02T13:00:00',
    title: 'Spruko Meetup',
    backgroundColor: 'rgba(71, 84, 242, 0.2)',
    borderColor: 'rgba(71, 84, 242, 0.2)',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '2',
    start: curYear + '-' + curMonth + '-12T09:00:00',
    end: curYear + '-' + curMonth + '-12T17:00:00',
    title: 'Design Review',
    backgroundColor: 'rgba(71, 84, 242, 0.2)',
    borderColor: 'rgba(71, 84, 242, 0.2)',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '3',
    start: curYear + '-' + curMonth + '-13T12:00:00',
    end: curYear + '-' + curMonth + '-13T18:00:00',
    title: 'Lifestyle Conference',
    backgroundColor: 'rgba(71, 84, 242, 0.2)',
    borderColor: 'rgba(71, 84, 242, 0.2)',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '4',
    start: curYear + '-' + curMonth + '-21T07:30:00',
    end: curYear + '-' + curMonth + '-21T15:30:00',
    title: 'Team Weekly Brownbag',
    backgroundColor: 'rgba(71, 84, 242, 0.2)',
    borderColor: 'rgba(71, 84, 242, 0.2)',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '5',
    start: curYear + '-' + curMonth + '-04T10:00:00',
    end: curYear + '-' + curMonth + '-06T15:00:00',
    title: 'Music Festival',
    backgroundColor: 'rgba(71, 84, 242, 0.2)',
    borderColor: 'rgba(71, 84, 242, 0.2)',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '6',
    start: curYear + '-' + curMonth + '-23T13:00:00',
    end: curYear + '-' + curMonth + '-23T18:30:00',
    title: 'Attend Lea\'s Wedding',
    backgroundColor: 'rgba(71, 84, 242, 0.2)',
    borderColor: 'rgba(71, 84, 242, 0.2)',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }]
}; // Birthday Events Source

var sptBirthdayEvents = {
  id: 2,
  backgroundColor: 'rgba(1, 195, 83, 0.2)',
  borderColor: 'rgba(1, 195, 83, 0.2)',
  events: [{
    id: '7',
    start: curYear + '-' + curMonth + '-04T18:00:00',
    end: curYear + '-' + curMonth + '-04T23:30:00',
    title: 'Harcates Birthday',
    backgroundColor: 'rgba(1, 195, 83, 0.2)',
    borderColor: 'rgba(1, 195, 83, 0.2)',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '8',
    start: curYear + '-' + curMonth + '-28T15:00:00',
    end: curYear + '-' + curMonth + '-28T21:00:00',
    title: 'Jinnysin\'s Birthday',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '9',
    start: curYear + '-' + curMonth + '-31T15:00:00',
    end: curYear + '-' + curMonth + '-31T21:00:00',
    title: 'Lee shin\'s Birthday',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }]
}; // Holiday Events Source

var sptHolidayEvents = {
  id: 3,
  backgroundColor: 'rgba(240, 74, 32, 0.2)',
  borderColor: 'rgba(240, 74, 32, 0.2)',
  events: [{
    id: '10',
    start: curYear + '-' + curMonth + '-05',
    end: curYear + '-' + curMonth + '-08',
    title: 'Festival Day'
  }, {
    id: '11',
    start: curYear + '-' + curMonth + '-18',
    end: curYear + '-' + curMonth + '-19',
    title: 'Memorial Day'
  }, {
    id: '12',
    start: curYear + '-' + curMonth + '-25',
    end: curYear + '-' + curMonth + '-26',
    title: 'Diwali'
  }]
}; // Other Events Source

var sptOtherEvents = {
  id: 4,
  backgroundColor: 'rgba(255, 173, 0,0.2)',
  borderColor: 'rgba(255, 173, 0,0.2)',
  events: [{
    id: '13',
    start: curYear + '-' + curMonth + '-07',
    end: curYear + '-' + curMonth + '-09',
    title: 'My Rest Day'
  }, {
    id: '13',
    start: curYear + '-' + curMonth + '-29',
    end: curYear + '-' + curMonth + '-31',
    title: 'My Rest Day'
  }]
};
document.addEventListener('DOMContentLoaded', function () {
  var _FullCalendar$Calenda;

  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, (_FullCalendar$Calenda = {
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
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
  }, _defineProperty(_FullCalendar$Calenda, "editable", true), _defineProperty(_FullCalendar$Calenda, "eventSources", [sptCalendarEvents, sptBirthdayEvents, sptHolidayEvents, sptOtherEvents]), _FullCalendar$Calenda));
  calendar.render();
});
/******/ })()
;