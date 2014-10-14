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
        <link rel="stylesheet" href="<?php echo $css; ?>front.css" type="text/css" />
        <!-- External Javascripts -->
        <?php //foreach($scripts as $script) echo HTML::script($script), "\n";?>

        <script type="text/javascript" src="<?php echo $js; ?>jquery-1.6.4.min.js"></script>
        <script type="text/javascript" src="<?php echo $js; ?>jquery-1.6.4.js"></script>
        <script type="text/javascript" src="<?php echo $js; ?>twitmarquee.js"></script>
        <script type="text/javascript">
            var page={};

            $(function() {
                new FrontPage().init();
            });
            
            var base = "<?php echo base_url();?>";
            var fullDate = new Date() 
            //convert month to 2 digits
            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    
            var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
            /**var auto_refresh = setInterval(
                function (){
                    $('#show').load(base +'check/index_ajax/'+"0" +"/"+currentDate).fadeIn("slow");
                }, 5000
            );*/
        </script>
    </head>
    <body>
        <div id="page-wrap">
            <div>
                <div id="temp"></div>
                {content}
            </div>
        </div>
        <div id="show_load"> </div>
    </body>
</html>
