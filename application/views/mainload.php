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

            $(document).ready(function(){
				var $anchor = $(this);
				$('html, body').stop().animate({
					scrollLeft: $($anchor.attr('href')).offset().left
				}, 1000);
				event.preventDefault();
            });
            
            var base = "<?php echo base_url();?>";
            var fullDate = new Date() 
        </script>
		<style>
		*{
    margin:0;
    padding:0;
}
body{
    background:#000;
    font-family:Georgia;
    font-size: 34px;
    font-style: italic;
    letter-spacing:-1px;
    width:12000px;
    position:absolute;
    top:0px;
    left:0px;
    bottom:0px;
}
.section{
    margin:0px;
    bottom:0px;
    width:4000px;
    float:left;
    height:100%;
    text-shadow:1px 1px 2px #f0f0f0;
}
.section h2{
    margin:50px 0px 30px 50px;
}
.section p{
    margin:20px 0px 0px 50px;
    width:600px;
}
.black{
    color:#fff;
    background:#000 url(../images/black.jpg) no-repeat top right;
}
.white{
    color:#000;
    background:#fff url(../images/white.jpg) no-repeat top right;
}
.section ul{
    list-style:none;
    margin:20px 0px 0px 550px;
}
.black ul li{
    float:left;
    padding:5px;
    margin:5px;
    color:#aaa;
}
.black ul li a{
    display:block;
    color:#f0f0f0;
}
.black ul li a:hover{
    text-decoration:none;
    color:#fff;
}
.white ul li{
    float:left;
    padding:5px;
    margin:5px;
    color:#aaa;
}
.white ul li a{
    display:block;
    color:#222;
}
.white ul li a:hover{
    text-decoration:none;
    color:#000;
}
		</style>
    </head>
    <body style="overflow:hidden;">
        <div class="section black" id="section1">
	<h2>Section 1</h2>
	<p>
		MY Spectre around me night and day
		Like a wild beast guards my way;
		My Emanation far within
		Weeps incessantly for my sin.
	</p>
	<ul class="nav">
		<li>1</li>
		<li><a href="#section2">2</a></li>
		<li><a href="#section3">3</a></li>
	</ul>
</div>
<div class="section white" id="section2">
	<h2>Section 2</h2>
	<p>
		A fathomless and boundless deep,
		There we wander, there we weep;
		On the hungry craving wind
		My Spectre follows thee behind.

	</p>
	<ul class="nav">
		<li><a href="#section1">1</a></li>
		<li>2</li>
		<li><a href="#section3">3</a></li>
	</ul>
</div>
<div class="section black" id="section3">
	<h2>Section 3</h2>
	<p>
		He scents thy footsteps in the snow
		Wheresoever thou dost go,
		Thro' the wintry hail and rain.
		When wilt thou return again?

	</p>
	<ul class="nav">
		<li><a href="#section1">1</a></li>
		<li><a href="#section2">2</a></li>
		<li>3</li>
	</ul>
</div>
    </body>
</html>
