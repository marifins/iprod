<div>
<ul id="pagination-digg"><?php echo $page_links;?></ul>
</div>
<div class="fRight" style="margin: -36px 9px 0 0">
    <button id="create-member">New Member</button>
</div>
<div id="show">
    <?php $this->load->view('member/show_member'); ?>
</div>

<?php
$options = "";
$options[''] = "- - Pilihan - -";
foreach($kebun as $k){
    $options[$k->no_rek] = $k->nama_kebun;
}

$int = array('1', '1a', '1b', '2', '3', '4', '5', '6', '7', '8', '9', '10');
$romawi = array('I', 'IA', 'IB', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X');

$option_afd = "";
$option_afd[''] = "- - Afdeling - -";
for($i=0; $i<count($int); $i++){
    $option_afd[$int[$i]] = $romawi[$i];
}
?>
<!-- Form Member-->
    <div id="form-member" title="Create New Member">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            echo form_open();
        ?>
        <?php echo form_label('No. Register', 'register');?>
        <?php
            $data = array(
                'name' => 'register',
                'id' => 'register_member',
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('No. Ponsel', 'no_ponsel');?>
        <?php
              $data = array(
                  'name' => 'no_ponsel',
                  'id' => 'no_ponsel',
                  'maxlength' => '15',
                  'size' => '15',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('Nama Lengkap', 'nama_member');?>
        <?php
              $data = array(
                  'name' => 'nama_member',
                  'id' => 'nama_member',
                  'maxlength' => '27',
                  'size' => '27',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>

       <?php echo form_label('Kebun Unit', 'kebun_unit');?><br />
       <?php echo form_dropdown('kebun_unit', $options, '','id = kebun_unit');?>
       <br />
       <?php echo form_label('Afdeling', 'afd_member');?><br />
       <?php echo form_dropdown('afd_member', $option_afd, '','id = afd_member');?>
       <br />

        <?php echo form_label('Jabatan', 'jabatan');?>
        <?php
              $data = array(
                  'name' => 'jabatan',
                  'id' => 'jabatan',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>
        
        <?php echo form_close('');?>
    </div>
<div id="dialog3" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="no_register" name="no_register">
	Are you sure?
    </p>
</div>
