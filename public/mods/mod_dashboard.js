$(document).ready(function () {
    renderStudentByMajor();
});

function getChartColorsArray(r) {
    r = $(r).attr("data-colors");
    return (r = JSON.parse(r)).map(function (r) {
        r = r.replace(" ", "");
        if (-1 == r.indexOf("--")) return r;
        r = getComputedStyle(document.documentElement).getPropertyValue(r);
        return r || void 0
    })
}
async function renderStudentByMajor() {
    var barColor = getChartColorsArray("#sales-chart")
    const {
        data: chartData
    } = await requestChartData('sales-chart');


    var options = {
        chart: {
            height: 350,
            type: 'area',
            zoom: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: 'straight',
        },
        series: [{
            name: 'Jumlah Penjualan',
            data: chartData.map(price => price.income)
        }],
        colors: barColor,

        grid: {
            borderColor: "#f1f1f1"
        },
        xaxis: {
            categories: chartData.map(month => month.month),
        },
        yaxis: {
            opposite: true,
            labels: {
                formatter: function (value) {
                    return 'Rp ' + new Intl.NumberFormat().format(value);
                },
            },
        },
    };

    var chart = new ApexCharts(
        document.querySelector('#sales-chart'),
        options
    );
    chart.render();
}
async function requestChartData(chartRouteName, prefix = 'administrator') {
    const res = await fetch(
        `${$('meta[name=base-url]').attr(
            'content'
        )}/${prefix}/dashboard/${chartRouteName}`
    );
    const data = await res.json();
    return data;
}
