<?php $img_link = base_url() . "/assets/images"; ?>
<br /><br />
<?php $q = $query; ?>

<table id="rounded-corner" summary="User">
    <thead>
        <tr>
            <th width="18%" class="rounded-company">No. Register</th>
            <th>No. Ponsel</th>
            <th width="25%">Nama Lengkap</th>
            <th>Kebun Unit</th>
            <th>Jabatan</th>
            <th class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="5" class="rounded-foot-left"><em>Member Management | SMS - Based Information System Fresh Fruit Bunch (FFB) Production</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if ($rows == 0): ?>
        <tr>
            <td colspan='5' align='center'><span id='red'>Data tidak tersedia</span></td>
        </tr>
    <?php else: ?>
    <?php $i = 0; ?>
    <?php foreach ($q as $row): ?>
          <?php
          $data = $this->member_model->get_kebun_name($row->kebun_unit);
          $str_kebun = $data->nama_kebun;
          ?>
                <tbody>
        <?php $i++; ?>
        <?php if ($i % 2 == 0): ?>
                    <tr>
            <?php else: ?>
                    <tr class="even">
            <?php endif; ?>
                        <td><?php echo $row->register; ?></td>
                        <td><?php echo $row->no_ponsel; ?></td>
                        <td><?php echo $row->nama_lengkap; ?></td>
                        <td><?php echo $str_kebun; ?></td>
                        <td><?php echo $row->jabatan; ?></td>
                        <td> <a href="javascript:void(0);" onclick='l("<?= base_url(); ?>member/details/<?php echo $row->register; ?>","")'><?php echo img($img_link . '/detail.png', TRUE); ?></a>
                            <a href="#" class="edit_member" register="<?php echo $row->register; ?>" no_ponsel="<?php echo $row->no_ponsel; ?>" nama_lengkap="<?php echo $row->nama_lengkap; ?>" kebun_unit="<?php echo $row->kebun_unit; ?>" jabatan="<?php echo $row->jabatan; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
                            <a href="#" class="delete_member" register="<?php echo $row->register; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a></td>
                    </tr>
                </tbody>
    <?php endforeach; ?>
    <?php endif; ?>
</table>