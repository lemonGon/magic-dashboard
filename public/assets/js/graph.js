let Chart = function (rawData, dateRange) {
    this.dateRange = dateRange;
    this.rawData = rawData;
};
Chart.prototype.getCustomerDataPoints = function () {
    let data = [];
    for (let i = 0; i < this.rawData.customer.length; i++) {
        this.rawData.customer[i]['customerCount'] = parseInt(this.rawData.customer[i]['customerCount']);

        if ('undefined' !== typeof this.rawData.customer[i-1]) {
            this.rawData.customer[i]['customerCount'] += this.rawData.customer[i-1]['customerCount'];
        }

        data.push({
            x: this.getJsDateFromMySql(this.rawData.customer[i]['reg_date']),
            y: this.rawData.customer[i]['customerCount']
        });
    }
    return data;
};
Chart.prototype.getOrderDataPoints = function () {
    let data = [];
    for (let i = 0; i < this.rawData.customer.length; i++) {
        this.rawData.order[i]['totalRevenue'] = parseFloat(this.rawData.order[i]['totalRevenue']);

        if ('undefined' !== typeof this.rawData.order[i-1]) {
            this.rawData.order[i]['totalRevenue'] += this.rawData.order[i-1]['totalRevenue'];
        }

        data.push({
            x: this.getJsDateFromMySql(this.rawData.order[i]['purchase_date']),
            y: this.rawData.order[i]['totalRevenue'] / 1000
        });
    }
    return data;
};
Chart.prototype.getJsDateFromMySql = function (mysqlDate) {
    mysqlDate = mysqlDate.split('-');
    return new Date(mysqlDate[0], mysqlDate[1] - 1, mysqlDate[2].substr(0, 2));
};
Chart.prototype.toogleDataSeries = function (e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
};
Chart.prototype.showChart = function () {
    this.options.data[0].dataPoints = this.getCustomerDataPoints();
    this.options.data[1].dataPoints = this.getOrderDataPoints();
    this.options.title.text += this.dateRange.dateFrom + ' - ' + this.dateRange.dateTo;

    $('#ajaxResult').CanvasJSChart(this.options);
};
Chart.prototype.options = {
    animationEnabled: true,
    theme: "light2",
    title: {
        text: 'Sign-ups vs purchases '
    },
    axisX: {
        valueFormatString: "DD MMM"
    },
    axisY: {
        title: "Number of customers",
        suffix: "",
        minimum: 0
    },
    toolTip: {
        shared: true
    },
    legend: {
        cursor: "pointer",
        verticalAlign: "bottom",
        horizontalAlign: "left",
        dockInsidePlotArea: true,
        itemclick: Chart.prototype.toogleDataSeries
    },
    data: [{
        type: "line",
        showInLegend: true,
        name: "Number of customers",
        markerType: "square",
        xValueFormatString: "DD MMM, YYYY",
        color: "#F08080",
        yValueFormatString: "#",
        dataPoints: []
    }, {
        type: "line",
        showInLegend: true,
        name: "Purchases",
        lineDashType: "dash",
        yValueFormatString: "#,##0 K",
        dataPoints: []
    }]
};