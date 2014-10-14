<script type='text/javascript'>
    function simpan()
    {

       send_form_loading(document.form_user,'user/insert','#temp');

    }
</script>
<?php
$register = '';
$username = '';
$password = '';
$nama_lengkap = '';
$level = '';
$tanggal = '';
if(isset($row))
{
        $register = $row->register;
        $username = $row->username;
        $password = $row->password;
        $nama_lengkap = $row->nama_lengkap;
        $level = $row->level;
}

$options = "";
$options[''] = "- - Pilihan - -";
if($rows_level > 0){
    foreach($status as $l){
        $options[$l->nama_level] = $l->nama_level;
    }
}else{
    $options[''] = "Selesai - Pilih Tanggal Lain";
}

?>

<div id="dialog-form" title="New User">
    <table id="dialog-table">
        <?php
        if(isset($register) && $register != ''){
           $url = 'user/update/' .$register;
        }
        else
        {
            $url = 'user/insert';
        }
        ?>
        <?php
        $attributes = array('class' => '', 'name' => 'form_user');
        echo form_open(base_url().$url, $attributes);
        ?>
        <?php echo form_hidden('form_sent', '');?>
        <?php if(isset($register) && $register != ''):?>
        <tr>
            <td><?php echo form_label('No. Register', 'register'); ?></td>
            <td>
                <?php echo $register;?>
            </td>
        </tr>
        <?php else:?>
        <tr>
            <td><?php echo form_label('No. Register', 'register');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'register',
                    'value' => (isset($register) && $register != '') ? $register : set_value('register'),
                    'maxlength' => '18',
                    'size' => '18',
                );
                ?>
                <?php echo form_input($data);?>
                <?php echo form_error('register');?>
            </td>
        </tr>
        <?php endif;?>
        <tr>
            <td><?php echo form_label('Username', 'username');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'username',
                    'value' => (isset($register) && $register != '') ? $username : set_value('username'),
                    'maxlength' => '25',
                    'size' => '25',
                );
                ?>
                <?php echo form_input($data);?>
                <?php echo form_error('username');?>
            </td>
        </tr>
        <?php if(isset($register) && $register != ''):?>
        <?php else:?>
        <tr>
            <td><?php echo form_label('Password', 'password');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'password',
                    'value' => (isset($register) && $register != '') ? $password : set_value('password'),
                    'maxlength' => '25',
                    'size' => '25',
                );
                ?>
                <?php echo form_password($data);?>
                <?php echo form_error('password');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Re-Password', 'repassword');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'repassword',
                    'value' => (isset($register) && $register != '') ? $repassword : set_value('repassword'),
                    'maxlength' => '25',
                    'size' => '25',
                );
                ?>
                <?php echo form_password($data);?>
                <?php echo form_error('repassword');?>
            </td>
        </tr>
        <?php endif;?>
         <tr>
            <td><?php echo form_label('Nama Lengkap', '');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'nama_lengkap',
                    'value' => (isset($register) && $register != '') ? $nama_lengkap : set_value('nama_lengkap'),
                    'maxlength' => '35',
                    'size' => '35',
                );
                ?>
                <?php echo form_input($data);?>
                <?php echo form_error('nama_lengkap');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Privilege', 'privilege');?></td>
            <td>
                <?php echo form_dropdown('privilege', $options, (isset($register) && $register != '') ? $options : set_value('privilege'));?>
                <?php echo form_error('privilege');?>
            </td>
        </tr>
        <tr>
            <td>
                <a href="javascript:void(0);" onclick='simpan();'>Simpan</a>
            </td>
        </tr>
        <?php echo form_close('');?>
    </table>
</div>
