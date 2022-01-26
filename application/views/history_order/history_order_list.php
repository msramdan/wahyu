<div id="content" class="app-content">
    <h1 class="page-header">ORDERS HISTORY</h1>  
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">List Data </h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="row" id="isitabel" style="display: none;">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">        
                        <div class="box-body">
                            <div class="box-body" style="overflow-x: scroll;">
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
                                            <th>Nama Barang</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
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
                                                    <td><?php echo $orders->nama_barang ?></td>
                                                    <td style="text-align:center" width="200px">
                                                        <button type="button" class="btn btn-info btn-sm copy_code" id="<?php echo $orders->kd_order ?>"  ><i class="fas fa-copy"></i></button>
                                                    </td>
                                                </tr>
                                                <?php 
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?= base_url() ?>assets/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/assets/plugins/jszip/dist/jszip.min.js"></script>
<script type="text/javascript">

    $('#data-table-data').DataTable({
        responsive: true,
        dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
        buttons: [
        {
            extend: 'copy', 
            className: 'btn-sm'
        },
        {
            extend: 'csv', 
            className: 'btn-sm',
            title: 'Orders History Report'
        },
        { 
            extend: 'excel', 
            className: 'btn-sm',
            title: 'Orders History Report'
        }]
    })
      $(document).ready(function() {
        $('#isitabel').css('display','block')

        $('#data-table-data').css('width','100%')


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