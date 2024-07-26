function loadGraphs_Utilidad(graph1, graph2, graph3, graph4, graph5, graph6) {

    alert('ingresa')

    viewGraphs1(graph1)
    viewGraphs2(graph2)
    viewGraphs3(graph3)
    viewGraphs4(graph4)
    viewGraphs5(graph5)
    viewGraphs6(graph6)

}

function viewGraphs1(objserie){

    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar
    // Create the chart
    Highcharts.chart('graphs1', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: ''
        },
        subtitle: {
            align: 'left',
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Browsers',
                colorByPoint: true,
                data: objserie
            }
        ],
        
    });
}

function viewGraphs2(objserie){

    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar
    // Create the chart
    Highcharts.chart('container2', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: ''
        },
        subtitle: {
            align: 'left',
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Browsers',
                colorByPoint: true,
                data: objserie
            }
        ],
        
    });
}

function viewGraphs3(objserie){

    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar
    // Create the chart
    Highcharts.chart('container3', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: ''
        },
        subtitle: {
            align: 'left',
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Browsers',
                colorByPoint: true,
                data: objserie
            }
        ],
        
    });
}

function viewGraphs4(objserie){

    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar
    // Create the chart
    Highcharts.chart('container4', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: ''
        },
        subtitle: {
            align: 'left',
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Browsers',
                colorByPoint: true,
                data: objserie
            }
        ],
        
    });
}

function viewGraphs5(objserie){

    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar
    // Create the chart
    Highcharts.chart('container5', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: ''
        },
        subtitle: {
            align: 'left',
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Browsers',
                colorByPoint: true,
                data: objserie
            }
        ],
        
    });
}

function viewGraphs6(objserie){

    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar
    // Create the chart
    Highcharts.chart('container6', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: ''
        },
        subtitle: {
            align: 'left',
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Browsers',
                colorByPoint: true,
                data: objserie
            }
        ],
        
    });
}