<div>
<ul id="pagination-digg"><?php echo $page_links;?></ul>
</div>
<br /><br />
<div id="show_info">
    <?php $this->load->view('info/show_info'); ?>
</div>

<div id="dialog" title="Delete Item ?">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <input type="hidden" value='' id="no_register" name="no_register">
	Are you sure?
    </p>
</div>
