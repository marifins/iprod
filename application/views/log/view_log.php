<?php
function toRomawi($str){
    $int = array('1','1a','1b','2','3','4','5','6','7','8','9','10');
    $romawi = array('I','IA','IB','II','III','IV','V','VI','VII','VIII','IX','X');

    for($i=0; $i<10; $i++){
        if($str == $int[$i])
        {
            return $romawi[$i];
        }
    }
}

function setNum($str){
    return number_format($str,0,',','.');
}
?>

<div>
<ul id="pagination-digg"><?php echo $page_links;?></ul>
</div>
<br /><br />
<div class="fRight" style="margin: -45px 8px 0 0;">
    <button id="create-log">Add Produksi</button>
</div>
<div id="show">
    <?php $this->load->view('log/show_log'); ?>
</div>

<?php

$kebun = $this->log_model->get_kebun_all();
$options = "";
$options[''] = "- - Kebun - -";

foreach ($kebun as $t) {
    $options[$t->no_rek] = $t->nama_kebun;
}

$options2 = "";
$options2[''] = "- - Afdeling - -";

for($i = 1; $i <= 10; $i++){
    $options2[$i] = $i;
}

$options3 = "";
$options3[''] = "- - Bulan- -";

for ($i = 1; $i <= 12; $i++) {
    $options3[$i] = $this->fungsi->bulan($i);
}
?>
<?php
$data_tgl = array(
    'name' => 'date_log',
    'id' => 'date_log',
    'maxlength' => '10',
    'size' => '10',
);
?>
<div id="form-log" title="Input Data Produksi">
    <p class="validateTips">All form fields are required.</p>
    <table id ="log" width="100%" cellpadding="0" cellspacing="0">
        <?php
        echo form_open();
        ?>
        <?php echo form_hidden('form_sent', '');?>
        <tr>
            <td>
                <?php
                $data = array(
                    'name' => 'id_log',
                    'id' => 'id_log',
                );
                ?>
                <?php echo form_input($data);?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Tanggal', 'tanggal'); ?></td>
            <td>
                <?php echo form_input($data_tgl); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Kebun', 'kebun');?></td>
            <td>
                <?php echo form_dropdown('kebun', $options, '', 'id=kebun_log');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Afdeling', 'afdeling');?></td>
            <td>
                <?php echo form_dropdown('afdeling', $options2, '', 'id=afdeling');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Estimasi TBS', 'estimasi');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'estimasi',
                    'id' => 'estimasi',
                    'maxlength' => '5',
                    'size' => '5',
                );
                ?>
                <?php echo form_input($data); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Realisasi TBS', 'realisasi');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'realisasi',
                    'id' => 'realisasi',
                    'maxlength' => '5',
                    'size' => '5',
                );
                ?>
                <?php echo form_input($data); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Brondolan', 'brondolan');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'brondolan',
                    'id' => 'brondolan',
                    'maxlength' => '4',
                    'size' => '4',
                );
                ?>
                <?php echo form_input($data);?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('HK Dinas', 'hk_dinas');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'hk_dinas',
                    'id' => 'hk_dinas',
                    'maxlength' => '3',
                    'size' => '3',
                );
                ?>
                <?php echo form_input($data);?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('HK BHL', 'hk_bhl');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'hk_bhl',
                    'id' => 'hk_bhl',
                    'maxlength' => '3',
                    'size' => '3',
                );
                ?>
                <?php echo form_input($data); ?>
            </td>
        </tr>
        <?php echo form_close('');?>
    </table>
</div>
<div id="dialog2" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="id" name="id">
	Are you sure?
    </p>
</div>
