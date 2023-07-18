/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************************!*\
  !*** ./resources/assets/js/support/support-userdash.js ***!
  \*********************************************************/
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function chartLine3() {
  'use strict'; // LIne-Chart 

  var ctx = document.getElementById("chartLine3").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Total Open Tickets',
        categoryPercentage: 0.4,
        barPercentage: 0.8,
        data: [20, 17, 27, 23, 17, 19, 23, 17, 13, 28, 22, 27],
        borderWidth: 2,
        backgroundColor: hexToRgba(myVarVal, 0.2),
        borderColor: hexToRgba(myVarVal, 0.2),
        pointBackgroundColor: '#ffffff',
        pointRadius: 0,
        type: 'bar'
      }, {
        label: 'Total Closed Tickets',
        categoryPercentage: 0.4,
        barPercentage: 0.8,
        data: [28, 22, 21, 18, 13, 22, 24, 18, 16, 21, 18, 24],
        borderWidth: 3,
        backgroundColor: myVarVal,
        borderColor: myVarVal,
        pointBackgroundColor: myVarVal,
        pointRadius: 0,
        type: 'bar'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 0,
          bottom: 0
        }
      },
      tooltips: {
        enabled: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: true,
            drawBorder: false,
            zeroLineColor: 'rgba(142, 156, 173,0.1)',
            color: "rgba(142, 156, 173,0.1)"
          },
          scaleLabel: {
            display: false
          },
          ticks: {
            beginAtZero: true,
            stepSize: 5,
            suggestedMin: 5,
            suggestedMax: 30,
            fontColor: "#8492a6"
          }
        }],
        xAxes: [{
          barValueSpacing: -2,
          barDatasetSpacing: 0,
          barRadius: 15,
          stacked: false,
          ticks: {
            beginAtZero: true,
            fontColor: "#8492a6"
          },
          gridLines: {
            color: "rgba(142, 156, 173,0.1)",
            display: false
          }
        }]
      },
      legend: {
        display: false
      },
      elements: {
        point: {
          radius: 0
        }
      }
    }
  });
}

(function () {
  "use strict"; // Data Table

  var _$$DataTable;

  $('#supportticket-dash').DataTable((_$$DataTable = {
    "order": [[0, "desc"]]
  }, _defineProperty(_$$DataTable, "order", []), _defineProperty(_$$DataTable, "columnDefs", [{
    orderable: false,
    targets: [5]
  }, {
    orderable: false,
    targets: [0]
  }]), _defineProperty(_$$DataTable, "language", {
    searchPlaceholder: 'Search...',
    sSearch: ''
  }), _$$DataTable)); // Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  });
})();
/******/ })()
;