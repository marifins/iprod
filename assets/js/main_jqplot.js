var ptg = [$('#ptg0').val(),$('#ptg1').val(),$('#ptg2').val(),$('#ptg3').val(),$('#ptg4').val(), 36.9];
    var klm = [$('#klm0').val(),$('#klm1').val(),$('#klm2').val(),$('#klm3').val(),$('#klm4').val(), 36.9];
    var kbr = [$('#kbr0').val(),$('#kbr1').val(),$('#kbr2').val(),$('#kbr3').val(),$('#kbr4').val(), 36.9];
    var tsw = [$('#tsw0').val(),$('#tsw1').val(),$('#tsw2').val(),$('#tsw3').val(),$('#tsw4').val(), 36.9];
    var jru = [$('#jru0').val(),$('#jru1').val(),$('#jru2').val(),$('#jru3').val(),$('#jru4').val(), 36.9];
    var cgr = [$('#cgr0').val(),$('#cgr1').val(),$('#cgr2').val(),$('#cgr3').val(),$('#cgr4').val(), 36.9];
    var xAxis = [$('#tgl0').val(), $('#tgl1').val(), $('#tgl2').val(), $('#tgl3').val(), $('#tgl4').val()];

    function CreateBarChartOptions()
    {
        var optionsObj = {
            //title: 'Realisasi Produksi TBS Harian',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: xAxis
                },
                yaxis: {min:0, max: 400}
            },
            series: [{label:'PTG'}, {label: 'KLM'}, {label: 'KBR'}, {label:'JRU'}, {label: 'TSW'}, {label: 'CGR'}],
            legend: {
                show: true,
                location: 'nw'
            },
            seriesDefaults:{
                shadow: true,
                renderer:$.jqplot.BarRenderer,
                rendererOptions:{
                    barPadding: 5,
                    barMargin: 7
                }
            },
            highlighter: {
                showTooltip: true,
                tooltipFade: true
            }
        };
        return optionsObj;
    }