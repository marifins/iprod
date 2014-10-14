<?php
    $q = $query;
    $tgl = "";
    foreach($q as $r){
        $tgl = $r->tanggal;
    }
?>
<?php
    $options = "";
    $options[''] = "Pilih Kebun";
    foreach($allkebun as $k){
        $options[$k->no_rek] = $k->nama_kebun;
    }

    $d = array(
        'name' => 'tanggal',
        'id' => 'dateview',
        'value' => '',
        'maxlength' => '10',
        'size' => '10',
        'class' => 'date_vp',
    );
?>
<?php $img_link = base_url()."/assets/images";?>
<div class="fLeft">
    <?php
        echo form_dropdown('kebun', $options, '', 'id=kebun');
        echo form_input($d);
    ?>
</div>
<?php if (is_logged_in ()):?>

<?php endif;?>
<div class="clear"></div>
<div id="show">
    <?php $this->load->view('produksi/show_produksi'); ?>
</div>

