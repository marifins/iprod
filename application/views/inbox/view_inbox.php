<?php
function toRomawi($str){
    $int = array('1','2','3','4','5','6','7','8','9','10');
    $romawi = array('I','II','III','IV','V','VI','VII','VIII','IX','X');

    for($i=0; $i<10; $i++){
        if($str == $int[$i])
        {
            return $romawi[$i];
        }
    }
}

function setNum($str){
    return number_format($str,0,',','.');
}

function status($num){
    if ($num == "true") return "<span id=green>proccessed</span>";
    else return "<span id=red>unprocessed</span>";
}
?>
<?php $img_link = base_url()."/assets/images";?>
<div>
<ul id="pagination-digg"><?php echo $page_links;?></ul>
</div>
<br /><br />
<?php $q = $query;?>
<table id="rounded-corner" summary="Inbox">
     <thead>
        <tr>
            <th class="rounded-company">ID</th>
            <th>Pengirim</th>
            <th>Pesan</th>
            <th>Status</th>
            <th class="rounded-q4">Waktu</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="4" class="rounded-foot-left"><em>Inbox SMS | SMS - Based Information System Fresh Fruit Bunch (FFB) Production</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if($rows == 0):?>
    <tr>
        <td colspan='5' align='center'><span id='red'>Data tidak tersedia</span></td>
    </tr>
    <?php else:?>
    <?php $i = 0;?>
    <?php foreach($q as $row):?>
    <tbody>
    <?php
    $kebun = "";
    $afd = "";
    $data = $this->inbox_model->get_krani($row->sendernumber);
    if($data != ""){
        $d = $this->inbox_model->get_nama_kebun($data->kebun_unit);
        $kebun = $d->nama_kebun;
        $afd = 'Afd. ' .$data->afdeling;
    }
    ?>
    <?php $i++;?>
    <?php if ($i % 2 == 0):?>
    <tr>
    <?php else:?>
    <tr class="even">
    <?php endif;?>
        <td><?php echo $row->id;?></td>
        <td>
         <?php echo $row->sendernumber;?>
         <br /> <?php echo $kebun;?><br /> <?php echo $afd;?>
        </td>
        <td><?php echo $row->textdecoded;?></td>
        <td><?php echo status($row->processed);?></td>
        <td><?php echo $row->receivingdatetime;?></td>
    </tr>
    </tbody>
    <?php endforeach;?>
    <?php endif;?>
</table>