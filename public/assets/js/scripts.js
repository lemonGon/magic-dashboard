const displayResultHelper = {
    showResultTag: 'ajaxResult',

    showCustomerCount: function (data, dateRange) {
        this.selectActiveMenu(this.showCustomerCount);
        $('#' + this.showResultTag).html(
            '<h3>Customer count</h3><p>' +
            'Date From <em>' + dateRange.dateFrom + '</em><br>' +
            'Date To <em>' + dateRange.dateTo + '</em><br>' +
            'Customer Count: <strong>' + data.customerCount + '<strong>'
        );
    },
    showOrderCount: function (data, dateRange) {
        this.selectActiveMenu(this.showOrderCount);
        $('#' + this.showResultTag).html(
            '<h3>Order count</h3><p>' +
            'Date From <em>' + dateRange.dateFrom + '</em><br>' +
            'Date To <em>' + dateRange.dateTo + '</em><br>' +
            'Order Count: <strong>' + data.orderCount + '<strong>'
        );
    },
    showOrderRevenue: function (data, dateRange) {
        this.selectActiveMenu(this.showOrderRevenue);
        $('#' + this.showResultTag).html(
            '<h3>Total Revenue</h3><p>' +
            'Date From <em>' + dateRange.dateFrom + '</em><br>' +
            'Date To <em>' + dateRange.dateTo + '</em><br>' +
            'Total Revenue: <strong>' + data.totalRevenue + '<strong>'
        );
    },
    showGraph: function (data, dateRange) {
        this.selectActiveMenu(this.showGraph);

        let chart = new Chart(data, dateRange)
        chart.showChart();

        // setGraph(data, dateRange);
    },
    showError: function (data) {
        $('#' + this.showResultTag).html(data.responseText);
    },
    setFromDate: function (date) {
        $('#dateFrom').val(date);
    },
    setToDate: function (date) {
        $('#dateTo').val(date);
    },
    selectActiveMenu: function (_function) {
        let listItems = $('#mainNavMenu ul li');
        listItems.each( function (idx, li) {
            $(li).children().removeClass('active');
        });

        if ('undefined' !== typeof _function) {
            $('#' + _function.name).addClass('active');
        }
    }
};

let Dashboard = function (dateFrom, dateTo) {
    this.dateFrom = dateFrom;
    this.dateTo = dateTo;
    this.root = window.location.protocol + '//' + window.location.host
};
Dashboard.prototype.ajaxPost = function (url, showUpFunction) {
    let _self = this;
    $.ajax({
        url: this.root + url,
        type: 'POST',
        dataType: 'json',
        data : {
            dateFrom: _self.dateFrom,
            dateTo: _self.dateTo
        },
        success: function (jsonResult) {
            displayResultHelper[showUpFunction](
                jsonResult.payload,
                {
                    dateFrom: _self.dateFrom,
                    dateTo: _self.dateTo
                }
            );
        },
        error: function (jsonResult) {
            displayResultHelper.showError(jsonResult);
        }
    });
};
Dashboard.prototype.getToDate = function () {
    let mySqlTodayDate = this.getMySqlDateFormat(new Date());

    displayResultHelper.setToDate(mySqlTodayDate);

    return mySqlTodayDate;
};
Dashboard.prototype.getFromDate = function () {
    let todayDate = new Date();
    todayDate.setDate(todayDate .getDate() -30);

    let mySqlTodayDate = this.getMySqlDateFormat(todayDate);

    displayResultHelper.setFromDate(mySqlTodayDate);

    return mySqlTodayDate;
};
Dashboard.prototype.getMySqlDateFormat = function (date) {
    return date.getUTCFullYear() +
        '-' +
        ('00' + (date.getUTCMonth()+1)).slice(-2) +
        '-' +
        ('00' + date.getUTCDate()).slice(-2);
};


let Report = function (dateFrom, dateTo, refreshLinks = false) {
    Dashboard.apply(this, arguments);

    this.dateFrom = dateFrom ? dateFrom : this.getFromDate();
    this.dateTo = dateTo ? dateTo : this.getToDate();
    if (refreshLinks) {
        displayResultHelper.selectActiveMenu();
    }
};
Report.prototype = Dashboard.prototype;
Report.prototype.getOrderCount = function () {
    this.ajaxPost(
        '/dynamic/report/getordercount',
        'showOrderCount'
    );
};
Report.prototype.getCustomerCount = function () {
    this.ajaxPost(
        '/dynamic/report/getusercount',
        'showCustomerCount'
    );
};
Report.prototype.getRevenue = function () {
    this.ajaxPost(
        '/dynamic/report/getrevenue',
        'showOrderRevenue'
    );
};
Report.prototype.getGraphData = function () {
    this.ajaxPost(
        '/dynamic/report/getgraphdata',
        'showGraph'
    );
};
