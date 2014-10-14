<div id="filterBox">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>Nomor SPK</td>
            <td><?php echo $result->no_spk;?></td>
        </tr>
        <tr>
            <td>Kebun</td>
            <td><?php echo $result->kebun;?></td>
        </tr>
        <tr>
            <td>Pemborong</td>
            <td><?php echo $result->pemborong;?></td>
        </tr>
        <tr>
            <td>Rekening Pekerjaan</td>
            <td><?php echo $result->rekening;?></td>
        </tr>
        <tr>
            <td>Dasar Pekerjaan</td>
            <td><?php echo $result->dasar;?></td>
        </tr>
        <tr>
            <td>Jenis Pekerjaan</td>
            <td><?php echo $result->jenis;?></td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td><?php echo $result->tempat;?></td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td><?php echo $result->lokasi;?></td>
        </tr>
        <tr>
            <td>Tahun Tanam</td>
            <td><?php echo $result->thn_tanam;?></td>
        </tr>
        <tr>
            <td>Mulai Dikerjakan</td>
            <td><?php echo $result->mulai;?></td>
        </tr>
        <tr>
            <td>Selesai Dikerjakan</td>
            <td><?php echo $result->selesai;?></td>
        </tr>
        <tr>
            <td>Dasar Harga</td>
            <td><?php echo $result->dasar_harga;?></td>
        </tr>
        <tr>
            <td>Pisik</td>
            <td><?php echo $result->pisik;?></td>
        </tr>
        <tr>
            <td>Harga Satuan</td>
            <td><?php echo "Rp. " .$result->harga_satuan;?></td>
        </tr>
        <tr>
            <td>PPN (Rp)</td>
            <td><?php echo "Rp. " .$result->ppn_rp;?></td>
        </tr>
        <tr>
            <td>Nilai SPK</td>
            <td><?php echo "Rp. " .$result->nilai_spk;?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><a href="<?=base_url();?>spk">Back</a></td>
        </tr>
    </table>
</div>