<?php $img_link = base_url()."/assets/images";?>

<?php $q = $query;?>
<table id="rounded-corner" summary="Outbox">
     <thead>
        <tr>
            <th class="rounded-company">ID</th>
            <th>Tujuan</th>
            <th width="50%">Pesan</th>
            <th>Status</th>
            <th class="rounded-q4">Waktu</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="4" class="rounded-foot-left"><em>Outbox SMS | SMS - Based Information System Fresh Fruit Bunch (FFB) Production</em></td>
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
    <?php $i++;?>
    <?php if ($i % 2 == 0):?>
    <tr>
    <?php else:?>
    <tr class="even">
    <?php endif;?>
         <td><?php echo $row->id;?></td>
        <td><?php echo $row->destinationnumber;?></td>
        <td><?php echo $row->textdecoded;?></td>
        <td><?php echo $row->creatorid;?></td>
        <td><?php echo $row->sendingdatetime;?></td>
    </tr>
    </tbody>
    <?php endforeach;?>
    <?php endif;?>
</table>