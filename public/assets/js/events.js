$(document).ready( function() {

    let report = new Report(
        $('#dateFrom').val(),
        $('#dateTo').val()
    );

    $('#dateFrom').change( function () {
        report = new Report(
            $('#dateFrom').val(),
            $('#dateTo').val(),
            true
        );
    });
    $('#dateTo').change( function () {
        report = new Report(
            $('#dateFrom').val(),
            $('#dateTo').val(),
            true
        );
    });


    $('#showCustomerCount').click( function () {
        report.getCustomerCount();
    });

    $('#showOrderCount').click( function () {
        report.getOrderCount();
    });

    $('#showOrderRevenue').click( function () {
        report.getRevenue();
    });

    $('#showGraph').click( function () {
        report.getGraphData();
    });
});