<div>
<ul id="pagination-digg"><?php echo $page_links;?></ul>
</div>
<div class="fRight" style="margin: -36px 9px 0 0">
    <button id="create-user">Create new user</button>
</div>
<div id="show">
    <?php $this->load->view('user/show_user'); ?>
</div>

<?php
$options = "";
$options[''] = "- - Pilihan - -";
if($rows_level > 0){
    foreach($status as $l){
        $options[$l->id_level] = $l->nama_level;
    }
}else{
    $options[''] = "Selesai - Pilih Tanggal Lain";
}
?>
<!-- Form User-->
    <div id="dialog-form" title="Create New User">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            $attributes = array('class' => '', 'name' => 'form_user');
            echo form_open("user/submit");
        ?>
     
         <?php
            $data = array(
                'name' => 'register_old',
                'id' => 'register_old',
                'value' => (isset($register) && $register != '') ? $register : set_value('register_old'),
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_hidden($data);?>
        <?php echo form_label('No. Register', 'register');?>
        <?php
            $data = array(
                'name' => 'register',
                'id' => 'register',
                'value' => (isset($register) && $register != '') ? $register : set_value('register'),
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('Nama Lengkap', '');?>
        <?php
              $data = array(
                  'name' => 'nama_lengkap',
                  'id' => 'nama_lengkap',
                  'value' => (isset($register) && $register != '') ? $nama_lengkap : set_value('nama_lengkap'),
                  'maxlength' => '35',
                  'size' => '35',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('Username', 'username');?>
        <?php
              $data = array(
                  'name' => 'username',
                  'id' => 'username',
                  'value' => (isset($register) && $register != '') ? $username : set_value('username'),
                  'maxlength' => '25',
                  'size' => '25',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>

        <?php
        $attr = array('id' => 'lblpass');
        ?>
        <?php echo form_label('Password', 'password', $attr);?>
        <?php
              $data = array(
                  'name' => 'password',
                  'id' => 'password',
                  'value' => (isset($register) && $register != '') ? $password : set_value('password'),
                  'maxlength' => '25',
                  'size' => '25',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_password($data);?>

        <?php
        $attr = array('id' => 'lblrepass');
        ?>
        <?php echo form_label('Re-Password', 'repassword', $attr);?>
        <?php
              $data = array(
                  'name' => 'repassword',
                  'id' => 'repassword',
                  'value' => (isset($register) && $register != '') ? $repassword : set_value('repassword'),
                  'maxlength' => '25',
                  'size' => '25',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_password($data);?>

        <?php echo form_label('Privilege', 'privilege');?><br />
        <?php echo form_dropdown('privilege', $options, (isset($register) && $register != '') ? $options : set_value('privilege'),'id = level');?>
        
        <?php echo form_close('');?>
    </div>
<div id="dialog-confirm" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="no_register" name="no_register">
	Are you sure?
    </p>
</div>
