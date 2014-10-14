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
<h3>&nbsp;RKO <?php echo $bulan ." ". $tahun; ?> per Afdeling</h3>

<table style="width: 430px;" id="rounded-corner" summary="User">
    <thead>
        <tr>
            <th width="56%" class="rounded-company">Kebun</th>
            <th>Afdeling</th>
            <th>RKAP (ton)</th>
            <th>RKO (ton)</th>
            <th width="27%" class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="4" class="rounded-foot-left"><em>RKO Afdeling | SMS - Based IS</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if ($rows_rko == 0): ?>
        <tr>
            <td colspan='5' align='center'><span id='red'>Data tidak tersedia</span></td>
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
                        <td><?php echo num($row->rkap); ?></td>
                        <td><?php echo num($row->rko); ?></td>
                        <td>
                            <?php if (is_logged_in ()):?>
                            <a href="#" class="edit_af" id="<?php echo $row->id; ?>" kebun="<?php echo $row->kebun; ?>" afdeling="<?php echo $row->afdeling; ?>" rkap="<?php echo $row->rkap; ?>" rko="<?php echo $row->rko; ?>" tahun="<?php echo $row->tahun; ?>" bulan="<?php echo $row->bulan; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
                            <a href="#" class="delete_af" id="<?php echo $row->id; ?>" tahun="<?php echo $row->tahun; ?>" bulan="<?php echo $row->bulan; ?>" kebun="<?php echo $row->kebun; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a></td>
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