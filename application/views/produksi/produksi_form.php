<style>
	
	.select2-container
	{
		width: 100%;
	}

	table.tabel-material-ready-to-use {
    	counter-reset: rowNumber;
	}

	table.tabel-material-ready-to-use tbody tr {
	    counter-increment: rowNumber;
	}

	table.tabel-material-ready-to-use tbody tr td:first-child::before {
	    content: counter(rowNumber);
	}

	.oops {
		background: #ff00004d;
	}

</style>

<form id="<?php echo $action; ?>" method="post">

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Tanggal Produksi <?php echo form_error('tanggal_produksi') ?></label>
		<div class="col-md-9">
			<input required type="date" class="form-control" name="tanggal_produksi" id="tanggal_produksi" placeholder="Tanggal Produksi" value="<?php echo $tanggal_produksi; ?>" />
		</div>
	</div>

	<div class="row mb-15px">
		<label class="form-label col-form-label col-md-3">Target Selesai</label>
		<div class="col-md-9">
			<input required type="date" class="form-control" readonly name="rencana_selesai" id="rencana_selesai" placeholder="Tanggal Produksi" value="<?php echo $rencana_selesai; ?>" />
		</div>
	</div>

	<div class="row mb-15px">
		<div class="accordion" id="accordion" style="margin: 10px 0;">
			  <div class="accordion-item border-0">
			    <div class="accordion-header" id="headingOne">
			    	<div class="bg-gray-900 text-white px-3 py-10px">
			    		<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="optionone" data-bs-toggle="collapse" data-bs-target="#collapseOne"/>
		  					<label class="form-check-label text-white" for="optionone">Smart Allocate</label>
						</div>
			    	</div>
			    </div>
			    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordion">
			      <div class="accordion-body bg-gray-800 text-white">
			        <div class="row mb-15px">
		        		<label class="form-label col-form-label col-3">Per-machine Material Treshold</label>
			        	<div class="col-3">
			        		<input type="number" name="tresholdmaterialspermachine" class="form-control tresholdmaterialspermachine" min="5" value="10" required="">
			        	</div>
			        </div>
			        <div class="row">
		        		<label class="form-label col-form-label col-3">Per-machine Goods Treshold</label>
			        	<div class="col-3">
			        		<input type="number" name="tresholdgoodspermachine" class="form-control tresholdgoodspermachine" min="5" value="10" required="">
			        	</div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="alertnya">
				
			</div>
			
			<table class="table table-hover table-sm tabel-machine">
				<thead>
					<tr>
						<th>Machine Name</th>
						<th>Used For</th>
						<th>Throughput</th>
						<th>Shift</th>
						<th>Material Processed</th>
						<th>Products</th>
						<th>Time</th>
						<th hidden="hidden">T. Minutes</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$arrbarangdoneperminuteonsinglemachine = [15, 25, 27 ,28 ,21];

					if ($machine_list) {
						foreach ($machine_list as $key => $value) {
							?>
							<tr class="available-machine" id="<?php echo $value->mesin_id ?>">
								<td>
									<div class="form-check">
										<input class="form-check-input checkboxmachine" name="machine_use[]" type="checkbox" id="checkbox<?php echo $value->mesin_id ?>" value="<?php echo $value->mesin_id ?>">
										<label class="form-check-label" for="checkbox<?php echo $value->mesin_id ?>"><?php echo $value->kd_mesin.' ('.$value->jenis_mesin.')' ?></label>
									</div>
								</td>
								<td>
									<input type="text" name="machineusedfor[]" class="form-control-plaintext" readonly value="<?php echo $value->used_for ?>">	
								</td>
								<td>
									<div class="input-group">
										<input type="number" name="troughputperproduct[]" class="form-control troughputperproduct" value="0" min="0">
										<span class="input-group-text">
											Minute(s)/Pd.
										</span>
									</div>
								</td>
								<td>
									<div class="form-check form-check-inline">
										<input class="form-check-input checkboxshiftformachine<?php echo $value->mesin_id ?>" name="shift1machine<?php echo $value->mesin_id ?>" type="checkbox" id="shift1machine<?php echo $value->mesin_id ?>" checked value="1" />
										<label class="form-check-label" for="shift1machine<?php echo $value->mesin_id ?>">1</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input checkboxshiftformachine<?php echo $value->mesin_id ?>" name="shift2machine<?php echo $value->mesin_id ?>" type="checkbox" id="shift2machine<?php echo $value->mesin_id ?>" value="0"/>
										<label class="form-check-label" for="shift2machine<?php echo $value->mesin_id ?>">2</label>
									</div>
								</td>
								<td>
									<input type="number" name="materialallocated[]" class="form-control materialallocated" value="0">
								</td>
								<td>
									<input type="text" name="goodsallocated[]" readonly class="form-control-plaintext goodsallocated" value="0">
								</td>
								<td>
									<div class="input-group">
										<input type="text" name="timespentpermachine[]" class="form-control-plaintext" readonly>
									</div>
								</td>
								<td hidden>
									<input type="number" name="totalminutes" class="totalminutespermachine" value="0">
								</td>

							</tr>
							<?php
						}
					}
					?>
					<tr>
						<td colspan="4" style="text-align: right; font-size: 14px;"><b>Total</b></td>
						<td><input type="text" name="totalmaterialused" class="form-control-plaintext totalmaterialused"></td>
						<td><input type="text" name="totalproductions" class="form-control-plaintext totalproductions"></td>
						<td><input type="text" name="predictiondone" class="form-control-plaintext predictiondone"></td>
						<td hidden><input type="number" name="totalminuteseverymachine" class="totalminuteseverymachine" value="0"></td>
					</tr>
					
				</tbody>
			</table>
	</div>

	<div class="row m-15px">
		<div class="col-md-3">
			
		</div>
		<div class="col-md-5">
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="User Id" value="<?php echo $user_id; ?>" />
			<div class="input-group">
			    <button type="submit" class="btn btn-danger btn-create-produksi disabled" disabled=""><i class="fas fa-save"></i> <?php echo $button ?></button> 
			    <button type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button>
			</div>
		</div>
	</div>

	<div class="container">
		<h4>Kebutuhan Material per-barang</h4>
		<div class="alertdiv">
			
		</div>
		<div class="row">
			<div class="col-md-6">
				<table class="table table-bordered table-hover table-td-valign-middle tabel-material-ready-to-use">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Material</th>
							<th>Qty</th>
							<th>will be used</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="materials_ready_to_use">
						<?php
						if ($material_needs) {
							foreach ($material_needs as $key => $value) {
								?>
								<tr id="<?php echo $value->kd_material ?>">
					        		<td></td>
					        		<td><input type="text" name="material_dibutuhkan[]" readonly class="form-control-plaintext ready-to-use-<?php echo $value->kd_material ?>-material" value="<?php echo $value->kd_material ?>" /></td>
					        		<td><input type="text" name="stok_dibutuhkan[]" readonly class="form-control-plaintext ready-to-use-qty ready-to-use-<?php echo $value->kd_material ?>-qty" value="<?php echo $value->jumlah_bahan ?>" /></td>
					        		<td><input type="text" name="stok_dibutuhkan[]" readonly class="form-control-plaintext qty-x-used qty-x-used-<?php echo $value->kd_material ?>" value="69" /></td>
					        		<td style="width: 80px;">
					        			<div class="input-group">
					        			<button type="button" id="<?php echo $value->kd_material ?>" class="btn btn-xs btn-secondary btn-kurangi-material"><i class="fas fa-minus"></i></button><button type="button" id="<?php echo $value->kd_material ?>" class="btn btn-xs btn-danger btn-hapus-material"><i class="fas fa-times"></i></button></td>
					        			</div>
					        	</tr>
								<?php
							}
						}
						?>
						
					</tbody>
				</table>
			</div>
			<div class="col-md-6">
				<table class="table table-hover table-sm tabel-material-yang-ada table-td-valign-middle">
					<thead>
						<tr>
							<th rowspan="2">Kode Material</th>
							<th rowspan="2">Weight/Pcs (Kg)</th>
							<th colspan="3">Dimensi</th>
							<th rowspan="2">Stock</th>
							<th rowspan="2">Action</th>
						</tr>
						<tr>
							<th>D/T (mm)</th>
							<th>P (mm)</th>
							<th>L (mm)</th>
						</tr>
					</thead>
					<tbody id="materials_available">
						<?php
						if ($material) {
							$o = 1;
							foreach ($material as $key => $value) {
								?>
								<tr class="material-available material-available-<?php echo $value->kd_material ?>">
									<td><input type="hidden" name="id_material_in_stock[]" value="<?php echo $value->id ?>"><input type="text" readonly class="form-control-plaintext" value="<?php echo $value->kd_material ?>"/></td>
									<td><span class="txtberatperpcs"><?php echo $value->berat_per_pcs ?></span></td>
									<?php

									$jsonanu = json_decode($value->dimensi, TRUE);
										?>
										<td>
											<input type="text" class="form-control-plaintext" name="dimensidiametertebal" value="<?php echo $jsonanu['diametertebal'] ?>">
										</td>
										<td>
											<input type="text" class="form-control-plaintext" name="dimensipanjang" value="<?php echo $jsonanu['panjang'] ?>">
										</td>
										<td>
											<input type="text" class="form-control-plaintext" name="dimensilebar" value="<?php echo $jsonanu['lebar'] ?>">
										</td>
										<?php
									?>
									<td><input type="text" name="qty_material_in_stock[]" readonly class="form-control-plaintext stock<?php echo $value->kd_material ?>" value="<?php echo $value->qty ?>"/></td>
									<td style="width: 80px;">
										<div class="input-group">
											<button type="button" id="<?php echo $value->kd_material ?>" class="btn btn-xs btn-success btn-detail-material"><i class="fas fa-eye"></i></button>
											<button type="button" id="<?php echo $value->kd_material ?>" class="btn btn-xs btn-primary btn-add-material"><i class="fas fa-plus-square"></i></button>
										</div>
									</td>
								</tr>
								<?php
							}
						} else {
							?>
							<tr>
								<td colspan="4">Tidak ada material tersedia</td>
							</tr>
							<?php
						}
						?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
	$(document).ready(function() {

		let smartallocate = 0

		$('.total-material').change(function() {
			if (smartallocate == 1) {
				smartAllocate()
			}
		})

		function sumthismachineETA(thisel) {

	    	var getrow = thisel
    		var idmesin = getrow.attr('id')
	    	var minutesperproduction = getrow.find('td').eq(2).find('input').val()
    		var productionpermachine = 0

    		//tetapkan jam kerja
    		var jamkerja = 0

    		var jamkerjashift1 = 480 //menit
    		var jamkerjashift2 = 420 //menit

    		var checkboxshift1 = $('#shift1machine' + idmesin).val()
    		var checkboxshift2 = $('#shift2machine' + idmesin).val()
	    	//bagi 2 shift
		    
	    	if (checkboxshift1 == 1) {
		    	jamkerja += jamkerjashift1
		    }

		    if (checkboxshift2 == 1) {
		    	jamkerja += jamkerjashift2
		    }
	    	
	    	productionpermachine = jamkerja/minutesperproduction
			
			console.log(productionpermachine)

			if (productionpermachine == null || productionpermachine == Infinity ) {
				productionpermachine = 0
			}

	    	getrow.find('td').eq(5).find('input').val(parseInt(productionpermachine))

	    	var o = 0

	    	if (productionpermachine > 0) {
    			o = parseInt(minutesperproduction) * parseInt(productionpermachine)
	    	} else {
	    		o = parseInt(productionpermachine) * 1
	    	}



    		getrow.find('td').eq(7).find('input').val(o)

    		var duration = moment.duration(o, 'minutes');

			var timeString = duration.days() + ':' + duration.hours() + ':' + duration.minutes() + ':' + duration.seconds()
	    	var eta = timeString
	    	getrow.find('td').eq(6).find('input').val(eta)
	    }

		function sumETA() {
	    	var arrminutes = []
			var summinutes = 0;

			var sumproduction = 0;

    		$('.available-machine.checked').each(function() {
    			var thisel = $(this)
    			sumthismachineETA(thisel)
    			//kumpulin menit dulu terus jumlah
    			var getminutestotal = thisel.find('td').eq(7).find('input').val()

    			if (!getminutestotal) {
    				getminutestotal = 0
    			}

    			summinutes += parseInt(getminutestotal)
    			arrminutes.push(getminutestotal)

				//umpulin produksi yang dihasilan dulu, terus jumlah
				var getproductiontotaal = thisel.find('td').eq(5).find('input').val()
				sumproduction += parseInt(getproductiontotaal)
    		})

    		console.log(arrminutes)

			//nyoba seting durasi ke 0 dah
			var tot = moment.duration(0);

			for (i = 0; i < arrminutes.length; i++) {                  
				var durasimasingmasingmesin = arrminutes[i].toString();
				tot.add(durasimasingmasingmesin, 'minutes');
			}

			//set total durasi pengerjaan
			$('.predictiondone').val(tot.days() + ':' + tot.hours() + ':' + tot.minutes() + ':' + tot.seconds())

			//it really not useful at all but it may be lmao
			$('.totalminuteseverymachine').val(summinutes)

			var date = moment($('#tanggal_produksi').val(), 'YYYY-MM-DD');
			date.add(summinutes, 'minutes');

			//set rencana selesai
			$('#rencana_selesai').val(moment(date).format('YYYY-MM-DD'))

			//set total target barang jadi
			$('.totalproductions').val(sumproduction)

	    }

		function checkAlokasiMelebihiTotalMaterial() {
			var sum = 0
	    	$('.materialallocated').each(function() {
	    		sum += parseInt($(this).val())
	    	})

	    	$('.alertnya').html('')

	    	if (sum > parseInt($('.total-material').val())) {
	    		$('.alertnya').html('<div class="alert alert-danger"><b>Alokasi material Melebihi batas.</b> Kurangi material sebagian pada beberapa mesin atau alokasian ke beberapa mesin</div>')
	    	}
		}

		function checkAlokasiMelebihiTotalGoods() {
			var sum = 0
	    	$('.goodsallocated').each(function() {
	    		sum += parseInt($(this).val())	
	    	})

	    	$('.alertnya').html('')

	    	if (sum > parseInt($('#total_barang_jadi').val())) {
	    		$('.alertnya').html('<div class="alert alert-danger"><b>Alokasi barang jadi Melebihi batas.</b> Kurangi target barang jadi pada sebagian mesin mesin atau alokasian target barang jadi ke mesin lain</div>')
	    	}
		}

		
		// {
		// 	let sum = 0
		// 	$('.qty-x-used').each(function() {
		// 		var getqty = parseInt($(this).parents('tr').find('td').eq(2).find('input').val())
		// 		var totalbarangjadi = parseInt($('#total_barang_jadi').val())

		// 		var nama_material = $(this).parents('tr').attr('id')

		// 		var total = getqty * totalbarangjadi


		// 		$(this).parents('tr').removeClass('oops')

		// 		$(this).val(total)
				
		// 		if (parseInt($(this).val()) > parseInt($('.stock' + nama_material).val())) {
		// 			$(this).parents('tr').addClass('oops')
		// 		}
				
		// 		sum += parseInt(total)
		// 	})
		// 	$('.total-material').val(parseInt(sum)).change()
		// }

		function smartAllocate() {

			//auto material allocated
			var totalmaterial = parseInt($('.total-material').val())
			var tresholdmaterialspermachine = 20 //tune here

			//auto goods allocated
			var totalgoods = parseInt($('#total_barang_jadi').val())
			var tresholdgoodspermachine = 20 //tune here

			if (smartallocate == 0) {
				tresholdgoodspermachine = parseInt($('.tresholdgoodspermachine').val())
				tresholdmaterialspermachine = parseInt($('.tresholdmaterialspermachine').val())
			}

			$('.available-machine').each(function() {
				var allocated = 0
				var thisidmachine = $(this).attr('id')

				if(totalgoods <= 0) {
					allocated = 0
				} else {
					$('#checkbox' + thisidmachine + '').prop("checked", true).parents('tr').addClass('checked')
					if (totalgoods <= tresholdgoodspermachine) {
						allocated = totalgoods
					}
					if(totalgoods > tresholdgoodspermachine) {
						for (var x = 0; x < tresholdgoodspermachine; x++) {
							allocated++
						}
					}
				}

				totalgoods-=tresholdgoodspermachine
				$(this).find('td').eq(4).find('input').val(allocated)
			})

			$('.available-machine').each(function() {
				var allocated = 0

				if(totalmaterial <= 0) {
					allocated = 0
				} else {
					if (totalmaterial <= tresholdmaterialspermachine) {
						allocated = totalmaterial
					}

					if(totalmaterial > tresholdmaterialspermachine) {
						for (var x = 0; x < tresholdmaterialspermachine; x++) {
							allocated++
						}
					}
				}

				totalmaterial-=tresholdmaterialspermachine
				$(this).find('td').eq(3).find('input').val(allocated)
			})


			sumETA()
		}


		function checkdisablecreateproductionbutton() {
			if ($('.tabel-material-ready-to-use tbody tr').length > 0 ){
				$('.btn-create-produksi').removeAttr('disabled').removeClass('disabled');
			} else {
				$('.btn-create-produksi').attr('disabled',true).addClass('disabled');
			}
		}

		let urutan = 1;

	    $('.tabel-material-yang-ada').on('click','.btn-add-material', function() {
	        const nama_material = $(this).attr('id')
	        const thisel = $(this)
		    let stockvalue = $('.stock' + nama_material)

		    if (stockvalue.val() > 0) {
		    	if ($('.tabel-material-ready-to-use tbody tr#' + nama_material).length > 0) {
			    	//let oldval = $('.ready-to-use-' + nama_material + '-qty').val()
			    	$('.ready-to-use-' + nama_material + '-qty').get(0).value++
			    } else {
			        $('#materials_ready_to_use').append(`
			        	<tr id="${nama_material}">
			        		<td></td>
			        		<td><input type="text" name="material_dibutuhkan[]" readonly class="form-control-plaintext ready-to-use-` + nama_material + `-material" value="${nama_material}" /></td>
			        		<td><input type="text" name="stok_dibutuhkan[]" readonly class="form-control-plaintext ready-to-use-qty ready-to-use-` + nama_material + `-qty" value="1" /></td>
			        		<td><input type="text" name="stok_dibutuhkan[]" readonly class="form-control-plaintext qty-x-used qty-x-used-` + nama_material + `" value="1" /></td>
			        		<td style="width: 80px;">
			        			<div class="input-group">
			        			<button type="button" id="${nama_material}" class="btn btn-xs btn-secondary btn-kurangi-material"><i class="fas fa-minus"></i></button><button type="button" id="${nama_material}" class="btn btn-xs btn-danger btn-hapus-material"><i class="fas fa-times"></i></button></td>
			        			</div>
			        	</tr>`);
			    }
			    // updateStock(nama_material, stockused, 'kurangin')
		    } else {
		    	Swal.fire({
                  icon: 'error',
                  title: "Stok Habis!",
                  text: 'Silahkan tambah pada menu material'
                })
		    }
		    checkdisablecreateproductionbutton()
	    });

	    $('.tabel-material-ready-to-use').on('click','.btn-kurangi-material', function() {
	        const nama_material = $(this).attr('id')
	        const thisel = $(this)
	        let thisrow = thisel.parents('tr')

		    let stockvalue = $('.ready-to-use-' + nama_material + '-qty')
		    
		    
		    if (stockvalue.val() > 1) {
		    	stockvalue.get(0).value--
		    } else {
		        thisrow.remove()
		        urutan--    	
		    }
		    checkdisablecreateproductionbutton()
	    })

	    $('.tabel-material-ready-to-use').on('click','.btn-hapus-material', function() {
	        const nama_material = $(this).attr('id')
	        const thisel = $(this)
	        let thisrow = thisel.parents('tr')

			thisrow.remove()
			checkdisablecreateproductionbutton()
	    })

	    $('#optionone').on('change', function() {
	    	if (this.checked) {
	    		smartallocate = 1
	    		smartAllocate()
	    		$('.available-machine').each(function(){
	    			$(this).find('td').eq(3).find('input').addClass('form-control-plaintext').removeClass('form-control').attr('readonly',true)
	    			$(this).find('td').eq(4).find('input').addClass('form-control-plaintext').removeClass('form-control').attr('readonly',true)
	    		})
	    	} else {
	    		smartallocate = 0
	    		$('.available-machine').each(function(){
	    			$(this).find('td').eq(3).find('input').removeClass('form-control-plaintext').addClass('form-control').removeAttr('readonly')
	    			$(this).find('td').eq(4).find('input').removeClass('form-control-plaintext').addClass('form-control').removeAttr('readonly')
	    			$(this).find('td').eq(3).find('input').val(0)
	    			$(this).find('td').eq(4).find('input').val(0)
	    		})
	    	}
	    	checkAlokasiMelebihiTotalMaterial()
	    })

	    $('.tabel-machine').on('input','.materialallocated', function() {

	    	var thisel = $(this)

	    	var materialallocatedonthismachine = parseInt($(this).val())
	    	var treshdldpermachine = parseInt($('.tresholdmaterialspermachine').val())
    		
    		thisel.removeClass('is-invalid')
	    	
	    	if (materialallocatedonthismachine > treshdldpermachine) {
	    		thisel.addClass('is-invalid')
	    	}

	    	checkAlokasiMelebihiTotalMaterial()
	    })

	    // $('.tabel-machine').on('input','.goodsallocated', function() {

	    // 	var thisel = $(this)

	    // 	if (thisel.parents('tr').hasClass('checked')) {
		   //  	sumETA()
	    // 	}

	    // })

	    $('.troughputperproduct').on('input', function() {
	    	
	    	var thisel = $(this)

	    	if (thisel.parents('tr').hasClass('checked')) {
	    		sumETA()
	    	}
	    })

	    $('.checkboxmachine').on('change', function() {
	    	if (this.checked) {
	    		$(this).parents('tr').addClass('checked')
	    	} else {
	    		$(this).parents('tr').removeClass('checked')
	    	}

	    	var thisel = $(this)
			sumETA()
	    })

	    $('#tanggal_produksi').on('change', function() {
	    	sumETA()
	    })

	    <?php 

	    if ($machine_list) {
			foreach ($machine_list as $key => $value) {
				?>

				$('.checkboxshiftformachine<?php echo $value->mesin_id ?>').on('change', function() {
					var thisel = $(this)

					if (this.checked) {
						thisel.val(1)
					} else {
						thisel.val(0)
					}
					sumETA()
				})

				<?php
			}
		}

	    ?>
	})
</script>