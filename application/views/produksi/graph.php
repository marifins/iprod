
<?php $i = 0;?>
<?php foreach($query as $row):?>
    <?php
    $jlh_luas = 0;
    $jlh_rkap = 0;
    $jlh_rkap_sd = 0;
    $jlh_rko = 0;
    $jlh_rko_sd = 0;
    $jlh_realisasi = 0;
    $jlh_realisasi_sd = 0;

    $rkap = round($row->rkap/1000,1);
    $rko = round($row->rko/1000,1);
    $realisasi = round($row->realisasi/1000,1);

    $f_rkap = array(
        'id' => 'rkap'.$i,
        'value' => $rkap,
        'class' => 'graph',
    );
    echo form_input($f_rkap);
    

    $f_rko = array(
        'id' => 'rko'.$i,
        'value' => $rko,
        'class' => 'graph',
    );
    echo form_input($f_rko);

    $f_real = array(
        'id' => 'real'.$i,
        'value' => $realisasi,
        'class' => 'graph',
    );
    echo form_input($f_real);
    $i++;
    ?>
<?php endforeach;?>
<script type="text/javascript">
   
    //var a = $('#rkap0').val();

    var rkap = [$('#rkap0').val(),$('#rkap1').val(),$('#rkap2').val(),$('#rkap3').val(),$('#rkap4').val(),$('#rkap5').val(),$('#rkap6').val(),$('#rkap7').val(),$('#rkap8').val(),$('#rkap9').val()];
    var rko = [$('#rko0').val(),$('#rko1').val(),$('#rko2').val(),$('#rko3').val(),$('#rko4').val(),$('#rko5').val(),$('#rko6').val(),$('#rko7').val(),$('#rko8').val(),$('#rko9').val()];
    var realisasi = [$('#real0').val(),$('#real1').val(),$('#real2').val(),$('#real3').val(),$('#real4').val(),$('#real5').val(),$('#real6').val(),$('#real7').val(),47.9,$('#real9').val()];
    var xAxis = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];

     function CreateLineChartOptions()
    {
        var optionsObj = {
            title: 'Grafik Produksi Hari Ini - Line Chart',
            axes: {  
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: xAxis
                }
            },
            series: [{label:'RKAP'}, {label: 'RKO'}, {label: 'Realisasi'}],
            seriesDefaults:{
                markerOptions:{
                    show: true,
                    style: 'diamond'
                }
            },
            legend: {
                show: true,
                location: 'nw'
            },
            highlighter: {
                showTooltip: true,
                tooltipFade: true
            }
        };
        return optionsObj;
    }

    function CreateBarChartOptions()
    {
        var optionsObj = {
            title: 'Grafik Produksi Hari Ini - Bar Chart',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: xAxis
                }
            },
            series: [{label:'RKAP'}, {label: 'RKO'}, {label: 'Realisasi'}],
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
<div>
    <div id="chartDiv" style="width:650px; height:400px;"></div>
</div>
<div>
    <input id="lineChartButton" type="button" value="Line Chart" />
    <input id="barChartButton" type="button" value="Bar Chart" />
</div>
<?php $img_link = base_url()."/assets/images";?>
<br />
<a href="<?=base_url();?>produksi/"><?php echo img($img_link.'/back.png', TRUE);?></a>