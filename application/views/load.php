<p>Do not close this window</p>
<?php
$base = base_url();
$js = $base . 'assets/js/'
?>
<script type="text/javascript" src="<?php echo $js; ?>jquery-1.6.4.js"></script>
<script type='text/javascript'>
    var site = "<?php echo site_url(); ?>";
    var auto_refresh = setInterval(
    function (){
        $('#show_load').load(site+'load').fadeIn("slow");
    }, 3000
);
</script>
<div id="show_load"></div>
<?php
if(isset($data)){
    echo "Loading..";
    print_r($data);
}
?>