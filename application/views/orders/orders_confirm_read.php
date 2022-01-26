<link href="<?php echo base_url() ?>assets/assets/plugins/bootstrap-clockpicker/src/clockpicker.css" rel="stylesheet" />
<style>
    /*
 *  STYLE 1
 */

#style-1::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
    background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
    height: 6px;
}

#style-1::-webkit-scrollbar-thumb
{
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-6">
            <table class="table table-borderless table-td-valign-middle text-white">
                <tr><td>Nama Pemesan</td><td>:</td><td><?php echo $nama_pemesan; ?></td></tr>
                <tr><td>Bagian</td><td>:</td><td><?php echo $classnyak->getbagiandata($bagian)->nama_bagian; ?></td></tr>
                <tr><td>No. Kontak</td><td>:</td><td><?php echo $no_kontak; ?></td></tr>

                <tr><td>Nama Barang</td><td>:</td><td><?php echo $nama_barang; ?></td></tr>
                <tr><td>Quantity</td><td>:</td><td><?php echo $qty; ?></td></tr>
                <tr><td>Due Date</td><td>:</td><td><?php echo date('d-m-Y',strtotime($due_date)); ?></td></tr>
                <tr><td>Note</td><td>:</td><td><?php echo $note; ?></td></tr>
                <tr><td>Priority</td><td>:</td><td><?php 

                $op = $priority;
                $badge = '';
                if ($op == 1) {
                    $badge = '<label class="badge bg-success">Biasa</label>';
                }
                if ($op == 2) {         
                    $badge = '<label class="badge bg-warning">Urgent</label>';
                }
                if ($op == 3) {
                    $badge = '<label class="badge bg-danger">Top Urgent</label>';
                }
                
                echo $badge;

                 ?></td></tr>
                <tr><td>Keterangan</td><td>:</td><td><?php 
                if ($keterangan == 1) {
                    echo 'Part Baru';
                }

                if ($keterangan == 2) {
                    echo 'Repair';
                }

                if ($keterangan == 3) {
                    echo 'Modifikasi';
                }
                 ?></td></tr>

                <tr><td>Status</td><td>:</td><td><?php echo $status; ?></td></tr>
                <tr><td>Tanggal Produksi</td><td>:</td><td><?php echo date('d-m-Y H:i',strtotime($tanggal_produksi)); ?></td></tr>
                <tr><td>Rencana Selesai</td><td>:</td><td><?php echo date('d-m-Y H:i',strtotime($rencana_selesai)); ?></td></tr>
                <tr><td>Total Barang Jadi</td><td>:</td><td><?php echo $total_barang_jadi; ?></td></tr>
                <tr>
                    <td>Mesin Digunakan</td>
                    <td>:</td>
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
            </table>
        </div>
        <div class="col-6">
            <div class="form-confirmation-order">
                <form id="form_confirm_order">
                    <table class="table table-borderless table-td-valign-middle text-white">
                        <tr>
                            <td>Plan</td><td>:</td><td><?php echo $rencana_selesai ?></td>
                        </tr>
                        <tr>
                            <td>Actual</td><td>:</td><td>
                                <?php

                                if ($status !== 'DONE') {
                                    ?>
                                    <div class="row">
                                        <div class="col-8">
                                            <input required type="date" class="form-control" name="tanggal_actual" id="tanggal_actual" />
                                            <input type="hidden" name="kd_order" value="<?php echo $kd_order ?>" />
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group clockpicker">
                                              <input type="text" class="form-control jam-awal" name="jam_actual" value="08:00"/>
                                              <span class="input-group-text input-group-addon">
                                                <i class="fa fa-clock"></i>
                                              </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo $aktual_selesai;
                                }

                                ?>
                            </td>
                        </tr>
                    </table>

                    <?php
                    if (!$aktual_selesai) {
                        ?>
                        <button class="btn btn-lg btn-success" type="submit" style="width: 100%;">Konfirmasi Selesai</button>

                        <?php
                    }
                    ?>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/assets/plugins/bootstrap-clockpicker/src/clockpicker.js"></script>
<script>
    $('.clockpicker').clockpicker({
        placement: 'bottom',
        align: 'right',
        autoclose: true
    })
</script>