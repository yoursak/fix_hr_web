'use strict';
$(document).ready(function() {
    var updatingChart1 = $("span.visitor1").peity("line", {
        fill: "rgba(70, 128, 254,0.2)",
        stroke: "rgb(70, 128, 254)"
    });
    var updatingChart2 = $("span.visitor2").peity("line", {
        fill: "rgba(252, 97, 128,0.2)",
        stroke: "rgb(252, 97, 128)"
    });
    var updatingChart3 = $("span.visitor3").peity("line", {
        fill: "rgba(147, 190, 82,0.2)",
        stroke: "rgb(147, 190, 82)"
    });
    var updatingChart4 = $("span.visitor4").peity("line", {
        fill: "rgba(255, 182, 77,0.2)",
        stroke: "rgb(255, 182, 77)"
    });
    var updatingChart5 = $("span.visitor5").peity("line", {
        fill: "rgba(254, 138, 125,0.2)",
        stroke: "rgb(254, 138, 125)"
    });
    // [ stock-scroll ] start
    var px = new PerfectScrollbar('.stock-scroll', {
        wheelSpeed: .5,
        swipeEasing: 0,
        wheelPropagation: 1,
        minScrollbarLength: 40,
    });
    // [ stock-scroll ] end

    // [ cust-scroll ] start
    var px = new PerfectScrollbar('.cust-scroll', {
        wheelSpeed: .5,
        swipeEasing: 0,
        wheelPropagation: 1,
        minScrollbarLength: 40,
    });
    // [ cust-scroll ] end

    // [ pro-scroll ] start
    var px = new PerfectScrollbar('.pro-scroll', {
        wheelSpeed: .5,
        swipeEasing: 0,
        wheelPropagation: 1,
        minScrollbarLength: 40,
    });
    // [ pro-scroll ] end

    // [ test-scroll ] start
    var px = new PerfectScrollbar('.test-scroll', {
        wheelSpeed: .5,
        swipeEasing: 0,
        wheelPropagation: 1,
        minScrollbarLength: 40,
    });
    // [ text-scroll ] end
});
