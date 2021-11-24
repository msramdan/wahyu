<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">        
            <div class="box-body">
                <div class='row'>
                    <div class='col-md-9'>
                        <div style="padding-bottom: 10px;">
<button class="btn btn-danger btn-sm tambah_data"><i class="fas fa-plus-square" aria-hidden="true"></i> Tambah Data</button>
                        </div>
                    </div>
                </div>    
                <div class="box-body" style="overflow-x: scroll; ">
                    <table id="data-table-default" class="table table-bordered table-hover table-td-valign-middle text-white">
                         <thead>
                            <tr>
                                <th>No</th>
                        <th>Nama Bagian</th>
                        <th>Action</th>
                            </tr></thead><tbody><?php $no = 1;
                            foreach ($bagian_data as $bagian)
                            {
                                ?>
                                <tr>
                            <td><?= $no++?></td>
                            <td><?php echo $bagian->nama_bagian ?></td>
                            <td style="text-align:center" width="200px">
                                <button type="button" class="btn btn-success btn-sm read_data" id="<?php echo encrypt_url($bagian->id_bagian) ?>"><i class="fas fa-eye" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-primary btn-sm update_data" id="<?php echo encrypt_url($bagian->id_bagian) ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger btn-sm delete_data" id="<?php echo encrypt_url($bagian->id_bagian) ?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
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


