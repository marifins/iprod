<?php
$info = $this->monitor_model->get_info();
?>
<div id="header">
    <div id="trends">

        <div class="inner">
            <ul class="trendscontent" style="zoom: 1; width: 3132px; left: -227px; ">
                <?php if (empty($info)): ?>
                    <li class="trend-label">VISI</li>
                    <li>
                        <a href="">
                            <?php
                            echo "Menjadi Perusahaan agribisnis perkebunan yang tangguh serta mampu memberikan kesejahteraan bagi stakeholders dan kontribusi yang optimal kepada negara.";
                            ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="trend-label">INFO</li>
                    <li>
                        <a href="">
                            <?php
                            foreach ($info as $r) {
                                $d = $this->monitor_model->get_kebun_from_ponsel($r->no_ponsel);
                                $kebun = $d->kebun_unit;
                                $kebun = $this->fungsi->rekToKebun($kebun);
                                echo $kebun . " (" . substr($r->tanggal, 8, 2) . "/" . substr($r->tanggal, 5, 2) . ") ";
                                echo $r->text;
                                echo "&nbsp;&nbsp;&nbsp; # &nbsp;&nbsp;&nbsp;";
                            }
                            ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <span class="fade fade-left"><p id="marquee">&nbsp;</p></span><span class="fade fade-right"><p id="marquee">&nbsp;</p></span>

    </div>
</div>
