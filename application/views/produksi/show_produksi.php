<?php
function toRomawi($str){
    $int = array('1','1a','1b','2','3','4','5','6','7','8','9','10');
    $romawi = array('I','IA','IB','II','III','IV','V','VI','VII','VIII','IX','X');

    for($i=0; $i<12; $i++){
        if($str == $int[$i])
        {
            return $romawi[$i];
        }
    }
}

function setNum($str){
    return number_format($str,0,',','.');
}
?>
<?php
    $q = $query;
    $tgl = ""; $kebun = "";
    foreach($q as $r){
        $tgl = $r->tanggal;
        $kebun = $r->kebun;
    }
?>
<?php $img_link = base_url()."/assets/images";?>
<div id="subjudul">
<h2>
<?php
    $data = $this->produksi_model->get_kebun_name($kebun);
    if($data != null) echo $data->nama_kebun .'|';
?>
<?php echo $tgl;?>
</h2>
</div>
<br /><br /><br />
<?php
$kebun = '';
$tanggal = '';
foreach($query as $row){
    $kebun = $row->kebun;
    $tanggal = $row->tanggal;
}
?>
<a href="<?=base_url();?>produksi/topdf/<?php echo $kebun ."/" .$tanggal;?>"><?php echo img($img_link.'/pdf.png', TRUE);?></a>
<h3>&nbsp;TBS</h3>
<table id="daily" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
    <thead>
    <tr>
        <th width="3%" rowspan="2" class="rounded-company">Afd</th>
        <th rowspan="2">Luas (ha)</th>
        <th colspan="2">RKAP</th>
        <th colspan="2">RKO</th>
        <th colspan="2">Realisasi</th>
        <th colspan="2">% RKAP</th>
        <th colspan="2" class="rounded-q4">% RKO</th>
    </tr>
    <tr>
        <th>Hari ini</th>
        <th>s/d</th>
        <th>Hari ini</th>
        <th>s/d</th>
        <th>Hari ini</th>
        <th>s/d</th>
        <th>Hari ini</th>
        <th>s/d</th>
        <th>Hari ini</th>
        <th>s/d</th>
    </tr>
    </thead>
    <?php if($rows == 0):?>
        <tr>
            <td colspan='12' align='center'><span class='dark77'>Data tidak tersedia</span></td>
        </tr>
    <?php else:?>
    <?php
        
    $i = 0;
    $style = "";
    $jlh_luas = 0;
    $jlh_rkap = 0;
    $jlh_rkap_sd = 0;
    $jlh_rko = 0;
    $jlh_rko_sd = 0;
    $jlh_realisasi = 0;
    $jlh_realisasi_sd = 0;
    ?>
    <?php foreach($query as $row):?>
    <?php
    $hr_kerja = $this->produksi_model->get_hr_kerja($row->tanggal);
    $jh = $hr_kerja->jlh_hari;
    
    $luas_afd = $this->produksi_model->get_luas_afdeling($row->kebun, $row->afdeling, $row->tanggal);
    $la = $luas_afd->luas;

    $i++;
    
    $rkap_hr = $row->rkap / $jh;
    $rko_hr  = $row->rko / $jh;
    
    $rkap_sd = $rkap_hr * $rows_afd;
    $rko_sd = $rko_hr * $rows_afd;
    
    $jlh_luas += $la;
    
    $jlh_rkap += $rkap_hr;
    $jlh_rkap_sd += $rkap_sd;
    
    $jlh_rko += $rko_hr;
    $jlh_rko_sd += $rko_sd;
    
    $real_hr = $row->realisasi;
    $jlh_realisasi += $real_hr;
    
    

    ?>
    <?php $style = ($i % 2 == 0) ? "" : "even";?>
    <tr class="<?php echo $style;?>">
        <td><?php echo toRomawi($row->afdeling);?></td>
        <td><?php echo setNum($la);?></td>
        <td><?php echo setNum($rkap_hr);?></td>
        <td><?php echo setNum($rkap_sd);?></td>
        <td><?php echo setNum($rko_hr);?></td>
        <td><?php echo setNum($rko_sd);?></td>
        <td><?php echo setNum($real_hr);?></td>
        <?php
            $str = substr($row->tanggal, 0, 7);
            $query = $this->db->query('SELECT (SUM(realisasi)) as realisasi_sd FROM produksi WHERE afdeling = "'.$row->afdeling.'" AND kebun = "'.$kebun.'" AND SUBSTRING(tanggal,1,7) = "'.$str.'" GROUP BY afdeling');
            foreach ($query->result() as $r):
                $jlh_realisasi_sd += ($r->realisasi_sd);
        ?>
        <td><?php echo setNum($r->realisasi_sd);?></td>
        <td><?php if($row->rkap == 0) echo "0"; else echo round($real_hr / $rkap_hr * 100,2);?></td>
        <td><?php if($rkap_sd == 0) echo "0"; else echo round($r->realisasi_sd / $rkap_sd * 100,2);?></td>
        <td><?php if($row->rko == 0) echo "0"; else echo round($real_hr / $rko_hr * 100,2);?></td>
        <td><?php if($rko_sd == 0) echo "0"; else echo round($r->realisasi_sd / $rko_sd * 100,2);?></td>
        <?php endforeach;?>
    </tr>
    <?php endforeach;?>
    <tr class="total">
        <td>Jlh.</td>
        <td><?php echo setNum($jlh_luas);?></td>
        <td><?php echo setNum($jlh_rkap);?></td>
        <td><?php echo setNum($jlh_rkap_sd);?></td>
        <td><?php echo setNum($jlh_rko);?></td>
        <td><?php echo setNum($jlh_rko_sd);?></td>
        <td><?php echo setNum($jlh_realisasi);?></td>
        <td><?php echo setNum($jlh_realisasi_sd);?></td>
        <td><?php if($jlh_rkap == 0) echo "0"; else echo round($jlh_realisasi / $jlh_rkap * 100,2);?></td>
        <td><?php if($jlh_rkap_sd == 0) echo "0"; else echo round($jlh_realisasi_sd / $jlh_rkap_sd * 100,2);?></td>
        <td><?php if($jlh_rko == 0) echo "0"; else echo round($jlh_realisasi / $jlh_rko * 100,2);?></td>
        <td><?php if($jlh_rko_sd == 0) echo "0"; else echo round($jlh_realisasi_sd / $jlh_rko_sd * 100,2);?></td>
    </tr>
    <?php endif;?>
</table>
<br/>

<h3>&nbsp;Brondolan</h3>
<table id="daily" width=\"40%\" cellpadding=\"0\" cellspacing=\"0\">
    <thead>
    <tr>
        <th width="3%" class="rounded-company">Afd</th>
        <th>Luas</th>
        <th>Hari ini</th>
        <th>s/d H.I</th>
        <th>s/d B.I</th>
        <th class="rounded-q4">% Brond</th>
    </tr>
    </thead>
    <?php if($rows == 0):?>
        <tr>
            <td colspan='6' align='center'><span class='dark77'>Data tidak tersedia</span></td>
        </tr>
    <?php else:?>
    <?php
    $i = 0;
    $style = "";
    $jlh_luas = 0;
    $jlh_hari_ini = 0;
    $jlh_sd_hi = 0;
    $jlh_sd_bi = 0;
    $jlh_realisasi_sd = 0;

    ?>
    <?php foreach($q as $row):?>
    <?php
    $luas_afd = $this->produksi_model->get_luas_afdeling($row->kebun, $row->afdeling, $row->tanggal);
    $la = $luas_afd->luas;
    
    $i++;
    $jlh_luas += $la;
    $jlh_hari_ini += $row->brondolan;
    ?>
    <?php $style = ($i % 2 == 0) ? "" : "even";?>
    <tr class="<?php echo $style;?>">
        <td><?php echo toRomawi($row->afdeling);?></td>
        <td><?php echo setNum($la);?></td>
        <td><?php echo setNum($row->brondolan);?></td>
        <?php
        $str = substr($row->tanggal, 0, 7);
            $query = $this->db->query('SELECT realisasi, (SUM(brondolan)) as brondolan_sd, (SUM(realisasi)) as realisasi_sd FROM produksi WHERE kebun = "'.$row->kebun.'" AND afdeling = "'.$row->afdeling.'" AND SUBSTRING(tanggal, 1, 7) = "'.$str.'" GROUP BY afdeling');
            foreach ($query->result() as $r):
                $jlh_sd_hi += $r->brondolan_sd;
                
                $jlh_realisasi_sd += $r->realisasi;
        ?>
        <td><?php echo setNum($r->brondolan_sd);?></td>
        <?php
            $q_brondolan = $this->db->query('SELECT (SUM(brondolan)) as brondolan_sum FROM produksi WHERE kebun = "'.$row->kebun.'" AND afdeling = "'.$row->afdeling.'" GROUP BY afdeling');
            foreach ($q_brondolan->result() as $rw):
                $jlh_sd_bi += $rw->brondolan_sum;
        ?>
                <td><?php echo setNum($rw->brondolan_sum);?></td>
            <?php endforeach;?>
            <?php if($r->realisasi != 0):?>
                <td><?php echo round($row->brondolan / $r->realisasi * 100,2);?></td>
            <?php else:?>
                <td>0</td>
            <?php endif;?>
        <?php endforeach;?>
    </tr>
    <?php endforeach;?>
    <tr class="total">
        <td>Jlh.</td>
        <td><?php echo setNum($jlh_luas);?></td>
        <td><?php echo setNum($jlh_hari_ini);?></td>
        <td><?php echo setNum($jlh_sd_hi);?></td>
        <td><?php echo setNum($jlh_sd_bi);?></td>
        <td><?php if($jlh_realisasi_sd == 0) echo "0"; else echo round($jlh_hari_ini / $jlh_realisasi_sd * 100,2);?></td>
    </tr>
    <?php endif;?>
</table>
<br/>
<h3>&nbsp;HK</h3>
<table id="daily" width=\"81%\" cellpadding=\"0\" cellspacing=\"0\">
    <thead>
    <tr>
        <th width="3%" rowspan="2" class="rounded-company">Afd</th>
        <th colspan="3">H I</th>
        <th colspan="3">s/d H I</th>
        <th colspan="3">s/d B I</th>
        <th colspan="2" class="rounded-q4">Prestasi</th>
    </tr>

    <tr>
        <th>Dinas</th>
        <th>BHL</th>
        <th>Jlh</th>
        <th>Dinas</th>
        <th>BHL</th>
        <th>Jlh</th>
        <th>Dinas</th>
        <th>BHL</th>
        <th>Jlh</th>
        <th>H I</th>
        <th>s/d</th>
    </tr>
    </thead>
    <?php if($rows == 0):?>
        <tr>
            <td colspan='12' align='center'><span class='dark77'>Data tidak tersedia</span></td>
        </tr>
    <?php else:?>
    <?php
    $i = 0;
    $style = "";
    $jlh_dinas_hi = 0;
    $jlh_bhl_hi = 0;
    $jlh_dinas_sd_hi = 0;
    $jlh_bhl_sd_hi = 0;
    $jlh_dinas_sd_bi = 0;
    $jlh_bhl_sd_bi = 0;
    $jlh_prestasi_hi = 0;
    $jlh_prestasi_sd = 0;
    $jlh_rata_sd_bi = 0;
    $realisasi_sum = 0;
    $jlh_realisasi_sum = 0;

    ?>
    <?php foreach($q as $row):?>
    <?php
    $i++;
    $jlh_dinas_hi += $row->hk_dinas;
    $jlh_bhl_hi += $row->hk_bhl;
    ?>
    <?php $style = ($i % 2 == 0) ? "" : "even";?>
    <tr class="<?php echo $style;?>">
        <td><?php echo toRomawi($row->afdeling);?></td>
        <td><?php echo setNum($row->hk_dinas);?></td>
        <td><?php echo setNum($row->hk_bhl);?></td>
        <td><?php echo setNum($row->hk_dinas + $row->hk_bhl);?></td>
        <?php
        $str = substr($row->tanggal, 0, 7);
            $query = $this->db->query('SELECT (SUM(hk_dinas)) as dinas_sd, (SUM(hk_bhl)) as bhl_sd FROM produksi WHERE kebun = "'.$row->kebun.'" AND afdeling = "'.$row->afdeling.'" AND SUBSTRING(tanggal, 1, 7) = "'.$str.'" GROUP BY afdeling');
            foreach ($query->result() as $r):
                $jlh_dinas_sd_hi += $r->dinas_sd;
                $jlh_bhl_sd_hi += $r->bhl_sd;
        ?>
        <td><?php echo setNum($r->dinas_sd);?></td>
        <td><?php echo setNum($r->bhl_sd);?></td>
        <td><?php echo setNum($r->dinas_sd + $r->bhl_sd);?></td>

        <td><?php echo setNum($r->dinas_sd);?></td>
        <td><?php echo setNum($r->bhl_sd);?></td>
        <td><?php echo setNum($r->dinas_sd + $r->bhl_sd);?></td>
        
        <?php
            $jlh_realisasi += $row->realisasi;
        ?>

        <!-- Start Prestasi Panen-->
        <td><?php
        if($row->hk_dinas != 0 && $row->hk_bhl != 0)
            echo setNum($row->realisasi / ($row->hk_dinas + $row->hk_bhl));
        else 
            echo "0";
        ?></td>
        <?php
            $query = $this->db->query('SELECT realisasi, (SUM(realisasi)) as realisasi_sd FROM produksi WHERE kebun = "'.$row->kebun.'" AND afdeling = "'.$row->afdeling.'" AND SUBSTRING(tanggal, 1, 7) = "'.$str.'" GROUP BY afdeling');
            foreach ($query->result() as $rw):
                $realisasi_sum += $rw->realisasi;
                $jlh_realisasi_sum += $rw->realisasi_sd;
        ?>
        <td><?php if(($r->dinas_sd + $r->bhl_sd) == 0) echo "0"; else echo setNum($rw->realisasi_sd / ($r->dinas_sd + $r->bhl_sd));?></td>
        <?php
            if(($jlh_dinas_hi + $jlh_bhl_hi) != 0)
                $jlh_prestasi_hi = $realisasi_sum / ($jlh_dinas_hi + $jlh_bhl_hi);
            if(($jlh_dinas_sd_hi + $jlh_bhl_sd_hi) != 0)
            $jlh_prestasi_sd = $jlh_realisasi_sum / ($jlh_dinas_sd_hi + $jlh_bhl_sd_hi);
        ?>
        <?php endforeach;?>
        
        <!-- End Prestasi Panen-->
        <?php endforeach;?>
    </tr>
    <?php endforeach;?>
    <tr class="total">
        <td>Jlh.</td>
        <td><?php echo setNum($jlh_dinas_hi);?></td>
        <td><?php echo setNum($jlh_bhl_hi);?></td>
        <td><?php echo setNum($jlh_dinas_hi + $jlh_bhl_hi);?></td>

        <td><?php echo setNum($jlh_dinas_sd_hi);?></td>
        <td><?php echo setNum($jlh_bhl_sd_hi);?></td>
        <td><?php echo setNum($jlh_dinas_sd_hi + $jlh_bhl_sd_hi);?></td>

        <td><?php echo setNum($jlh_dinas_sd_hi);?></td>
        <td><?php echo setNum($jlh_bhl_sd_hi);?></td>
        <td><?php echo setNum($jlh_dinas_sd_hi + $jlh_bhl_sd_hi);?></td>

        <td><?php echo setNum($jlh_prestasi_hi);?></td>
        <td><?php echo setNum($jlh_prestasi_sd);?></td>
    </tr>
    <?php endif;?>
</table>
