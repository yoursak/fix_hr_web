'use strict';
$(document).ready(function() {
    setTimeout(function() {
        floatchart()
    }, 700);
});

function floatchart() {

    // [ revenue-status-d-graph ] start
    $(function() {
        var options = {
            chart: {
                type: 'bar',
                height: 30,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#4886ff"],
            plotOptions: {
                bar: {
                    columnWidth: '60%'
                }
            },
            series: [{
                data: [9, 5, 7, 8, 3, 2, 1]
            }],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Amount Spent :'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        var chart = new ApexCharts(document.querySelector("#revenue-status-d-graph"), options);
        chart.render();
    });
    // [ revenue-status-d-graph ] end
    // [ revenue-status-w-graph ] start
    $(function() {
        var options = {
            chart: {
                type: 'bar',
                height: 30,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#ff484c"],
            plotOptions: {
                bar: {
                    columnWidth: '60%'
                }
            },
            series: [{
                data: [2, 9, 7, 4, 3, 8, 1]
            }],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Amount Spent :'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        var chart = new ApexCharts(document.querySelector("#revenue-status-w-graph"), options);
        chart.render();
    });
    // [ revenue-status-w-graph ] end
    // [ new-user-daily ] start
    $(function() {
        var options = {
            chart: {
                type: 'bar',
                height: 90,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#7ad835', '#7ad835', '#7ad835', '#7ad835', '#7ad835', '#CCCCCC', '#CCCCCC'],
            plotOptions: {
                bar: {
                    columnWidth: '60%',
                    distributed: true
                }
            },
            series: [{
                data: [9, 5, 7, 8, 3, 2, 1]
            }],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Amount Spent :'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        var chart = new ApexCharts(document.querySelector("#new-user-daily"), options);
        chart.render();
    });
    // [ new-user-daily ] end
    // [ page-views-today ] start
    $(function() {
        var options = {
            chart: {
                type: 'bar',
                height: 90,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#fa7d03', '#fa7d03', '#fa7d03', '#fa7d03', '#fa7d03', '#CCCCCC', '#CCCCCC'],
            plotOptions: {
                bar: {
                    columnWidth: '60%',
                    distributed: true
                }
            },
            series: [{
                data: [5, 2, 7, 4, 3, 2, 6]
            }],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Amount Spent :'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        var chart = new ApexCharts(document.querySelector("#page-views-today"), options);
        chart.render();
    });
    // [ page-views-today ] end

    // [ tax-deduction-graph ] start
    $(function() {
        var options = {
            chart: {
                type: 'bar',
                height: 150,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#4886ff"],
            plotOptions: {
                bar: {
                    columnWidth: '25%'
                }
            },
            series: [{
                data: [150, 335, 240, 200, 275, 205, 170, 150]
            }],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Amount Spent :'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        var chart = new ApexCharts(document.querySelector("#tax-deduction-graph"), options);
        chart.render();
    });
    // [ tax-deduction-graph ] end
    // [ order-graph ] start
    $(function() {
        var options = {
            chart: {
                height: 150,
                type: 'pie',
            },
            dataLabels: {
                enabled: false
            },
            series: [85.7, 47.56],
            colors: ["#d8d8d8", "#ff484c"],
            labels: ["Order", "New Order"],
            legend: {
                show: false,
            }
        }
        var chart = new ApexCharts(document.querySelector("#order-graph"), options);
        chart.render();
    });
    // [ order-graph ] end
    // [ revenue-generate-graph ] start
    $(function() {
        var options = {
            chart: {
                type: 'bar',
                height: 150,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#fa7d03"],
            plotOptions: {
                bar: {
                    columnWidth: '25%'
                }
            },
            series: [{
                data: [150, 335, 240, 200, 275, 205, 170, 150]
            }],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Amount Spent :'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        }
        var chart = new ApexCharts(document.querySelector("#revenue-generate-graph"), options);
        chart.render();
    });
    // [ revenue-generate-graph ] end

    // [ Servey-chart ] start
    $(function() {
        var colors = ['#cccccc', '#cccccc', '#cccccc', '#cccccc', '#cccccc', '#7ad835', '#7ad835'];
        var options = {
            chart: {
                height: 210,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                    endingShape: 'rounded'
                }
            },
            grid: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },
            series: [{
                data: [21, 22, 10, 16, 21, 13, 28]
            }],
            xaxis: {
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '14px'
                    }
                },
                axisBorder: {
                    show: false,
                },
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#Servey-chart"),
            options
        );
        chart.render();
        function generateDayWiseTimeSeries(baseval, count, yrange) {
            var i = 0;
            var series = [];
            while (i < count) {
                var x = baseval;
                var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

                series.push([x, y]);
                baseval += 86400000;
                i++;
            }
            return series;
        }
    });
    // [ Servey-chart ] end
    // [ solid-gauge1 ] start
    $(function() {
        var options = {
            chart: {
                height: 300,
                type: 'radialBar',
                offsetY: -10,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                colors: ['#7ad835'],
                opacity: 1,
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    hollow: {
                        margin: 0,
                        size: "80%",
                    },
                    dataLabels: {
                        name: {
                            fontSize: '0',
                        },
                        value: {
                            fontSize: '0',
                        }
                    }
                }
            },
            series: [67],
        }
        var chart = new ApexCharts(
            document.querySelector("#solid-gauge1"),
            options
        );
        chart.render();
    });
    // [ solid-gauge1 ] end

    // [ fees-collection ] start
    $(function() {
        var colors = ['#4886ff', '#ff484c', '#fa7d03'];
        var options = {
            chart: {
                height: 200,
                type: 'bar',
                toolbar: {
                    show: false
                },
                events: {
                    click: function(chart, w, e) {
                        console.log(chart, w, e)
                    }
                },
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true
                }
            },
            dataLabels: {
                enabled: false,
            },
            series: [{
                data: [4025, 2582, 1086]
            }],
            xaxis: {
                categories: ['Collection', 'Fees', 'Jake'],
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '14px'
                    }
                }
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#fees-collection"),
            options
        );
        chart.render();
    });
    // [ fees-collection ] end
    // [ website-traffic ] start
    $(function() {
        var colors = ['#4886ff', '#ff484c', '#fa7d03'];
        var options = {
            chart: {
                height: 150,
                type: 'bar',
                sparkline: {
                    enabled: true
                },
                toolbar: {
                    show: false
                },
                events: {
                    click: function(chart, w, e) {
                        console.log(chart, w, e)
                    }
                },
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true
                }
            },
            dataLabels: {
                enabled: false,
            },
            series: [{
                data: [1086, 2582, 4025]
            }],
            xaxis: {
                categories: ['Collection', 'Fees', 'Jake'],
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '14px'
                    }
                }
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#website-traffic"),
            options
        );
        chart.render();
    });
    // [ website-traffic ] end

    // ===================================================================
    // ===================================================================
    // ===================================================================

    // [ power-card-chart1 ] start
    $(function() {
        var options = {
            chart: {
                type: 'line',
                height: 75,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#ff484c"],
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'series1',
                data: [55, 35, 75, 50, 90, 50]
            }],
            yaxis: {
                min: 10,
                max: 100,
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false,
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Power'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#power-card-chart1"), options);
        chart.render();
    });
    // [ power-card-chart1 ] end
    // [ power-card-chart2 ] start
    $(function() {
        var options = {
            chart: {
                type: 'line',
                height: 75,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#4886ff"],
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'series1',
                data: [50, 90, 50, 75, 55, 80]
            }],
            yaxis: {
                min: 10,
                max: 100,
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false,
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Water'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#power-card-chart2"), options);
        chart.render();
    });
    // [ power-card-chart2 ] end
    // [ power-card-chart3 ] start
    $(function() {
        var options = {
            chart: {
                type: 'line',
                height: 75,
                sparkline: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#7ad835"],
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'series1',
                data: [55, 35, 75, 50, 90, 50]
            }],
            yaxis: {
                min: 10,
                max: 100,
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false,
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return 'Temperature'
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#power-card-chart3"), options);
        chart.render();
    });
    // [ power-card-chart3 ] end
}
