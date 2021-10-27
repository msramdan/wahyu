<style>
	
.need-attention {
	animation: glow 1s infinite alternate;
}

@keyframes glow {
  from {
    text-shadow: 0;
  }
  to {
    text-shadow: 0 0 3px #fff, 0 0 3px #e39b3f, 0 0 3px #e39b3f, 0 0 3px #e39b3f, 0 0 3px #e39b3f, 0 0 3px #e39b3f, 0 0 3px #e39b3f;
  }
}

.erroryahaha {
    animation: animate-error 500ms ease-in-out;
}

@keyframes animate-error {
    0% {
        transform: scale(1.0);
    }
    25% {
        transform: scale(1.1);
    }
    50% {
        transform: scale(1.0);
    }
    75% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1.0);
    }
}


</style>

<button type="button" class="btn btn-info list-data mb-15px"><i class="fas fa-undo"></i> Kembali</button>

<?php 	
	if ($action == 'form_update_action') {
		?>
		<form id="<?php echo $action; ?>">
			<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" /> 
			<div class="row">
				<div class="col-md-9">
					<table class="table  table-bordered table-hover table-td-valign-middle">
				        <thead>
						    <tr>
						    	<td >Nama Pemesan <?php echo form_error('nama_pemesan') ?></td>
						    	<td><input type="text" class="form-control" name="nama_pemesan" id="nama_pemesan" placeholder="Nama Pemesan" value="<?php echo $nama_pemesan; ?>" /></td>
						    </tr>
						    <tr>
						    	<td >Bagian <?php echo form_error('bagian') ?></td>
						    	<td><input type="text" class="form-control" name="bagian" id="bagian" placeholder="Bagian" value="<?php echo $bagian; ?>" /></td>
						    </tr>
						    <tr>
						    	<td >Keterangan <?php echo form_error('keterangan') ?></td>
						    	<td><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?php echo $keterangan; ?>" /></td>
						    </tr>
						    <tr>
						    	<td >Priority <?php echo form_error('priority') ?></td>
						    	<td>
						    		<select class="form-control" name="priority" id="priority">
						    			<option>-pilih-</option>
						    			<option value="0" <?php echo $priority == 0 ? 'selected' : '' ?> >Biasa</option>
						    			<option value="1" <?php echo $priority == 1 ? 'selected' : '' ?>>Urgent</option>
						    			<option value="2" <?php echo $priority == 2 ? 'selected' : '' ?>>Top Urgent</option>
						    		</select>
						    </tr>
						    <tr>
						    	<td >Approved By <?php echo form_error('approved_by') ?></td>
						    	<td><input type="text" class="form-control" name="approved_by" id="approved_by" placeholder="Approved By" value="<?php echo $approved_by; ?>" /></td>
						    </tr>
						    <tr>
						    	<td >Attachment <?php echo form_error('attachment') ?></td>
						    	<td>
						    		<img id="frame" src="<?php echo base_url().'assets/internal/'.$attachment ?>" width="100%" height="200px" style="object-fit: cover;" />
									<input class="form-control" name="attachment" id="attachment" type="file" onchange="preview()" required/>
						    		<input type="hidden" class="form-control" name="attachment_old" id="attachment_old" placeholder="Attachment" value="<?php echo $attachment; ?>" />
						    	</td>
						    </tr>
						    <tr>
						    	<td></td>
						    	<td class="btn-action-group">
						    		<button type="submit" class="btn btn-action btn-danger btn-submit"><i class="fas fa-save"></i> Simpan</button> 
						    	</td>
						    </tr>
						</thead>
					</table>
				</div>
				<div class="col-md-3">
					<h4>Step</h4>
					<ul class="fa-ul">
						<li><span class="fa-li"><i class="fas fa-check-circle" style="color: green;"></i></span> Identitas Pemesan</li>
						<li><span class="fa-li"><i class="fas fa-check-circle" style="color: green;"></i></span> Verifikasi</li>
						<li><span class="fa-li"><i class="fas fa-check-circle" style="color: green;"></i></span> Sketch Upload</li>
					</ul>
					<div class="alertnya">
						<div class="alert alert-success alert-dismissible fade show">
						  <strong>Catatan!</strong> Selesaikan isian yang diperlukan terlebih dahulu untuk lanjut ke tahap selanjutnya< 
						  <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php
	}

	if ($action == 'form_create_action') {
		?>
		<form id="<?php echo $action; ?>">
			<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" /> 
			<div class="row">
				<div class="col-md-9">
					<table class="table  table-bordered table-hover table-td-valign-middle">
				        <thead>
						    <tr class="step1 step-form">
						    	<td >Nama Pemesan <?php echo form_error('nama_pemesan') ?></td>
						    	<td><input type="text" class="form-control" name="nama_pemesan" id="nama_pemesan" placeholder="Nama Pemesan" value="<?php echo $nama_pemesan; ?>" /></td>
						    </tr>
						    <tr class="step1 step-form">
						    	<td >Bagian <?php echo form_error('bagian') ?></td>
						    	<td><input type="text" class="form-control" name="bagian" id="bagian" placeholder="Bagian" value="<?php echo $bagian; ?>" /></td>
						    </tr>
						    <tr class="step1 step-form">
						    	<td >Keterangan <?php echo form_error('keterangan') ?></td>
						    	<td><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?php echo $keterangan; ?>" /></td>
						    </tr>
						    <tr class="step1 step-form">
						    	<td >Priority <?php echo form_error('priority') ?></td>
						    	<td>
						    		<select class="form-control" name="priority" id="priority">
						    			<option>-pilih-</option>
						    			<option value="0" <?php echo $priority == 0 ? 'selected' : '' ?> >Biasa</option>
						    			<option value="1" <?php echo $priority == 1 ? 'selected' : '' ?>>Urgent</option>
						    			<option value="2" <?php echo $priority == 2 ? 'selected' : '' ?>>Top Urgent</option>
						    		</select>
						    </tr>
						    <tr class="step2 step-form" hidden>
						    	<td >Approved By <?php echo form_error('approved_by') ?></td>
						    	<td><input type="text" class="form-control" name="approved_by" id="approved_by" placeholder="Approved By" value="<?php echo $approved_by; ?>" /></td>
						    </tr>
						    <tr class="step3 step-form" hidden>
						    	<td >Attachment <?php echo form_error('attachment') ?></td>
						    	<td>
						    		<img id="frame" src="" width="100%" height="200px" style="object-fit: cover;" />
									<input class="form-control" name="attachment" id="attachment" type="file" onchange="preview()" required/>
						    		<input type="hidden" class="form-control" name="attachment_old" id="attachment_old" placeholder="Attachment" value="<?php echo $attachment; ?>" />
						    	</td>
						    </tr>
						    <tr>
						    	<td></td>
						    	<td class="btn-action-group">
						    		<button type="button" class="btn btn-success btn-action btn-next"><i class="fas fa-chevron-right"></i> Selanjutnya</button> 
						    	</td>
						    </tr>
						</thead>
					</table>
				</div>
				<div class="col-md-3">
					<h4>Step</h4>
					<ul class="fa-ul">
						<li><span class="fa-li step-text step1-text need-attention"><i class="fas fa-exclamation-circle" style="color: red;"></i></span> Identitas Pemesan</li>
						<li><span class="fa-li step-text step2-text"><i class="fas fa-exclamation-circle" style="color: red;"></i></span> Verifikasi</li>
						<li><span class="fa-li step-text step3-text"><i class="fas fa-exclamation-circle" style="color: red;"></i></span> Sketch Upload</li>
					</ul>
					<div class="alertnya">
						<div class="alert alert-success alert-dismissible fade show">
						  <strong>Catatan!</strong> Selesaikan isian yang diperlukan terlebih dahulu untuk lanjut ke tahap selanjutnya< 
						  <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php
	}

?>



<script type="text/javascript">

	function preview() {
	    frame.src=URL.createObjectURL(event.target.files[0]);
	}

	var step = 1

	function stepstatus(w, elem) {	
	
		$('.alertnya').html(`<div class="alert alert-success alert-dismissible fade show">
			  <strong>Catatan!</strong> Selesaikan isian yang diperlukan terlebih dahulu untuk lanjut ke tahap selanjutnya< 
			  <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
			</div>`)
		$(elem).addClass('disabled').attr('disabled','disabled').html('<i class="fas fa-sync fa-spin"></i>')

		var inputan = $('.step' + step).find('input').val()

		if (!!inputan) {
			$('.step-text.need-attention').html('<i class="fas fa-check-circle" style="color: green;"></i>')
		}

		if (!inputan) {
			$('.step-text.need-attention').html('<i class="fas fa-exclamation-circle" style="color: red;"></i>')
		}
		
		if (elem == '.btn-next') {
    		step++
		}
		if (elem == '.btn-prev') {
    		step--
		}
		$('.step-text').removeClass('need-attention')
        $('.step' + step + '-text').addClass('need-attention')


        setTimeout(function(){

        	$('.step-form').attr('hidden','hidden')
			$('.step' + step).removeAttr('hidden')

			if (step <= 1) {
				$('.btn-action-group').html(`
					<button type="button" class="btn btn-action btn-success btn-next"><i class="fas fa-chevron-right"></i> Selanjutnya</button> 
				`)
			}

			if (step > 1 && step < 3) {
				$('.btn-action-group').html(`
					<button type="button" class="btn btn-action btn-warning btn-prev"><i class="fas fa-chevron-left"></i> Sebelumnya</button> 
					<button type="button" class="btn btn-action btn-success btn-next"><i class="fas fa-chevron-right"></i> Selanjutnya</button> 
				`)
			}

			if (step >= 3) {
				$('.btn-action-group').html(`
				<button type="button" class="btn btn-action btn-warning btn-prev"><i class="fas fa-chevron-left"></i> Sebelumnya</button> 
				<button type="submit" action="save" class="btn btn-action btn-danger btn-submit"><i class="fas fa-save"></i> Simpan</button>
				<button type="submit" action="savethenproduction" class="btn btn-action btn-danger btn-submit"><i class="fas fa-save"></i> Simpan dan Produksi</button>
				`)
			}

			$('.btn-next').removeClass('disabled').removeAttr('disabled').html('<i class="fas fa-chevron-right"></i> Selanjutnya')
        }, 1000)
    }

    $('.btn-action-group').on('click','.btn-next',function() {
    	var inputan = $('.step' + step).find('input').val()

    	if (!inputan) {
    		$('.alertnya').html(`
    			<div class="alert alert-danger alert-dismissible erroryahaha fade show">
				  <strong>Isi bidang yang kosong!</strong> Selesaikan isian yang diperlukan terlebih dahulu untuk lanjut ke tahap selanjutnya< 
				  <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
				</div>
    			`)
    	} else {
    		stepstatus(step, '.btn-next')
    	}
    })

    $('.btn-action-group').on('click','.btn-prev',function() {
    	stepstatus(step, '.btn-prev')
    })

    // $('#attachment').on('change',function() {
    // 	var filename = $(this).val().replace(/C:\\fakepath\\/i, '')
    // })





</script>