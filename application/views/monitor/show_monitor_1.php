
<?php $img_link = base_url()."/assets/images";?>
<?php $q = $query;?>
<?php
$date = date("d M Y", time() - (60*60*24));
?>

<table id="monitor-view" summary="View">
     <thead>
        <tr>
            <th style="text-align: left;" colspan="6" width="70%">
                <img style="position: absolute; margin: -11px 0 0 -10px;" src="<?php echo $img_link;?>/n1.png" width="70" height="57"/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Produksi Harian Kelapa Sawit (kg)
            </th>
            <th style="text-align: right;" colspan="2" width="30%" style="font-size: 23px;"><blink><?php echo $date;?></blink></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td width="12.5%"><p id="header-table">Kebun</p></td>
        <td width="12.5%"><p id="header-table">Rencana</p></td>
        <td width="12.5%"><p id="header-table">Real</p></td>
        <td width="12.5%"><p id="header-table">%&nbsp;HI</p></td>
        <td width="12.5%"><p id="header-table">Renc&nbsp;SD</p></td>
        <td width="12.5%"><p id="header-table">Real&nbsp;SD</p></td>      
        <td width="12.5%"><p id="header-table">% SD</p></td>
        <td width="12.5%"><p id="header-table">Sisa</p></td>
    </tr>
    <?php
        $total_hi_t = 0;
        $total_hi_r = 0;
        $total_sd_t = 0;
        $total_sd_r = 0;
        $total_sisa = 0;
        $rek = array("080.01","080.02","080.03","080.08","080.04","080.13");
        $name = array("PTG","KLM","KBR","TSW","JRU","CGR");
        
        for($i=0; $i<count($rek); $i++):
            $str = "";
            $dt = $this->monitor_model->get_complete($rek[$i], $date);
            foreach ($dt as $d){          
                $str .= $this->fungsi->toRomawi($d->afdeling);
                $str .= ", ";
            }
            $hi = $this->monitor_model->real_kebun($rek[$i]);
            $sd = $this->monitor_model->real_kebun_sd($rek[$i]);
            $persen_hi = persentase($hi->t, $hi->r);
            $persen_sd = persentase($sd->t, $sd->r);
            
            $total_hi_t += $hi->t;
            $total_hi_r += $hi->r;
            $total_sd_t += $sd->t;
            $total_sd_r += $sd->r;
            $total_sisa += $hi->s;
            $persen_total_hi = persentase($total_hi_t, $total_hi_r);
            $persen_total_sd = persentase($total_sd_t, $total_sd_r);
    ?>
        <tr>
            <td><b><?php echo $name[$i];?></b> <b class="indicator"><?php echo $str;?></b></td>
            <td><b><?php echo setNum($hi->t);?></b></td>
            <td><b><?php echo setNum($hi->r);?></b></td>
            
            <?php if($persen_hi < 80):?>
            <td>
                <b style="color: #ff0000;"><?php echo round($persen_hi, 2);?></b>
            </td>
            <?php else:?>
            <td>
                <b><?php echo round($persen_hi, 2);?></b>
            </td>
            <?php endif;?>
            
            <td><b><?php echo setNum($sd->t);?></b></td>
            <td><b><?php echo setNum($sd->r);?></b></td>
            
            <?php if($persen_sd < 80):?>
            <td>
                <b style="color: #ff0000;"><?php echo round($persen_sd, 2);?></b>
            </td>
            <?php else:?>
            <td>
                <b><?php echo round($persen_sd, 2);?></b>
            </td>
            <?php endif;?>

            <?php if($hi->s > 0):?>
            <td><b style="color: #ff0000;"><?php echo setNum($hi->s);?></b></td>
            <?php else:?>
            <td><b><?php echo setNum($hi->s);?></b></td>
            <?php endif;?>
        </tr>
   <?php endfor;?>
    <tr>
        <td><p id="header-table">Total</p></td>
        <td><p id="header-table"><?php echo setNum($total_hi_t);?></p></td>
        <td><p id="header-table"><?php echo setNum($total_hi_r);?></p></td>
        <td><p id="header-table"><?php echo setNum($total_sd_t);?></p></td>
        <td><p id="header-table"><?php echo setNum($total_sd_r);?></p></td>      
        <td><p id="header-table"><?php echo $persen_total_hi;?></p></td>
        <td><p id="header-table"><?php echo $persen_total_sd;?></p></td>
        <td><p id="header-table"><?php echo setNum($total_sisa);?></p></td>
    </tbody>
    <?php //endforeach;?>
    
    <tfoot>
        <tr>
            <td height="5px" colspan="8"><em>Monitoring Produksi Kelapa Sawit | PT Perkebunan Nusantara I (Persero)</em></td>
        </tr>
    </tfoot>
</table>

<?php

function persentase($a, $b){
    $res = 0;
    if(isset($b) AND $b != 0){
        if(isset($a) AND $a != 0){
            $res = ($b / $a) * 100;
        }
    }
    return round($res, 2);
}
function setNum($str){
    return number_format($str,0,',','.');
}
?>