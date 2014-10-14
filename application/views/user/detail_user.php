<?php
function userStr($id){
    if($id == "1") return "Operator";
    else if($id == "2") return "Administrator";
    else return "none";
}
?>
<div align="center" id="dialog-box" title="User Details">
    <table id="dialog-table">
        <tr>
            <td>Register</td>
            <td><?php echo $row->register;?></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><?php echo $row->username;?></td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td><?php echo $row->nama_lengkap;?></td>
        </tr>
        <tr>
            <td>Level</td>
            <td><?php echo userStr($row->level);?></td>
        </tr>
    </table>
</div>
