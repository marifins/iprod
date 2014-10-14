<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <title>{title}</title>
        <!-- Meta Tags -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <!-- External CSS -->
        <?php //foreach($styles as $style) echo HTML::style($style), "\n";?>
        <?php
        $base = base_url();
        $css = $base . 'assets/css/';
        $js = $base . 'assets/js/';
        $i = $base . 'assets/images/';
        ?>
        <link rel="shorcut icon" href="<?php echo $i; ?>favicon.png" />
        <link rel="stylesheet" href="<?php echo $css; ?>home.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $css; ?>menu.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.jqplot.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $css; ?>custom-theme/jquery-ui-1.8.16.custom.css" type="text/css" />
        <!-- External Javascripts -->
        <?php //foreach($scripts as $script) echo HTML::script($script), "\n";?>

        <script type="text/javascript" src="<?php echo $js; ?>jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="<?php echo $js; ?>jquery-1.6.4.js"></script>
        <script type="text/javascript" src="<?php echo $js; ?>ui.datepicker-id.js"></script>
        <script type="text/javascript" src="<?php echo $js; ?>jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>excanvas.min.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>jqplot.dragable.min.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>jqplot.highlighter.min.js"></script>
        <script type="text/javascript" src="<?php echo $js; ?>main.js"></script>
        <script type="text/javascript" src="<?php echo $js; ?>menu.js"></script>
        
        <script type='text/javascript'>
            var site = "<?php echo site_url(); ?>";
            var loading_image_large = "<?php echo $i; ?>loading_large.gif";
            var loading_image_small = "<?php echo $i; ?>loading.gif";
            var base = "<?php echo base_url();?>";
            var auto_refresh = setInterval(
                function (){
                    //$('#load_inbox').load(base +'load').fadeIn("slow");
                    var pathname = $(location).attr('href');
                    var thn = $("#tahun").val();
                    var bln = $("#bulan").val();
                    if(bln.length == 1) bln = "0"+bln;
                    if(base == pathname)
                    $('#show').load(base +'def/i/'+thn +"/"+bln).fadeIn("slow");

                    load_graph("def/igraph/"+thn+"/"+bln,"#show_graph");
                    //setVar();
                    //load("def/igraph/"+thn+"/"+bln,"#show_graph");
                    //alert('');
                    //$.jqplot('chartDiv', [ptg, klm, kbr, tsw, jru, cgr], CreateBarChartOptions());
                }, 5000
            );
        </script>
    </head>
    <body>
        <div id="page-wrap">
            <div id="header2">
                <div class="wrapper2">
                    <div align="right">
                        <div id="login">
                            <br />
                            <?php
                            if (is_logged_in ()) {
                                echo "Welcome, ";
                                echo from_session('nama');
                                echo "\r |";
                            }
                            ?>
                            <?php if (is_logged_in ()): ?>
                                <a href="<?php echo $base; ?>login/do_logout">Logout</a>
                            <?php else: ?>
                                <a class="login" href="#">Login</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="main-title">
                        <h1><a href="" title="SMS Produksi"><span> SMS - Based Information System</span></a></h1>
                        <span id="title">SMS - Based Information System <br /> for Oil Palm FFB Production </span>  
                    </div>
                    <?php if (is_logged_in () && from_session('level') == 2): ?>
                    <div id="menu_admin">
                        <a href="<?php echo $base; ?>user">User</a> &nbsp;| 
                        &nbsp;<a href="<?php echo $base; ?>member">Member</a>
                    </div>
                    <?php endif;?>
                    <?php if (is_logged_in () && (from_session('level') == 2 || from_session('level') == 1)): ?>
                    <div id="box_menu">
                        <?php $img_link = base_url() . "/assets/images"; ?>
                        <?php
                        $ibx = array('src' => $img_link . '/inbox.png', 'title' => 'Inbox');
                        $obx = array('src' => $img_link . '/outbox.png', 'title' => 'Outbox');
                        $snt = array('src' => $img_link . '/sent_items.png', 'title' => 'Sent Items');
                        ?>
                        <a href="<?php echo $base; ?>inbox"><?php echo img($ibx); ?></a>
                        <a href="<?php echo $base; ?>outbox"><?php echo img($obx); ?></a>
                        <a href="<?php echo $base; ?>sent_items"><?php echo img($snt); ?></a>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <br />
            <div align="center">
                <div id="wrapper">
                    <div>
                        <div class="title"></div>
                        <?php $this->load->view('menu'); ?>
                    </div>
                    <div id="contentMain">
                        <h2>{judul}</h2>
                        <div id="temp"></div>
                        <br />
                        {content}
                        <br />
                    </div>
                </div>
            </div>
            <div class="shadow2"></div>
            <div id="footer">
                <div class="wrapper2">
                    <p align="center">
                        <br />
                        Copyright &copy; 2011 All rights reserved<br />
                        SMS-Based Information System for Fresh Fruit Bunch (FFB) Production<br />
                        Sistem Informasi Produksi Kelapa Sawit Online dengan Teknologi SMS (Short Message Service)<br /><br />
                        Pulo Tiga | Kebun Lama | Kebun Baru | Julu Rayeu Utara | Tualang Sawit | Cot Girek <br /><br />
                    </p>
                </div>
            </div>
        </div>
<div id="show_load"> </div>
<div id="not_valid" title="Warning">
	<p>Username OR Password not valid.</p>
</div>

<div id="logged_in" title="Warning">
	<p>You've already loggged in.</p>
</div>
<div id="form-login" title="Login Form">
    <?php $this->load->view('form_login'); ?>
</div>
    </body>
</html>
