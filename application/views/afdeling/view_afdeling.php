<div style="min-height: 515px;">
    <?php
    $kebun = $this->afdeling_model->get_kebun_all();
    $options2 = "";
    $options2[''] = "- - Kebun - -";

    foreach($kebun as $t){
        $options2[$t->no_rek] = $t->nama_kebun;
    }
    
    $int = array('1','1a','1b','2','3','4','5','6','7','8','9','10');
    $romawi = array('I','IA','IB','II','III','IV','V','VI','VII','VIII','IX','X');
    $options4 = "";
    $options4[''] = "- - Afdeling - -";
    for($i=0; $i<12; $i++){
        $options4[$int[$i]] = $romawi[$i];
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
        &nbsp;<?php echo form_dropdown('tahun_la_show', $options, '', 'id=tahun_la_show');?>
        &nbsp;<?php echo form_dropdown('kebun_la_show', $options2, '', 'id=kebun_la_show');?>   
        <?php if (is_logged_in ()):?>
            <button id="create-la">Add Luas</button>
        <?php endif;?>
        <br /><br />
        <div id="show_la">
            <?php $this->load->view('afdeling/show_luas'); ?>
        </div>
    </div>
    <div class="fRight">
        <?php
        $options3 = "";
        $options3[''] = "- - Bulan- -";

        for($i = 1; $i <=12; $i++){
            if(strlen($i) == 1)
                $options3["0".$i] = $this->fungsi->bulan($i);
            else
                $options3["".$i] = $this->fungsi->bulan($i);
        }

        ?>
        <?php echo form_dropdown('tahun_af_show', $options, '', 'id=tahun_af_show');?>
        <?php echo form_dropdown('bulan_af_show', $options3, '', 'id=bulan_af_show');?>
        <?php echo form_dropdown('kebun_af_show', $options2, '', 'id=kebun_af_show');?>
       
        <?php if (is_logged_in ()):?>
            <button id="create-af">Add</button>
        <?php endif;?>
        <div id="show_afd">
            <?php $this->load->view('afdeling/show_afdeling'); ?>
        </div>
    </div>
</div>
<?php

?>
<!-------------------------------- Form Luas Afdeling ---------------------------------->
    <div id="form-la" title="Input Data Luas Afdeling">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            $attributes = array('class' => '', 'name' => 'form_luas_afdeling');
            echo form_open("afdeling/submit_la");
        ?>
     
         <?php
            $data = array(
                'name' => 'id_la',
                'id' => 'id_la',
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('Tahun', 'tahun_la');?><br />
        <?php echo form_dropdown('tahun_la', $options, '', 'id = tahun_la');?>
        <br />
        <?php echo form_label('Kebun', 'kebun_la');?><br />
        <?php echo form_dropdown('kebun_la', $options2, '', 'id = kebun_la');?>
        <br />
        <?php echo form_label('Afdeling', 'afdeling_la');?><br />
        <?php echo form_dropdown('afdeling_la', $options4, '', 'id = afdeling_la');?>
        <br />
        <?php echo form_label('Luas', 'luas_la');?>
        <?php
              $data = array(
                  'name' => 'luas_la',
                  'id' => 'luas_la',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>
        
        <?php echo form_close('');?>
    </div>
<!-------------------------------- End of Form Luas Afdeling ---------------------------------->

<!-------------------------------- Form Afdeling ---------------------------------->
    <div id="form-af" title="Input Data Afdeling">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            $attributes = array('class' => '', 'name' => 'form_af');
            echo form_open("afdeling/submit_af");
        ?>

         <?php
            $data = array(
                'name' => 'id_af',
                'id' => 'id_af',
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('Tahun', 'tahun_af');?><br />
        <?php echo form_dropdown('tahun_af', $options, '', 'id = tahun_af');?>
        <br />
        <?php echo form_label('Bulan', 'bulan_af');?><br />
        <?php echo form_dropdown('bulan_af', $options3, '', 'id = bulan_af');?>
        <br />
        <?php echo form_label('Kebun', 'kebun_af');?><br />
        <?php echo form_dropdown('kebun_af', $options2, '', 'id = kebun_af');?>
        <br />
        <?php echo form_label('Afdeling', 'af');?><br />
        <?php echo form_dropdown('af', $options4, '', 'id = af');?>
        <br />
        <?php echo form_label('RKAP', 'rkap_af');?>
        <?php
              $data = array(
                  'name' => 'rkap_af',
                  'id' => 'rkap_af',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>
        <?php echo form_label('RKO', 'rko_af');?>
        <?php
              $data = array(
                  'name' => 'rko_af',
                  'id' => 'rko_af',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_close('');?>
    </div>
<!-------------------------------- End of Form Afdeling ---------------------------------->

<div id="dialog" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="id" name="id">
	Are you sure?
    </p>
</div>
