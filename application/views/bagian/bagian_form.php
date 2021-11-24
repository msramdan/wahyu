
        
            <form id="<?php echo $action; ?>" method="post">
            
            <table class="table  table-bordered table-hover table-td-valign-middle">
            <thead>
	    <tr><td >Nama Bagian <?php echo form_error('nama_bagian') ?></td><td><input type="text" class="form-control" name="nama_bagian" id="nama_bagian" placeholder="Nama Bagian" value="<?php echo $nama_bagian; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_bagian" value="<?php echo $id_bagian; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> <?php echo $button ?></button> 
	    <button type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button></td></tr>
</thead>
	</table>