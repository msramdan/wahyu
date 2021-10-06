<style>
	
	.select2-container
	{
		width: 100%;
	}

</style>


<style>
	
	.select2-container
	{
		width: 100%;
	}

</style>

<form id="<?php echo $action; ?>" method="post">

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Kd Mesin <?php echo form_error('kd_mesin') ?></label>
		<div class="col-md-9">
			<input type="text" class="form-control" name="kd_mesin" id="kd_mesin" placeholder="Kd Mesin" value="<?php echo $kd_mesin; ?>" />
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Nama Mesin <?php echo form_error('nama_mesin') ?></label>
		<div class="col-md-9">
			<input type="text" class="form-control" name="nama_mesin" id="nama_mesin" placeholder="Nama Mesin" value="<?php echo $nama_mesin; ?>" required />
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Keterangan <?php echo form_error('Keterangan') ?></label>
		<div class="col-md-9">
			<textarea class="form-control" rows="3" name="Keterangan" id="Keterangan" placeholder="Keterangan"><?php echo $Keterangan; ?></textarea>
		</div>
	</div>

	<input type="hidden" name="mesin_id" value="<?php echo $mesin_id; ?>" />
    <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> <?php echo $button ?></button> 
    <button type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		let timeoutID = null;
		$('#kd_mesin').keyup(function(e){

			const thisel = $(this)

			const val = $(this).val()

			thisel.removeClass('is-invalid')
			thisel.removeClass('is-valid')
			thisel.nextAll('div').remove()

			clearTimeout(timeoutID);
			timeoutID = setTimeout(() => {

				if (val.length > 1) {
					$.ajax({
			            type : "POST",
			            url  : "<?php echo base_url() ?>/mesin/detect_kd_mesin",
			            data : {
			                kd_mesin: val
			            },
			            success: function(data){
			                const dt = JSON.parse(data)

			                thisel.addClass(dt.class)
			                thisel.after(dt.appendedelement)
			                $('.btn-danger').css('display',dt.a)
			            },
			            error: function(e){
			              	thisel.addClass('is-invalid')
			                thisel.after(`<div class="invalid-feedback">Jaringan mengalami masalah</div>`)
			                $('.btn-danger').css('display','none')
			            }
			        });
				}

				if (val.length <= 1) {
					thisel.addClass('is-invalid')
			        thisel.after(`<div class="invalid-feedback">Wajib Diisi</div>`)
				}

			}, 500)
		})
	})
</script>