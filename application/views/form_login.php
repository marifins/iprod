<?php echo form_open("user/submit"); ?>

<?php echo form_label('Username', 'register'); ?>
<?php
$data = array(
    'name' => 'register',
    'id' => 'register_login',
    'maxlength' => '18',
    'size' => '18',
    'class' => 'text ui-widget-content ui-corner-all',
);
?>
<?php echo form_input($data); ?>

<?php echo form_label('Password', 'password'); ?>
<?php
$data = array(
    'name' => 'password',
    'id' => 'password_login',
    'maxlength' => '18',
    'size' => '18',
    'class' => 'text ui-widget-content ui-corner-all',
);
?>
<?php echo form_password($data); ?>

<?php echo form_close(''); ?>
