
<table id="data-table-default" class="table table-hover table-bordered table-td-valign-middle">
    <tr><td>Id</td><td><?php echo $id; ?></td></tr>
    <tr><td>Tanggal Produksi</td><td><?php echo $tanggal_produksi; ?></td></tr>
    <tr><td>Total Barang Jadi</td><td><?php echo $total_barang_jadi; ?></td></tr>
    <tr><td>Priority</td><td><?php echo $priority; ?></td></tr>
    <tr><td>Material</td><td>
        <ul>
            <?php
            foreach ($materialsdata as $key => $value) {
                ?>
                <li><?php echo $value->kd_material ?> (<?php echo $value->jumlah_bahan ?> Pcs)</li>
                <?php
            }
            ?>
        </ul>

    </td></tr>
    <tr><td>User Id</td><td><?php echo $user_id; ?></td></tr>
    <tr><td></td><td><button type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button></td></tr>
</table>