<?php
    $data = $this->member_model->get_kebun_name($row->kebun_unit);
    $str_kebun = $data->nama_kebun;
?>
<div align="center" id="dialog-box" title="Member Details">
    <table id="dialog-table">
        <tr>
            <td>Register</td>
            <td><?php echo $row->register;?></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><?php echo $row->no_ponsel;?></td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td><?php echo $row->nama_lengkap;?></td>
        </tr>
        <tr>
            <td>Kebun</td>
            <td><?php echo $str_kebun?></td>
        </tr>
        <tr>
            <td>Afdeling</td>
            <td><?php echo $this->fungsi->toRomawi($row->afdeling);?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td><?php echo $row->jabatan;?></td>
        </tr>
    </table>
</div>
