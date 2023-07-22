/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/index.js":
/*------------------------------------------------------------------

Project        :   FixHr
Version        :   V.1
Create Date    :   18 july 2023
Copyright      :   Fixing Dots
Author         :   Aman Sahu
Support	       :   support@spruko.com

-------------------------------------------------------------------*/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "advancedtask": () => (/* binding */ advancedtask),
/* harmony export */   "analysis": () => (/* binding */ analysis),
/* harmony export */   "balance": () => (/* binding */ balance),
/* harmony export */   "chartLine3": () => (/* binding */ chartLine3),
/* harmony export */   "chartbar": () => (/* binding */ chartbar),
/* harmony export */   "chartline1": () => (/* binding */ chartline1),
/* harmony export */   "chartstatistics": () => (/* binding */ chartstatistics),
/* harmony export */   "employee1": () => (/* binding */ employee1),
/* harmony export */   "expenses": () => (/* binding */ expenses),
/* harmony export */   "index": () => (/* binding */ index),
/* harmony export */   "index1": () => (/* binding */ index1),
/* harmony export */   "index2": () => (/* binding */ index2),
/* harmony export */   "overview": () => (/* binding */ overview),
/* harmony export */   "spenttask": () => (/* binding */ spenttask),
/* harmony export */   "statistics": () => (/* binding */ statistics),
/* harmony export */   "statistics1": () => (/* binding */ statistics1),
/* harmony export */   "ticketoverview": () => (/* binding */ ticketoverview)
/* harmony export */ });
function index2(myVarVal, hexToRgba) {
  "use strict"; // Chartjs (#sales-summary)

  var myCanvas = document.getElementById("sales-summary");
  myCanvas.height = "300";
  var myChart = new Chart(myCanvas, {
    type: 'bar',
    data: {
      labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      datasets: [{
        barPercentage: 0.15,
        label: 'This Month',
        data: [27, 50, 28, 50, 18, 30, 22],
        backgroundColor: myVarVal,
        borderWidth: 2,
        hoverBackgroundColor: myVarVal,
        hoverBorderWidth: 0,
        borderColor: myVarVal,
        hoverBorderColor: myVarVal,
        borderDash: [5, 2]
      }, {
        barPercentage: 0.15,
        label: 'Last Month',
        data: [68, 57, 53, 58, 23, 75, 28],
        backgroundColor: '#fe7f00',
        borderWidth: 2,
        hoverBackgroundColor: '#fe7f00',
        hoverBorderWidth: 0,
        borderColor: '#fe7f00',
        hoverBorderColor: '#fe7f00'
      }, {
        barPercentage: 0.15,
        label: 'Last Month',
        data: [100, 78, 68, 95, 0, 98, 58],
        backgroundColor: hexToRgba(myVarVal, 0.2),
        borderWidth: 2,
        hoverBackgroundColor: hexToRgba(myVarVal, 0.2),
        hoverBorderWidth: 0,
        borderColor: hexToRgba(myVarVal, 0.2),
        hoverBorderColor: hexToRgba(myVarVal, 0.2)
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
            stepSize: 25,
            suggestedMin: 0,
            suggestedMax: 100,
            fontColor: "#8492a6",
            userCallback: function userCallback(tick) {
              return tick.toString() + '%';
            }
          }
        }],
        xAxes: [{
          barValueSpacing: 0,
          barDatasetSpacing: 0,
          barRadius: 0,
          stacked: true,
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
function index1(myVarVal) {
  "use strict";
  /*----- Employees ------*/

  var options = {
    series: [74, 35],
    chart: {
      height: 300,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    stroke: {
      show: true,
      width: 0
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '29px',
              color: '#6c6f9a',
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '26px',
              color: undefined,
              offsetY: 16,
              formatter: function formatter(val) {
                return val + "%";
              }
            },
            total: {
              show: true,
              showAlways: false,
              label: 'Total',
              fontSize: '22px',
              fontWeight: 600,
              color: '#373d3f'
            }
          }
        }
      }
    },
    responsive: [{
      options: {
        legend: {
          show: false
        }
      }
    }],
    labels: ["Male", "Female"],
    colors: [myVarVal, '#fe7f00']
  };
  document.getElementById('employees').innerHTML = '';
  var chart = new ApexCharts(document.querySelector("#employees"), options);
  chart.render();
}
function index(myVarVal, hexToRgba) {
  // LIne-Chart
  var ctx = document.getElementById("chartLine").getContext('2d');
  var myChart = new Chart(ctx, {
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Total BUdget',
        data: [100, 210, 180, 454, 454, 230, 230, 656, 656, 350, 350, 210, 410],
        borderWidth: 3,
        backgroundColor: 'transparent',
        borderColor: myVarVal,
        pointBackgroundColor: '#ffffff',
        pointRadius: 0,
        type: 'line'
      }, {
        label: 'Total Employess',
        data: [200, 530, 110, 110, 480, 520, 780, 435, 475, 738, 454, 454, 230],
        borderWidth: 3,
        backgroundColor: 'transparent',
        borderColor: hexToRgba(myVarVal, 0.2),
        pointBackgroundColor: '#ffffff',
        pointRadius: 0,
        type: 'line',
        borderDash: [7, 3]
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
            min: 0,
            max: 1050,
            stepSize: 150,
            fontColor: "#8492a6"
          }
        }],
        xAxes: [{
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
function chartbar(myVarVal, hexToRgba) {
  'use strict'; // Bar-Chart

  var ctx = document.getElementById("chartbar").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        barPercentage: .8,
        categoryPercentage: 0.38,
        label: 'TOTAL BUDGET',
        data: [27, 17, 19, 23, 17, 19, 23, 17, 13, 28, 22, 27],
        borderWidth: 0,
        backgroundColor: hexToRgba(myVarVal, 0.2),
        borderColor: hexToRgba(myVarVal, 0.2),
        pointBackgroundColor: '#ffffff'
      }, {
        label: 'AMOUNT USED',
        barPercentage: .8,
        categoryPercentage: 0.38,
        data: [28, 22, 21, 18, 13, 22, 24, 18, 16, 21, 18, 24],
        borderWidth: 0,
        backgroundColor: myVarVal,
        borderColor: myVarVal,
        pointBackgroundColor: myVarVal
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
            min: 5,
            stepSize: 5,
            max: 30,
            fontColor: "#8492a6",
            fontFamily: 'Poppins'
          }
        }],
        xAxes: [{
          barValueSpacing: -2,
          barDatasetSpacing: 0,
          barRadius: 15,
          stacked: false,
          ticks: {
            beginAtZero: true,
            fontColor: "#8492a6",
            fontFamily: 'Poppins'
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
;
function balance(myVarVal, hexToRgba) {
  /*-----Balance Statistics-----*/
  var myCanvas = document.getElementById("balance");
  var myCanvasContext = myCanvas.getContext("2d");
  var gradientStroke1 = myCanvasContext.createLinearGradient(0, 180, 0, 280);
  gradientStroke1.addColorStop(0, hexToRgba(myVarVal, 0.1));
  gradientStroke1.addColorStop(1, 'rgba(246, 247, 249, .05)');
  myCanvas.height = "380";
  var myChart = new Chart(myCanvas, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'on going',
        data: [11, 13, 13, 20, 22, 25, 17, 23, 16, 16, 15, 17, 15],
        backgroundColor: 'transparent',
        borderWidth: 3,
        borderColor: myVarVal,
        hoverBorderColor: myVarVal
      }, {
        label: 'Completed',
        data: [10, 12, 12.2, 16, 18, 12, 17, 15.2, 20.2, 15, 14, 16],
        backgroundColor: 'transparent',
        borderWidth: 3,
        borderColor: '#fe7f00',
        hoverBorderColor: '#fe7f00'
      }, {
        label: '',
        data: [13, 18, 12, 22, 18, 22, 17, 21, 20, 22, 24, 19],
        backgroundColor: gradientStroke1,
        borderWidth: 3,
        borderColor: hexToRgba(myVarVal, 0.1)
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
            min: 5,
            stepSize: 5,
            max: 30,
            fontColor: "#8492a6"
          }
        }],
        xAxes: [{
          ticks: {
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
  /*-----Balance Statistics-----*/
}
function advancedtask(myVarVal) {
  "use strict";
  /*----- Advancedtask ------*/

  var options = {
    series: [74, 35],
    chart: {
      height: 280,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    stroke: {
      show: true,
      width: 0
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '29px',
              color: '#6c6f9a',
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '26px',
              color: undefined,
              offsetY: 16,
              formatter: function formatter(val) {
                return val + "%";
              }
            },
            total: {
              show: true,
              showAlways: false,
              label: 'Total Tasks',
              fontSize: '22px',
              fontWeight: 600,
              color: '#373d3f' // formatter: function (w) {
              //   return w.globals.seriesTotals.reduce((a, b) => {
              // 	return a + b
              //   }, 0)
              // }

            }
          }
        }
      }
    },
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          show: false
        }
      }
    }],
    labels: ["Completed", "Running"],
    colors: [myVarVal, '#fe7f00']
  };
  document.getElementById('advancedtask').innerHTML = '';
  var chart = new ApexCharts(document.querySelector("#advancedtask"), options);
  chart.render();
}
function spenttask(myVarVal, hexToRgba) {
  "use strict";
  /* Chartjs (#spenttask) */

  var myCanvas = document.getElementById("spenttask");
  myCanvas.height = "310";
  var myChart = new Chart(myCanvas, {
    type: 'bar',
    data: {
      labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      datasets: [{
        barPercentage: 0.2,
        label: 'Work',
        data: [8, 6.5, 7, 8.2, 7, 7.8, 6.5],
        backgroundColor: myVarVal,
        borderWidth: 2,
        hoverBackgroundColor: myVarVal,
        hoverBorderWidth: 0,
        borderColor: myVarVal,
        hoverBorderColor: myVarVal,
        borderDash: [5, 2]
      }, {
        label: 'Working Hours',
        barPercentage: 0.2,
        data: [10, 10, 10, 10, 10, 10, 10],
        backgroundColor: hexToRgba(myVarVal, 0.5),
        borderWidth: 2,
        hoverBackgroundColor: hexToRgba(myVarVal, 0.5),
        hoverBorderWidth: 0,
        borderColor: hexToRgba(myVarVal, 0.5),
        hoverBorderColor: hexToRgba(myVarVal, 0.5)
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
            min: 0,
            max: 10,
            stepSize: 2,
            fontColor: "#8492a6",
            userCallback: function userCallback(tick) {
              return tick.toString() + 'hrs';
            }
          }
        }],
        xAxes: [{
          barValueSpacing: 0,
          barDatasetSpacing: 0,
          barRadius: 0,
          stacked: true,
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
function statistics(myVarVal, hexToRgba) {
  "use strict";
  /*-----Statistics-----*/

  var myCanvas = document.getElementById("statistics");
  var myCanvasContext = myCanvas.getContext("2d");
  var gradientStroke1 = myCanvasContext.createLinearGradient(0, 180, 0, 280);
  gradientStroke1.addColorStop(0, hexToRgba(myVarVal, 0.1));
  gradientStroke1.addColorStop(1, 'rgba(246, 247, 249, .05)');
  myCanvas.height = "350";
  var myChart = new Chart(myCanvas, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'on going',
        data: [12, 20, 23, 18, 26, 25, 29.9, 25.5, 23, 25, 27, 18],
        backgroundColor: 'transparent',
        borderWidth: 3,
        borderColor: myVarVal,
        hoverBorderColor: myVarVal
      }, {
        label: 'Completed',
        data: [15, 17, 9.2, 20, 23, 17, 10, 25.2, 25, 18, 22, 20],
        backgroundColor: 'transparent',
        borderWidth: 3,
        borderColor: '#fe7f00',
        hoverBorderColor: '#fe7f00'
      }, {
        label: '',
        data: [18, 18, 15, 23, 20, 16, 22, 18, 20, 24, 15, 22],
        backgroundColor: gradientStroke1,
        borderWidth: 3,
        borderColor: hexToRgba(myVarVal, 0.1)
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
            min: 5,
            stepSize: 5,
            max: 30,
            fontColor: "#8492a6"
          }
        }],
        xAxes: [{
          ticks: {
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
  /*-----Statistics-----*/
}
function employee1(myVarVal) {
  "use strict";
  /*----- Advancedtask ------*/

  var options = {
    series: [74, 35],
    chart: {
      height: 260,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    stroke: {
      show: true,
      width: 0
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '29px',
              color: '#6c6f9a',
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '26px',
              color: undefined,
              offsetY: 16,
              formatter: function formatter(val) {
                return val + "%";
              }
            },
            total: {
              show: true,
              showAlways: false,
              label: 'Total Employees',
              fontSize: '22px',
              fontWeight: 600,
              color: '#373d3f' // formatter: function (w) {
              //   return w.globals.seriesTotals.reduce((a, b) => {
              // 	return a + b
              //   }, 0)
              // }

            }
          }
        }
      }
    },
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          show: false
        }
      }
    }],
    labels: ["Male", "Female"],
    colors: [myVarVal, '#fe7f00']
  };
  document.getElementById('employee1').innerHTML = '';
  var chart = new ApexCharts(document.querySelector("#employee1"), options);
  chart.render();
}
function chartstatistics(myVarVal, hexToRgba) {
  "use strict";
  /*Bar-Chart */

  var ctx = document.getElementById('chartbar-statistics').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Projects',
        categoryPercentage: 0.45,
        data: [27, 18, 27, 23, 17, 19, 22.5, 19.5, 17.5, 18.5, 19.8, 27],
        borderWidth: 0,
        backgroundColor: hexToRgba(myVarVal, 0.2),
        borderColor: hexToRgba(myVarVal, 0.2),
        pointBackgroundColor: hexToRgba(myVarVal, 0.2)
      }, {
        label: 'Expenses',
        categoryPercentage: 0.45,
        data: [29.5, 22, 23, 17, 20.5, 21, 24.8, 17, 15.8, 21, 22, 28.5],
        borderWidth: 0,
        backgroundColor: myVarVal,
        borderColor: myVarVal,
        pointBackgroundColor: myVarVal
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
          bottom: 20
        }
      },
      tooltips: {
        enabled: false
      },
      scales: {
        xAxes: [{
          barValueSpacing: 20,
          barDatasetSpacing: 2,
          barRadius: 15,
          stacked: false,
          ticks: {
            beginAtZero: true,
            fontColor: "#8492a6",
            fontFamily: 'Poppins'
          },
          gridLines: {
            color: "rgba(142, 156, 173,0.1)",
            display: false
          }
        }],
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
            stepSize: 5,
            suggestedMin: 0,
            suggestedMax: 30,
            fontColor: "#8492a6"
          }
        }]
      },
      legend: {
        display: false
      }
    }
  });
}
function analysis(myVarVal) {
  /*----- Advancedtask ------*/
  var options = {
    series: [62, 23, 15],
    chart: {
      height: 280,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    stroke: {
      show: true,
      width: 0
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '29px',
              color: '#6c6f9a',
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '26px',
              color: undefined,
              offsetY: 16,
              formatter: function formatter(val) {
                return val + "%";
              }
            },
            total: {
              show: true,
              showAlways: false,
              label: 'Total Analysis',
              fontSize: '22px',
              fontWeight: 600,
              color: '#373d3f' // formatter: function (w) {
              //   return w.globals.seriesTotals.reduce((a, b) => {
              // 	return a + b
              //   }, 0)
              // }

            }
          }
        }
      }
    },
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          show: false
        }
      }
    }],
    labels: ["Design", "Development", "Service"],
    colors: [myVarVal, '#fe7f00', '#0dcd94']
  };
  document.getElementById('analysis').innerHTML = '';
  var chart = new ApexCharts(document.querySelector("#analysis"), options);
  chart.render();

  if (document.querySelectorAll('#analysis svg').length >= 2) {
    var svgs = document.querySelectorAll('#analysis svg');

    for (var i = 0; i <= svgs.length - 1; i++) {
      if (i == 0) {} else {
        svgs[i].remove();
      }
    }
  }
}
function expenses(myVarVal, hexToRgba) {
  "use strict";
  /*-----Expenses-----*/

  var myCanvas = document.getElementById("expenses");
  myCanvas.height = "150";
  var myChart = new Chart(myCanvas, {
    type: 'line',
    data: {
      labels: ['2015', '2016', '2017', '2018', '2019', '2020'],
      datasets: [{
        label: 'Expenses',
        data: [15, 32, 15, 38, 18, 25, 22],
        backgroundColor: 'transparent',
        borderWidth: 3,
        borderColor: myVarVal,
        hoverBorderColor: myVarVal
      }, {
        label: '',
        data: [25, 28, 21, 33, 18, 36, 18],
        backgroundColor: hexToRgba(myVarVal, 0.2),
        borderWidth: 3,
        borderColor: hexToRgba(myVarVal, 0.2)
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
            min: 10,
            stepSize: 10,
            max: 40,
            fontColor: "#8492a6",
            userCallback: function userCallback(tick) {
              return tick.toString() + 'k';
            }
          }
        }],
        xAxes: [{
          ticks: {
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
  /*-----Expenses-----*/
}
function statistics1(myVarVal, hexToRgba) {
  "use strict";
  /*-----Statistics-----*/

  var myCanvas = document.getElementById("statistics1");
  var myCanvasContext = myCanvas.getContext("2d");
  var gradientStroke1 = myCanvasContext.createLinearGradient(0, 180, 0, 230);
  gradientStroke1.addColorStop(0, hexToRgba(myVarVal, 0.1));
  gradientStroke1.addColorStop(1, 'rgba(246, 247, 249, .05)');
  myCanvas.height = "350";
  var myChart = new Chart(myCanvas, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Applications',
        data: [12.5, 17, 12.5, 15.5, 18, 14.5, 22, 11, 17.5, 15.5, 16, 12.5],
        backgroundColor: 'transparent',
        borderWidth: 3,
        borderColor: myVarVal,
        hoverBorderColor: myVarVal
      }, {
        label: 'Shortlisted',
        data: [9.5, 18, 11.2, 18, 14.5, 18, 11, 15.5, 13.5, 11.5, 13, 11],
        backgroundColor: 'transparent',
        borderWidth: 3,
        borderColor: hexToRgba(myVarVal, 0.5),
        hoverBorderColor: hexToRgba(myVarVal, 0.5),
        type: 'line',
        borderDash: [7, 6]
      }, {
        label: '',
        data: [17, 23, 18, 18.5, 14, 20.5, 18, 19, 22, 20, 18.5, 24],
        backgroundColor: gradientStroke1,
        borderWidth: 3,
        borderColor: hexToRgba(myVarVal, 0.1)
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
            min: 5,
            stepSize: 5,
            max: 25,
            fontColor: "#8492a6"
          }
        }],
        xAxes: [{
          ticks: {
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
  /*-----Statistics-----*/
}
function overview(myVarVal) {
  "use strict";
  /*----- Advancedtask ------*/

  var options = {
    series: [64, 45, 28, 18],
    chart: {
      height: 300,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    stroke: {
      show: true,
      width: 0
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '29px',
              color: '#6c6f9a',
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '26px',
              color: undefined,
              offsetY: 16,
              formatter: function formatter(val) {
                return val + "%";
              }
            },
            total: {
              show: true,
              showAlways: false,
              label: 'Total Overview',
              fontSize: '22px',
              fontWeight: 600,
              color: '#373d3f' // formatter: function (w) {
              //   return w.globals.seriesTotals.reduce((a, b) => {
              // 	return a + b
              //   }, 0)
              // }

            }
          }
        }
      }
    },
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          show: false
        }
      }
    }],
    labels: ["Applications", "Interviews", "Reject", "Hired"],
    colors: [myVarVal, '#fe7f00', '#f7284a', '#0dcd94']
  };
  document.getElementById('overview').innerHTML = '';
  var chart = new ApexCharts(document.querySelector("#overview"), options);
  chart.render();
}
function chartline1(myVarVal, hexToRgba) {
  "use strict";
  /*LIne-Chart */

  var ctx = document.getElementById("chartline1").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Income',
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
        label: 'Expense',
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
function ticketoverview(myVarVal, hexToRgba) {
  'use strict'; // Ticketstatistics

  var ctx = document.getElementById("ticketoverview").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Total Assigned Tickets',
        categoryPercentage: 0.2,
        barPercentage: 0.8,
        data: [20, 17, 14, 13, 17, 19, 20, 17, 13, 18, 12, 17],
        borderWidth: 3,
        backgroundColor: myVarVal,
        borderColor: myVarVal,
        pointBackgroundColor: myVarVal,
        pointRadius: 0,
        type: 'bar'
      }, {
        label: 'Total Closed Tickets',
        categoryPercentage: 0.2,
        barPercentage: 0.8,
        data: [28, 22, 21, 28, 23, 22, 24, 28, 26, 25, 28, 24],
        borderWidth: 2,
        backgroundColor: '#fe7f00',
        borderColor: '#fe7f00',
        pointBackgroundColor: '#fe7f00',
        pointRadius: 0,
        type: 'bar'
      }, {
        label: '',
        categoryPercentage: 0.2,
        barPercentage: 0.8,
        data: [30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30],
        borderWidth: 3,
        backgroundColor: hexToRgba(myVarVal, 0.2),
        borderColor: hexToRgba(myVarVal, 0.2),
        pointBackgroundColor: hexToRgba(myVarVal, 0.2),
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
          stacked: true,
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
function chartLine3(myVarVal, hexToRgba) {
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

/***/ }),

/***/ "./resources/assets/js/themeColors.js":
/*!********************************************!*\
  !*** ./resources/assets/js/themeColors.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "checkOptions": () => (/* binding */ checkOptions),
/* harmony export */   "names": () => (/* binding */ names)
/* harmony export */ });
/* harmony import */ var _index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index */ "./resources/assets/js/index.js");
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

 // modified code start

var lightPrimaryColor = document.querySelector('#colorID');
lightPrimaryColor === null || lightPrimaryColor === void 0 ? void 0 : lightPrimaryColor.addEventListener('input', changePrimaryColor);
var darkPrimaryColorID = document.querySelector('#darkPrimaryColorID');
darkPrimaryColorID === null || darkPrimaryColorID === void 0 ? void 0 : darkPrimaryColorID.addEventListener('input', darkPrimaryColor);
var transparentBgColorID = document.querySelector('#transparentBgColorID');
transparentBgColorID === null || transparentBgColorID === void 0 ? void 0 : transparentBgColorID.addEventListener('input', transparentBgColor);
var transparentPrimaryColorID = document.querySelector('#transparentPrimaryColorID');
transparentPrimaryColorID === null || transparentPrimaryColorID === void 0 ? void 0 : transparentPrimaryColorID.addEventListener('input', transparentPrimaryColor);
var transparentBgImgPrimaryColorID = document.querySelector('#transparentBgImgPrimaryColorID');
transparentBgImgPrimaryColorID === null || transparentBgImgPrimaryColorID === void 0 ? void 0 : transparentBgImgPrimaryColorID.addEventListener('input', transparentBgImgPrimaryColor);
var bgImageFn = document.querySelectorAll('.bg-img');
bgImageFn.forEach(function (e, i) {
  e.addEventListener('click', function (el) {
    bgImage(this);
  });
}); // modified code end

var handleThemeUpdate = function handleThemeUpdate(cssVars) {
  var root = document.querySelector(':root');
  var keys = Object.keys(cssVars);
  keys.forEach(function (key) {
    root.style.setProperty(key, cssVars[key]);
  });
};

function dynamicPrimaryColor(primaryColor) {
  primaryColor.forEach(function (item) {
    item.addEventListener('input', function (e) {
      var _handleThemeUpdate;

      var cssPropName = "--primary-".concat(e.target.getAttribute('data-id'));
      var cssPropName1 = "--primary-".concat(e.target.getAttribute('data-id1'));
      var cssPropName2 = "--primary-".concat(e.target.getAttribute('data-id2'));
      var cssPropName7 = "--primary-".concat(e.target.getAttribute('data-id7'));
      var cssPropName8 = "--darkprimary-".concat(e.target.getAttribute('data-id8'));
      var cssPropName3 = "--dark-".concat(e.target.getAttribute('data-id3'));
      var cssPropName4 = "--transparent-".concat(e.target.getAttribute('data-id4'));
      var cssPropName5 = "--transparent-".concat(e.target.getAttribute('data-id5'));
      var cssPropName6 = "--transparent-".concat(e.target.getAttribute('data-id6'));
      var cssPropName9 = "--transparentprimary-".concat(e.target.getAttribute('data-id9'));
      handleThemeUpdate((_handleThemeUpdate = {}, _defineProperty(_handleThemeUpdate, cssPropName, e.target.value), _defineProperty(_handleThemeUpdate, cssPropName1, e.target.value + 95), _defineProperty(_handleThemeUpdate, cssPropName2, e.target.value), _defineProperty(_handleThemeUpdate, cssPropName3, e.target.value), _defineProperty(_handleThemeUpdate, cssPropName4, e.target.value), _defineProperty(_handleThemeUpdate, cssPropName5, e.target.value), _defineProperty(_handleThemeUpdate, cssPropName6, e.target.value + 95), _defineProperty(_handleThemeUpdate, cssPropName7, e.target.value + 20), _defineProperty(_handleThemeUpdate, cssPropName8, e.target.value + 20), _defineProperty(_handleThemeUpdate, cssPropName9, e.target.value + 20), _handleThemeUpdate));
    });
  });
}

(function () {
  // Light theme color picker
  // const LightThemeSwitchers = document.querySelectorAll('.light-mode .switch_section span');
  var dynamicPrimaryLight = document.querySelectorAll('input.color-primary-light'); // themeSwitch(LightThemeSwitchers);

  dynamicPrimaryColor(dynamicPrimaryLight); // dark theme color picker
  // const DarkThemeSwitchers = document.querySelectorAll('.dark-mode .switch_section span')

  var DarkDynamicPrimaryLight = document.querySelectorAll('input.color-primary-dark'); // themeSwitch(DarkThemeSwitchers);

  dynamicPrimaryColor(DarkDynamicPrimaryLight); // tranparent theme color picker
  // const transparentThemeSwitchers = document.querySelectorAll('.transparent-mode .switch_section span')

  var transparentDynamicPrimaryLight = document.querySelectorAll('input.color-primary-transparent'); // themeSwitch(transparentThemeSwitchers);

  dynamicPrimaryColor(transparentDynamicPrimaryLight); // tranparent theme bgcolor picker
  // const transparentBgThemeSwitchers = document.querySelectorAll('.transparent-mode .switch_section span')

  var transparentDynamicPBgLight = document.querySelectorAll('input.color-bg-transparent'); // themeSwitch(transparentBgThemeSwitchers);

  dynamicPrimaryColor(transparentDynamicPBgLight);
  localStorageBackup();
  $('#myonoffswitch1').on('click', function () {
    var _document$querySelect, _document$querySelect2, _document$querySelect3, _document$querySelect4, _document$querySelect5, _document$querySelect6;

    (_document$querySelect = document.querySelector('body')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.classList.remove('dark-mode');
    (_document$querySelect2 = document.querySelector('body')) === null || _document$querySelect2 === void 0 ? void 0 : _document$querySelect2.classList.remove('transparent-mode');
    (_document$querySelect3 = document.querySelector('body')) === null || _document$querySelect3 === void 0 ? void 0 : _document$querySelect3.classList.remove('bg-img1');
    (_document$querySelect4 = document.querySelector('body')) === null || _document$querySelect4 === void 0 ? void 0 : _document$querySelect4.classList.remove('bg-img2');
    (_document$querySelect5 = document.querySelector('body')) === null || _document$querySelect5 === void 0 ? void 0 : _document$querySelect5.classList.remove('bg-img3');
    (_document$querySelect6 = document.querySelector('body')) === null || _document$querySelect6 === void 0 ? void 0 : _document$querySelect6.classList.remove('bg-img4');
    localStorage.removeItem('amansahuBgImage');
    $('#myonoffswitch1').prop('checked', true);
    localStorage.removeItem('amansahudarkMode');
    localStorage.removeItem('amansahutransparentMode');
  });
  $('#myonoffswitch2').on('click', function () {
    var _document$querySelect7, _document$querySelect8, _document$querySelect9, _document$querySelect10, _document$querySelect11, _document$querySelect12;

    (_document$querySelect7 = document.querySelector('body')) === null || _document$querySelect7 === void 0 ? void 0 : _document$querySelect7.classList.remove('light-mode');
    (_document$querySelect8 = document.querySelector('body')) === null || _document$querySelect8 === void 0 ? void 0 : _document$querySelect8.classList.remove('transparent-mode');
    (_document$querySelect9 = document.querySelector('body')) === null || _document$querySelect9 === void 0 ? void 0 : _document$querySelect9.classList.remove('bg-img1');
    (_document$querySelect10 = document.querySelector('body')) === null || _document$querySelect10 === void 0 ? void 0 : _document$querySelect10.classList.remove('bg-img2');
    (_document$querySelect11 = document.querySelector('body')) === null || _document$querySelect11 === void 0 ? void 0 : _document$querySelect11.classList.remove('bg-img3');
    (_document$querySelect12 = document.querySelector('body')) === null || _document$querySelect12 === void 0 ? void 0 : _document$querySelect12.classList.remove('bg-img4');
    localStorage.removeItem('amansahuBgImage');
    $('#myonoffswitch2').prop('checked', true);
    localStorage.setItem('amansahudarkMode', true);
    localStorage.removeItem('amansahulightMode');
    localStorage.removeItem('amansahutransparentMode');
  });
  $('#myonoffswitchTransparent').on('click', function () {
    var _document$querySelect13, _document$querySelect14, _document$querySelect15, _document$querySelect16, _document$querySelect17, _document$querySelect18;

    (_document$querySelect13 = document.querySelector('body')) === null || _document$querySelect13 === void 0 ? void 0 : _document$querySelect13.classList.remove('dark-mode');
    (_document$querySelect14 = document.querySelector('body')) === null || _document$querySelect14 === void 0 ? void 0 : _document$querySelect14.classList.remove('light-mode');
    (_document$querySelect15 = document.querySelector('body')) === null || _document$querySelect15 === void 0 ? void 0 : _document$querySelect15.classList.remove('bg-img1');
    (_document$querySelect16 = document.querySelector('body')) === null || _document$querySelect16 === void 0 ? void 0 : _document$querySelect16.classList.remove('bg-img2');
    (_document$querySelect17 = document.querySelector('body')) === null || _document$querySelect17 === void 0 ? void 0 : _document$querySelect17.classList.remove('bg-img3');
    (_document$querySelect18 = document.querySelector('body')) === null || _document$querySelect18 === void 0 ? void 0 : _document$querySelect18.classList.remove('bg-img4');
    localStorage.removeItem('amansahuBgImage');
    $('#myonoffswitchTransparent').prop('checked', true);
    localStorage.setItem('amansahutransparentMode', true);
    localStorage.removeItem('amansahulightMode');
    localStorage.removeItem('amansahudarkMode');
  });
})();

function localStorageBackup() {
  // if there is a value stored, update color picker and background color
  // Used to retrive the data from local storage
  if (localStorage.amansahuprimaryColor) {
    document.getElementById('colorID').value = localStorage.amansahuprimaryColor;
    document.querySelector('html').style.setProperty('--primary-bg-color', localStorage.amansahuprimaryColor);
    document.querySelector('html').style.setProperty('--primary-bg-hover', localStorage.amansahuprimaryHoverColor);
    document.querySelector('html').style.setProperty('--primary-bg-border', localStorage.amansahuprimaryBorderColor);
    document.querySelector('html').style.setProperty('--primary-transparentcolor', localStorage.amansahuprimaryTransparent); // document.querySelector('body').setAttribute('class', 'app sidebar-mini light-mode');

    document.querySelector('body').classList.add("light-mode");
    document.querySelector('body').classList.remove("dark-mode");
    document.querySelector('body').classList.remove("transparent-mode");
    $('#myonoffswitch3').prop('checked', true);
    $('#myonoffswitch6').prop('checked', true);
    $('#myonoffswitch1').prop('checked', true);
  }

  if (localStorage.amansahudarkPrimary) {
    document.getElementById('darkPrimaryColorID').value = localStorage.amansahudarkPrimary;
    document.querySelector('html').style.setProperty('--primary-bg-color', localStorage.amansahudarkPrimary);
    document.querySelector('html').style.setProperty('--primary-bg-hover', localStorage.amansahudarkPrimary);
    document.querySelector('html').style.setProperty('--primary-bg-border', localStorage.amansahudarkPrimary);
    document.querySelector('html').style.setProperty('--dark-primary', localStorage.darkPrimary);
    document.querySelector('html').style.setProperty('--darkprimary-transparentcolor', localStorage.amansahudarkprimaryTransparent); // document.querySelector('body').setAttribute('class', 'app sidebar-mini dark-mode');

    document.querySelector('body').classList.remove("light-mode");
    document.querySelector('body').classList.add("dark-mode");
    document.querySelector('body').classList.remove("transparent-mode");
    $('#myonoffswitch2').prop('checked', true);
  }

  if (localStorage.amansahutransparentPrimary) {
    document.getElementById('transparentPrimaryColorID').value = localStorage.amansahutransparentPrimary;
    document.querySelector('html').style.setProperty('--primary-bg-color', localStorage.amansahutransparentPrimary);
    document.querySelector('html').style.setProperty('--primary-bg-hover', localStorage.amansahutransparentPrimary);
    document.querySelector('html').style.setProperty('--primary-bg-border', localStorage.amansahutransparentPrimary);
    document.querySelector('html').style.setProperty('--transparent-primary', localStorage.amansahutransparentPrimary);
    document.querySelector('html').style.setProperty('--transparentprimary-transparentcolor', localStorage.amansahutransparentprimaryTransparent); // document.querySelector('body').setAttribute('class', 'app sidebar-mini transparent-mode');

    document.querySelector('body').classList.remove("light-mode");
    document.querySelector('body').classList.remove("dark-mode");
    document.querySelector('body').classList.add("transparent-mode");
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahutransparentBgImgPrimary) {
    var _document$querySelect19, _document$querySelect20, _document$querySelect21;

    document.getElementById('transparentBgImgPrimaryColorID').value = localStorage.amansahutransparentBgImgPrimary;
    document.querySelector('html').style.setProperty('--primary-bg-color', localStorage.amansahutransparentBgImgPrimary);
    document.querySelector('html').style.setProperty('--primary-bg-hover', localStorage.amansahutransparentBgImgPrimary);
    document.querySelector('html').style.setProperty('--primary-bg-border', localStorage.amansahutransparentBgImgPrimary);
    document.querySelector('html').style.setProperty('--transparent-primary', localStorage.amansahutransparentBgImgPrimary);
    document.querySelector('html').style.setProperty('--transparentprimary-transparentcolor', localStorage.amansahutransparentBgImgprimaryTransparent);
    (_document$querySelect19 = document.querySelector('body')) === null || _document$querySelect19 === void 0 ? void 0 : _document$querySelect19.classList.add('transparent-mode');
    (_document$querySelect20 = document.querySelector('body')) === null || _document$querySelect20 === void 0 ? void 0 : _document$querySelect20.classList.remove('dark-mode');
    (_document$querySelect21 = document.querySelector('body')) === null || _document$querySelect21 === void 0 ? void 0 : _document$querySelect21.classList.remove('light-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahutransparentBgColor) {
    document.getElementById('transparentBgColorID').value = localStorage.amansahutransparentBgColor;
    document.querySelector('html').style.setProperty('--transparent-body', localStorage.amansahutransparentBgColor);
    document.querySelector('html').style.setProperty('--transparent-mode', localStorage.amansahutransparentThemeColor);
    document.querySelector('html').style.setProperty('--transparentprimary-transparentcolor', localStorage.amansahutransparentprimaryTransparent);
    document.querySelector('body').classList.add('transparent-mode');
    document.querySelector('body').classList.remove('dark-mode');
    document.querySelector('body').classList.remove('light-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahuBgImage) {
    var _document$querySelect22, _document$querySelect23, _document$querySelect24, _document$querySelect25;

    (_document$querySelect22 = document.querySelector('body')) === null || _document$querySelect22 === void 0 ? void 0 : _document$querySelect22.classList.add('transparent-mode');
    var bgImg = localStorage.amansahuBgImage.split(' ')[0];
    (_document$querySelect23 = document.querySelector('body')) === null || _document$querySelect23 === void 0 ? void 0 : _document$querySelect23.classList.add(bgImg);
    (_document$querySelect24 = document.querySelector('body')) === null || _document$querySelect24 === void 0 ? void 0 : _document$querySelect24.classList.remove('dark-mode');
    (_document$querySelect25 = document.querySelector('body')) === null || _document$querySelect25 === void 0 ? void 0 : _document$querySelect25.classList.remove('light-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahulightMode) {
    var _document$querySelect26, _document$querySelect27, _document$querySelect28;

    (_document$querySelect26 = document.querySelector('body')) === null || _document$querySelect26 === void 0 ? void 0 : _document$querySelect26.classList.add('light-mode');
    (_document$querySelect27 = document.querySelector('body')) === null || _document$querySelect27 === void 0 ? void 0 : _document$querySelect27.classList.remove('dark-mode');
    (_document$querySelect28 = document.querySelector('body')) === null || _document$querySelect28 === void 0 ? void 0 : _document$querySelect28.classList.remove('transparent-mode');
  }

  if (localStorage.amansahudarkMode) {
    var _document$querySelect29, _document$querySelect30, _document$querySelect31;

    (_document$querySelect29 = document.querySelector('body')) === null || _document$querySelect29 === void 0 ? void 0 : _document$querySelect29.classList.remove('light-mode');
    (_document$querySelect30 = document.querySelector('body')) === null || _document$querySelect30 === void 0 ? void 0 : _document$querySelect30.classList.add('dark-mode');
    (_document$querySelect31 = document.querySelector('body')) === null || _document$querySelect31 === void 0 ? void 0 : _document$querySelect31.classList.remove('transparent-mode');
    $('#myonoffswitch7').prop('checked', true);
  }

  if (localStorage.amansahutransparentMode) {
    var _document$querySelect32, _document$querySelect33, _document$querySelect34;

    (_document$querySelect32 = document.querySelector('body')) === null || _document$querySelect32 === void 0 ? void 0 : _document$querySelect32.classList.remove('light-mode');
    (_document$querySelect33 = document.querySelector('body')) === null || _document$querySelect33 === void 0 ? void 0 : _document$querySelect33.classList.remove('dark-mode');
    (_document$querySelect34 = document.querySelector('body')) === null || _document$querySelect34 === void 0 ? void 0 : _document$querySelect34.classList.add('transparent-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahuhorizontal) {
    document.querySelector('body').classList.add('horizontal');
  }

  if (localStorage.amansahuhorizontalHover) {
    document.querySelector('body').classList.add('horizontal-hover');
  }

  if (localStorage.amansahurtl) {
    document.querySelector('body').classList.add('rtl');
  }

  if (localStorage.amansahubgimage1) {
    document.querySelector('body').classList.add('bg-img1');
    document.querySelector('body').classList.add('transparent-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahubgimage2) {
    document.querySelector('body').classList.add('bg-img2');
    document.querySelector('body').classList.add('transparent-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahubgimage3) {
    document.querySelector('body').classList.add('bg-img3');
    document.querySelector('body').classList.add('transparent-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahubgimage4) {
    document.querySelector('body').classList.add('bg-img4');
    document.querySelector('body').classList.add('transparent-mode');
    $('#myonoffswitchTransparent').prop('checked', true);
  }

  if (localStorage.amansahubodystyle) {
    document.querySelector('body').classList.add('body-style1');
  }

  if (localStorage.amansahuboxed) {
    document.querySelector('body').classList.add('boxed');
    $('#myonoffswitch19').prop('checked', true);
  }

  if (localStorage.amansahuscrollable) {
    document.querySelector('body').classList.add('scrollable-layout');
  }

  if (localStorage.amansahulightmenu) {
    document.querySelector('body').classList.add('light-menu');
  }

  if (localStorage.amansahucolormenu) {
    document.querySelector('body').classList.add('color-menu');
  }

  if (localStorage.amansahugradientmenu) {
    document.querySelector('body').classList.add('gradient-menu');
  }

  if (localStorage.amansahudarkmenu) {
    document.querySelector('body').classList.add('dark-menu');
  }

  if (localStorage.amansahulightheader) {
    document.querySelector('body').classList.add('light-header');
  }

  if (localStorage.amansahugradientheader) {
    document.querySelector('body').classList.add('gradient-header');
  }

  if (localStorage.amansahucolorheader) {
    document.querySelector('body').classList.add('color-header');
  }

  if (localStorage.amansahudarkheader) {
    document.querySelector('body').classList.add('dark-header');
  }

  if (localStorage.amansahuicontextmenu) {
    document.querySelector('body').classList.add('icon-text');
  }

  if (localStorage.amansahuclosed) {
    document.querySelector('body').classList.add('closed');
  }

  if (localStorage.amansahuhoversubmenu) {
    document.querySelector('body').classList.add('hover-submenu');
  }

  if (localStorage.amansahuhoversubmenu1) {
    document.querySelector('body').classList.add('hover-submenu1');
  }

  if (localStorage.amansahuiconover) {
    document.querySelector('body').classList.add('icon-overlay');
  } // Boxed style


  if (document.querySelector('body').classList.contains('boxed')) {
    $('#myonoffswitch10').prop('checked', true);
  } // scrollable-layout style


  if (document.querySelector('body').classList.contains('scrollable-layout')) {
    $('#myonoffswitch12').prop('checked', true);
  } // closed-menu style


  if (document.querySelector('body').classList.contains('closed')) {
    $('#myonoffswitch23').prop('checked', true);
  } // icontext-menu style


  if (document.querySelector('body').classList.contains('icon-text')) {
    $('#myonoffswitch29').prop('checked', true);
  } // iconoverlay-menu style


  if (document.querySelector('body').classList.contains('icon-overlay')) {
    $('#myonoffswitch25').prop('checked', true);
  } // hover-submenu style


  if (document.querySelector('body').classList.contains('hover-submenu')) {
    $('#myonoffswitch24').prop('checked', true);
  } // hover-submenu1 style


  if (document.querySelector('body').classList.contains('hover-submenu1')) {
    $('#myonoffswitch30').prop('checked', true);
  }
} // triggers on changing the color picker


function changePrimaryColor() {
  $('#myonoffswitch3').prop('checked', true);
  $('#myonoffswitch6').prop('checked', true);
  checkOptions();
  var userColor = document.getElementById('colorID').value;
  localStorage.setItem('amansahuprimaryColor', userColor); // to store value as opacity 0.95 we use 95

  localStorage.setItem('amansahuprimaryHoverColor', userColor + 95);
  localStorage.setItem('amansahuprimaryBorderColor', userColor);
  localStorage.setItem('amansahuprimaryTransparent', userColor + 20); // removing dark theme properties

  localStorage.removeItem('amansahudarkPrimary');
  localStorage.removeItem('amansahutransparentBgColor');
  localStorage.removeItem('amansahutransparentThemeColor');
  localStorage.removeItem('amansahutransparentPrimary');
  localStorage.removeItem('amansahutransparentBgImgPrimary');
  localStorage.removeItem('amansahutransparentBgImgprimaryTransparent');
  localStorage.removeItem('amansahudarkprimaryTransparent');
  document.querySelector('body').classList.add('light-mode');
  document.querySelector('body').classList.remove('transparent-mode');
  document.querySelector('body').classList.remove('dark-mode');
  localStorage.removeItem('amansahuBgImage');
  $('#myonoffswitch1').prop('checked', true);
  names();
  localStorage.setItem('amansahulightMode', true);
  localStorage.removeItem('amansahudarkMode');
  localStorage.removeItem('amansahutransparentMode');
}

function darkPrimaryColor() {
  var userColor = document.getElementById('darkPrimaryColorID').value;
  localStorage.setItem('amansahudarkPrimary', userColor);
  localStorage.setItem('amansahudarkprimaryTransparent', userColor + 20);
  $('#myonoffswitch5').prop('checked', true);
  $('#myonoffswitch8').prop('checked', true);
  checkOptions(); // removing light theme data

  localStorage.removeItem('amansahuprimaryColor');
  localStorage.removeItem('amansahuprimaryHoverColor');
  localStorage.removeItem('amansahuprimaryBorderColor');
  localStorage.removeItem('amansahuprimaryTransparent');
  localStorage.removeItem('amansahutransparentBgImgPrimary');
  localStorage.removeItem('amansahutransparentBgImgprimaryTransparent');
  localStorage.removeItem('amansahutransparentBgColor');
  localStorage.removeItem('amansahutransparentThemeColor');
  localStorage.removeItem('amansahutransparentPrimary');
  localStorage.removeItem('amansahuBgImage');
  document.querySelector('body').classList.add('dark-mode');
  document.querySelector('body').classList.remove('light-mode');
  document.querySelector('body').classList.remove('transparent-mode');
  $('#myonoffswitch2').prop('checked', true);
  names();
  localStorage.setItem('amansahudarkMode', true);
  localStorage.removeItem('amansahulightMode');
  localStorage.removeItem('amansahutransparentMode');
}

function transparentPrimaryColor() {
  var _document$querySelect35, _document$querySelect36, _document$querySelect37, _document$querySelect38;

  $('#myonoffswitch3').prop('checked', false);
  $('#myonoffswitch6').prop('checked', false);
  $('#myonoffswitch5').prop('checked', false);
  $('#myonoffswitch8').prop('checked', false);
  var userColor = document.getElementById('transparentPrimaryColorID').value;
  localStorage.setItem('amansahutransparentPrimary', userColor);
  localStorage.setItem('amansahutransparentprimaryTransparent', userColor + 20);
  document.querySelector('body').classList.remove("light-menu");
  document.querySelector('body').classList.remove("light-header"); // removing light theme data

  localStorage.removeItem('amansahudarkPrimary');
  localStorage.removeItem('amansahuprimaryColor');
  localStorage.removeItem('amansahuprimaryHoverColor');
  localStorage.removeItem('amansahuBgImage');
  localStorage.removeItem('amansahuprimaryBorderColor');
  localStorage.removeItem('amansahuprimaryTransparent');
  localStorage.removeItem('amansahutransparentBgImgPrimary');
  localStorage.removeItem('amansahutransparentBgImgprimaryTransparent');
  localStorage.removeItem('amansahubgimage1');
  localStorage.removeItem('amansahubgimage2');
  localStorage.removeItem('amansahubgimage3');
  localStorage.removeItem('amansahubgimage4');
  document.querySelector('body').classList.add('transparent-mode');
  document.querySelector('body').classList.remove('light-mode');
  document.querySelector('body').classList.remove('dark-mode');
  (_document$querySelect35 = document.querySelector('body')) === null || _document$querySelect35 === void 0 ? void 0 : _document$querySelect35.classList.remove('bg-img1');
  (_document$querySelect36 = document.querySelector('body')) === null || _document$querySelect36 === void 0 ? void 0 : _document$querySelect36.classList.remove('bg-img2');
  (_document$querySelect37 = document.querySelector('body')) === null || _document$querySelect37 === void 0 ? void 0 : _document$querySelect37.classList.remove('bg-img3');
  (_document$querySelect38 = document.querySelector('body')) === null || _document$querySelect38 === void 0 ? void 0 : _document$querySelect38.classList.remove('bg-img4');
  $('#myonoffswitchTransparent').prop('checked', true);
  checkOptions();
  names();
  localStorage.setItem('amansahutransparentMode', true);
  localStorage.removeItem('amansahulightMode');
  localStorage.removeItem('amansahudarkMode');
}

function transparentBgImgPrimaryColor() {
  var _document$querySelect39, _document$querySelect40, _document$querySelect41, _document$querySelect42, _document$querySelect44, _document$querySelect45, _document$querySelect46, _document$querySelect47;

  $('#myonoffswitch3').prop('checked', false);
  $('#myonoffswitch6').prop('checked', false);
  $('#myonoffswitch5').prop('checked', false);
  $('#myonoffswitch8').prop('checked', false);
  var userColor = document.getElementById('transparentBgImgPrimaryColorID').value;
  localStorage.setItem('amansahutransparentBgImgPrimary', userColor);
  localStorage.setItem('amansahutransparentBgImgprimaryTransparent', userColor + 20);

  if (((_document$querySelect39 = document.querySelector('body')) === null || _document$querySelect39 === void 0 ? void 0 : _document$querySelect39.classList.contains('bg-img1')) == false && ((_document$querySelect40 = document.querySelector('body')) === null || _document$querySelect40 === void 0 ? void 0 : _document$querySelect40.classList.contains('bg-img2')) == false && ((_document$querySelect41 = document.querySelector('body')) === null || _document$querySelect41 === void 0 ? void 0 : _document$querySelect41.classList.contains('bg-img3')) == false && ((_document$querySelect42 = document.querySelector('body')) === null || _document$querySelect42 === void 0 ? void 0 : _document$querySelect42.classList.contains('bg-img4')) == false) {
    var _document$querySelect43;

    (_document$querySelect43 = document.querySelector('body')) === null || _document$querySelect43 === void 0 ? void 0 : _document$querySelect43.classList.add('bg-img1');
    localStorage.setItem('amansahuBgImage', 'bg-img1');
  } // removing light theme data


  localStorage.removeItem('amansahudarkPrimary');
  localStorage.removeItem('amansahuprimaryColor');
  localStorage.removeItem('amansahuprimaryHoverColor');
  localStorage.removeItem('amansahuprimaryBorderColor');
  localStorage.removeItem('amansahuprimaryTransparent');
  localStorage.removeItem('amansahudarkprimaryTransparent');
  localStorage.removeItem('amansahutransparentPrimary');
  localStorage.removeItem('transparentprimaryTransparent');
  document.querySelector('body').classList.add('transparent-mode');
  (_document$querySelect44 = document.querySelector('body')) === null || _document$querySelect44 === void 0 ? void 0 : _document$querySelect44.classList.remove('light-mode');
  (_document$querySelect45 = document.querySelector('body')) === null || _document$querySelect45 === void 0 ? void 0 : _document$querySelect45.classList.remove('dark-mode');
  (_document$querySelect46 = document.querySelector('body')) === null || _document$querySelect46 === void 0 ? void 0 : _document$querySelect46.classList.remove('light-menu');
  (_document$querySelect47 = document.querySelector('body')) === null || _document$querySelect47 === void 0 ? void 0 : _document$querySelect47.classList.remove('light-header');
  $('#myonoffswitchTransparent').prop('checked', true);
  checkOptions();
  names();
  localStorage.setItem('amansahutransparentMode', true);
  localStorage.removeItem('amansahulightMode');
  localStorage.removeItem('amansahudarkMode');
}

function transparentBgColor() {
  var _document$querySelect48, _document$querySelect49, _document$querySelect50, _document$querySelect51;

  $('#myonoffswitch3').prop('checked', false);
  $('#myonoffswitch6').prop('checked', false);
  $('#myonoffswitch5').prop('checked', false);
  $('#myonoffswitch8').prop('checked', false);
  var userColor = document.getElementById('transparentBgColorID').value;
  localStorage.setItem('amansahutransparentBgColor', userColor);
  localStorage.setItem('amansahutransparentThemeColor', userColor + 95);
  localStorage.setItem('amansahutransparentprimaryTransparent', userColor + 20);
  localStorage.removeItem('amansahutransparentBgImgPrimary');
  localStorage.removeItem('amansahutransparentBgImgprimaryTransparent');
  document.querySelector('body').classList.remove('light-menu');
  document.querySelector('body').classList.remove('light-header'); // removing light theme data

  localStorage.removeItem('amansahuBgImage');
  localStorage.removeItem('amansahudarkPrimary');
  localStorage.removeItem('amansahuprimaryColor');
  localStorage.removeItem('amansahuprimaryHoverColor');
  localStorage.removeItem('amansahuprimaryBorderColor');
  localStorage.removeItem('amansahuprimaryTransparent');
  localStorage.removeItem('amansahuBgImage');
  localStorage.removeItem('amansahubgimage1');
  localStorage.removeItem('amansahubgimage2');
  localStorage.removeItem('amansahubgimage3');
  localStorage.removeItem('amansahubgimage4');
  document.querySelector('body').classList.add('transparent-mode');
  document.querySelector('body').classList.remove('light-mode');
  document.querySelector('body').classList.remove('dark-mode');
  (_document$querySelect48 = document.querySelector('body')) === null || _document$querySelect48 === void 0 ? void 0 : _document$querySelect48.classList.remove('bg-img1');
  (_document$querySelect49 = document.querySelector('body')) === null || _document$querySelect49 === void 0 ? void 0 : _document$querySelect49.classList.remove('bg-img2');
  (_document$querySelect50 = document.querySelector('body')) === null || _document$querySelect50 === void 0 ? void 0 : _document$querySelect50.classList.remove('bg-img3');
  (_document$querySelect51 = document.querySelector('body')) === null || _document$querySelect51 === void 0 ? void 0 : _document$querySelect51.classList.remove('bg-img4');
  $('#myonoffswitchTransparent').prop('checked', true);
  checkOptions();
  localStorage.setItem('amansahutransparentMode', true);
  localStorage.removeItem('amansahulightMode');
  localStorage.removeItem('amansahudarkMode');
}

function bgImage(e) {
  var _document$querySelect52, _document$querySelect53;

  $('#myonoffswitch3').prop('checked', false);
  $('#myonoffswitch6').prop('checked', false);
  $('#myonoffswitch5').prop('checked', false);
  $('#myonoffswitch8').prop('checked', false);
  var imgID = e.getAttribute('class');
  localStorage.setItem('amansahuBgImage', imgID);
  localStorage.setItem('amansahutransparentMode', true); // removing light theme data

  localStorage.removeItem('amansahudarkPrimary');
  localStorage.removeItem('amansahuprimaryColor');
  localStorage.removeItem('amansahutransparentBgColor');
  localStorage.removeItem('amansahutransparentThemeColor');
  localStorage.removeItem('amansahutransparentprimaryTransparent');
  document.querySelector('body').classList.add('transparent-mode');
  (_document$querySelect52 = document.querySelector('body')) === null || _document$querySelect52 === void 0 ? void 0 : _document$querySelect52.classList.remove('light-mode');
  (_document$querySelect53 = document.querySelector('body')) === null || _document$querySelect53 === void 0 ? void 0 : _document$querySelect53.classList.remove('dark-mode');
  $('#myonoffswitchTransparent').prop('checked', true);
  checkOptions();
} // to check the value is hexa or not


var isValidHex = function isValidHex(hexValue) {
  return /^#([A-Fa-f0-9]{3,4}){1,2}$/.test(hexValue);
};

var getChunksFromString = function getChunksFromString(st, chunkSize) {
  return st.match(new RegExp(".{".concat(chunkSize, "}"), "g"));
}; // convert hex value to 256


var convertHexUnitTo256 = function convertHexUnitTo256(hexStr) {
  return parseInt(hexStr.repeat(2 / hexStr.length), 16);
}; // get alpha value is equla to 1 if there was no value is asigned to alpha in function


var getAlphafloat = function getAlphafloat(a, alpha) {
  if (typeof a !== "undefined") {
    return a / 255;
  }

  if (typeof alpha != "number" || alpha < 0 || alpha > 1) {
    return 1;
  }

  return alpha;
}; // convertion of hex code to rgba code


function hexToRgba(hexValue, alpha) {
  if (!isValidHex(hexValue)) {
    return null;
  }

  var chunkSize = Math.floor((hexValue.length - 1) / 3);
  var hexArr = getChunksFromString(hexValue.slice(1), chunkSize);

  var _hexArr$map = hexArr.map(convertHexUnitTo256),
      _hexArr$map2 = _slicedToArray(_hexArr$map, 4),
      r = _hexArr$map2[0],
      g = _hexArr$map2[1],
      b = _hexArr$map2[2],
      a = _hexArr$map2[3];

  return "rgba(".concat(r, ", ").concat(g, ", ").concat(b, ", ").concat(getAlphafloat(a, alpha), ")");
}

var myVarVal;
function names() {
  // let docStyle = getComputedStyle(document.documentElement);
  var primaryColorVal = getComputedStyle(document.documentElement).getPropertyValue('--primary-bg-color').trim(); //get variable

  myVarVal = localStorage.getItem("amansahuprimaryColor") || localStorage.getItem("amansahudarkPrimary") || localStorage.getItem("amansahutransparentPrimary") || localStorage.getItem("amansahutransparentBgImgPrimary") || primaryColorVal;

  if (document.querySelector('#chartLine') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.index)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#employees') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.index1)(myVarVal);
  }

  if (document.querySelector('#sales-summary') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.index2)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#chartbar') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.chartbar)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#balance') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.balance)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#advancedtask') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.advancedtask)(myVarVal);
  }

  if (document.querySelector('#spenttask') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.spenttask)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#statistics') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.statistics)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#statistics1') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.statistics1)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#employee1') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.employee1)(myVarVal);
  }

  if (document.querySelector('#chartbar-statistics') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.chartstatistics)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#analysis') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.analysis)(myVarVal);
  }

  if (document.querySelector('#overview') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.overview)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#chartline1') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.chartline1)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#chartLine3') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.chartLine3)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#overview') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.overview)(myVarVal);
  }

  if (document.querySelector('#ticketoverview') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.ticketoverview)(myVarVal, hexToRgba);
  }

  if (document.querySelector('#expenses') !== null) {
    (0,_index__WEBPACK_IMPORTED_MODULE_0__.expenses)(myVarVal, hexToRgba);
  }

  var colorData = hexToRgba(myVarVal || primaryColorVal, 0.1);
  document.querySelector('html').style.setProperty('--primary01', colorData);
  var colorData1 = hexToRgba(myVarVal || primaryColorVal, 0.2);
  document.querySelector('html').style.setProperty('--primary02', colorData1);
  var colorData2 = hexToRgba(myVarVal || primaryColorVal, 0.3);
  document.querySelector('html').style.setProperty('--primary03', colorData2);
  var colorData3 = hexToRgba(myVarVal || primaryColorVal, 0.6);
  document.querySelector('html').style.setProperty('--primary06', colorData3);
  var colorData4 = hexToRgba(myVarVal || primaryColorVal, 0.8);
  document.querySelector('html').style.setProperty('--primary08', colorData4);
  var colorData5 = hexToRgba(myVarVal || primaryColorVal, 0.9);
  document.querySelector('html').style.setProperty('--primary09', colorData5);
}
names(); // CHECK OPTIONS

function checkOptions() {
  "use strict"; // rtl

  if (document.querySelector('body').classList.contains('rtl')) {
    $('#myonoffswitch55').prop('checked', true);
  } // horizontal


  if (document.querySelector('body').classList.contains('horizontal')) {
    $('#myonoffswitch35').prop('checked', true);
  } // horizontal-hover


  if (document.querySelector('body').classList.contains('horizontal-hover')) {
    $('#myonoffswitch111').prop('checked', true);
  } // light header


  if (document.querySelector('body').classList.contains('light-header')) {
    $('#background1').prop('checked', true);
  } // color header


  if (document.querySelector('body').classList.contains('color-header')) {
    $('#background2').prop('checked', true);
  } // gradient header


  if (document.querySelector('body').classList.contains('gradient-header')) {
    $('#background3').prop('checked', true);
  } // dark header


  if (document.querySelector('body').classList.contains('dark-header')) {
    $('#background11').prop('checked', true);
  } // light menu


  if (document.querySelector('body').classList.contains('light-menu')) {
    $('#background4').prop('checked', true);
  } // color menu


  if (document.querySelector('body').classList.contains('color-menu')) {
    $('#background5').prop('checked', true);
  } // gradient menu


  if (document.querySelector('body').classList.contains('gradient-menu')) {
    $('#background10').prop('checked', true);
  } // dark menu


  if (document.querySelector('body').classList.contains('dark-menu')) {
    $('#background6').prop('checked', true);
  }
}
checkOptions(); // RESET SWITCHER TO DEFAULT

var reset = document.querySelector('#resetAll');

if (reset) {
  reset.addEventListener('click', function () {
    resetData();
  });
}

var customreset = document.querySelector('#customresetAll');

if (customreset) {
  customreset.addEventListener('click', function () {
    customresetData();
  });
}

function resetData() {
  var _$, _$2, _$3, _$4, _$5, _$6, _$7, _$8, _$9, _$10, _$11, _$12, _$13, _$14, _$15, _$16, _$17, _$18, _$19, _$20, _$21, _$22, _document$getElementB;

  localStorage.clear();
  $('#myonoffswitch34').prop('checked', true);
  $('#myonoffswitch54').prop('checked', true);
  $('#myonoffswitch3').prop('checked', true);
  $('#myonoffswitch6').prop('checked', true);
  $('#myonoffswitch1').prop('checked', true);
  $('#myonoffswitch9').prop('checked', true);
  $('#background1').prop('checked', true);
  $('#background6').prop('checked', true);
  $('#myonoffswitch10').prop('checked', false);
  $('#myonoffswitch11').prop('checked', true);
  $('#myonoffswitch12').prop('checked', false);
  $('#myonoffswitch13').prop('checked', true);
  $('#myonoffswitch14').prop('checked', false);
  $('#myonoffswitch15').prop('checked', false);
  $('#myonoffswitch16').prop('checked', false);
  $('#myonoffswitch17').prop('checked', false);
  $('#myonoffswitch18').prop('checked', true);
  $('#myonoffswitch22').prop('checked', true);
  $('#background3').prop('checked', false);
  $('#myonoffswitch2').prop('checked', false);
  (_$ = $('body')) === null || _$ === void 0 ? void 0 : _$.removeClass('bg-img4');
  (_$2 = $('body')) === null || _$2 === void 0 ? void 0 : _$2.removeClass('bg-img1');
  (_$3 = $('body')) === null || _$3 === void 0 ? void 0 : _$3.removeClass('bg-img2');
  (_$4 = $('body')) === null || _$4 === void 0 ? void 0 : _$4.removeClass('bg-img3');
  (_$5 = $('body')) === null || _$5 === void 0 ? void 0 : _$5.removeClass('transparent-mode');
  (_$6 = $('body')) === null || _$6 === void 0 ? void 0 : _$6.removeClass('light-menu');
  (_$7 = $('body')) === null || _$7 === void 0 ? void 0 : _$7.removeClass('dark-mode');
  (_$8 = $('body')) === null || _$8 === void 0 ? void 0 : _$8.removeClass('dark-menu');
  (_$9 = $('body')) === null || _$9 === void 0 ? void 0 : _$9.removeClass('color-menu');
  (_$10 = $('body')) === null || _$10 === void 0 ? void 0 : _$10.removeClass('gradient-menu');
  (_$11 = $('body')) === null || _$11 === void 0 ? void 0 : _$11.removeClass('dark-header');
  (_$12 = $('body')) === null || _$12 === void 0 ? void 0 : _$12.removeClass('color-header');
  (_$13 = $('body')) === null || _$13 === void 0 ? void 0 : _$13.removeClass('gradient-header');
  (_$14 = $('body')) === null || _$14 === void 0 ? void 0 : _$14.removeClass('boxed');
  (_$15 = $('body')) === null || _$15 === void 0 ? void 0 : _$15.removeClass('icon-text');
  (_$16 = $('body')) === null || _$16 === void 0 ? void 0 : _$16.removeClass('icon-overlay');
  (_$17 = $('body')) === null || _$17 === void 0 ? void 0 : _$17.removeClass('closed');
  (_$18 = $('body')) === null || _$18 === void 0 ? void 0 : _$18.removeClass('hover-submenu');
  (_$19 = $('body')) === null || _$19 === void 0 ? void 0 : _$19.removeClass('hover-submenu1');
  (_$20 = $('body')) === null || _$20 === void 0 ? void 0 : _$20.removeClass('sidenav-toggled');
  (_$21 = $('body')) === null || _$21 === void 0 ? void 0 : _$21.removeClass('scrollable-layout');
  (_$22 = $('body')) === null || _$22 === void 0 ? void 0 : _$22.removeClass('rtl'); // resetting horizontal to vertical

  ActiveSubmenu();
  $('body').removeClass('horizontal');
  $('body').removeClass('horizontal-hover');
  $('body').addClass('default-menu');
  $('body').addClass('sidebar-mini');
  $('sidebar-mini').removeClass('hor-content');
  $('sidebar-mini').addClass('main-content"');
  $(".app-sidebar3").removeClass("horizontal-mainwrapper container");
  $(".main-content").removeClass("hor-content");
  $(".main-content").addClass("app-content");
  $(".main-container").removeClass("container");
  $(".main-container").addClass("container-fluid");
  $(".angle").removeClass("horizontal-icon");
  $(".main-menu").removeClass("horizontalMenu");
  $(".main-container").addClass("side-app");
  $(".header").removeClass("hor-header");
  $(".header").addClass("app-header");
  $(".app-sidebar").removeClass("horizontal-main");
  $(".main-sidemenu").removeClass("container");
  $(".app-sidebar").removeClass("hor-menu ");
  $('#slide-left').removeClass('d-none');
  $('#slide-right').removeClass('d-none');
  localStorage.setItem("amansahusidebar-mini", "True");
  menuClick();
  responsive();
  $('body').addClass('ltr');
  $('body').removeClass('rtl');
  $("html[lang=en]").attr("dir", "ltr");
  localStorage.setItem("ltr", "True");
  $("head link#style").attr("href", $(this));
  (_document$getElementB = document.getElementById("style")) === null || _document$getElementB === void 0 ? void 0 : _document$getElementB.setAttribute("href", "https://laravelui.spruko.com/amansahu/assets/plugins/bootstrap/css/bootstrap.css");
  var carousel = $('.owl-carousel');
  $.each(carousel, function (index, element) {
    // element == this
    var carouselData = $(element).data('owl.carousel');
    carouselData.settings.rtl = false; //don't know if both are necessary

    carouselData.options.rtl = false;
    $(element).trigger('refresh.owl.carousel');
  });
  document.querySelector('html').style = '';
  names();
}

function customresetData() {
  var _$23, _$24, _$25, _$26, _$27, _$28, _$29, _$30, _$31, _document$getElementB2;

  localStorage.clear();
  $('#myonoffswitch54').prop('checked', true);
  $('#myonoffswitch1').prop('checked', true);
  $('#myonoffswitch18').prop('checked', true);
  $('#myonoffswitch19').prop('checked', false);
  $('#myonoffswitch2').prop('checked', false);
  (_$23 = $('body')) === null || _$23 === void 0 ? void 0 : _$23.removeClass('bg-img4');
  (_$24 = $('body')) === null || _$24 === void 0 ? void 0 : _$24.removeClass('bg-img1');
  (_$25 = $('body')) === null || _$25 === void 0 ? void 0 : _$25.removeClass('bg-img2');
  (_$26 = $('body')) === null || _$26 === void 0 ? void 0 : _$26.removeClass('bg-img3');
  (_$27 = $('body')) === null || _$27 === void 0 ? void 0 : _$27.removeClass('transparent-mode');
  (_$28 = $('body')) === null || _$28 === void 0 ? void 0 : _$28.removeClass('dark-mode');
  (_$29 = $('body')) === null || _$29 === void 0 ? void 0 : _$29.removeClass('dark-menu');
  (_$30 = $('body')) === null || _$30 === void 0 ? void 0 : _$30.removeClass('boxed');
  (_$31 = $('body')) === null || _$31 === void 0 ? void 0 : _$31.removeClass('rtl');
  $('body').addClass('ltr');
  $('body').removeClass('rtl');
  $("html[lang=en]").attr("dir", "ltr");
  localStorage.setItem("ltr", "True");
  $("head link#style").attr("href", $(this));
  (_document$getElementB2 = document.getElementById("style")) === null || _document$getElementB2 === void 0 ? void 0 : _document$getElementB2.setAttribute("href", "https://laravelui.spruko.com/amansahu/assets/plugins/bootstrap/css/bootstrap.css");
  var carousel = $('.owl-carousel');
  $.each(carousel, function (index, element) {
    // element == this
    var carouselData = $(element).data('owl.carousel');
    carouselData.settings.rtl = false; //don't know if both are necessary

    carouselData.options.rtl = false;
    $(element).trigger('refresh.owl.carousel');
  });
  document.querySelector('html').style = '';
  names();
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***************************************!*\
  !*** ./resources/assets/js/custom.js ***!
  \***************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _themeColors__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./themeColors */ "./resources/assets/js/themeColors.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }



(function ($) {
  "use strict"; //  Page Loading

  $(window).on("load", function (e) {
    $("#global-loader").fadeOut("slow");
  }); //  Full screen

  $(document).on("click", ".fullscreen-button", function toggleFullScreen() {
    $('html').addClass('fullscreen-content');

    if (document.fullScreenElement !== undefined && document.fullScreenElement === null || document.msFullscreenElement !== undefined && document.msFullscreenElement === null || document.mozFullScreen !== undefined && !document.mozFullScreen || document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen) {
      if (document.documentElement.requestFullScreen) {
        document.documentElement.requestFullScreen();
      } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
      } else if (document.documentElement.webkitRequestFullScreen) {
        document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
      } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen();
      }
    } else {
      $('html').removeClass('fullscreen-content');

      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }
  }); //  Cover Image

  $(".cover-image").each(function () {
    var attr = $(this).attr('data-bs-image-src');

    if (_typeof(attr) !== ( true ? "undefined" : 0) && attr !== false) {
      $(this).css('background', 'url(' + attr + ') center center');
    }
  }); //  Horizonatl

  $(document).ready(function () {
    $("a[data-theme]").on('click', function () {
      $("head link#theme").attr("href", $(this).data("theme"));
      $(this).toggleClass('active').siblings().removeClass('active');
    });
    $("a[data-effect]").on('click', function () {
      $("head link#effect").attr("href", $(this).data("effect"));
      $(this).toggleClass('active').siblings().removeClass('active');
    });
  }); //  Tooltip

  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  }); //  POPOVER

  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  }); //  MODAL
  // showing modal with effect

  $('.modal-effect').on('click', function (e) {
    e.preventDefault();
    var effect = $(this).attr('data-effect');
    $('#modaldemo8').addClass(effect);
  }); // hide modal with effect

  $('#modaldemo8').on('hidden.bs.modal', function (e) {
    $(this).removeClass(function (index, className) {
      return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
    });
  }); //  Back to top Button

  $(window).on("scroll", function (e) {
    if ($(this).scrollTop() > 0) {
      $('#back-to-top').fadeIn('slow');
    } else {
      $('#back-to-top').fadeOut('slow');
    }
  });
  $("#back-to-top").on("click", function (e) {
    $("html, body").animate({
      scrollTop: 0
    }, 0);
    return false;
  }); //  Chart-circle

  if ($('.chart-circle').length) {
    $('.chart-circle').each(function () {
      var $this = $(this);
      $this.circleProgress({
        fill: {
          color: $this.attr('data-color')
        },
        size: $this.height(),
        startAngle: -Math.PI / 4 * 2,
        emptyFill: '#e5e9f2',
        lineCap: 'round'
      });
    });
  } //  Chart-circle


  if ($('.chart-circle-primary').length) {
    $('.chart-circle-primary').each(function () {
      var $this = $(this);
      $this.circleProgress({
        fill: {
          color: $this.attr('data-color')
        },
        size: $this.height(),
        startAngle: -Math.PI / 4 * 2,
        emptyFill: 'rgba(51, 102, 255, 0.4)',
        lineCap: 'round'
      });
    });
  } //  Chart-circle


  if ($('.chart-circle-secondary').length) {
    $('.chart-circle-secondary').each(function () {
      var $this = $(this);
      $this.circleProgress({
        fill: {
          color: $this.attr('data-color')
        },
        size: $this.height(),
        startAngle: -Math.PI / 4 * 2,
        emptyFill: 'rgba(254, 127, 0, 0.4)',
        lineCap: 'round'
      });
    });
  } //  Chart-circle


  if ($('.chart-circle-success').length) {
    $('.chart-circle-success').each(function () {
      var $this = $(this);
      $this.circleProgress({
        fill: {
          color: $this.attr('data-color')
        },
        size: $this.height(),
        startAngle: -Math.PI / 4 * 2,
        emptyFill: 'rgba(13, 205, 148, 0.5)',
        lineCap: 'round'
      });
    });
  } //  Chart-circle


  if ($('.chart-circle-warning').length) {
    $('.chart-circle-warning').each(function () {
      var $this = $(this);
      $this.circleProgress({
        fill: {
          color: $this.attr('data-color')
        },
        size: $this.height(),
        startAngle: -Math.PI / 4 * 2,
        emptyFill: 'rgba(247, 40, 74, 0.4)',
        lineCap: 'round'
      });
    });
  } //  Chart-circle


  if ($('.chart-circle-danger').length) {
    $('.chart-circle-danger').each(function () {
      var $this = $(this);
      $this.circleProgress({
        fill: {
          color: $this.attr('data-color')
        },
        size: $this.height(),
        startAngle: -Math.PI / 4 * 2,
        emptyFill: 'rgba(247, 40, 74, 0.4)',
        lineCap: 'round'
      });
    });
  } //  Global Search


  $(document).on("click", "[data-bs-toggle='search']", function (e) {
    var body = $("body");

    if (body.hasClass('search-gone')) {
      body.addClass('search-gone');
      body.removeClass('search-show');
    } else {
      body.removeClass('search-gone');
      body.addClass('search-show');
    }
  });

  var toggleSidebar = function toggleSidebar() {
    var w = $(window);

    if (w.outerWidth() <= 1024) {
      $("body").addClass("sidebar-gone");
      $(document).off("click", "body").on("click", "body", function (e) {
        if ($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
          $("body").removeClass("sidebar-show");
          $("body").addClass("sidebar-gone");
          $("body").removeClass("search-show");
        }
      });
    } else {
      $("body").removeClass("sidebar-gone");
    }
  };

  toggleSidebar();
  $(window).resize(toggleSidebar);
  var DIV_CARD = 'div.card'; //  Function for remove card

  $(document).on('click', '[data-bs-toggle="card-remove"]', function (e) {
    var $card = $(this).closest(DIV_CARD);
    $card.remove();
    e.preventDefault();
    return false;
  }); //  Functions for collapsed card

  $(document).on('click', '[data-bs-toggle="card-collapse"]', function (e) {
    var $card = $(this).closest(DIV_CARD);
    $card.toggleClass('card-collapsed');
    e.preventDefault();
    return false;
  }); //  Card full screen

  $(document).on('click', '[data-bs-toggle="card-fullscreen"]', function (e) {
    var $card = $(this).closest(DIV_CARD);
    $card.toggleClass('card-fullscreen').removeClass('card-collapsed');
    e.preventDefault();
    return false;
  }); // Input file-browser

  $(document).on('change', '.file-browserinput', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  }); // We can watch for our custom `fileselect` event like this
  // File Upload

  $('.file-browserinput').on('fileselect', function (event, numFiles, label) {
    var input = $(this).parents('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;

    if (input.length) {
      input.val(log);
    } else {
      if (log) ;
    }
  }); // Select2

  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: '100%'
  }); //  Product carosuel

  $('.thumb').on('click', function () {
    if (!$(this).hasClass('active')) {
      $(".thumb.active").removeClass("active");
      $(this).addClass("active");
    }
  }); // LTR AND

  $('#myonoffswitch55').on('click', function () {
    if (this.checked) {
      var _document$getElementB;

      $('body').addClass('rtl');
      $('body').removeClass('ltr');
      $("html[lang=en]").attr("dir", "rtl");
      $("head link#style").attr("href", $(this));
      (_document$getElementB = document.getElementById("style")) === null || _document$getElementB === void 0 ? void 0 : _document$getElementB.setAttribute("href", "https://laravelui.spruko.com/amansahu/assets/plugins/bootstrap/css/bootstrap.rtl.css");
      var carousel = $('.owl-carousel');

      if (carousel) {
        $.each(carousel, function (index, element) {
          // element == this
          var carouselData = $(element).data('owl.carousel');

          if (carouselData) {
            carouselData.settings.rtl = true; //don't know if both are necessary

            carouselData.options.rtl = true;
            $(element).trigger('refresh.owl.carousel');
          }
        });
      }

      localStorage.setItem('amansahurtl', true);
      localStorage.removeItem('amansahultr');
    }
  });
  var bodyRtl = $('body').hasClass('rtl');

  if (bodyRtl) {
    var _document$getElementB2;

    $('body').addClass('rtl');
    $('body').removeClass('ltr');
    $("html[lang=en]").attr("dir", "rtl");
    $("head link#style").attr("href", $(this));
    (_document$getElementB2 = document.getElementById("style")) === null || _document$getElementB2 === void 0 ? void 0 : _document$getElementB2.setAttribute("href", "https://laravelui.spruko.com/amansahu/assets/plugins/bootstrap/css/bootstrap.rtl.css");
  }

  $('#myonoffswitch54').on('click', function () {
    if (this.checked) {
      var _document$getElementB3;

      $('body').addClass('ltr');
      $('body').removeClass('rtl');
      $("html[lang=en]").attr("dir", "ltr");
      $("head link#style").attr("href", $(this));
      (_document$getElementB3 = document.getElementById("style")) === null || _document$getElementB3 === void 0 ? void 0 : _document$getElementB3.setAttribute("href", "https://laravelui.spruko.com/amansahu/assets/plugins/bootstrap/css/bootstrap.css");
      var carousel = $('.owl-carousel');

      if (carousel) {
        $.each(carousel, function (index, element) {
          // element == this
          var carouselData = $(element).data('owl.carousel');

          if (carouselData) {
            carouselData.settings.rtl = false; //don't know if both are necessary

            carouselData.options.rtl = false;
            $(element).trigger('refresh.owl.carousel');
          }
        });
      }

      localStorage.setItem('amansahultr', true);
      localStorage.removeItem('amansahurtl');
    } else {
      var _document$getElementB4;

      $('body').removeClass('ltr');
      $('body').addClass('rtl');
      $("html[lang=en]").attr("dir", "rtl");
      localStorage.setItem("amansahultr", "false");
      $("head link#style").attr("href", $(this));
      (_document$getElementB4 = document.getElementById("style")) === null || _document$getElementB4 === void 0 ? void 0 : _document$getElementB4.setAttribute("href", "https://laravelui.spruko.com/amansahu/assets/plugins/bootstrap/css/bootstrap.rtl.css");
    }
  });
  var bodyltr = $('body').hasClass('ltr');

  if (bodyltr) {
    var _document$getElementB5;

    $('body').addClass('ltr');
    $('body').removeClass('rtl');
    $("html[lang=en]").attr("dir", "ltr");
    $("head link#style").attr("href", $(this));
    (_document$getElementB5 = document.getElementById("style")) === null || _document$getElementB5 === void 0 ? void 0 : _document$getElementB5.setAttribute("href", "https://laravelui.spruko.com/amansahu/assets/plugins/bootstrap/css/bootstrap.css");
    var carousel = $('.owl-carousel');

    if (carousel) {
      $.each(carousel, function (index, element) {
        // element == this
        if (carouselData) {
          var carouselData = $(element).data('owl.carousel');
          carouselData.settings.rtl = false; //don't know if both are necessary

          carouselData.options.rtl = false;
          $(element).trigger('refresh.owl.carousel');
        }
      });
    }
  } // Header Style


  $('#background1').on('click', function () {
    if (this.checked) {
      $('body').addClass('light-header');
      $('body').removeClass('color-header');
      $('body').removeClass('dark-header');
      $('body').removeClass('gradient-header');
      localStorage.setItem("amansahulightheader", true);
      localStorage.removeItem("amansahucolorheader");
      localStorage.removeItem("amansahudarkheader");
      localStorage.removeItem("amansahugradientheader");
    }
  });
  $('#background2').on('click', function () {
    if (this.checked) {
      $('body').addClass('color-header');
      $('body').removeClass('light-header');
      $('body').removeClass('dark-header');
      $('body').removeClass('gradient-header');
      localStorage.setItem("amansahucolorheader", true);
      localStorage.removeItem("amansahulightheader");
      localStorage.removeItem("amansahudarkheader");
      localStorage.removeItem("amansahugradientheader");
    }
  });
  $('#background3').on('click', function () {
    if (this.checked) {
      $('body').addClass('dark-header');
      $('body').removeClass('light-header');
      $('body').removeClass('color-header');
      $('body').removeClass('gradient-header');
      localStorage.setItem("amansahudarkheader", true);
      localStorage.removeItem("amansahulightheader");
      localStorage.removeItem("amansahucolorheader");
      localStorage.removeItem("amansahugradientheader");
    }
  });
  $('#background11').on('click', function () {
    if (this.checked) {
      $('body').addClass('gradient-header');
      $('body').removeClass('light-header');
      $('body').removeClass('color-header');
      $('body').removeClass('dark-header');
      localStorage.setItem("amansahugradientheader", true);
      localStorage.removeItem("amansahulightheader");
      localStorage.removeItem("amansahucolorheader");
      localStorage.removeItem("amansahudarkheader");
    }
  }); // Leftmenu Style

  $('#background4').on('click', function () {
    if (this.checked) {
      $('body').addClass('light-menu');
      $('body').removeClass('color-menu');
      $('body').removeClass('dark-menu');
      $('body').removeClass('gradient-menu');
      localStorage.setItem("amansahulightmenu", true);
      localStorage.removeItem("amansahucolormenu");
      localStorage.removeItem("amansahudarkmenu");
      localStorage.removeItem("amansahugradientmenu");
    }
  });
  $('#background5').on('click', function () {
    if (this.checked) {
      $('body').addClass('color-menu');
      $('body').removeClass('light-menu');
      $('body').removeClass('dark-menu');
      $('body').removeClass('gradient-menu');
      localStorage.setItem("amansahucolormenu", true);
      localStorage.removeItem("amansahulightmenu");
      localStorage.removeItem("amansahudarkmenu");
      localStorage.removeItem("amansahugradientmenu");
    }
  });
  $('#background6').on('click', function () {
    if (this.checked) {
      $('body').addClass('dark-menu');
      $('body').removeClass('light-menu');
      $('body').removeClass('color-menu');
      $('body').removeClass('gradient-menu');
      localStorage.setItem("amansahudarkmenu", true);
      localStorage.removeItem("amansahulightmenu");
      localStorage.removeItem("amansahucolormenu");
      localStorage.removeItem("amansahugradientmenu");
    }
  });
  $('#background10').on('click', function () {
    if (this.checked) {
      $('body').addClass('gradient-menu');
      $('body').removeClass('light-menu');
      $('body').removeClass('color-menu');
      $('body').removeClass('dark-menu');
      localStorage.setItem("amansahugradientmenu", true);
      localStorage.removeItem("amansahulightmenu");
      localStorage.removeItem("amansahucolormenu");
      localStorage.removeItem("amansahudarkmenu");
    }
  }); // width styles

  $('#myonoffswitch18').on('click', function () {
    if (this.checked) {
      $('body').addClass('default');
      $('body').removeClass('boxed');
      localStorage.setItem("amansahudefault", "True");
    } else {
      $('body').removeClass('default');
      localStorage.setItem("amansahudefault", "false");
    }
  });
  $('#myonoffswitch19').on('click', function () {
    if (this.checked) {
      $('body').addClass('boxed');
      $('body').removeClass('default');
      localStorage.setItem("amansahuboxed", "True");
    } else {
      $('body').removeClass('boxed');
      localStorage.setItem("amansahuboxed", "false");
    }
  }); // Theme-layout

  $('#myonoffswitch1').on('click', function () {
    if (this.checked) {
      $('body').addClass('light-mode');
      $('body').removeClass('gradient-hormenu');
      $('body').removeClass('dark-mode');
      $('body').removeClass('transparent-mode');
      $('body').removeClass('color-header');
      $('body').removeClass('dark-header');
      $('body').removeClass('dark-menu');
      $('body').removeClass('gradient-menu');
      $('body').removeClass('gradient-header');
      $('body').removeClass('color-menu');
      localStorage.setItem("amansahulight-mode", "True");
      localStorage.removeItem("amansahubgimage1");
      localStorage.removeItem("amansahubgimage2");
      localStorage.removeItem("amansahubgimage3");
      localStorage.removeItem("amansahubgimage4");
      localStorage.removeItem("amansahudark-mode");
      localStorage.removeItem('amansahucolormenu');
      localStorage.removeItem('amansahudarkmenu');
      localStorage.removeItem('amansahugradientmenu');
      localStorage.removeItem('amansahucolorheader');
      localStorage.removeItem('amansahudarkheader');
      localStorage.removeItem('amansahugradientheader');
      $('#background1').prop('checked', true);
      $('#background3').prop('checked', false);
    } else {
      $('body').removeClass('light-mode');
      localStorage.setItem("amansahulight-mode", "false");
    }
  });
  $('#myonoffswitch2').on('click', function () {
    if (this.checked) {
      $('body').addClass('dark-mode');
      $('body').removeClass('light-mode');
      $('body').removeClass('light-menu');
      $('body').removeClass('color-menu');
      $('body').removeClass('dark-header');
      $('body').removeClass('color-header');
      $('body').removeClass('light-header');
      $('body').removeClass('dark-menu');
      $('body').removeClass('light-hormenu');
      $('body').removeClass('gradient-hormenu');
      $('body').removeClass('gradient-menu');
      localStorage.setItem("amansahudark-mode", "True");
      localStorage.removeItem("amansahubgimage1");
      localStorage.removeItem("amansahubgimage2");
      localStorage.removeItem("amansahubgimage3");
      localStorage.removeItem("amansahubgimage4");
      localStorage.removeItem("amansahulight-mode");
      localStorage.removeItem('amansahulightmenu');
      localStorage.removeItem('amansahucolormenu');
      localStorage.removeItem('amansahugradientmenu');
      localStorage.removeItem('amansahulightheader');
      localStorage.removeItem('amansahucolorheader');
      localStorage.removeItem('amansahugradientheader');
      $('#background3').prop('checked', true);
      $('#background4').prop('checked', false);
      $('#background6').prop('checked', true);
    } else {
      $('body').removeClass('dark-mode');
      localStorage.setItem("amansahudark-mode", "false");
    }
  });
  /*********************Horizontal Versions********************/

  $('#myonoffswitch20').on('click', function () {
    if (this.checked) {
      $("#global-loader").fadeOut("slow");
      $('body').addClass('default-horizontal');
      $('body').removeClass('centerlogo-horizontal');
      localStorage.setItem("amansahudefault-horizontal", "True");
    } else {
      $('body').removeClass('default-horizontal');
      localStorage.setItem("amansahudefault-horizontal", "false");
    }
  });
  $('#myonoffswitch21').on('click', function () {
    if (this.checked) {
      $('body').addClass('centerlogo-horizontal');
      $('body').removeClass('default-horizontal');
      localStorage.setItem("amansahucenterlogo-horizontal", "True");
    } else {
      $('body').removeClass('centerlogo-horizontal');
      localStorage.setItem("amansahucenterlogo-horizontal", "false");
    }
  });
  /*********************Default-menu open********************/

  $('#myonoffswitch22').on('click', function () {
    if (this.checked) {
      $("#global-loader").fadeOut("slow");
      $('body').addClass('default-sidemenu');
      hovermenu();
      $('body').removeClass('sidenav-toggled');
      $('body').removeClass('closed');
      $('body').removeClass('hover-submenu1');
      $('body').removeClass('default-sidebar');
      $('body').removeClass('hover-submenu');
      $('body').removeClass('icon-overlay');
      $('body').removeClass('icon-text');
    } else {
      $('body').removeClass('default-sidemenu');
    }
  });
  /*********************closed-menu open********************/

  $('#myonoffswitch23').on('click', function () {
    if (this.checked) {
      $("#global-loader").fadeOut("slow");
      $('body').addClass('closed');
      $('body').addClass('sidenav-toggled');
      hovermenu();
      $('body').removeClass('default-sidemenu');
      $('body').removeClass('hover-submenu1');
      $('body').removeClass('default-sidebar');
      $('body').removeClass('hover-submenu');
      $('body').removeClass('icon-overlay');
      $('body').removeClass('icon-text');
      localStorage.setItem("amansahuclosed", true);
      localStorage.removeItem("amansahudefaultmenu");
      localStorage.removeItem("amansahuicontextmenu");
      localStorage.removeItem("amansahuhovermenu");
      localStorage.removeItem("amansahusideiconmenu");
      localStorage.removeItem("amansahuhoversubmenu1");
    }
  });
  /*********************hover-menu open********************/

  $('#myonoffswitch24').on('click', function () {
    if (this.checked) {
      $("#global-loader").fadeOut("slow");
      $('body').addClass('hover-submenu');
      hovermenu();
      responsive();
      $('body').addClass('sidenav-toggled');
      $('body').removeClass('default-sidemenu');
      $('body').removeClass('hover-submenu1');
      $('body').removeClass('default-sidebar');
      $('body').removeClass('closed');
      $('body').removeClass('icon-overlay');
      $('body').removeClass('icon-text');
      localStorage.setItem("amansahuhoversubmenu", true);
      localStorage.removeItem("amansahudefaultmenu");
      localStorage.removeItem("amansahuicontextmenu");
      localStorage.removeItem("amansahuclosed");
      localStorage.removeItem("amansahusideiconmenu");
      localStorage.removeItem("amansahuhoversubmenu1");
    }
  });
  /*********************hover-menu-1 open********************/

  $('#myonoffswitch30').on('click', function () {
    if (this.checked) {
      $("#global-loader").fadeOut("slow");
      $('body').addClass('hover-submenu1');
      hovermenu();
      $('body').addClass('sidenav-toggled');
      $('body').removeClass('default-sidemenu');
      $('body').removeClass('hover-submenu');
      $('body').removeClass('default-sidebar');
      $('body').removeClass('closed');
      $('body').removeClass('icon-overlay');
      $('body').removeClass('icon-text');
      localStorage.setItem("amansahuhoversubmenu1", true);
      localStorage.removeItem("amansahudefaultmenu");
      localStorage.removeItem("amansahuicontextmenu");
      localStorage.removeItem("amansahuclosed");
      localStorage.removeItem("amansahusideiconmenu");
      localStorage.removeItem("amansahuhoversubmenu");
    }
  });
  /*********************icon-overlay open********************/

  $('#myonoffswitch25').on('click', function () {
    if (this.checked) {
      $("#global-loader").fadeOut("slow");
      $('body').addClass('icon-overlay');
      hovermenu();
      $('body').addClass('sidenav-toggled');
      $('body').removeClass('default-sidemenu');
      $('body').removeClass('hover-submenu');
      $('body').removeClass('default-sidebar');
      $('body').removeClass('closed');
      $('body').removeClass('hover-submenu1');
      $('body').removeClass('icon-text');
      localStorage.setItem("amansahuiconover", true);
      localStorage.removeItem("amansahudefaultmenu");
      localStorage.removeItem("amansahuicontextmenu");
      localStorage.removeItem("amansahuclosed");
      localStorage.removeItem("amansahuhoversubmenu1");
      localStorage.removeItem("amansahuhoversubmenu");
    }
  });
  /*********************icon-text open********************/

  $('#myonoffswitch29').on('click', function () {
    if (this.checked) {
      $("#global-loader").fadeOut("slow");
      $('body').addClass('icon-text');
      icontext();
      $('body').addClass('sidenav-toggled');
      $('body').removeClass('default-sidemenu');
      $('body').removeClass('hover-submenu');
      $('body').removeClass('default-sidebar');
      $('body').removeClass('closed');
      $('body').removeClass('hover-submenu1');
      $('body').removeClass('icon-overlay');
      localStorage.setItem("amansahuicontextmenu", true);
      localStorage.removeItem("amansahudefaultmenu");
      localStorage.removeItem("amansahuclosedmenu");
      localStorage.removeItem("amansahuhovermenu");
      localStorage.removeItem("amansahusideiconmenu");
      localStorage.removeItem("amansahuhoversubmenu1");
    }
  });
  /*********************vertical-menu********************/

  $('#myonoffswitch34').on('click', function () {
    if (this.checked) {
      ActiveSubmenu();
      $('#myonoffswitch22').prop('checked', true);
      $('body').removeClass('horizontal');
      $('body').removeClass('horizontal-hover');
      $('body').addClass('default-menu');
      $('body').addClass('sidebar-mini');
      $('sidebar-mini').removeClass('hor-content');
      $('sidebar-mini').addClass('main-content"');
      $(".app-sidebar3").removeClass("horizontal-mainwrapper container");
      $(".main-content").removeClass("hor-content");
      $(".main-content").addClass("app-content");
      $(".main-container").removeClass("container");
      $(".main-container").addClass("container-fluid");
      $(".angle").removeClass("horizontal-icon");
      $(".main-menu").removeClass("horizontalMenu");
      $(".main-container").addClass("side-app");
      $(".header").removeClass("hor-header");
      $(".header").addClass("app-header");
      $(".app-sidebar").removeClass("horizontal-main");
      $(".main-sidemenu").removeClass("container");
      $(".app-sidebar").removeClass("hor-menu ");
      $('#slide-left').removeClass('d-none');
      $('#slide-right').removeClass('d-none');
      localStorage.setItem("amansahusidebar-mini", "True");
      localStorage.removeItem("amansahuhorizontal", "False");
      menuClick();
      responsive();
    } else {
      $('body').removeClass('sidebar-mini');
      localStorage.setItem("amansahusidebar-mini", "False");
    }
  });
  /*********************horizontal ********************/

  $('#myonoffswitch35').on('click', function () {
    if (this.checked) {
      ActiveSubmenu();
      $(".app-sidebar").off("click");
      $('body').addClass('horizontal');
      $(".main-content").addClass("hor-content");
      $(".main-content").removeClass("app-content");
      $(".main-container").addClass("container");
      $(".main-container").removeClass("container-fluid");
      $(".app-sidebar3").addClass("horizontal-mainwrapper container");
      $(".angle").addClass("horizontal-icon");
      $(".main-menu").addClass("horizontalMenu");
      $(".main-container").removeClass("side-app");
      $(".app-header").addClass("hor-header");
      $(".hor-header").removeClass("app-header");
      $(".app-sidebar").addClass("horizontal-main");
      $(".app-sidebar").addClass("hor-menu ");
      $(".main-sidemenu").addClass("container");
      $('body').removeClass('sidebar-mini');
      $('body').removeClass('sidenav-toggled');
      $('body').removeClass('sidenav-toggled1');
      $('body').removeClass('horizontal-hover');
      $('body').removeClass('default-menu');
      $('body').removeClass('icon-text');
      $('body').removeClass('icon-overlay');
      $('body').removeClass('closed');
      $('body').removeClass('hover-submenu');
      $('body').removeClass('hover-submenu1');
      localStorage.setItem("amansahuhorizontal", "true");
      localStorage.removeItem("amansahusidebarMini");
      localStorage.removeItem("amansahuhorizontalHover");
      $('#slide-left').removeClass('d-none');
      $('#slide-right').removeClass('d-none');

      if (document.querySelector('.horizontal').classList.contains('login-img') !== true) {
        var _document$querySelect;

        (_document$querySelect = document.querySelector('.horizontal .side-menu')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.classList.add('flex-nowrap');
      }

      menuClick();
      checkHoriMenu();
      responsive();
      var li = document.querySelectorAll('.side-menu li');
      li.forEach(function (e, i) {
        e.classList.remove('is-expanded');
      });
      var animationSpeed = 300; // first level

      var parent = $("[data-bs-toggle='sub-slide']").parents('ul');
      var ul = parent.find('ul:visible').slideUp(animationSpeed);
      ul.removeClass('open');
      var parent1 = $("[data-bs-toggle='sub-slide2']").parents('ul');
      var ul1 = parent1.find('ul:visible').slideUp(animationSpeed);
      ul1.removeClass('open');
      var sub = $(".sub-slide-menu.open");
      sub.slideUp(animationSpeed);
      sub.removeClass('open');
      var sub2 = $(".sub-slide-menu2.open");
      sub2.slideUp(animationSpeed);
      sub2.removeClass('open');
    } else {
      $('body').removeClass('horizontal');
      localStorage.setItem("amansahuhorizontal", "False");
    }
  });

  if (document.querySelector('body.main-content')) {
    document.body.classList.remove('hover-submenu');
    document.body.classList.remove('hover-submenu1');
    document.body.classList.remove('icon-text');
    document.body.classList.remove('icon-overlay');
    document.body.classList.remove('closed');
    document.body.classList.remove('default-sidemenu');
    document.body.classList.remove('sidenav-toggled');
    document.body.classList.remove('sidenav-toggled1');
    document.body.classList.remove('horizontal');
    document.body.classList.remove('horizontal-hover');
  }

  var bodyhorizontal = $('body').hasClass('horizontal');

  if (bodyhorizontal) {
    $('body').addClass('horizontal');
    $(".main-content").addClass("hor-content");
    $(".main-content").removeClass("app-content");
    $(".main-container").addClass("container");
    $(".main-container").removeClass("container-fluid");
    $(".app-sidebar3").addClass("horizontal-mainwrapper container");
    $(".angle").addClass("horizontal-icon");
    $(".main-menu").addClass("horizontalMenu");
    $(".main-container").removeClass("side-app");
    $(".app-header").addClass("hor-header");
    $(".hor-header").removeClass("app-header");
    $(".app-sidebar").addClass("horizontal-main");
    $(".app-sidebar").addClass("hor-menu ");
    $(".main-sidemenu").addClass("container");
    $('body').removeClass('sidebar-mini');
    $('body').removeClass('sidenav-toggled');
    $('body').removeClass('horizontal-hover');
    $('body').removeClass('default-menu');
    $('body').removeClass('icon-text');
    $('body').removeClass('icon-overlay');
    $('body').removeClass('closed');
    $('body').removeClass('hover-submenu');
    $('body').removeClass('hover-submenu1');
    localStorage.setItem("amansahuhorizontal", "true");
    localStorage.removeItem("amansahusidebarMini");
    localStorage.removeItem("amansahuhorizontalHover");
    $('#slide-left').removeClass('d-none');
    $('#slide-right').removeClass('d-none');

    if (!document.querySelector('body').classList.contains('login-img') && !$('body').hasClass('main-content')) {
      var _document$querySelect2;

      (_document$querySelect2 = document.querySelector('.horizontal .side-menu')) === null || _document$querySelect2 === void 0 ? void 0 : _document$querySelect2.classList.add('flex-nowrap');
      responsive();
    }

    var li = document.querySelectorAll('.side-menu li');
    li.forEach(function (e, i) {
      e.classList.remove('is-expanded');
    });
    var animationSpeed = 300; // first level

    var parent = $("[data-bs-toggle='sub-slide']").parents('ul');
    var ul = parent.find('ul:visible').slideUp(animationSpeed);
    ul.removeClass('open');
    var parent1 = $("[data-bs-toggle='sub-slide2']").parents('ul');
    var ul1 = parent1.find('ul:visible').slideUp(animationSpeed);
    ul1.removeClass('open');
    var sub = $(".sub-slide-menu.open");
    sub.slideUp(animationSpeed);
    sub.removeClass('open');
    var sub2 = $(".sub-slide-menu2.open");
    sub2.slideUp(animationSpeed);
    sub2.removeClass('open');
  } else {}

  var darkMode = $('body').hasClass('dark-mode');

  if (darkMode) {
    $('body').addClass('dark-mode');
    $('#myonoffswitch2').prop('checked', true);

    if (!localStorage.getItem('amansahucolorheader') && !localStorage.getItem('amansahugradientheader') && !localStorage.getItem('amansahulightheader')) {
      $('#background3').prop('checked', true);
    }

    if (!localStorage.getItem('amansahucolormenu 	') && !localStorage.getItem('amansahugradientmenu') && !localStorage.getItem('amansahulightmenu')) {
      $('#background6').prop('checked', true);
    }
  }
  /********************* Horizontal Hover Menu ********************/


  $('#myonoffswitch111').on('click', function () {
    if (this.checked) {
      var _li = document.querySelectorAll('.side-menu li');

      _li.forEach(function (e, i) {
        e.classList.remove('is-expanded');
      });

      var animationSpeed = 300; // first level

      var parent = $("[data-bs-toggle='sub-slide']").parents('ul');
      var ul = parent.find('ul:visible').slideUp(animationSpeed);
      ul.removeClass('open');
      var parent1 = $("[data-bs-toggle='sub-slide2']").parents('ul');
      var ul1 = parent1.find('ul:visible').slideUp(animationSpeed);
      ul1.removeClass('open');
      setTimeout(function () {
        var sub = $(".sub-slide-menu.open");
        sub.slideUp(animationSpeed);
        sub.removeClass('open');
        var sub2 = $(".sub-slide-menu2.open");
        sub2.slideUp(animationSpeed);
        sub2.removeClass('open');
      }, 500);
      $('body').addClass('horizontal-hover');
      $('body').addClass('horizontal');
      $(".main-content").addClass("hor-content");
      $(".main-content").removeClass("app-content");
      $(".main-container").addClass("container");
      $(".main-container").removeClass("container-fluid");
      $(".app-sidebar3").addClass("horizontal-mainwrapper container");
      $(".angle").addClass("horizontal-icon");
      $(".main-menu").addClass("horizontalMenu");
      $(".main-container").removeClass("side-app");
      $(".app-header").addClass("hor-header");
      $(".hor-header").removeClass("app-header");
      $(".app-sidebar").addClass("horizontal-main");
      $(".app-sidebar").addClass("hor-menu ");
      $(".main-sidemenu").addClass("container");
      $('body').removeClass('sidebar-mini');
      $('body').removeClass('sidenav-toggled');
      $('body').removeClass('default-menu');
      $('body').removeClass('icon-text');
      $('body').removeClass('icon-overlay');
      $('body').removeClass('closed');
      $('body').removeClass('hover-submenu');
      $('body').removeClass('hover-submenu1');
      localStorage.removeItem("amansahuhorizontal");
      localStorage.removeItem("amansahusidebarMini");
      localStorage.setItem("amansahuhorizontalHover", "true");
      $('#slide-left').removeClass('d-none');
      $('#slide-right').removeClass('d-none');

      if (document.querySelector('.horizontal-hover').classList.contains('login-img') !== true || !$('body').hasClass('main-content')) {
        document.querySelector('.horizontal-hover .side-menu').style.flexWrap = 'nowrap';
        ActiveSubmenu();
        HorizontalHovermenu();
        checkHoriMenu();
        responsive();
      }
    } else {
      $('body').removeClass('horizontal-hover');
      localStorage.setItem("amansahuhorizontal-hover", "False");
    }
  }); // $('body').addClass('horizontal-hover');

  var bodyhorizontalHover = $('body').hasClass('horizontal-hover');

  if (bodyhorizontalHover) {
    $('body').addClass('horizontal-hover');
    $('body').addClass('horizontal');
    $(".main-content").addClass("hor-content");
    $(".main-content").removeClass("app-content");
    $(".main-container").addClass("container");
    $(".main-container").removeClass("container-fluid");
    $(".app-sidebar3").addClass("horizontal-mainwrapper container");
    $(".angle").addClass("horizontal-icon");
    $(".main-menu").addClass("horizontalMenu");
    $(".main-container").removeClass("side-app");
    $(".app-header").addClass("hor-header");
    $(".hor-header").removeClass("app-header");
    $(".app-sidebar").addClass("horizontal-main");
    $(".app-sidebar").addClass("hor-menu ");
    $(".main-sidemenu").addClass("container");
    $('body').removeClass('sidebar-mini');
    $('body').removeClass('sidenav-toggled');
    $('body').removeClass('default-menu');
    $('body').removeClass('icon-text');
    $('body').removeClass('icon-overlay');
    $('body').removeClass('closed');
    $('body').removeClass('hover-submenu');
    $('body').removeClass('hover-submenu1');
    localStorage.removeItem("amansahuhorizontal");
    localStorage.removeItem("amansahusidebarMini");
    localStorage.setItem("amansahuhorizontalHover", "true");
    $('#slide-left').removeClass('d-none');
    $('#slide-right').removeClass('d-none'); // $('#slide-left').addClass('d-none');
    // $('#slide-right').addClass('d-none');

    $('#slide-left').removeClass('d-none');
    $('#slide-right').removeClass('d-none');

    if (!document.querySelector('body').classList.contains('login-img') && !$('body').hasClass('main-content')) {
      document.querySelector('.horizontal-hover .side-menu').style.flexWrap = 'nowrap';
      ActiveSubmenu();
      HorizontalHovermenu();
      checkHoriMenu();
      responsive();
    }
  }

  if (!document.querySelector('body').classList.contains('login-img') && !document.body.classList.contains('main-content')) {
    /***************** CLOSEDMENU HAs Class *********************/
    var bodyclosed = $('body').hasClass('closed');

    if (bodyclosed) {
      $('body').addClass('closed');
      $('body').removeClass('icon-overlay');
      hovermenu();
      $('body').addClass('sidenav-toggled');
    }
    /***************** CLOSEDMENU HAs Class *********************/

    /***************** ICONTEXT MENU HAs Class *********************/


    var bodyicontext = $('body').hasClass('icon-text');

    if (bodyicontext) {
      $('body').addClass('icon-text');
      $('body').removeClass('icon-overlay');
      $('body').addClass('sidenav-toggled');
      $('myonoffswitch29').prop('checked', true);
      icontext();
    }
    /***************** ICONTEXT MENU HAs Class *********************/

    /***************** HOVER-SUBMENU HAs Class *********************/


    var bodyhover = $('body').hasClass('hover-submenu');

    if (bodyhover) {
      $('body').addClass('hover-submenu');
      $('body').removeClass('icon-overlay');
      hovermenu();
      $('body').addClass('sidenav-toggled');
    }
    /***************** HOVER-SUBMENU HAs Class *********************/

    /***************** HOVER-SUBMENU HAs Class *********************/


    var bodyhover1 = $('body').hasClass('hover-submenu1');

    if (bodyhover1) {
      $('body').addClass('hover-submenu1');
      $('body').removeClass('icon-overlay');
      $('body').addClass('sidenav-toggled');
      hovermenu();
    }
    /***************** HOVER-SUBMENU HAs Class *********************/

  }
})(jQuery); // Success Notification


$('body').on('click', '.projectnotify', function (e) {
  e.preventDefault();
  notif({
    msg: "<b><i class='fa fa-check fs-20 me-2'></i></b> Well done Details Submitted Successfully",
    type: "success"
  });
}); // ______________ SWITCHER-toggle ______________//

$('.layout-setting').on("click", function (e) {
  if (!document.querySelector('body').classList.contains('dark-mode')) {
    $('body').addClass('dark-mode');
    $('body').removeClass('light-mode');
    $('body').removeClass('transparent-mode');
    $('#background4').prop('checked', false);
    localStorage.setItem('amansahudarkMode', true);
    localStorage.removeItem('amansahulightMode');
    localStorage.removeItem('amansahutransparentMode');
    $('#myonoffswitch2').prop('checked', true);
    $('#background3').prop('checked', true);
    $('#background6').prop('checked', true);
  } else {
    $('body').removeClass('dark-mode');
    $('body').addClass('light-mode');
    localStorage.setItem('amansahulightMode', true);
    localStorage.removeItem('amansahutransparentMode');
    localStorage.removeItem('amansahudarkMode');
    $('#myonoffswitch1').prop('checked', true);
    $('#background1').prop('checked', true);
  }
});
$(document).ready(function () {
  $("#Password-toggle a").on('click', function (event) {
    event.preventDefault();

    if ($('#Password-toggle input').attr("type") == "text") {
      $('#Password-toggle input').attr('type', 'password');
      $('#Password-toggle i').addClass("fe-eye-off");
      $('#Password-toggle i').removeClass("fe-eye");
    } else if ($('#Password-toggle input').attr("type") == "password") {
      $('#Password-toggle input').attr('type', 'text');
      $('#Password-toggle i').removeClass("fe-eye-off");
      $('#Password-toggle i').addClass("fe-eye");
    }
  });
  $("#Password-toggle1 a").on('click', function (event) {
    event.preventDefault();

    if ($('#Password-toggle1 input').attr("type") == "text") {
      $('#Password-toggle1 input').attr('type', 'password');
      $('#Password-toggle1 i').addClass("fe-eye-off");
      $('#Password-toggle1 i').removeClass("fe-eye");
    } else if ($('#Password-toggle1 input').attr("type") == "password") {
      $('#Password-toggle1 input').attr('type', 'text');
      $('#Password-toggle1 i').removeClass("fe-eye-off");
      $('#Password-toggle1 i').addClass("fe-eye");
    }
  });
  $("#Password-toggle2 a").on('click', function (event) {
    event.preventDefault();

    if ($('#Password-toggle2 input').attr("type") == "text") {
      $('#Password-toggle2 input').attr('type', 'password');
      $('#Password-toggle2 i').addClass("fe-eye-off");
      $('#Password-toggle2 i').removeClass("fe-eye");
    } else if ($('#Password-toggle2 input').attr("type") == "password") {
      $('#Password-toggle2 input').attr('type', 'text');
      $('#Password-toggle2 i').removeClass("fe-eye-off");
      $('#Password-toggle2 i').addClass("fe-eye");
    }
  });
}); // $('body').addClass('horizontal');
// Transparent Layout Start

$(document).on("click", '#myonoffswitchTransparent', function () {
  if (this.checked) {
    var _document$querySelect3, _document$querySelect4, _document$querySelect5, _document$querySelect6, _document$querySelect7, _document$querySelect8, _document$querySelect9, _document$querySelect10;

    $('body').addClass('transparent-mode');
    $('#myonoffswitch3').prop('checked', false);
    $('#myonoffswitch6').prop('checked', false);
    $('#myonoffswitch5').prop('checked', false);
    $('#myonoffswitch8').prop('checked', false);
    $('body').removeClass('dark-mode');
    $('body').removeClass('light-mode');
    $('body').removeClass('light-menu'); // remove light theme properties

    localStorage.removeItem('amansahuprimaryColor');
    localStorage.removeItem('amansahuprimaryHoverColor');
    localStorage.removeItem('amansahuprimaryBorderColor'); // reseting the menu and header switcher

    (_document$querySelect3 = document.querySelector('.lightMenu')) === null || _document$querySelect3 === void 0 ? void 0 : _document$querySelect3.classList.remove('d-none');
    (_document$querySelect4 = document.querySelector('.lightMenu')) === null || _document$querySelect4 === void 0 ? void 0 : _document$querySelect4.classList.add('d-flex');
    (_document$querySelect5 = document.querySelector('.lightHeader')) === null || _document$querySelect5 === void 0 ? void 0 : _document$querySelect5.classList.remove('d-none');
    (_document$querySelect6 = document.querySelector('.lightHeader')) === null || _document$querySelect6 === void 0 ? void 0 : _document$querySelect6.classList.add('d-flex');
    (_document$querySelect7 = document.querySelector('.darkMenu')) === null || _document$querySelect7 === void 0 ? void 0 : _document$querySelect7.classList.remove('d-none');
    (_document$querySelect8 = document.querySelector('.darkMenu')) === null || _document$querySelect8 === void 0 ? void 0 : _document$querySelect8.classList.add('d-flex');
    (_document$querySelect9 = document.querySelector('.darkHeader')) === null || _document$querySelect9 === void 0 ? void 0 : _document$querySelect9.classList.remove('d-none');
    (_document$querySelect10 = document.querySelector('.darkHeader')) === null || _document$querySelect10 === void 0 ? void 0 : _document$querySelect10.classList.add('d-flex'); // removing light theme data

    localStorage.removeItem('amansahudarkPrimary');
    localStorage.removeItem('amansahuprimaryColor');
    localStorage.removeItem('amansahuprimaryHoverColor');
    localStorage.removeItem('amansahuprimaryBorderColor');
    localStorage.removeItem('amansahuprimaryTransparent');
    localStorage.removeItem('amansahutransparentPrimary');
    localStorage.removeItem('amansahudarkprimaryTransparent');
    localStorage.removeItem('amansahutransparentBgImgPrimary');
    localStorage.removeItem('amansahutransparentBgImgprimaryTransparent');
    localStorage.removeItem('amansahulightmenu');
    localStorage.removeItem('amansahucolormenu');
    localStorage.removeItem('amansahudarkmenu');
    localStorage.removeItem('amansahugradientmenu');
    localStorage.removeItem('amansahulightheader');
    localStorage.removeItem('amansahucolorheader');
    localStorage.removeItem('amansahudarkheader');
    localStorage.removeItem('amansahugradientheader');
    $('#myonoffswitch2').prop('checked', false);
    $('#myonoffswitch1').prop('checked', false);
    $('#myonoffswitchTransparent').prop('checked', true); //

    (0,_themeColors__WEBPACK_IMPORTED_MODULE_0__.checkOptions)(); // removeForTransparent();

    var root = document.querySelector(':root');
    root.style = "";
    (0,_themeColors__WEBPACK_IMPORTED_MODULE_0__.names)();
  } else {
    $('body').removeClass('transparent-mode');
    localStorage.removeItem("amansahutransparent-mode");
  }

  $('body').removeClass('bg-img1');
  $('body').removeClass('bg-img2');
  $('body').removeClass('bg-img3');
  $('body').removeClass('bg-img4');
}); // Transparent Bg-Image Style Start

$(document).on("click", '#bgimage1', function () {
  var _document$querySelect11, _document$querySelect12;

  $('body').addClass('bg-img1');
  $('body').removeClass('bg-img2');
  $('body').removeClass('bg-img3');
  $('body').removeClass('bg-img4');
  $('body').removeClass('light-menu');
  $('body').removeClass('color-menu');
  $('body').removeClass('gradient-menu');
  $('body').removeClass('dark-menu');
  $('body').removeClass('dark-header');
  $('body').removeClass('color-header');
  $('body').removeClass('light-header');
  $('body').removeClass('gradient-header');
  localStorage.setItem("amansahubgimage1", "True");
  localStorage.setItem("transparent-mode", "True");
  localStorage.removeItem("amansahubgimage2");
  localStorage.removeItem("amansahubgimage3");
  localStorage.removeItem("amansahubgimage4");
  localStorage.removeItem("amansahudark-mode");
  localStorage.removeItem("amansahudarkMode");
  localStorage.removeItem("amansahulight-mode");
  localStorage.removeItem("amansahulightMode");
  localStorage.removeItem('amansahulightmenu');
  localStorage.removeItem('amansahucolormenu');
  localStorage.removeItem('amansahudarkmenu');
  localStorage.removeItem('amansahugradientmenu');
  localStorage.removeItem('amansahulightheader');
  localStorage.removeItem('amansahucolorheader');
  localStorage.removeItem('amansahudarkheader');
  localStorage.removeItem('amansahugradientheader');
  document.querySelector('body').classList.add('transparent-mode');
  (_document$querySelect11 = document.querySelector('body')) === null || _document$querySelect11 === void 0 ? void 0 : _document$querySelect11.classList.remove('light-mode');
  (_document$querySelect12 = document.querySelector('body')) === null || _document$querySelect12 === void 0 ? void 0 : _document$querySelect12.classList.remove('dark-mode');
  $('#myonoffswitch2').prop('checked', false);
  $('#myonoffswitch1').prop('checked', false);
  $('#myonoffswitchTransparent').prop('checked', true);
  (0,_themeColors__WEBPACK_IMPORTED_MODULE_0__.checkOptions)(); // removeForTransparent();
});
$(document).on("click", '#bgimage2', function () {
  var _document$querySelect13, _document$querySelect14;

  $('body').addClass('bg-img2');
  $('body').removeClass('bg-img1');
  $('body').removeClass('bg-img3');
  $('body').removeClass('bg-img4');
  $('body').removeClass('light-menu');
  $('body').removeClass('color-menu');
  $('body').removeClass('gradient-menu');
  $('body').removeClass('dark-menu');
  $('body').removeClass('dark-header');
  $('body').removeClass('color-header');
  $('body').removeClass('light-header');
  $('body').removeClass('gradient-header');
  localStorage.setItem("amansahubgimage2", "True");
  localStorage.setItem("transparent-mode", "True");
  localStorage.removeItem("amansahubgimage1");
  localStorage.removeItem("amansahubgimage3");
  localStorage.removeItem("amansahubgimage4");
  localStorage.removeItem("amansahudark-mode");
  localStorage.removeItem("amansahudarkMode");
  localStorage.removeItem("amansahulight-mode");
  localStorage.removeItem("amansahulightMode");
  localStorage.removeItem('amansahulightmenu');
  localStorage.removeItem('amansahucolormenu');
  localStorage.removeItem('amansahudarkmenu');
  localStorage.removeItem('amansahugradientmenu');
  localStorage.removeItem('amansahulightheader');
  localStorage.removeItem('amansahucolorheader');
  localStorage.removeItem('amansahudarkheader');
  localStorage.removeItem('amansahugradientheader');
  document.querySelector('body').classList.add('transparent-mode');
  (_document$querySelect13 = document.querySelector('body')) === null || _document$querySelect13 === void 0 ? void 0 : _document$querySelect13.classList.remove('light-mode');
  (_document$querySelect14 = document.querySelector('body')) === null || _document$querySelect14 === void 0 ? void 0 : _document$querySelect14.classList.remove('dark-mode');
  $('#myonoffswitch2').prop('checked', false);
  $('#myonoffswitch1').prop('checked', false);
  $('#myonoffswitchTransparent').prop('checked', true);
  (0,_themeColors__WEBPACK_IMPORTED_MODULE_0__.checkOptions)(); // removeForTransparent();
});
$(document).on("click", '#bgimage3', function () {
  var _document$querySelect15, _document$querySelect16;

  $('body').addClass('bg-img3');
  $('body').removeClass('bg-img1');
  $('body').removeClass('bg-img2');
  $('body').removeClass('bg-img4');
  $('body').removeClass('light-menu');
  $('body').removeClass('color-menu');
  $('body').removeClass('gradient-menu');
  $('body').removeClass('dark-menu');
  $('body').removeClass('dark-header');
  $('body').removeClass('color-header');
  $('body').removeClass('light-header');
  $('body').removeClass('gradient-header');
  localStorage.setItem("amansahubgimage3", "True");
  localStorage.setItem("transparent-mode", "True");
  localStorage.removeItem("amansahubgimage1");
  localStorage.removeItem("amansahubgimage2");
  localStorage.removeItem("amansahubgimage4");
  localStorage.removeItem("amansahudark-mode");
  localStorage.removeItem("amansahudarkMode");
  localStorage.removeItem("amansahulight-mode");
  localStorage.removeItem("amansahulightMode");
  localStorage.removeItem('amansahulightmenu');
  localStorage.removeItem('amansahucolormenu');
  localStorage.removeItem('amansahudarkmenu');
  localStorage.removeItem('amansahugradientmenu');
  localStorage.removeItem('amansahulightheader');
  localStorage.removeItem('amansahucolorheader');
  localStorage.removeItem('amansahudarkheader');
  localStorage.removeItem('amansahugradientheader');
  document.querySelector('body').classList.add('transparent-mode');
  (_document$querySelect15 = document.querySelector('body')) === null || _document$querySelect15 === void 0 ? void 0 : _document$querySelect15.classList.remove('light-mode');
  (_document$querySelect16 = document.querySelector('body')) === null || _document$querySelect16 === void 0 ? void 0 : _document$querySelect16.classList.remove('dark-mode');
  $('#myonoffswitch2').prop('checked', false);
  $('#myonoffswitch1').prop('checked', false);
  $('#myonoffswitchTransparent').prop('checked', true);
  (0,_themeColors__WEBPACK_IMPORTED_MODULE_0__.checkOptions)(); // removeForTransparent();
});
$(document).on("click", '#bgimage4', function () {
  var _document$querySelect17, _document$querySelect18;

  $('body').addClass('bg-img4');
  $('body').removeClass('bg-img1');
  $('body').removeClass('bg-img2');
  $('body').removeClass('bg-img3');
  $('body').removeClass('light-menu');
  $('body').removeClass('color-menu');
  $('body').removeClass('gradient-menu');
  $('body').removeClass('dark-menu');
  $('body').removeClass('dark-header');
  $('body').removeClass('color-header');
  $('body').removeClass('light-header');
  $('body').removeClass('gradient-header');
  localStorage.setItem("amansahubgimage4", "True");
  localStorage.setItem("transparent-mode", "True");
  localStorage.removeItem("amansahubgimage1");
  localStorage.removeItem("amansahubgimage2");
  localStorage.removeItem("amansahubgimage3");
  localStorage.removeItem("amansahudark-mode");
  localStorage.removeItem("amansahudarkMode");
  localStorage.removeItem("amansahulight-mode");
  localStorage.removeItem("amansahulightMode");
  localStorage.removeItem('amansahulightmenu');
  localStorage.removeItem('amansahucolormenu');
  localStorage.removeItem('amansahudarkmenu');
  localStorage.removeItem('amansahugradientmenu');
  localStorage.removeItem('amansahulightheader');
  localStorage.removeItem('amansahucolorheader');
  localStorage.removeItem('amansahudarkheader');
  localStorage.removeItem('amansahugradientheader');
  document.querySelector('body').classList.add('transparent-mode');
  (_document$querySelect17 = document.querySelector('body')) === null || _document$querySelect17 === void 0 ? void 0 : _document$querySelect17.classList.remove('light-mode');
  (_document$querySelect18 = document.querySelector('body')) === null || _document$querySelect18 === void 0 ? void 0 : _document$querySelect18.classList.remove('dark-mode');
  $('#myonoffswitch2').prop('checked', false);
  $('#myonoffswitch1').prop('checked', false);
  $('#myonoffswitchTransparent').prop('checked', true);
  (0,_themeColors__WEBPACK_IMPORTED_MODULE_0__.checkOptions)(); // removeForTransparent();
}); // Transparent Bg-Image Style End
})();

/******/ })()
;
