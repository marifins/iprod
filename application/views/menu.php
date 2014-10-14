<?php $base = base_url();?>
<?php if (is_logged_in ()): ?>
<?php if (from_session('level') == 2): ?>
        <div class="navigation">        
            <ul class="menu" id="menu">
                <li><span class="home"></span><a href="<?php echo $base; ?>" class="first">Home</a></li>
                <li><span class="details"></span><a href="<?php echo $base; ?>produksi">Details</a></li>
                <li><span class="rkap"></span><a href="<?php echo $base; ?>rkap">Kebun</a></li>
                <li><span class="afdeling"></span><a href="<?php echo $base; ?>afdeling">Afdeling</a></li>
                <li><span class="hk"></span><a href="<?php echo $base; ?>hk">HK</a></li>
                <li><span class="info"></span><a href="<?php echo $base; ?>info">Info</a></li>
                <li><span class="log_entry"></span><a href="<?php echo $base; ?>log">Log Entry</a></li>
                <li><span class="view"></span><a href="<?php echo $base; ?>view" class="last">View</a></li>
            </ul>
        </div>
<?php elseif (from_session('level') == 1): ?>
            <div class="navigation2">
                <ul class="menu" id="menu">
                    <li><span class="home"></span><a href="<?php echo $base; ?>" class="first">Home</a></li>
                    <li><span class="details"></span><a href="<?php echo $base; ?>produksi">Details</a></li>
                    <li><span class="rkap"></span><a href="<?php echo $base; ?>rkap">Kebun</a></li>
                    <li><span class="afdeling"></span><a href="<?php echo $base; ?>afdeling">Afdeling</a></li>
                    <li><span class="hk"></span><a href="<?php echo $base; ?>hk">HK</a></li>
                    <li><span class="info"></span><a href="<?php echo $base; ?>info">Info</a></li>
                    <li><span class="log_entry"></span><a href="<?php echo $base; ?>log">Log Entry</a></li>
                    <li><span class="view"></span><a href="<?php echo $base; ?>view" class="last">View</a></li>
                </ul>
            </div>
<?php endif; ?>
<?php else: ?>
                <div class="navigation3">
                    <ul class="menu" id="menu">
                        <li><span class="home"></span><a href="<?php echo $base; ?>" class="first">Home</a></li>
                        <li><span class="details"></span><a href="<?php echo $base; ?>produksi">Details</a></li>
                        <li><span class="rkap"></span><a href="<?php echo $base; ?>rkap">Kebun</a></li>
                        <li><span class="afdeling"></span><a href="<?php echo $base; ?>afdeling">Afdeling</a></li>
                        <li><span class="hk"></span><a href="<?php echo $base; ?>hk">HK</a></li>
                        <li><span class="info"></span><a href="<?php echo $base; ?>info" class="last">Info</a></li>
                    </ul>
                </div>
<?php endif; ?>