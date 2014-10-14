<?php $img_link = base_url()."/assets/images";?>
<div class="fRight" style="margin: -35px 18px 0 0;">
<h2>
    <a href="<?=base_url();?>def/topdf/<?php echo $year ."/" .$month;?>"><?php echo img($img_link.'/pdf.png', TRUE);?></a>
    <?php echo $this->fungsi->bulan($month) .' '.$year;?>
</h2>
</div>
<table id="rounded-corner" summary="Outbox">
    <thead>
    <tr class="top">
        <th class="rounded-company">Tanggal</th>
        <th>PTG</th>
        <th>KLM</th>
        <th>KBR</th>
        <th>JRU</th>
        <th>TSW</th>
        <th>CGR</th>
        <th class="rounded-q4">Jumlah</th>
    </tr>
    </thead>
    <?php if($rows == 0):?>
    <tr align="center">
        <td colspan="8"><span id="error">Data Tidak Tersedia</span></td>
    </tr>
    <?php else:?>
    <?php
    $i = 0;
    $total_ptg = 0; $total_klm = 0; $total_kbr = 0;
    $total_tsw = 0; $total_jru = 0; $total_cgr = 0;
    $total = 0;
        
    foreach ($query as $row):
    $i++;
    $tgl = $row->tanggal;
    if($i % 2 == 0):
    ?>
    <tr>
    <?php else:?>
    <tr class="even">
    <?php endif;?>
    <?php
        $ptg = $this->produksi_model->by_kebun('080.01', $tgl);
        $klm = $this->produksi_model->by_kebun('080.02', $tgl);
        $kbr = $this->produksi_model->by_kebun('080.03', $tgl);
        $tsw = $this->produksi_model->by_kebun('080.08', $tgl);
        $jru = $this->produksi_model->by_kebun('080.04', $tgl);
        $cgr = $this->produksi_model->by_kebun('080.13', $tgl);

        $total_ptg += s($ptg); $total_klm += s($klm); $total_kbr += s($kbr);
        $total_tsw += s($tsw); $total_jru += s($jru); $total_cgr += s($cgr);
    ?>
        <td><?php echo $tgl;?></td>
        <td id="hov" kebun="080.01" tgl="<?php echo $tgl;?>"><?php echo s($ptg);?></td>
        <td id="hov" kebun="080.02" tgl="<?php echo $tgl;?>"><?php echo s($klm);?></td>
        <td id="hov" kebun="080.03" tgl="<?php echo $tgl;?>"><?php echo s($kbr);?></td>
        <td id="hov" kebun="080.04" tgl="<?php echo $tgl;?>"><?php echo s($jru);?></td>
        <td id="hov" kebun="080.08" tgl="<?php echo $tgl;?>"><?php echo s($tsw);?></td>
        <td id="hov" kebun="080.13" tgl="<?php echo $tgl;?>"><?php echo s($cgr);?></td>
        <?php
            $jlh = s($ptg) + s($klm) + s($kbr) + s($tsw) + s($jru) + s($cgr);
            $total += $jlh;
        ?>
        <td id="hovt" tgl="<?php echo $tgl;?>"><?php echo ($jlh);?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="total">
        <td>JUMLAH</td>
        <td><?php echo $total_ptg;?></td>
        <td><?php echo $total_klm;?></td>
        <td><?php echo $total_kbr;?></td>
        <td><?php echo $total_tsw;?></td>
        <td><?php echo $total_jru;?></td>
        <td><?php echo $total_cgr;?></td>
        <td><?php echo $total;?></td>
    </tr>
    <?php endif;?>
</table>
<?php

function s($input) {
    $res = 0;
    if (array_key_exists('0', $input)) {
        $res = $input['0']['realisasi'] / 1000;
        return round($res, 2);
    } else {
        return 0;
    }
}

?>