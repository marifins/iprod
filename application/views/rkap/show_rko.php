<?php $img_link = base_url() . "/assets/images"; ?>

<?php $q = $query_rko; ?>
<?php
$bulan = "";
foreach ($q as $row) {
    $tahun = $row->tahun;
    $bulan = $row->bulan;
}
if(is_array($tahun)) $tahun = "";
if($bulan != "")$bulan = $this->fungsi->bulan($bulan);
?>
<br />
<h3>&nbsp;RKO <?php echo $bulan ." ". $tahun; ?></h3>

<table style="width: 430px;" id="rounded-corner" summary="User">
    <thead>
        <tr>
            <th width="56%" class="rounded-company">Kebun</th>
            <th>RKAP</th>
            <th>RKO</th>
            <th width="25%" class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="3" class="rounded-foot-left"><em>RKO Produksi | SMS - Based IS</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if ($rows_rko == 0): ?>
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
                        <?php $data = $this->rkap_model->get_kebun_name($row->kebun);?>
                        <td><?php echo $data->nama_kebun; ?></td>
                        <td><?php echo num($row->rkap); ?></td>
                        <td><?php echo num($row->rko); ?></td>
                        <td>
                            <?php if (is_logged_in ()):?>
                            <a href="#" class="edit_rko" id="<?php echo $row->id; ?>" kebun="<?php echo $row->kebun; ?>" rkap="<?php echo $row->rkap; ?>" rko="<?php echo $row->rko; ?>" tahun="<?php echo $row->tahun; ?>" bulan="<?php echo $row->bulan; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
                            <a href="#" class="delete_rko" id="<?php echo $row->id; ?>" tahun="<?php echo $row->tahun; ?>" bulan="<?php echo $row->bulan; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a></td>
                            <?php endif;?>
                    </tr>
                </tbody>
    <?php endforeach; ?>
    <?php endif; ?>
</table>
<?php
function num($str){
    return number_format($str,0,',','.');
}
?>