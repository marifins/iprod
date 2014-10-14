<?php $img_link = base_url() . "/assets/images"; ?>

<?php $q = $query; ?>
<?php
foreach ($query as $row) {
    $tahun = $row->tahun;
}
if(is_array($tahun)) $tahun = "";

?>
<h3>&nbsp;Luas Afdeling <?php echo $tahun; ?></h3>

<table style="width: 380px;" id="rounded-corner" summary="User">
    <thead>
        <tr>
            <th width="56%" class="rounded-company">Kebun</th>
            <th>Afdeling</th>
            <th>Luas (ha)</th>
            <th width="25%" class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="3" class="rounded-foot-left"><em>Luas Afdeling | SMS - Based IS</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if ($rows == 0): ?>
        <tr>
            <td colspan='4' align='center'><span id='red'>Data tidak tersedia</span></td>
        </tr>
    <?php else: ?>
    <?php $i = 0; ?>
    <?php foreach ($q as $row): ?>
                <tbody>
        <?php $i++; ?>
        <?php if ($i % 2 == 0): ?>
                    <tr>
            <?php else: ?>
                    <tr class="even">
            <?php endif; ?>
                        <?php $data = $this->afdeling_model->get_kebun_name($row->kebun);?>
                        <td><?php echo $data->nama_kebun; ?></td>
                        <td><?php echo $this->fungsi->toRomawi($row->afdeling); ?></td>
                        <td><?php echo $row->luas; ?></td>
                        <td>
                            <?php if (is_logged_in ()):?>
                            <a href="#" class="edit_la" id="<?php echo $row->id; ?>" kebun="<?php echo $row->kebun; ?>" afdeling="<?php echo $row->afdeling; ?>" luas="<?php echo $row->luas; ?>" tahun="<?php echo $row->tahun; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
                            <a href="#" class="delete_la" id="<?php echo $row->id; ?>" kebun="<?php echo $row->kebun; ?>" tahun="<?php echo $row->tahun; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a>
                            <?php endif;?>
                        </td> 
                    </tr>
                </tbody>
    <?php endforeach; ?>
    <?php endif; ?>
</table>
<?php
function setNum($str){
    return number_format($str,0,',','.');
}
?>