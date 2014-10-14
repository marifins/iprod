
<?php $img_link = base_url()."/assets/images";?>
<?php $q = $query;?>
<?php
$date = date("d M Y", time() - (60*60*24));
?>

<table id="monitor-view" summary="View">
     <thead>
        <tr>
            <th style="text-align: left;" colspan="7" width="70%">
                <img style="position: absolute; margin: -11px 0 0 -10px;" src="<?php echo $img_link;?>/n1.png" width="70" height="57"/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Produksi Harian Kelapa Sawit (kg)
            </th>
            <th style="text-align: right;" colspan="4" width="30%" style="font-size: 23px;"><blink><?php echo $date;?></blink></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td width="9.09%" rowspan="2"><p id="header-table">Kebun</p></td>
        <td colspan="2"><p id="header-table">RKAP</p></td>
        <td colspan="2"><p id="header-table">REAL</p></td>
        <td colspan="2"><p id="header-table">Pencapaian(%)</p></td>
        <td><p id="header-table">Ket</p></td>
        <td colspan="3"><p id="header-table">Jan&nbsp;SD&nbsp;HI</p></td>      
    </tr>
    <tr>
        <td width="9.09%"><p id="header-monitor">HI</p></td>
        <td width="9.09%"><p id="header-monitor">SD&nbsp;HI</p></td>
        <td width="9.09%"><p id="header-monitor">HI</p></td>
        <td width="9.09%"><p id="header-monitor">SD&nbsp;HI</p></td>
        <td width="9.09%"><p id="header-monitor">HI</p></td>      
        <td width="9.09%"><p id="header-monitor">SD&nbsp;HI</p></td>
        <td width="9.09%"><p id="header-monitor">Sisa</p></td>
        <td width="9.09%"><p id="header-monitor">RKAP</p></td>
        <td width="9.09%"><p id="header-monitor">REAL</p></td>
        <td width="9.09%"><p id="header-monitor">%</p></td>
    </tr>
    <?php

        $rek = array("080.01","080.02","080.03","080.08","080.04","080.13");
        $name = array("PTG","KLM","KBR","TSW","JRU","CGR");
        
        
    ?>
        <tr>
            <td><b style="color: #2693ac;"><?php echo $name[$i];?></b></td>
            <td><b><?php echo 1;?></b></td>
            <td><b style="color: #2693ac;"><?php echo 11;?></b></td>
            <td><b><?php 2;?></b></td>                     
            <td><b style="color: #2693ac;"><?php echo 22;?></b></td>
            <td><b><?php 3;?></b></td>  
            <td><b style="color: #2693ac;"><?php echo 33;?></b></td>

            <td><b><?php echo 44;?></b></td>
            <td><b><?php echo 55;?></b></td>
            <td><b style="color: #2693ac;"><?php echo 66;?></b></td>
            <td><b><?php echo 77;?></b></td>
            
        </tr>

    <tr>
        <td><p id="header-table">Total</p></td>
        <td><p id="header-table"><?php echo 111;?></p></td>
        <td><p id="header-table"><?php echo setNum($total_sd_t);?></p></td>
        <td><p id="header-table"><?php echo setNum($total_hi_r);?></p></td>       
        <td><p id="header-table"><?php echo setNum($total_sd_r);?></p></td>      
        <td><p id="header-table"><?php echo $persen_total_hi;?></p></td>
        <td><p id="header-table"><?php echo $persen_total_sd;?></p></td>
        <td><p id="header-table"><?php echo setNum($total_sisa);?></p></td>
        <td><p id="header-table"><?php echo setNum($total_jan_sd_t);?></p></td>
        <td><p id="header-table"><?php echo setNum($total_jan_sd_r);?></p></td>
        <td><p id="header-table"><?php echo $persen_total_jan_sd;?></p></td>
    </tbody>
    <?php //endforeach;?>
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