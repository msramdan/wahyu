<div class="row" id="isitabel" style="display:none;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">        
                            <div class="box-body">
                                <div class='row'>
                                    <div class='col-md-9'>
                                        <div style="padding-bottom: 10px;">
                                                <button class="btn btn-danger btn-sm tambah_data"><i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Data</button>
                                                <button class="btn btn-success btn-sm export_data"><i class="far fa-file-excel" aria-hidden="true"></i> Export Ms Excel</button>
            </div>
        </div>
    </div>    
    <div class="box-body" style="overflow-x: scroll; ">
    <table id="data-table-default" class="table table-bordered table-hover table-td-valign-middle text-white">
     <thead>
        <tr>
            <th>No</th>
    <th>Npk</th>
    <th>Nama Karyawan</th>
    <th>Status Karyawan</th>
    <th>Skill Level</th>
    <th>Action</th>
        </tr></thead><tbody><?php $no = 1;
        foreach ($karyawan_data as $karyawan)
        {
            ?>
            <tr>
        <td><?= $no++?></td>
        <td><?php echo $karyawan->npk ?></td>
        <td><?php echo $karyawan->nama_karyawan ?></td>
        <td><?php echo $karyawan->status_karyawan ?></td>
        <td><?php echo $karyawan->skill_level ?></td>
        <td style="text-align:center" width="200px">
            <button type="button" class="btn btn-success btn-sm read_data" id="<?php echo encrypt_url($karyawan->karyawan_id) ?>"><i class="fas fa-eye" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-primary btn-sm update_data" id="<?php echo encrypt_url($karyawan->karyawan_id) ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-danger btn-sm delete_data" id="<?php echo encrypt_url($karyawan->karyawan_id) ?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
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

    $('#data-table-default').DataTable({
        responsive: true
    })
  })
</script>