<div class="row" id="isitabel" style="display: none;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">        
                            <div class="box-body">
                                <div class='row'>
                                    <div class='col-md-9'>
                                        <div style="padding-bottom: 10px;">
   <button class="btn btn-danger btn-sm tambah_data"><i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Data</button>
                                                <a class="btn btn-success btn-sm" href="<?php echo base_url().'orders/excel' ?>"><i class="far fa-file-excel" aria-hidden="true"></i> Export Ms Excel</a>
            </div>
        </div>
    </div>    
    <div class="box-body" style="overflow-x: scroll; ">
    <table id="data-table-data" class="table table-bordered table-hover table-td-valign-middle text-white">
     <thead>
        <tr>
            <th>No</th>
	<th>Kode Order</th>
	<th>Nama Pemesan</th>
	<th>Bagian</th>
	<th>Priority</th>
	<th>Status</th>
	<th>Waktu</th>
	<th>Action</th>
        </tr></thead><tbody><?php $no = 1;
        foreach ($orders_data as $orders)
        {
            ?>
            <tr>
		<td><?= $no++?></td>
        <td><?php echo $orders->kd_order ?></td>
		<td><?php echo $orders->nama_pemesan ?></td>
		<td><?php echo $classnyak->getbagiandata($orders->bagian)->nama_bagian ?></td>
		<td><?php

        $op = $orders->priority;

        if ($op == 1) {
            ?>
            <label class="badge bg-success">Biasa</label>
            <?php
        }

        if ($op == 2) {
            ?>
            <label class="badge bg-warning">Urgent</label>
            <?php
        }

        if ($op == 3) {
            ?>
            <label class="badge bg-danger">Top Urgent</label>
            <?php
        } ?></td>
		<td><?php

        $opx = $orders->status;

        if ($opx == 'WAITING') {
            ?>
            <label class="badge bg-warning">Dalam Review</label>
            <?php
        }

        if ($opx == 'DONE') {
            ?>
            <label class="badge bg-success">Selesai</label>
            <?php
        }

        if ($opx == 'ON PROGRESS') {
            ?>
            <label class="badge bg-info">Diproses</label>
            <?php
        }

        if ($opx == 'REJECTED') {
            ?>
            <label class="badge bg-danger">Perlu Revisi</label>
            <?php
        } ?></td>
		<td><?php echo $orders->tanggal_order ?></td>
		<td style="text-align:center" width="200px">
			<button type="button" class="btn btn-success btn-sm read_data" id="<?php echo encrypt_url($orders->order_id) ?>"><i class="fas fa-eye" aria-hidden="true"></i></button>

            <?php
            $cek = $classnyak->detectalreadysigned($orders->order_id);

            if ($cek == 0) {

                if ($opx == 'REJECTED' || $opx == 'ON PROGRESS') {
                    ?>

                    <button type="button" class="btn btn-primary btn-sm update_data" id="<?php echo encrypt_url($orders->order_id) ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-danger btn-sm delete_data" id="<?php echo encrypt_url($orders->order_id) ?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>

                    <?php
                }
            }

            ?>
            <button type="button" class="btn btn-info btn-sm copy_code" id="<?php echo $orders->kd_order ?>"  ><i class="fas fa-copy"></i></button>
		</td>
	</tr>
            <?php } ?>
        </tbody>
    </table>
            
  </div>
    </div>
    </div>
    </div>
    </div>

    <script src="<?= base_url() ?>assets/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">

      $(document).ready(function() {

        $('#isitabel').css('display','block')

        $('#data-table-data').DataTable({
            responsive: true
        })

        function copyToClipboard(element) {
          var $temp = $("<input>");
          $("body").append($temp);
          $temp.val(element.attr('id')).select();
          document.execCommand("copy");
          $temp.remove();
          alert('Kode Order berhasil disalin')
        }

        $('.copy_code').on('click', function() {
            copyToClipboard($(this))
        })
      })
</script>