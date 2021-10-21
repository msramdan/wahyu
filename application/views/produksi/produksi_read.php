
<table id="data-table-default" class="table table-bordered table-td-valign-middle">
    <tr><td>Id</td><td><?php echo $id; ?></td></tr>
    <tr><td>Tanggal Produksi</td><td><?php echo $tanggal_produksi; ?></td></tr>
    <tr><td>Rencana Selesai</td><td><?php echo $rencana_selesai; ?></td></tr>
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
    <tr>
        <td>Mesin Digunakan</td>
        <td>
            <ul>
                <?php

                $mu = json_decode($machine_used, TRUE);

                foreach ($mu as $key => $value) {
                    ?>
                    <li><?php echo $classnyak->getmachinedetail($value['machine_id'])->kd_mesin ?></li>
                    <table class="table table-sm table-hover">
                        <tr>
                            <td>Estimasi Selesai per-barang</td>
                            <td><?php echo $value['estimateddonepergoods'] ?> Minute(s)</td>
                        </tr>
                        <tr>
                            <td>Alokasi Material</td>
                            <td><?php echo $value['materialallocated'] ?> Pcs</td>
                        </tr>
                        <tr>
                            <td>Alokasi Target Barang Jadi</td>
                            <td><?php echo $value['goodsallocated'] ?> Pcs</td>
                        </tr>
                        <tr>
                            <td>Shift</td>
                            <td><?php if ($value['shift1']) {
                                ?>
                                <label class="badge bg-success">Shift 1</label>
                                <?php
                            } ?>
                            <?php if ($value['shift2']) {
                                ?>
                                <label class="badge bg-success">Shift 2</label>
                                <?php
                            } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Estimasi</td>
                            <td><?php echo $value['etapermachine'] ?></td>
                        </tr>
                    </table>
                    <?php
                }

                ?>
            </ul>
        </td>
    </tr>
    <tr><td>User Id</td><td><?php echo $user_id; ?></td></tr>
    <tr><td></td><td><button type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button></td></tr>
</table>