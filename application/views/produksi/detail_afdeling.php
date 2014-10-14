<?php
$kbn = $this->produksi_model->get_kebun_name($kebun);
$t_telling = 0;
$t_estimasi = 0;
$t_realisasi = 0;
$t_brondolan = 0;
$t_sisa = 0;
$t_ch = 0;
$t_dinas = 0;
$t_bhl = 0;

if ($row == null):
    ?>
    <div align="center" id="dialog-box" title="Informasi">
        <p>Data Afdeling</p>
        <p>Kebun : <?php echo $kbn->nama_kebun; ?></p>
        <p>Tanggal : <?php echo $tgl; ?></p>
        <p>belum ada pada database.</p>
    </div>
<?php else: ?>
    <div align="center" id="dialog-box" title="<?php echo $kbn->nama_kebun; ?> | <?php echo $tgl; ?>">
        <?php if ($kebun == '080.04'): ?>
            <h3>Kelapa Sawit</h3><br />
        <?php endif; ?>
        <table id="dialog-details-afd">
            <tr>
                <th>Afd.</th>
                <th>Telling</th>
                <th>Estimasi</th>
                <th>Realisasi</th>
                <th>Brondolan</th>
                <th>Sisa</th>
                <th>C.Hujan</th>
                <th>Dinas</th>
                <th>BHL</th>
            </tr>
            <?php $i = 0;?>
            <?php foreach ($row as $r): ?>
                <?php
                    $i++;
                    $t_telling += $r->telling;
                    $t_estimasi += $r->estimasi;
                    $t_realisasi += $r->realisasi;
                    $t_brondolan += $r->brondolan;
                    $t_sisa += $r->sisa;
                    $t_dinas += $r->hk_dinas;
                    $t_bhl += $r->hk_bhl;
                    ?>
                <tr>
                    <td><?php echo toRomawi($r->afdeling); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->telling); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->estimasi); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->realisasi); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->brondolan); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->sisa); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->curah_hujan); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->hk_dinas); ?></td>
                    <td><?php echo $this->fungsi->setNum($r->hk_bhl); ?></td>
                    <?php
                        if($kebun == '080.04'){
                            if($i == 2) break;
                        }
                    ?>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td><b>Total</b></td>
                    <td><b><?php echo $this->fungsi->setNum($t_telling);?></b></td>
                    <td><b><?php echo $this->fungsi->setNum($t_estimasi);?></b></td>
                    <td><b><?php echo $this->fungsi->setNum($t_realisasi);?></b></td>
                    <td><b><?php echo $this->fungsi->setNum($t_brondolan);?></b></td>
                    <td><b><?php echo $this->fungsi->setNum($t_sisa);?></b></td>
                    <td><b>N/A</b></td>
                    <td><b><?php echo $this->fungsi->setNum($t_dinas);?></b></td>
                    <td><b><?php echo $this->fungsi->setNum($t_bhl);?></b></td>
                </tr>
        </table>

        <?php if ($kebun == '080.04'): ?>
        <br /><h3>Karet</h3><br />
            <table id="dialog-details-afd">
                <tr>
                    <th>Afd.</th>
                    <th>Realisasi</th>
                    <th>Basah</th>
                    <th>Kering</th>
                    <th>DRC</th>
                    <th>C. Hujan</th>
                    <th>Dinas</th>
                    <th>BHL</th>
                </tr>
                <?php $i = 0;?>
                <?php foreach ($row as $r): ?>
                <?php $i++;?>
                <?php if($i > 2):?>
                    <tr>
                        <td><?php echo toRomawi($r->afdeling); ?></td>
                        <td><?php echo $r->realisasi; ?></td>
                        <td><?php echo ""; ?></td>
                        <td><?php echo ""; ?></td>
                        <td><?php echo ""; ?></td>
                        <?php //DRC = (kering / basah) * 100 %?>
                        <td><?php echo $r->curah_hujan; ?></td>
                        <td><?php echo $r->hk_dinas; ?></td>
                        <td><?php echo $r->hk_bhl; ?></td>
                    </tr>
                <?php endif;?>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

    </div>
<?php endif; ?>
<?php

function toRomawi($str) {
    $int = array('1', '1a', '1b', '2', '3', '4', '5', '6', '7', '8', '9', '10');
    $romawi = array('I', 'IA', 'IB', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X');

    for ($i = 0; $i < 12; $i++) {
        if ($str == $int[$i]) {
            return $romawi[$i];
        }
    }
}
?>