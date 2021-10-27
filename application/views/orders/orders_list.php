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
    <th>Progress</th>
	<th>Approved By</th>
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
		<td><?php echo $orders->bagian ?></td>
		<td><?php

        $op = $orders->priority;

        if ($op == 0) {
            ?>
            <label class="badge bg-success">Biasa</label>
            <?php
        }

        if ($op == 1) {
            ?>
            <label class="badge bg-warning">Urgent</label>
            <?php
        }

        if ($op == 2) {
            ?>
            <label class="badge bg-danger">Top Urgent</label>
            <?php
        } ?></td>
        <td>
            <?php

            $percent = 0;

            if ($orders->status == 'READY') {
                $percent = 25;
            }

            if ($orders->status == 'ON PROGRESS') {
                $percent = 50;
            }
            ?>
            
            <div class="progress rounded-pill mb-2 mt-2">
                <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated fs-7px fw-bold" style="width: <?php echo $percent ?>%"></div>
            </div>

        </td>
		<td><?php echo $orders->approved_by ?></td>
		<td><?php echo $orders->tanggal_order ?></td>
		<td style="text-align:center" width="200px">
			<button type="button" class="btn btn-success btn-sm read_data" id="<?php echo encrypt_url($orders->order_id) ?>"><i class="fas fa-eye" aria-hidden="true"></i></button>
			<button type="button" class="btn btn-primary btn-sm update_data" id="<?php echo encrypt_url($orders->order_id) ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
			<button type="button" class="btn btn-danger btn-sm delete_data" id="<?php echo encrypt_url($orders->order_id) ?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
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