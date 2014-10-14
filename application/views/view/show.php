
<?php $img_link = base_url() . "/assets/images"; ?>
<?php $q = $query; ?>

<?php if($kebun == '080.04'):?>
<center><h4>&nbsp;Produksi Kelapa Sawit</h4></center>
<?php endif;?>

<table id="rounded-corner" summary="View">
    <thead>
        <tr>
            <th width="5%" class="rounded-company">Afd.</th>
            <th>Estimasi</th>
            <th>Realisasi</th>
            <th>Brondolan</th>
            <th>Sisa</th>
            <th>Curah Hujan</th>
            <th>Dinas</th>
            <th class="rounded-q4">BHL</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="7" class="rounded-foot-left"><em>Produksi Kelapa Sawit | SMS - Based Information System Fresh Fruit Bunch (FFB) Production</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if ($rows == 0): ?>
        <tr>
            <td colspan='7' align='center'><span id='red'>Data tidak tersedia</span></td>
        </tr>
    <?php elseif (empty($q)): ?>
        <tr>
            <td colspan='8' align='center'><span id='red'>Silahkan pilih Kebun dan Tanggal</span></td>
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
                    <td><?php echo $this->fungsi->toRomawi($row->afdeling); ?></td>
                    <td><?php echo $this->fungsi->setNum2($row->estimasi); ?></td>
                    <td><?php echo $this->fungsi->setNum2($row->realisasi); ?></td>
                    <td><?php echo $this->fungsi->setNum2($row->brondolan); ?></td>
                    <td><?php echo $this->fungsi->setNum2($row->sisa); ?></td>
                    <td><?php echo $this->fungsi->setCH($row->curah_hujan); ?></td>
                    <td><?php echo $row->hk_dinas; ?></td>
                    <td><?php echo $row->hk_bhl; ?></td>
                    <?php 
                        if($kebun == '080.04'){
                            if($i == 2) break;
                        }
                    ?>
                </tr>
            </tbody>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<?php if ($kebun == '080.04'): ?>
    <br /><br />
    <center><h4>&nbsp;Produksi Karet</h4></center>
    <table id="rounded-corner" summary="View">
        <thead>
            <tr>
                <th width="5%" class="rounded-company">Afd.</th>
                <th>Realisasi</th>
                <th>Curah Hujan</th>
                <th>Dinas</th>
                <th class="rounded-q4">BHL</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="4" class="rounded-foot-left"><em>Produksi Karet | SMS - Based Information System Fresh Fruit Bunch (FFB) Production</em></td>
                <td class="rounded-foot-right">&nbsp;</td>
            </tr>
        </tfoot>
        <?php if (empty($q)): ?>
            <tr>
                <td colspan='6' align='center'><span id='red'>Silahkan pilih Kebun dan Tanggal</span></td>
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
                        <?php if ($i > 2): ?>
                            <td><?php echo $this->fungsi->toRomawi($row->afdeling); ?></td>
                            <td><?php echo $this->fungsi->setNum2($row->realisasi); ?></td>
                            <td><?php echo $this->fungsi->setCH($row->curah_hujan); ?></td>
                            <td><?php echo $row->hk_dinas; ?></td>
                            <td><?php echo $row->hk_bhl; ?></td>
                        <?php endif; ?>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
<?php endif; ?>
