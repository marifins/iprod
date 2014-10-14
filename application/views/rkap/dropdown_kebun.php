<?php

$options2 = "";
$options2[''] = "- - Kebun - -";

foreach($kebun as $t){
    $options2[$t->no_rek] = $t->nama_kebun;
}
?>
<?php echo form_label('Kebun', 'kbn');?><br />
<?php echo form_dropdown('kbn', $options2, '', 'id = kbn');?>