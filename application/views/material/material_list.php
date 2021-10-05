<div class="row">
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
                <th>Kd Material</th>
                <th>Id Bentuk</th>
                <th>Id Jenis Material</th>
                <th>Dimensi</th>
                <th>Berat Per Pcs</th>
                <th>Berat Total</th>
                <th>Qty</th>
                <th>Masa Jenis Material</th>
                <th>Volume</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($material_data as $material)
            {
                ?>
                <tr>
                    <td><?= $no++?></td>
                    <td><?php echo $material->kd_material ?></td>
                    <td><?php echo $material->id_bentuk ?></td>
                    <td><?php echo $material->id_jenis_material ?></td>
                    <td><?php echo $material->dimensi ?></td>
                    <td><?php echo $material->berat_per_pcs ?></td>
                    <td><?php echo $material->berat_total ?></td>
                    <td><?php echo $material->qty ?></td>
                    <td><?php echo $material->masa_jenis_material ?></td>
                    <td><?php echo $material->volume ?></td>
                    <td style="text-align:center" width="200px">
                        <?php 
                        echo anchor(site_url('material/read/'.encrypt_url($material->id)),'<i class="fas fa-eye" aria-hidden="true"></i>','class="btn btn-success btn-sm read_data"'); 
                        echo '  '; 
                        echo anchor(site_url('material/update/'.encrypt_url($material->id)),'<i class="fas fa-pencil-alt" aria-hidden="true"></i>','class="btn btn-primary btn-sm update_data"'); 
                        echo '  '; 
                        echo anchor(site_url('material/delete/'.encrypt_url($material->id)),'<i class="fas fa-trash-alt" aria-hidden="true"></i>','class="btn btn-danger btn-sm delete_data" Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                        ?>
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
      $('#data-table-default').DataTable({
        responsive: true
      });
</script>