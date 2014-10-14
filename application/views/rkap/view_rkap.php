<div style="min-height: 360px;">
    <?php
    $kebun = $this->rkap_model->get_kebun_all();
    $options2 = "";
    $options2[''] = "- - Kebun - -";

    foreach($kebun as $t){
        $options2[$t->no_rek] = $t->nama_kebun;
    }
    ?>
    <div class="fLeft">
        <?php
        $options = "";
        $options[''] = "- - Tahun- -";

        for($i = 2009; $i<2015; $i++){
            $options[$i] = $i;
        }
        ?>
       
        &nbsp;<?php echo form_dropdown('tahun_rkap', $options, '', 'id=tahun_rkap');?>
        <?php if (is_logged_in ()):?>
            <button id="create-rkap">Add RKAP</button>
        <?php endif;?>
        <br /><br />
        <div id="show_rkap">
            <?php $this->load->view('rkap/show_rkap'); ?>
        </div>
    </div>
    <div class="fRight">
        <?php
        $options3 = "";
        $options3[''] = "- - Bulan- -";

        for($i = 1; $i <=12; $i++){
            $options3[$i] = $this->fungsi->bulan($i);
        }

        ?>
        <?php echo form_dropdown('tahun_rko', $options, '', 'id=tahun_rko');?>
        
        <?php echo form_dropdown('bulan_rko', $options3, '', 'id=bulan_rko');?>

        <?php if (is_logged_in ()):?>
            <button id="create-rko">Add RKO</button>
        <?php endif;?>
        <div id="show_rko">
            <?php $this->load->view('rkap/show_rko'); ?>
        </div>
    </div>
</div>
<?php

?>
<!-------------------------------- Form RKAP ---------------------------------->
    <div id="form-rkap" title="Input Data RKAP">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            $attributes = array('class' => '', 'name' => 'form_rkap');
            echo form_open("rkap/submit");
        ?>
     
         <?php
            $data = array(
                'name' => 'id',
                'id' => 'id',
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_hidden($data);?>

        <?php echo form_label('Tahun', 'tahun');?><br />
        <?php echo form_dropdown('tahun', $options, '', 'id = tahun2');?>
        <br />
        <?php echo form_label('Kebun', 'kbn');?><br />
        <?php echo form_dropdown('kbn', $options2, '', 'id = kbn');?>
        <br />
        <?php echo form_label('RKAP', 'rkap');?>
        <?php
              $data = array(
                  'name' => 'rkap',
                  'id' => 'rkap',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>
        
        <?php echo form_close('');?>
    </div>
<!-------------------------------- End of Form RKAP ---------------------------------->

<!-------------------------------- Form RKO ---------------------------------->
    <div id="form-rko" title="Input Data RKO">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            $attributes = array('class' => '', 'name' => 'form_rko');
            echo form_open("rkap/submit_rko");
        ?>

         <?php
            $data = array(
                'name' => 'id_rko',
                'id' => 'id_rko',
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('Tahun', 'tahun');?><br />
        <?php echo form_dropdown('tahun', $options, '', 'id = tahun_rko_form');?>
        <br />
        <?php echo form_label('Bulan', 'bulan');?><br />
        <?php echo form_dropdown('bulan', $options3, '', 'id = bulan_rko_form');?>
        <br />
        <?php echo form_label('Kebun', 'kebun');?><br />
        <?php echo form_dropdown('kebun', $options2, '', 'id = kebun_rko_form');?>
        <br />
        <?php echo form_label('RKAP', 'rkap');?>
        <?php
              $data = array(
                  'name' => 'rkap_rko',
                  'id' => 'rkap_rko',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>
        <?php echo form_label('RKO', 'rko');?>
        <?php
              $data = array(
                  'name' => 'rko',
                  'id' => 'rko',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_close('');?>
    </div>
<!-------------------------------- End of Form RKO ---------------------------------->

<div id="dialog" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="id" name="id">
	Are you sure?
    </p>
</div>
