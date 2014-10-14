<?php $img_link = base_url() . "/assets/images"; ?>

<?php $q = $query; ?>

<table id="rounded-corner" summary="Info">
    <?php if ($rows == 0): ?>
        <tr>
            <td colspan='3' align='center'><span id='red'>Data tidak tersedia</span></td>
        </tr>
    <?php else: ?>
        <?php foreach ($q as $row): ?>
                <tr class="info">
                <td>
                <?php echo $row->date;?>
                <?php echo " | ";?>
                <?php echo $row->time;?>
                <?php
                    $data = $this->info_model->get_kebun_by_ponsel($row->no_ponsel);
                ?>
                <?php echo "<h4>Pengirim : </h4>" .$data->nama_kebun; ?>
                <?php echo " | " .$row->no_ponsel; ?>  
                <?php echo "<h4>Pesan : </h4>" .$row->text; ?>
                </td>
                <?php if (is_logged_in ()): ?>
                <td>
                    <a href="#" class="delete_info" id="<?php echo $row->id; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a>
                </td>
                <?php endif;?>
            </tr>
            <tr class="info"><td><hr /></td></tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>