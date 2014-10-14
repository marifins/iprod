<?php $img_link = base_url()."/assets/images";?>
<?php
$num = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
//$date = date("d M Y", time() - (60*60*24));
?>
<?php foreach($query as $q):?>
<div style="text-align: left;"><h3><?php echo $q->nama_kebun;?></h3></div>
<div>&nbsp;</div>
<table id="daily" summary="View">
     <thead>
         <tr>
             <th rowspan="2">AFD</th>
             <th colspan="<?php echo $num;?>"><?php echo $this->fungsi->bulan(date("m"));?></th>
         </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <?php for($i=1; $i<=$num; $i++):?>
            <td><?php echo $i?></td>
            <?php endfor;?>
        </tr>
        <?php
            $data = $this->cek_model->get_afd($q->no_rek);           
            foreach($data as $d):
        ?>
                <tr>
                    <td><?php echo $this->fungsi->toRomawi($d->afdeling);?></td>
                    <?php for($i=1; $i<=$num; $i++):?>
                        <td>
                            <?php
                                $tgl = '2012-08-';
                                $tgl .= $i;
                                $all = $this->cek_model->is_all($q->no_rek, $d->afdeling, $tgl);
                                $empty = $this->cek_model->is_empty($q->no_rek, $d->afdeling, $tgl);
                                $some = $this->cek_model->is_some($q->no_rek, $d->afdeling, $tgl);
                                if($all == 1) echo "<span style=\"font-family: Arial Unicode MS, Lucida Grande\">&#10004;</span>";
                                
                                else if($some == 1) echo "-";
                                else echo ""; 
                            ?>
                        </td>
                    <?php endfor;?>
                </tr>
            <?php endforeach;?>
    </tbody>
</table>
<?php endforeach;?>
<?php

function persentase($a, $b){
    $res = 0;
    if(isset($b) AND $b != 0){
        if(isset($a) AND $a != 0){
            $res = ($b / $a) * 100;
        }
    }
    return $res;
}
function setNum($str){
    return number_format($str,0,',','.');
}
?>