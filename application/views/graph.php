<?php $i = 0;?>
<?php foreach($query_g as $row):?>
    <?php
    $tgl = $row->tanggal;


    $data1 = $this->produksi_model->by_kebun('080.01', $tgl);
    $ptg = round($data1['0']['realisasi']/1000,2);
    $data2 = $this->produksi_model->by_kebun('080.02', $tgl);
    $klm = round($data2['0']['realisasi']/1000,2);
    $data3 = $this->produksi_model->by_kebun('080.03', $tgl);
    $kbr = round($data3['0']['realisasi']/1000,2);
    $data4 = $this->produksi_model->by_kebun('080.08', $tgl);
    $tsw = round($data4['0']['realisasi']/1000,2);
    $data5 = $this->produksi_model->by_kebun('080.04', $tgl);
    $jru = round($data5['0']['realisasi']/1000,2);
    $data6 = $this->produksi_model->by_kebun('080.13', $tgl);
    $cgr = round($data6['0']['realisasi']/1000,2);

    $f_tgl = array(
        'id' => 'tgl'.$i,
        'value' => $tgl,
        'class' => 'graph',
    );
    echo form_input($f_tgl);

    $f_ptg = array(
        'id' => 'ptg'.$i,
        'value' => $ptg,
        'class' => 'graph',
    );
    echo form_input($f_ptg);


    $f_klm = array(
        'id' => 'klm'.$i,
        'value' => $klm,
        'class' => 'graph',
    );
    echo form_input($f_klm);

    $f_kbr = array(
        'id' => 'kbr'.$i,
        'value' => $kbr,
        'class' => 'graph',
    );
    echo form_input($f_kbr);

    $f_tsw = array(
        'id' => 'tsw'.$i,
        'value' => $tsw,
        'class' => 'graph',
    );
    echo form_input($f_tsw);

    $f_jru = array(
        'id' => 'jru'.$i,
        'value' => $jru,
        'class' => 'graph',
    );
    echo form_input($f_jru);

    $f_cgr = array(
        'id' => 'cgr'.$i,
        'value' => $cgr,
        'class' => 'graph',
    );
    echo form_input($f_cgr);

    $i++;
    ?>
<?php endforeach;?>

<div>
    <div id="chartDiv" style="width:800px; height:300px;"></div>
</div>

<script type="text/javascript">
    var ptg = [$('#ptg4').val(),$('#ptg3').val(),$('#ptg2').val(),$('#ptg1').val(),$('#ptg0').val()];
    var klm = [$('#klm4').val(),$('#klm3').val(),$('#klm2').val(),$('#klm1').val(),$('#klm0').val()];
    var kbr = [$('#kbr4').val(),$('#kbr3').val(),$('#kbr2').val(),$('#kbr1').val(),$('#kbr0').val()];
    var tsw = [$('#tsw4').val(),$('#tsw3').val(),$('#tsw2').val(),$('#tsw1').val(),$('#tsw0').val()];
    var jru = [$('#jru4').val(),$('#jru3').val(),$('#jru2').val(),$('#jru1').val(),$('#jru0').val()];
    var cgr = [$('#cgr4').val(),$('#cgr3').val(),$('#cgr2').val(),$('#cgr1').val(),$('#cgr0').val()];
    var xAxis = [$('#tgl4').val(), $('#tgl3').val(), $('#tgl2').val(), $('#tgl1').val(), $('#tgl0').val()];

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

</script>