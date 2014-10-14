<?php
function toRomawi($str){
    $int = array('1','2','3','4','5','6','7','8','9','10');
    $romawi = array('I','II','III','IV','V','VI','VII','VIII','IX','X');

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

function status($num){
    if ($num == "2") return "<span id=green>proccessed</span>";
    else return "<span id=red>unprocessed</span>";
}
?>
<div>
<ul id="pagination-digg"><?php echo $page_links;?></ul>
</div>
<br /><br />
<div class="fRight" style="margin: -36px 9px 0 0">
    <button id="compose-message">New Message</button>
</div>
<div id="show_outbox">
    <?php $this->load->view('outbox/show_outbox'); ?>
</div>


<!-- Form New Message-->
    <div id="form-new-message" title="Compose New Message">
        <p class="validateTips">All form fields are required.</p>
        <br />
        <?php
            echo form_open();
        ?>
        <?php
        $data = array(
            'name' => 'all_krani',
            'id' => 'all_krani',
            'value' => 'all_krani',
        );

        echo form_checkbox($data);
        echo form_label('Semua Krani', 'all_krani');
        ?>
        <br />
        <div style="margin: 5px 0 0 0;"></div>
        <?php echo form_label('No. Tujuan', 'no_tujuan');?>
        <?php
              $data = array(
                  'name' => 'no_tujuan',
                  'id' => 'no_tujuan',
                  'maxlength' => '15',
                  'size' => '15',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_input($data);?>

        <br />
        <?php echo form_label('Pesan', 'pesan');?>
        <br />
        <?php
              $data = array(
                  'name' => 'pesan',
                  'id' => 'pesan',
                  'maxlength' => '160',
                  'size' => '160',
                  'style' => 'width:350px; height:100px',
                  'class' => 'text ui-widget-content ui-corner-all',
              );
        ?>
        <?php echo form_textarea($data);?>

        <?php echo form_close('');?>
    </div>
<div id="dialog3" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="no_register" name="no_register">
	Are you sure?
    </p>
</div>

