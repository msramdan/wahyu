
<style>
	
	.select2-container
	{
		width: 100%;
	}

</style>

<form id="<?php echo $action; ?>" method="post">

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Npk <?php echo form_error('npk') ?></label>
		<div class="col-md-9">
			<input type="text" class="form-control" name="npk" id="npk" placeholder="Npk" value="<?php echo $npk; ?>" required />
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Nama Karyawan <?php echo form_error('nama_karyawan') ?></label>
		<div class="col-md-9">
			<input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan" placeholder="Nama Karyawan" value="<?php echo $nama_karyawan; ?>" required />
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Status Karyawan <?php echo form_error('status_karyawan') ?></label>
		<div class="col-md-9">
			<select name="status_karyawan" id="status_karyawan" class="form-control">
    			<?php

    			$liststatus = ['TETAP','KONTRAK'];

    			foreach ($liststatus as $value) {
    				?>
    					<option value="<?php echo $value ?>" <?php if($status_karyawan == $value){echo 'selected';} ?>><?php echo $value ?></option>
    				<?php
    			}
    			?>
    		</select>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Skill Level <?php echo form_error('skill_level') ?></label>
		<div class="col-md-9">
			<div class="input-group">
				<input type="range" class="form-range" min="1" max="4" name="skill_level" id="skill_level" value="<?php echo $skill_level; ?>" style="width: 200px;margin: auto 5px auto 0;"/>
				<span class="input-group-text level_text">1</span>
			</div>
		</div>
	</div>
	<input type="hidden" name="karyawan_id" value="<?php echo $karyawan_id; ?>" />
    <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> <?php echo $button ?></button> 
    <button type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button>
</form>

<script type="text/javascript">
	
	$(document).ready(function() {
		$(document).on('input', '#skill_level', function() {
			$('.level_text').text($(this).val())
		})
	})

</script>