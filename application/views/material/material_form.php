
<style>
	
	.select2-container
	{
		width: 100%;
	}

</style>

<form id="<?php echo $action; ?>" method="post">

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Kode Material <?php echo form_error('kd_material') ?></label>
		<div class="col-md-9">
			<input required type="text" class="form-control" name="kd_material" id="kd_material" placeholder="Kd Material" value="<?php echo $kd_material; ?>" />
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Bentuk <?php echo form_error('id_bentuk') ?></label>
		<div class="col-md-9">
			<select class="form-control default-select2" name="id_bentuk" id="id_bentuk">
    			<?php
    			foreach ($list_bentuk as $key => $value) {
    				?>
    					<option value="<?php echo $value->kode_bentuk ?>" <?php if($id_bentuk == $value->kode_bentuk){echo 'selected';} ?>><?php echo $value->nama_bentuk ?></option>
    				<?php
    			}
    			?>
    		</select>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Jenis Material <?php echo form_error('id_jenis_material') ?></label>
		<div class="col-md-9">
			<select class="form-control default-select2" class="form-control" name="id_jenis_material" id="id_jenis_material">
    			<?php
    			foreach ($list_jenis_material as $key => $value) {
    				?>
    					<option value="<?php echo $value->id ?>" <?php if($id_jenis_material == $value->id){echo 'selected';} ?>><?php echo $value->nama_jenis_material ?></option>
    				<?php
    			}
    			?>
    		</select>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Dimensi <?php echo form_error('dimensi') ?></label>
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-4">
					<label>Diameter/Tebal</label>
					<div class="input-group">
						<input required type="number" class="form-control" value="<?php echo $diametertebal ?>" name="diametertebal" id="diametertebal"  />
						<span class="input-group-text">mm</span>
					</div>
				</div>
				<div class="col-md-4">
					<label>Panjang</label>
					<div class="input-group">
						<input required type="number" class="form-control" value="<?php echo $panjang ?>" name="panjang" id="panjang"  />
						<span class="input-group-text">mm</span>
					</div>
				</div>
				<div class="col-md-4">
					<label>Lebar</label>
					<div class="input-group">
						<input type="number" class="form-control" value="<?php echo $lebar ?>" name="lebar" id="lebar"  />
						<span class="input-group-text">mm</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Masa Jenis Material <?php echo form_error('masa_jenis_material') ?></label>
		<div class="col-md-9">
			<div class="input-group">
				<input required type="number" step="0.01" class="form-control" name="masa_jenis_material" id="masa_jenis_material" placeholder="Masa Jenis Material" value="<?php echo $masa_jenis_material; ?>" />
				<span class="input-group-text">Kg/cm3</span>
			</div>
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Qty <?php echo form_error('qty') ?></label>
		<div class="col-md-9">
			<div class="input-group">
				<input required type="number" class="form-control" name="qty" id="qty" placeholder="Qty" value="<?php echo $qty; ?>" />
				<span class="input-group-text">pcs</span>
			</div>
		</div>
	</div>

	<h4>Summary</h4>
	<table class="table  table-bordered table-hover table-td-valign-middle">
		<thead>	
		    <tr><td >Berat Per Pcs <?php echo form_error('berat_per_pcs') ?></td><td>
		    	<div class="input-group" style="width: 200px;">
		    		<input required type="text" readonly class="form-control" name="berat_per_pcs" id="berat_per_pcs" placeholder="0" value="<?php echo $berat_per_pcs; ?>" />
		    		<span class="input-group-text">Kg</span>
		    	</div>
		    	</td>
		    </tr>
		    		
		    <tr><td >Berat Total <?php echo form_error('berat_total') ?></td><td>
		    	<div class="input-group" style="width: 200px;">
		    		<input required type="text" readonly class="form-control" name="berat_total" id="berat_total" placeholder="0" value="<?php echo $berat_total; ?>" />
		    		<span class="input-group-text">Kg</span>
		    	</div>
		    	</td>
		    </tr>
		    <tr><td >Volume <?php echo form_error('volume') ?></td><td>
		    	<div class="input-group" style="width: 200px;">
		    		<input required type="text" readonly class="form-control" name="volume" id="volume" placeholder="0" value="<?php echo $volume; ?>" />
		    		<span class="input-group-text">Kg</span>
		    	</div></td>
			</tr>
		</thead>
	</table>
	<input type="hidden" name="id" value="<?php echo $id; ?>" /> 
    <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> <?php echo $button ?></button> 
    <button type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button>
</form>
<script src="<?= base_url() ?>assets/assets/plugins/select2/dist/js/select2.min.js"></script>
<script type="text/javascript">

   $(".default-select2").select2();
	$(document).ready(function() {
		let timeoutID = null;
		$('#kd_material').keyup(function(e){

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
			            url  : "<?php echo base_url() ?>/Material/detect_kd_material",
			            data : {
			                kd_material: val
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

		let qty = $('#qty').val()
		let beratperpcs = $('#berat_per_pcs').val()
		let totalberat = $('#berat_total').val()
		let volume = $('#volume').val()
		let masajenis = $('#masajenis').val()
		let diametertebal = $('#diametertebal').val()
		let panjang = $('#panjang').val()
		let lebar = $('#lebar').val()

		function hitung_volume(diametertebal,panjang,lebar) {
			if (lebar) {
				volume = diametertebal * panjang * lebar

				$('#volume').val(volume.toFixed(2))
			} else {
				volume = 3.14 * ((diametertebal / 2) ** 2) * panjang
				$('#volume').val(volume.toFixed(2))
			}
		}

		function hitung_berat_per_pcs(masajenis) {
			beratperpcs = (volume/1000000)*masajenis
			$('#berat_per_pcs').val(beratperpcs.toFixed(2))
		}

		function hitung_total_berat(qty) {
			totalberat = beratperpcs * qty
			$('#berat_total').val(totalberat.toFixed(2))
		}

		$('#qty').keyup(function() {
			hitung_total_berat($(this).val())
		})

		$('#masa_jenis_material').keyup(function() {
			hitung_berat_per_pcs($(this).val())
		})

		$('#diametertebal').keyup(function() {
			diametertebal = $(this).val()
			hitung_volume(diametertebal,panjang,lebar)
		})

		$('#panjang').keyup(function() {
			panjang = $(this).val()
			hitung_volume(diametertebal,panjang,lebar)	
		})

		$('#lebar').keyup(function() {
			lebar = $(this).val()
			hitung_volume(diametertebal,panjang,lebar)
		})

	})

</script>