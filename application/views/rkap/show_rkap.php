<?php $img_link = base_url() . "/assets/images"; ?>

<?php $q = $query; ?>
<?php
foreach ($query as $row) {
    $tahun = $row->tahun;
}
if(is_array($tahun)) $tahun = "";

?>
<h3>&nbsp;RKAP <?php echo $tahun; ?></h3>

<table style="width: 330px;" id="rounded-corner" summary="User">
    <thead>
        <tr>
            <th width="56%" class="rounded-company">Kebun</th>
            <th>RKAP</th>
            <th width="25%" class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="2" class="rounded-foot-left"><em>RKAP Produksi | SMS - Based IS</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if ($rows == 0): ?>
        <tr>
            <td colspan='3' align='center'><span id='red'>Data tidak tersedia</span></td>
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
                        <?php $data = $this->rkap_model->get_kebun_name($row->kebun);?>
                        <td><?php echo $data->nama_kebun; ?></td>
                        <td><?php echo setNum($row->rkap); ?></td>
                        <td>
                            <?php if (is_logged_in ()):?>
                            <a href="#" class="edit_rkap" id="<?php echo $row->id; ?>" kebun="<?php echo $row->kebun; ?>" rkap="<?php echo $row->rkap; ?>" tahun="<?php echo $row->tahun; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
                            <a href="#" class="delete_rkap" id="<?php echo $row->id; ?>" tahun="<?php echo $row->tahun; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a>
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