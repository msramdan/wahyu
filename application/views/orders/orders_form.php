<link href="<?php echo base_url() ?>assets/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<style>

.select2 {
	min-height: calc(1.5em + (1rem + 2px));
	font-size: 0.875rem;
	border-radius: 6px;
	width: 100%;
}
	
.towewew {
    animation: animate-error 600ms ease-in-out;
}

@keyframes animate-error {
    0% {
        transform: scale(1.0);
    }
    25% {
        transform: scale(1.08);
    }
    50% {
        transform: scale(1.0);
    }
    75% {
        transform: scale(1.02);
    }
    100% {
        transform: scale(1.0);
    }
}

</style>

<button type="button" class="btn btn-info list-data mb-15px"><i class="fas fa-chevron-left"></i> Kembali</button>
<div class="row">
	<div class="col">
		
	</div>

	<div class="col-md-8 col-sm-12 col-xs-12">
		<form id="<?php echo $action; ?>">
			<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" /> 
			<div class="row">
				<div class="col">
					<div class="mb-15px">
					  <label style="font-weight: bold; color: white;" for="nama_pemesan" class="form-label mb-15px">
					    Nama Pemesan <span style="color: red">*</span>
					  </label>
					  <input type="text" class="form-control form-control-lg" name="nama_pemesan" id="nama_pemesan" placeholder="Masukan inputan anda" value="<?php echo $nama_pemesan; ?>" required/>
					</div>

					<div class="mb-15px">
					  <label style="font-weight: bold; color: white;" for="bagian" class="form-label mb-15px">Bagian</label>
					  <select class="form-control form-control-lg" name="bagian" id="bagian" placeholder="Masukan inputan anda" required>
					  	<?php
					  		foreach ($bagian_list as $key => $value) {
					  			?>
					  			<option value="<?php echo $value->id_bagian ?>" <?php echo $bagian == $value->id_bagian ? 'selected' : '' ?>><?php echo $value->nama_bagian ?></option>
					  			<?php
					  		}
					  	?>
					  </select>
					</div>

					<div class="mb-15px">
					  <label style="font-weight: bold; color: white;" for="no_kontak" class="form-label mb-15px">No. Telepon</label>
					  <input type="text" name="no_kontak" id="no_kontak" class="form-control form-control-lg" value="<?php echo $no_kontak ?>" placeholder="Masukan inputan anda" required/>
					</div>

					<div class="mb-15px">
						<label style="font-weight: bold; color: white;" for="keterangan" class="form-label mb-15px">
					    Keterangan
					  	</label>
					  <select name="keterangan" class="form-control form-control-lg" id="keterangan" required>
		    			<option selected>-pilih-</option>
		    			<option value="1" <?php echo $keterangan == 1 ? 'selected' : '' ?>>Part Baru</option>
		    			<option value="2" <?php echo $keterangan == 2 ? 'selected' : '' ?>>Repair</option>
		    			<option value="3" <?php echo $keterangan == 3 ? 'selected' : '' ?>>Modifikasi</option>
		    		  </select>
					</div>

					<div class="mb-15px">
					 <label style="font-weight: bold; color: white;" for="priority" class="form-label mb-15px">
					    Prioritas
					  </label>
					  <div class="warning">
					  	
					  </div>
					  <select class="form-control form-control-lg" name="priority" id="priority" required>
			    			<option selected>-pilih-</option>
			    			<option value="1" <?php echo $priority == 1 ? 'selected' : '' ?> >Biasa</option>
			    			<option value="2" <?php echo $priority == 2 ? 'selected' : '' ?>>Urgent</option>
			    			<option value="3" <?php echo $priority == 3 ? 'selected' : '' ?>>Top Urgent</option>
			    	  </select>
					</div>

					<div class="mb-15px">
					  <label style="font-weight: bold; color: white;" for="nama_barang" class="form-label mb-15px">
					    Nama Barang
					  </label>
					  <input type="text" name="nama_barang" value="<?php echo $nama_barang ?>" id="nama_barang" placeholder="Masukan inputan anda" class="form-control form-control-lg" required/>
					</div>

					<div class="mb-15px">
					  <label style="font-weight: bold; color: white;" for="qty" class="form-label mb-15px">
					    Quantity
					  </label>
					  <input type="number" name="qty" value="<?php echo $qty ?>" id="qty" class="form-control form-control-lg" placeholder="Masukan inputan anda" required/>
					</div>

					<div class="mb-15px">
					  <label style="font-weight: bold; color: white;" for="Due Date" class="form-label mb-15px">
					    Due Date
					  </label>
					  <input type="date" name="due_date" value="<?php echo $due_date ?>" id="due_date" class="form-control form-control-lg" placeholder="Masukan inputan anda" required/>
					</div>

					<div class="mb-15px">
					  <label style="font-weight: bold; color: white;" for="note" class="form-label mb-15px">
					    Catatan
					  </label>
					  <textarea type="text" name="note" rows="4" value="<?php echo $note ?>" id="note" class="form-control form-control-lg" placeholder="Masukan inputan anda"><?php echo $note ?></textarea>
					</div>

					<label style="font-weight: bold; color: white;" for="attachment" class="form-label mb-15px">
					    Attachment
					</label>
					<div id="frame-pdf" style="width: 100%; height: 0px;">
						<canvas id="pdfViewer" style="height: 100%; width: 100%; object-fit: cover;"></canvas>
					</div>
					<img id="frame" src="<?php echo base_url().'assets/internal/'.$attachment ?>" style="object-fit: cover; display: <?php echo $action == 'form_update_action' ? 'block':'none' ?>; width: 100%; height: 0px;" />
					<div class="mb-15px">
					  <input class="form-control form-control-lg" name="attachment" id="attachment" type="file" accept=".png,.jpeg,.jpg,.rar,.pdf" onchange="preview(this)"/>
			    		<input type="hidden" name="attachment_old" id="attachment_old" placeholder="Attachment" value="<?php echo $attachment; ?>" />
					</div>

					<button type="submit" class="btn btn-action btn-danger btn-submit"><i class="fas fa-save"></i> Simpan</button>
					<button type="reset" class="btn btn-action btn-info"><i class="fas fa-redo"></i> Bersihkan</button> 

				</div>
			</div>
		</form>	
	</div>

	<div class="col">
		
	</div>
</div>

<script src="<?php echo base_url() ?>assets/assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script type="text/javascript">
	$('#form_create_action').on('reset', function(e)
	{
	    setTimeout(function() { 
	    	frame.style.display = "none"
	    	frame.src = null
	    	$('.warning').html(``)
	    });
	});

	$("#bagian").select2({ placeholder: "Pilih Bagian" });

	function preview(s) {
		if(s.files[0].size > 2097152){
	       s.value = ""
	       frame.style.display = "none"
	       alert("Maksimal lampiran 2 MB")
	    } else {

	    	var ext = s.value.match(/\.([^\.]+)$/)[1];
			switch (ext) {
			case 'jpg':
			case 'jpeg':
			case 'png':
				$('#frame').css('height','200px')
				$('#frame-pdf').css('height','0px')
			  	frame.style.display = "block"
	    		frame.src=URL.createObjectURL(event.target.files[0]);
			  	break;
			case 'pdf':
				var file = s.files[0]
				var pdfjsLib = window['pdfjs-dist/build/pdf'];
				pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
				var fileReader = new FileReader();  
				fileReader.onload = function() {
					var pdfData = new Uint8Array(this.result);
					var loadingTask = pdfjsLib.getDocument({data: pdfData});
					loadingTask.promise.then(function(pdf) {
					  // console.log('PDF loaded');
					  var pageNumber = 1;
					  pdf.getPage(pageNumber).then(function(page) {
						// console.log('Page loaded');
						
						var scale = 1.5;
						var viewport = page.getViewport({scale: scale});

						// Prepare canvas using PDF page dimensions
						var canvas = $("#pdfViewer")[0];
						var context = canvas.getContext('2d');
						canvas.height = viewport.height;
						canvas.width = viewport.width;

						// Render PDF page into canvas context
						var renderContext = {
						  canvasContext: context,
						  viewport: viewport
						};
						var renderTask = page.render(renderContext);
						renderTask.promise.then(function () {
						  // console.log('Page rendered');
						  $('#frame').css('height','0px')
						  $('#frame-pdf').css('height','200px')
						});
					  });
					}, function (reason) {
					  // PDF loading error
					  console.error(reason);
					});
				};
				fileReader.readAsArrayBuffer(file);
				break;
			case 'rar':
				break;
			default:
				$('#frame').css('height','0px')
				$('#frame-pdf').css('height','0px')
				alert('Not allowed');
				this.value = '';
			}
	    }
	}

	$('#priority').on('change', function() {
		var thisval = $(this).val()
		if (thisval == 1) {
			$('.warning').html(`
				<div class="alert alert-warning towewew">
					<p><i class="fas fa-exclamation-triangle"></i> Informasi</p>
					Dengan memilih prioritas <b>Biasa</b>, order anda akan diproses dengan jadwal yang normal
				</div>
				`)
		}

		if (thisval == 2) {
			$('.warning').html(`
				<div class="alert alert-warning towewew">
					<p><i class="fas fa-exclamation-triangle"></i> Informasi</p>
					Dengan memilih prioritas <b>Urgent</b>, order anda akan diproses dengan jadwal yang diprioritaskan dari segala order dengan prioritas <b>Biasa</b>.
				</div>
				`)
		}

		if (thisval == 3) {
			$('.warning').html(`
				<div class="alert alert-warning towewew">
					<p><i class="fas fa-exclamation-triangle"></i> Informasi</p>
					Dengan memilih prioritas <b>Top Ugent</b>, order anda akan paling diprioritaskan daripada order <b>Biasa</b> dan <b>Urgent</b>, kemungkinan besar order anda dapat diselesaikan dalam waktu cepat. <i>Untuk memilih opsi ini silahkan koordinasi dengan pihak terkait.</i>
				</div>
				`)
		}

		if (thisval == null) {
			$('.warning').html(``)
		}

	})

</script>