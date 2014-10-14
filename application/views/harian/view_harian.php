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


?>
<div id="show">
    <?php $this->load->view('harian/show_harian'); ?>
</div>



