<?php
function userStr($id) {
    if ($id == "1")
        return "Operator";
    else if ($id == "2")
        return "Administrator";
    else
        return "none";
}
?>
<?php $img_link = base_url() . "/assets/images"; ?>

<div class="page_links"><?php echo $page_links; ?></div>
<?php $q = $query; ?>

<table id="rounded-corner" summary="User">
    <thead>
        <tr>
            <th width="25%" class="rounded-company">No. Register</th>
            <th>Username</th>
            <th width="25%">Nama Lengkap</th>
            <th>Privilege</th>
            <th class="rounded-q4"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="4" class="rounded-foot-left"><em>User Management | SMS - Based Information System Fresh Fruit Bunch (FFB) Production</em></td>
            <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <?php if ($rows == 0): ?>
        <tr>
            <td colspan='4' align='center'><span id='red'>Data tidak tersedia</span></td>
        </tr>
    <?php else: ?>
    <?php $i = 0; ?>
    <?php foreach ($q as $row): ?>
                <tbody>
        <?php $i++; ?>
        <?php if ($i % 2 == 0): ?>
                    <tr>
            <?php else: ?>
                    <tr class="even">
            <?php endif; ?>
                        <td><?php echo $row->register; ?></td>
                        <td><?php echo $row->username; ?></td>
                        <td><?php echo $row->nama_lengkap; ?></td>
                        <td><?php echo userStr($row->level); ?></td>
                        <td> <a href="javascript:void(0);" onclick='l("<?= base_url(); ?>user/details/<?php echo $row->register; ?>","")'><?php echo img($img_link . '/detail.png', TRUE); ?></a>
                            <a href="#" class="edit" register="<?php echo $row->register; ?>" username="<?php echo $row->username; ?>" nama_lengkap="<?php echo $row->nama_lengkap; ?>" level="<?php echo $row->level; ?>"><?php echo img($img_link . '/edit.png', TRUE); ?></a>
                            <a href="#" class="delete" register="<?php echo $row->register; ?>"><?php echo img($img_link . '/delete.png', TRUE); ?></a></td>
                    </tr>
                </tbody>
    <?php endforeach; ?>
    <?php endif; ?>
</table>