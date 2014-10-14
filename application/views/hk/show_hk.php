<?php $img_link = base_url() . "/assets/images"; ?>

<?php $q = $query; ?>
<?php
$bulan = "";
foreach ($q as $row) {
    $tahun = $row->tahun;
}
if(is_array($tahun)) $tahun = "";
if($bulan != "")$bulan = $this->fungsi->bulan($bulan);
?>
<br />
<h3>&nbsp;HK Tahun <?php echo $tahun; ?> </h3>

<table style="width: 315px;" id="rounded-corner" summary="User">
    <thead>
        <tr>
            <th width="27%" class="rounded-company">Tahun</th>
            <th>Bulan</th>
            <th>Hari Kerja</th>
            <th width="18%" class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="3" class="rounded-foot-left"><em>RKO Afdeling | SMS - Based IS</em></td>
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
                        <td><?php echo $row->tahun; ?></td>
                        <td><?php echo $this->fungsi->bulan($row->bulan); ?></td>
                        <td><?php echo $row->jlh_hari; ?></td>
                        <td>
                            <?php if (is_logged_in ()):?>
                            <a href="#" class="edit_hk" id="<?php echo $row->id; ?>" jlh_hari="<?php echo $row->jlh_hari; ?>" tahun="<?php echo $row->tahun; ?>" bulan="<?php echo $row->bulan; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
                            <a href="#" class="delete_hk" id="<?php echo $row->id; ?>" tahun="<?php echo $row->tahun; ?>" bulan="<?php echo $row->bulan; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a></td>
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