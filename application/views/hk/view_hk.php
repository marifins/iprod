<div style="min-height: 515px;">
    <div align="center">
        <?php
        $options = "";
        $options[''] = "- - Tahun- -";

        for($i = 2009; $i<2015; $i++){
            $options[$i] = $i;
        }
        
        $options2 = "";
        $options2[''] = "- - Bulan- -";

        for($i = 1; $i <=12; $i++){
            if(strlen($i) == 1)
                $options2["0".$i] = $this->fungsi->bulan($i);
            else
                $options2["".$i] = $this->fungsi->bulan($i);
        }
        ?>
        &nbsp;<?php echo form_dropdown('tahun_hk_show', $options, '', 'id=tahun_hk_show');?>
        <?php if (is_logged_in ()):?>
            <button id="create-hk">Add HK</button>
        <?php endif;?>
        <br /><br />
        <div id="show_hari_kerja">
            <?php $this->load->view('hk/show_hk'); ?>
        </div>
    </div>
</div>
<?php

?>
<!-------------------------------- Form HK ---------------------------------->
    <div id="form-hk" title="Input Data HK">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            $attributes = array('class' => '', 'name' => 'form_hk');
            echo form_open("hk/submit");
        ?>
     
         <?php
            $data = array(
                'name' => 'id_hk',
                'id' => 'id_hk',
                'maxlength' => '18',
                'size' => '18',
                'class' => 'text ui-widget-content ui-corner-all',
            );
        ?>
        <?php echo form_input($data);?>

        <?php echo form_label('Tahun', 'tahun_hk');?><br />
        <?php echo form_dropdown('tahun_hk', $options, '', 'id = tahun_hk');?>
        <br />
        <?php echo form_label('Bulan', 'bulan_hk');?><br />
        <?php echo form_dropdown('bulan_hk', $options2, '', 'id = bulan_hk');?>
        <br />
        <?php echo form_label('Hari Kerja', 'jlh_hari');?>
        <?php
              $data = array(
                  'name' => 'jlh_hari',
                  'id' => 'jlh_hari',
                  'maxlength' => '18',
                  'size' => '18',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>
        
        <?php echo form_close('');?>
    </div>
<!-------------------------------- End of Form HK ---------------------------------->

<div id="dialog" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="id" name="id">
	Are you sure?
    </p>
</div>
