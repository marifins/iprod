<?php
function toRomawi($str){
    $int = array('1','2','3','4','5','6','7','8','9','10');
    $romawi = array('I','II','III','IV','V','VI','VII','VIII','IX','X');

    for($i=0; $i<10; $i++){
        if($str == $int[$i])
        {
            return $romawi[$i];
        }
    }
}
?>
<div align="center" id="dialog-box" title="Log Entry Details">
    <table id="dialog-table">
        <tr>
            <td>ID</td>
            <td><?php echo $row->id;?></td>
        </tr>
        <tr>
            <td>Kebun</td>
            <td><?php echo $row->nama_kebun;?></td>
        </tr>
        <tr>
            <td>Afdeling</td>
            <td><?php echo toRomawi($row->afdeling);?></td>
        </tr>
        <tr>
            <td>Estimasi</td>
            <td><?php echo $row->estimasi;?></td>
        </tr>
        <tr>
            <td>Realisasi</td>
            <td><?php echo $row->realisasi;?></td>
        </tr>
        <tr>
            <td>Brondolan</td>
            <td><?php echo $row->brondolan;?></td>
        </tr>
        <tr>
            <td>HK Dinas</td>
            <td><?php echo $row->hk_dinas;?></td>
        </tr>
        <tr>
            <td>HK BHL</td>
            <td><?php echo $row->hk_bhl;?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td><?php echo $row->tanggal;?></td>
        </tr>
    </table>
</div>
