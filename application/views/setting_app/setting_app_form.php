<div id="content" class="app-content">
<div class="col-xl-12 ui-sortable">
<div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

<div class="panel-heading ui-sortable-handle">
<h4 class="panel-title">KELOLA DATA SETTING_APP</h4>
<div class="panel-heading-btn">
<a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand" data-bs-original-title="" title="" data-tooltip-init="true"><i class="fa fa-expand"></i></a>
<a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
<a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
<a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
</div>
</div>
<div class="panel-body">      
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <thead>
            <table class="table  table-bordered table-hover table-td-valign-middle">
	    <tr><td >Nama Aplikasi <?php echo form_error('nama_aplikasi') ?></td><td><input type="text" class="form-control" name="nama_aplikasi" id="nama_aplikasi" placeholder="Nama Aplikasi" value="<?php echo $nama_aplikasi; ?>" /></td></tr>
	    <tr><td >Company <?php echo form_error('company') ?></td><td><input type="text" class="form-control" name="company" id="company" placeholder="Company" value="<?php echo $company; ?>" /></td></tr>

        <tr><td >Alamat <?php echo form_error('company') ?></td><td><input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" /></td></tr>


	    <tr><td >Author <?php echo form_error('author') ?></td><td><input type="text" class="form-control" name="author" id="author" placeholder="Author" value="<?php echo $author; ?>" /></td></tr>  



                    <tr>
                        <td >Favicon <?php echo form_error('favicon') ?></td>
                        <td>
                            <a href="#modal-dialog" data-bs-toggle="modal"><img  src="<?php echo base_url();?>assets/assets/img/<?=$favicon?>" style="width: 150px;height: 150px;border-radius: 10%;"></img></a>
                            <input type="hidden" name="favicon_lama" value="<?=$favicon?>">
                            <p style="color: red">Note : Pilih favicon Jika Ingin Merubah</p>
                            <input type="file" class="form-control" name="favicon" id="favicon" placeholder="favicon" value="" onchange="return validasiEkstensi_fav()" />
                        </td>
                    </tr>

                    <tr><td>
                      Jam Kerja <?php echo form_error('jam_kerja') ?></td><td>
                        <div class="input-group" style="max-width: 200px;">
                        <input type="number" class="form-control" name="jam_kerja" id="jam_kerja" placeholder="jam_kerja" value="<?php echo $jam_kerja; ?>" />
                        <div class="input-group-prepend">
                          <div class="input-group-text">Menit</div>
                        </div>
                        </div>
                    </td></tr>
                    


	    <tr><td></td><td><input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> <?php echo $button ?></button> 
	    <a class="btn btn-info" onclick="self.history.back()"><i class="fas fa-undo"></i> Kembali</a>
	</td></tr>
</thead>
	</table></form>        </div>
</div>
</div>
</div>

<!-- #modal-dialog Fav-->
<div class="modal fade" id="modal-dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <img src="<?php echo base_url();?>assets/assets/img/<?=$favicon?>" width="100%" />
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
        <a class="btn btn-primary" href="<?php echo base_url(); ?>setting_app/download_fav/<?=$favicon?>"><i
                        class="ace-icon fa fa-download"></i> Download</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function validasiEkstensi_fav(){
    var inputFile = document.getElementById('favicon');
    var pathFile = inputFile.value;
    var ekstensiOk = /(\.png)$/i;
    if(!ekstensiOk.exec(pathFile)){
        alert('Silakan upload file yang memiliki ekstensi .png');
        inputFile.value = '';
        return false;
    }else{
        // Preview photo
        if (inputFile.files && inputFile.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').innerHTML = '<iframe src="'+e.target.result+'" style="height:400px; width:600px"/>';
            };
            reader.readAsDataURL(inputFile.files[0]);
        }
    }
}
</script>