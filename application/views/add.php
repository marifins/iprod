<?php
$base = base_url();
$rek = array("080.01", "080.02", "080.03", "080.04", "080.08", "080.13");
$name = array("PTG", "KLM", "KBR", "TSW", "JRU", "CGR");
?>
<form method="post" action="<?php echo $base; ?>/add/go/">
    <table>
        <tr>
            <th><?php echo "Tanggal"; ?>&nbsp;&nbsp;&nbsp;</th>
            <td><input type="text" class="text ui-widget-content ui-corner-all" id="dateAdd" name="tgl" title="Tanggal" /></td>
        </tr>
        <?php for ($i = 0; $i < 6; $i++): ?>
            <tr>
                <th><?php echo $name[$i]; ?></th>
                <td><input type="text" class="text ui-widget-content ui-corner-all" id="rkap<?php echo $i; ?>" name="rkap<?php echo $i; ?>" title="Realisasi" /></td>
                <td><input type="text" class="text ui-widget-content ui-corner-all" id="rko<?php echo $i; ?>" name="rko<?php echo $i; ?>" title="RKAP" /></td>
                <td><input type="text" class="text ui-widget-content ui-corner-all" id="real<?php echo $i; ?>" name="real<?php echo $i; ?>" title="RKO" /></td>
            </tr>
        <?php endfor; ?>
        <tr align="right">
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
            <td><input id="btnSave" type="button" value="Simpan Data" /></td>
        </tr>
    </table>
</form>
<script>
    
    $("#btnSave").live("click",function(){
        var s = 1;
        for(var i=0; i<6; i++){
            if($("#rkap"+i).val() == "" || $("#rko"+i).val() == "" || $("#real"+i).val() == ""){
                s = 0;
            }else{
                if($("#dateAdd").val() == "") s = 0;
            }
        }
        if(s == 0){
            alert("Harap isi seluruh form!");
        }else{
            this.form.submit();
        }
    });
</script>