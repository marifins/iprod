<?php
if ($row == null):
    ?>
    <div align="center" id="dialog-box" title="Informasi">
        <p>Data Total Produksi PT Perkebunan Nusantara I (Persero)</p>
        <p>Tanggal : <?php echo $tgl; ?></p>
        <p>belum ada pada database.</p>
    </div>
<?php else: ?>
    <div align="center" id="dialog-box" title="Total | <?php echo $tgl; ?>">
        <b>Total Data Produksi <br /> <?php echo $tgl; ?></b>
        <br />
        <table style="width: 180px;">
            <tr>
                <td>Telling</td><td>:</td>
                <td><?php echo $this->fungsi->setNum($row->telling); ?></td>
            </tr>
            <tr>
                <td>Estimasi</td><td>:</td>
                <td><?php echo $this->fungsi->setNum($row->estimasi); ?></td>
            </tr>
            <tr>
                <td>Realisasi</td><td>:</td>
                <td><?php echo $this->fungsi->setNum($row->realisasi); ?></td>
            </tr>
            <tr>
                <td>Brondolan</td><td>:</td>
                <td><?php echo $this->fungsi->setNum($row->brondolan); ?></td>
            </tr>
            <tr>
                <td>Sisa</td><td>:</td>
                <td><?php echo $this->fungsi->setNum($row->sisa); ?></td>
            </tr>
            <tr>
                <td>HK Dinas</td><td>:</td>
                <td><?php echo $this->fungsi->setNum($row->hk_dinas); ?></td>
            </tr>
            <tr>
                <td>HK BHL</td><td>:</td>
                <td><?php echo $this->fungsi->setNum($row->hk_bhl); ?></td>
            </tr>
        </table>

    </div>
<?php endif; ?>
