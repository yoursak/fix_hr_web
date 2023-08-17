/*
Template Name: Admin Mintone
Author: SRGIT
File: js
*/

// ==============================================================
// r the chart
// ==============================================================

$(function() {
    "use strict";
    Morris.Area.prototype.fillForSeries = function(i) {
        var color;
        return "0-#e2ecff:10-#6D9EFF:80";
    };

    var profileBar = Morris.Area({
        element: 'extra-area-chart-last-week',
        data: [{
            time: '5 Sec',
            percent: 0
        }, {
            time: '10 Sec',
            percent: 50
        }, {
            time: '15 Sec',
            percent: 20
        }, {
            time: '20 Sec',
            percent: 60
        }, {
            time: '25 Sec',
            percent: 30
        }, {
            time: '30 Sec',
            percent: 25
        }, {
            time: '35 Sec',
            percent: 10
        }],
        lineColors: ['#84adff'],
        xkey: 'time',
        ykeys: ['percent'],
        labels: [''],
        pointSize: 0,
        lineWidth: 0,
        resize: true,
        fillOpacity: 0.8,
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        hideHover: 'auto'
    });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var target = $(e.target).attr("href") // activated tab
        switch (target) {
            case "#last-year":
                homeBar.redraw();
                $(window).trigger('resize');
                break;
            case "#last-month":
                profileBar.redraw();
                $(window).trigger('resize');
                break;
            case "#last-week":
                profileBar.redraw();
                $(window).trigger('resize');
                break;
        }
    });

    $('[data-plugin="knob"]').knob();
});


// ==============================================================
// r scrollbar
// ==============================================================

var px = new PerfectScrollbar('#slimtest2', {
    wheelSpeed: .5,
    swipeEasing: 0,
    suppressScrollX: !0,
    wheelPropagation: 1,
    minScrollbarLength: 40,
});
var px = new PerfectScrollbar('#slimtest4', {
    wheelSpeed: .5,
    swipeEasing: 0,
    suppressScrollX: !0,
    wheelPropagation: 1,
    minScrollbarLength: 40,
});

jQuery('#world-map-markers').vectorMap({
    map: 'world_mill_en',
    backgroundColor: 'transparent',
    borderColor: '#818181',
    borderOpacity: 0.25,
    borderWidth: 1,
    zoomOnScroll: false,
    color: '#d7e6ff',
    regionStyle: {
        initial: {
            fill: '#d7e6ff'
        }
    },
    markerStyle: {
        initial: {
            r: 5,
            'fill': '#4886ff',
            'fill-opacity': 1,
            'stroke': '#000',
            'stroke-width': 2,
            'stroke-opacity': 0
        },
    },
    enableZoom: true,
    hoverColor: '#d7e6ff',
    markers: [{
            latLng: [37.0902, 95.7129],
            name: 'USA',
        }


    ],

    hoverOpacity: null,
    normalizeFunction: 'linear',
    scaleColors: ['#b6d6ff', '#005ace'],
    selectedColor: '#c9dfaf',
    selectedRegions: [],
    showTooltip: true,
    onRegionClick: function(element, code, region) {
        var message = 'You clicked "' +
            region +
            '" which has the code: ' +
            code.toUpperCase();

        alert(message);
    }
});
