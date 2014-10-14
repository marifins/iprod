<?php
$id = '';
$afdeling = '';
$realisasi_tbs = '';
$brondolan = '';
$hk_dinas = '';
$hk_bhl = '';
$tanggal = '';
if(isset($result))
{
    foreach($result as $karpim) {
        $id = $karpim->id;
        $realisasi_tbs = $karpim->nama;
        $brondolan = $karpim->jabatan;
        $hk_dinas = $karpim->gol;
        $hk_bhl = $karpim->bagian;
        $afdeling = $karpim->kebun_unit;
    }
}

function toRomawi($str){
    $int = array('1','1a','1b','2','3','4','5','6','7','8','9','10');
    $romawi = array('I','IA','IB','II','III','IV','V','VI','VII','VIII','IX','X');

    for($i=0; $i<12; $i++){
        if($str == $int[$i])
        {
            return $romawi[$i];
        }
    }
}

$options = "";
$options[''] = "- - Pilihan - -";
if($afd_rows > 0){
    foreach($afd as $k){
        $options[$k->afdeling] = toRomawi($k->afdeling);
    }
}else{
    $options[''] = "Selesai - Pilih Tanggal Lain";
}

?>
<?php
$data_tgl = array(
    'name' => 'tanggal',
    'id' => 'date2',
    'value' => (isset($id) && $id != '') ? $tanggal : set_value('tanggal'),
    'maxlength' => '10',
    'size' => '10',
    'class' => 'date_input',
);
?>
<div id="filterBox">
    <table width="100%" cellpadding="0" cellspacing="0">
        <?php
        if(isset($id) && $id != ''){
           $url = 'master/update/' .$id;
        }
        else
        {
            $url = 'produksi/insert';
        }
        ?>
        <?php
        $attributes = array('class' => '', 'id' => 'form_peminjaman');
        echo form_open(base_url().$url, $attributes);
        ?>
        <?php echo form_hidden('form_sent', '');?>
        <tr>
            <td>
                <?php
                $data = array(
                    'name' => 'id',
                    'value' => (isset($id) && $id != '') ? $id : set_value('id'),
                );
                ?>
                <?php echo form_hidden($data);?>
                <?php echo form_error('id');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Tanggal', 'tanggal'); ?></td>
            <td>
                <?php echo form_input($data_tgl); ?>
                <?php echo form_error('tanggal'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Afdeling', 'afdeling');?></td>
            <td>
                <?php echo form_dropdown('afdeling', $options, (isset($id) && $id != '') ? $afdeling : set_value('afdeling'));?>
                <?php echo form_error('afdeling');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Realisasi TBS', 'realisasi_tbs');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'realisasi_tbs',
                    'value' => (isset($id) && $id != '') ? $realisasi_tbs : set_value('realisasi_tbs'),
                    'maxlength' => '5',
                    'size' => '5',
                );
                ?>
                <?php echo form_input($data); echo " Kg"?>
                <?php echo form_error('realisasi_tbs');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('Brondolan', 'brondolan');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'brondolan',
                    'value' => (isset($id) && $id != '') ? $brondolan : set_value('brondolan'),
                    'maxlength' => '4',
                    'size' => '4',
                );
                ?>
                <?php echo form_input($data); echo " Kg"; ?>
                <?php echo form_error('brondolan');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('HK Dinas', 'hk_dinas');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'hk_dinas',
                    'value' => (isset($id) && $id != '') ? $hk_dinas : set_value('hk_dinas'),
                    'maxlength' => '3',
                    'size' => '3',
                );
                ?>
                <?php echo form_input($data); echo " HK";?>
                <?php echo form_error('hk_dinas');?>
            </td>
        </tr>
        <tr>
            <td><?php echo form_label('HK BHL', 'hk_bhl');?></td>
            <td>
                <?php
                $data = array(
                    'name' => 'hk_bhl',
                    'value' => (isset($id) && $id != '') ? $hk_bhl : set_value('hk_bhl'),
                    'maxlength' => '3',
                    'size' => '3',
                );
                ?>
                <?php echo form_input($data); echo " HK";?>
                <?php echo form_error('hk_bhl');?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <?php $img_link = base_url()."/assets/images";?>
                <div class="fLeft btnMargin"><a href="<?=base_url();?>produksi"><?php echo img($img_link.'/cancel_btn_03.png', TRUE);?></a></div>
                <div class="fLeft"><input type="image" src="<?=$img_link?>/save_btn_06.png" id="no_border" /></div>
            </td>
        </tr>
        <?php echo form_close('');?>
    </table>
</div>
