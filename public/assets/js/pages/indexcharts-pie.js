function loadGraphs(graph1) {

    viewGraphs(graph1)
}

function viewGraphs(objdata) {

    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        subtitle: {
            text: '',
            align: 'left'
        },

        accessibility: {
            announceNewData: {
                enabled: true
            },
            point: {
                valueSuffix: '%'
            }
        },

        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                name: 'Registros',
                colorByPoint: true,
                data: [
                    {
                        name: 'Presencial',
                        y: 61.04,
                        drilldown: 'Presencial'
                    },
                    {
                        name: 'Distancia',
                        y: 8.15,
                        drilldown: 'Distancia'
                    },
                    {
                        name: 'Virtual',
                        y: 11.02,
                        drilldown: 'Virtual'
                    }
                ]
            }
        ],
    });

}