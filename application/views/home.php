<div id="show_graph" style="margin: -50px 0 0 0;">
    <?php $this->load->view('graph'); ?>
</div>
<br />
<div style="margin-bottom: 5px;">
    &nbsp;
    <?php
    $options = "";
    $options[''] = "-- Tahun --";
    foreach($tahun as $t){
        $options[$t->tahun] = $t->tahun;
    }
    echo form_dropdown('privilege', $options, '', 'id=tahun');
    echo "\r";

    $month = "";
    $month[''] = "-- Bulan --";
    for($i=1; $i<=12; $i++){
        $i = "".$i;
        if(strlen($i) == 1) $i = "0" .$i;
        $month[$i] = $this->fungsi->toStr($i);
    }
    echo form_dropdown('bulan', $month, '', 'id=bulan');
    ?>
</div>
<div id="show">
    <?php $this->load->view('show_home'); ?>
</div>

<script>
    
$("td#hov").live("click",
    function () {
        var tgl = $(this).attr("tgl");
        var kebun = $(this).attr("kebun");
        var link = "<?=base_url(); ?>produksi/detail_afdeling/" +kebun +"/" +tgl;
        l2(link,"");
    },
    function () {
        $(this).find("span:last").remove();
    }
);
    
$("td#hovt").live("click",
    function () {
        var tgl = $(this).attr("tgl");
        var link = "<?= base_url(); ?>produksi/total_details/" +tgl;
        l3(link,"");
    },
    function () {
        $(this).find("span:last").remove();
    }
);



//li with fade class
$("li.fade").hover(function(){$(this).fadeOut(100);$(this).fadeIn(500);});

</script>
