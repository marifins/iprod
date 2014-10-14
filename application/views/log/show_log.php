<?php $img_link = base_url()."/assets/images";?>
<?php $q = $query;?>
<table id="rounded-corner" summary="Inbox">
     <thead>
        <tr>
            <th width="5%" class="rounded-company">ID</th>
            <th>Kebun</th>
            <th width="5%">Afdeling</th>
            <th>Estimasi</th>
            <th>Realisasi</th>
            <th>Brondolan</th>
            <th>Tanggal</th>
            <th class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="7" class="rounded-foot-left"><em>Log Produksi | SMS - Based Information System Fresh Fruit Bunch (FFB) Production</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if($rows == 0):?>
    <tr>
        <td colspan='7' align='center'><span id='red'>Data tidak tersedia</span></td>
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
        <td><?php echo $row->nama_kebun;?></td>
        <td><?php echo toRomawi($row->afdeling);?></td>
        <td><?php echo setNum($row->estimasi) ." kg";?></td>
        <td><?php echo setNum($row->realisasi) ." kg";?></td>
        <td><?php echo setNum($row->brondolan) ." kg";?></td>
        <td><?php echo $row->tanggal;?></td>
        <td>
            <a href="javascript:void(0);" onclick='l("<?=base_url();?>log/details/<?php echo $row->id;?>","")'><?php echo img($img_link.'/detail.png', TRUE);?></a>
            <a href="#" class="edit_log" id="<?php echo $row->id; ?>" tanggal="<?php echo $row->tanggal; ?>" kebun="<?php echo $row->kebun; ?>" afdeling="<?php echo $row->afdeling; ?>" tanggal="<?php echo $row->tanggal; ?>" estimasi="<?php echo $row->estimasi; ?>" realisasi="<?php echo $row->realisasi; ?>" brondolan="<?php echo $row->brondolan; ?>" hk_dinas="<?php echo $row->hk_dinas; ?>" hk_bhl="<?php echo $row->hk_bhl; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
            <a href="#" class="delete_log" id="<?php echo $row->id; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a>
        </td>
    </tr>
    </tbody>
    <?php endforeach;?>
    <?php endif;?>
</table>