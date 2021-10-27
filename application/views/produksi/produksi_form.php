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
	<input type="hidden" class="form-control masked-input-date priority" name="priority" id="priority" />
	<div class="row">
		<div class="row mb-15px">
			<label class="form-label col-form-label col-md-3">Kode Order</label>
			<div class="col-md-9">
				<div class="input-group">
					<input type="text" class="form-control" name="kode_order" id="kode_order"/>
					<button type="button" class="btn btn-warning button-ceg input-group-button" style="pointer-events: none;"><i class="fas fa-exclamation-triangle"></i></button>
				</div>
			</div>
		</div>
		<div class="input-group input-group-kdorder">
			<button type="button" class="btn btn-purple list-data tombol-kembali-input-kdorder">Kembali</button>
		</div>
	</div>
	<div class="formnya container" style="display: none;">
		<div class="row">
			<div class="col-md-9">

				<div class="row mb-15px">
					<label class="form-label col-form-label col-md-3">Tanggal Produksi <?php echo form_error('tanggal_produksi') ?></label>
					<div class="col-md-6">
						<input required type="date" class="form-control" name="tanggal_produksi" id="tanggal_produksi" placeholder="Tanggal Produksi" value="<?php echo $tanggal_produksi; ?>" />
					</div>
					<div class="col-md-3">
						<div class="input-group">
						  <input type="text" class="form-control masked-input-date jam-awal" name="jam_awal" value="08:00"/>
						  <span class="input-group-text input-group-addon">
						    <i class="fa fa-clock"></i>
						  </span>
						</div>
					</div>
				</div>

				<div class="row mb-15px">
					<label class="form-label col-form-label col-md-3">Target Selesai</label>
					<div class="col-md-6">
						<input required type="date" class="form-control" readonly name="rencana_selesai" id="rencana_selesai" placeholder="Tanggal Produksi" value="<?php echo $rencana_selesai; ?>"/>
					</div>
					<div class="col-md-3">
						<div class="input-group">
						  <input type="text" class="form-control masked-input-date jam-akhir" readonly name="jam_akhir" value="16:00" />
						  <span class="input-group-text input-group-addon">
						    <i class="fa fa-clock"></i>
						  </span>
						</div>
					</div>
				</div>	

				<!-- <div class="row mb-15px">
					<div class="ol-md-3"></div>
					<div class="col-md-9">
						<div class="form-check form-switch">
						  	<input class="form-check-input" type="checkbox" id="cbsmartallocate" name="cbsmartallocate" checked />
						  	<label class="form-check-label" for="cbsmartallocate">Smart Allocate</label>
						</div>
					</div>
				</div> -->	
			</div>
			<div class="col-md-3">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="User Id" value="<?php echo $user_id; ?>" />
				<div class="input-group" style="height: 10vh;">
				    <button style="flex: 50%;" type="submit" class="btn btn-danger btn-create-produksi disabled" disabled=""><i class="fas fa-save"></i> <?php echo $button ?></button> 
				    <button style="flex: 50%;" type="button" class="btn btn-info list-data"><i class="fas fa-undo"></i> Kembali</button>
				</div>
			</div>
		</div>

		<div class="alertnya">
			
		</div>
		<div class="row mb-15px">
				<table class="table table-hover table-sm tabel-machine">
					<thead>
						<tr>
							<th>Machine Name</th>
							<th hidden>Used For</th>
							<th>Throughput</th>
							<th>Shift</th>
							<th>Material Processed</th>
							<th>Products</th>
							<th>Time</th>
							<th hidden="hidden">T. Minutes</th>
						</tr>
					</thead>
					<tbody class="daftar_mesin">
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" style="text-align: right; font-size: 14px;"><b>Total</b></td>
							<td><input type="text" name="totalmaterialused" class="form-control-plaintext totalmaterialused"></td>
							<td><input type="text" name="totalproductions" class="form-control-plaintext totalproductions"></td>
							<td><input type="text" name="predictiondone" class="form-control-plaintext predictiondone"></td>
							<td hidden><input type="number" name="totalminuteseverymachine" class="totalminuteseverymachine" value="0"></td>
						</tr>
					</tfoot>
				</table>
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
	</div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$(".masked-input-date").mask("99:99");

		let smartallocate = 0

		$('.total-material').change(function() {
			if (smartallocate == 1) {
				smartAllocate()
			}
		})

		function getMachine(machine_id) {
			$.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>produksi/get_machine_data/" + machine_id,
                success: function(data){
                	$('.daftar_mesin').append(data)
                },
                error: function(error) {
                    Swal.fire({
                      icon: 'error',
                      title: "Oops!",
                      text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                    })
                }
            });
		}

		function enableDisableInputMachine(thisel) {
			if (thisel.parents('tr').hasClass('checked')) {
				thisel.parents('tr').find('td').eq(2).find('input').removeAttr('readonly').removeClass('readonly')
				thisel.parents('tr').find('td').eq(4).find('input').removeAttr('readonly').removeClass('readonly')
				thisel.parents('tr').find('td').eq(5).find('input').removeAttr('readonly').removeClass('readonly')
				thisel.parents('tr').find('td').eq(6).find('input').removeAttr('readonly').removeClass('readonly')
				thisel.parents('tr').find('td').eq(7).find('input').removeAttr('readonly').removeClass('readonly')
			} else {
				thisel.parents('tr').find('td').eq(2).find('input').attr('readonly','readonly').addClass('readonly')
				thisel.parents('tr').find('td').eq(4).find('input').attr('readonly','readonly').addClass('readonly')
				thisel.parents('tr').find('td').eq(5).find('input').attr('readonly','readonly').addClass('readonly')
				thisel.parents('tr').find('td').eq(6).find('input').attr('readonly','readonly').addClass('readonly')
				thisel.parents('tr').find('td').eq(7).find('input').attr('readonly','readonly').addClass('readonly')
			}
		}

		function refreshMachineList() {
			var start_date = $('#tanggal_produksi').val() + ' ' + $('.jam-awal').val() + ':00'
			var end_date = $('#rencana_selesai').val() + ' ' + $('.jam-akhir').val() + ':00'

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>produksi/get_machine_list",
                data: {
                    ds: start_date,
                    de: end_date
                },
                success: function(data){
                	var dt = JSON.parse(data)

                	if ($('.available-machine').length <= 0) {
                		console.log('no machine available, generating...')

                		for (let i = 0; i < dt.length; i++) {
						  	// $('.daftar_mesin').append('<div class="available-machine" id="' + dt[i] + '"><input type="checkbox" name="cb"/>' + dt[i] + '</div>')
						  	getMachine(dt[i])
						}
                	} else {
                		console.log('machine available, detecting...')

                		//buat array daftar available machine (termasuk yang sudah dicopot)

                		var arravailablemachinesaatini = []

	                	$('.available-machine').each(function(i) {

	                		var thisel = $(this)

	                		var thisid = $(this).attr('id')

	                		//jika element ini sudah tidak ada di dt, hapus ae
	                		if (!dt.includes(thisid)) {
	                			thisel.remove()
	                		}

	                		//dorong ke arrayavailablemachinesaatini
	                		arravailablemachinesaatini.push(thisid)
	                	})

	                	//cari data mesin baru

	                	// dt di filter arraynya untuk menampilkan arraiabilablemachinesaatini tidak ada di dt
	                	var foundnew = dt.filter( ai => !arravailablemachinesaatini.includes(ai) );

	                	console.log(arravailablemachinesaatini)
	                	console.log(foundnew)

	                	//jika ada data mesin baru dari server
	                	if (foundnew) {
	                		for (let i = 0; i < foundnew.length; i++) {
							  	getMachine(foundnew[i])
							}
	                	} else {
	                		$('.daftar_mesin').append('<tr><td colspan="6">No Machine Available</td></tr>')
	                	}
                	}

                    // $('.daftar_mesin').html(dt.machinelist)
                },
                error: function(error) {
                    Swal.fire({
                      icon: 'error',
                      title: "Oops!",
                      text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                    })
                }
            }); 
		}

		function deteksiKetersediaanJadwal() {
			var start_date = $('#tanggal_produksi').val() + ' ' + $('.jam-awal').val() + ':00'
			var end_date = $('#rencana_selesai').val() + ' ' + $('.jam-akhir').val() + ':00'

			console.log(start_date + '/' + end_date)

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>produksi/deteksi_ketersediaan_jadwal",
                data: {
                    ds: start_date,
                    de: end_date
                },
                success: function(data){
                	var dt = JSON.parse(data)
                    $('#smart_assist_title').text(dt.smart_assist_title)
                    $('#smart_assist_message').html(dt.smart_assist_message)
                    $('#smart_assist_recommendation').html(dt.smart_assist_recommendation_action)
                    // alert(dt.message)
                    // $('.daftar_mesin').html(dt.machinelist)
                },
                error: function(error) {
                    Swal.fire({
                      icon: 'error',
                      title: "Oops!",
                      text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                    })
                }
            });
		}

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

			// console.log(productionpermachine)

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

	    	console.log(o)

    		getrow.find('td').eq(7).find('input').val(o)

    		var duration = moment.duration(o, 'minutes');

	    	// var workhour = duration.hours()
	    	// if (detectedhours) {}
			
			var timeString = duration.days() + ':' + duration.hours() + ':' + duration.minutes() + ':' + duration.seconds()
	    	var eta = timeString
	    	getrow.find('td').eq(6).find('input').val(eta)
	    }

		function sumETA() {
	    	var arrminutes = []
			var summinutes = 0;

			var sumproduction = 0;

    		$('.available-machine').each(function() {
				var thisel = $(this)

    			if (thisel.hasClass('checked')) {
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
    			} else {
					arrminutes.push(0)
					sumproduction += 0
    			}
    		})

    		// console.log(arrminutes)

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

			//JIKA melebihi dari jumlah jam kerja shift 1 dan shift 2, tambah waktu durasinya hingga besok sampe jam masuk kerja (majuin 8 jem)

			var date = moment($('#tanggal_produksi').val() + ' ' + $('.jam-awal').val(), 'YYYY-MM-DD HH:mm')
			date.add(summinutes, 'minutes')
			var test = summinutes - 900
			console.log(test)
			if (test > 0) {
				date.add(540, 'minutes')
				console.log('NEXT DAY!')
			}

			//set rencana selesai
			$('#rencana_selesai').val(moment(date).format('YYYY-MM-DD'))
			$('.jam-akhir').val(moment(date).format('HH:mm'))

			//set total target barang jadi
			$('.totalproductions').val(sumproduction)

			checkmaterialwillbeused(sumproduction)

	    }

	    function checkmaterialwillbeused(sumproduction) {
	    	$('.qty-x-used').each(function(i) {

				var nama_material = $(this).parents('tr').attr('id')

				var getqty = parseInt($(this).parents('tr').find('td').eq(2).find('input').val())

				var total = getqty * sumproduction

				if (total == 0) {
					total = 1
				}

				$(this).parents('tr').removeClass('oops')

				$(this).parents('tr').find('td').eq(3).find('input').val(total)
				
				if (parseInt($(this).val()) > parseInt($('.stock' + nama_material).val())) {
					$(this).parents('tr').addClass('oops')
				}
			})
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
			    var willbeused = 0
		    	willbeused = parseInt($('.ready-to-use-' + nama_material + '-qty').val()) * parseInt($('.totalproductions').val())

		    	$('.qty-x-used-' + nama_material).val(willbeused)

		    	checkmaterialwillbeused(willbeused)
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
		    sumETA()
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
	    		// smartAllocate()
	    		// $('.available-machine').each(function(){
	    		// 	$(this).find('td').eq(3).find('input').addClass('form-control-plaintext').removeClass('form-control').attr('readonly',true)
	    		// 	$(this).find('td').eq(4).find('input').addClass('form-control-plaintext').removeClass('form-control').attr('readonly',true)
	    		// })
	    	} else {
	    		smartallocate = 0
	    		// $('.available-machine').each(function(){
	    		// 	$(this).find('td').eq(3).find('input').removeClass('form-control-plaintext').addClass('form-control').removeAttr('readonly')
	    		// 	$(this).find('td').eq(4).find('input').removeClass('form-control-plaintext').addClass('form-control').removeAttr('readonly')
	    		// 	$(this).find('td').eq(3).find('input').val(0)
	    		// 	$(this).find('td').eq(4).find('input').val(0)
	    		// })
	    	}
	    	// checkAlokasiMelebihiTotalMaterial()
	    })

	    // $('.tabel-machine').on('input','.materialallocated', function() {

	    // 	var thisel = $(this)

	    // 	var materialallocatedonthismachine = parseInt($(this).val())
	    // 	var treshdldpermachine = parseInt($('.tresholdmaterialspermachine').val())
    		
    	// 	thisel.removeClass('is-invalid')
	    	
	    // 	if (materialallocatedonthismachine > treshdldpermachine) {
	    // 		thisel.addClass('is-invalid')
	    // 	}

	    // 	checkAlokasiMelebihiTotalMaterial()
	    // })

	    // $('.tabel-machine').on('input','.goodsallocated', function() {

	    // 	var thisel = $(this)

	    // 	if (thisel.parents('tr').hasClass('checked')) {
		   //  	sumETA()
	    // 	}

	    // })

	    $('.daftar_mesin').on('input','.troughputperproduct',function() {
	    	
	    	var thisel = $(this)

	    	if (thisel.parents('tr').hasClass('checked')) {
	    		sumETA()
	    	}
	    })

	    $('.daftar_mesin').on('change','.checkboxmachine', function() {
	    	
	    	var thisel = $(this)

	    	if (this.checked) {
	    		thisel.parents('tr').addClass('checked')
	    	} else {
	    		thisel.parents('tr').removeClass('checked')
	    		thisel.parents('tr').find('td').eq(2).find('input').val(0)
				thisel.parents('tr').find('td').eq(4).find('input').val(0)
				thisel.parents('tr').find('td').eq(5).find('input').val(0)
				thisel.parents('tr').find('td').eq(6).find('input').val('')
				thisel.parents('tr').find('td').eq(7).find('input').val(0)
	    	}
			sumETA()
			enableDisableInputMachine(thisel)
	    })

	    $('#tanggal_produksi').on('change', function() {
    		sumETA()
	    	deteksiKetersediaanJadwal()
	    	refreshMachineList()
	    	checkdisablecreateproductionbutton()
	    	setTimeout(function() {
	    		sumETA()
	    	},500)
	    })

		var typingTimer;
		var doneTypingInterval = 3000;

		//on keyup, start the countdown
		$('#kode_order').on('input',function(){
		    clearTimeout(typingTimer);

		    $('.input-group-kdorder').html('<button type="button" class="btn btn-purple list-data tombol-kembali-input-kdorder">Kembali</button>')

		    if ($('#kode_order').val()) {
		    	$('.button-ceg').replaceWith('<button type="button" class="btn btn-primary button-ceg input-group-button" style="pointer-events: none;"><i class="fas fa-sync fa-spin"></i></button>')
		    	$('#smart_assist_title').text('Sedang mencari...')
                $('#smart_assist_message').html(`Sistem sedang mendeteksi kode order yang diinput, mohon tunggu...
                	<div class="progress rounded-pill mb-2 mt-2">
						<div class="progress-bar bg-indigo progress-bar-striped progress-bar-animated rounded-pill fs-10px fw-bold" style="width: 100%"></div>
					</div>
                	`)
                $('#smart_assist_recommendation').html("")
		        typingTimer = setTimeout(doneTyping, doneTypingInterval);
		    }
		});

		//user is "finished typing," do something
		function doneTyping() {
		    var id = $('#kode_order').val()

	    	$.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>produksi/cek_kode_order_ready",
                data: {
                    id: id,
                },
                success: function(data){
                	var dt = JSON.parse(data)

                	if (dt.status == 'ok') {
                		// alert('sip')
                		$('.button-ceg').replaceWith('<button type="button" class="btn btn-success button-ceg input-group-button" style="pointer-events: none;"><i class="fas fa-check"></i></button>')
                		$('#smart_assist_title').text('Data Order')
		                $('#smart_assist_message').html(dt.message)
		                $('#smart_assist_recommendation').html("")
		                $('.input-group-kdorder').html('<button type="button" class="btn btn-purple list-data tombol-kembali-input-kdorder">Kembali</button><button type="button" class="btn btn-success btn-next">Konfirmasi</button>')
		                $('#priority').val(dt.priority)
                	} else {
                		// alert('no!')
                		$('.button-ceg').replaceWith('<button type="button" class="btn btn-danger button-ceg input-group-button" style="pointer-events: none;"><i class="fas fa-times"></i></button>')
                		$('#smart_assist_title').text('Order tidak ditemukan!')
		                $('#smart_assist_message').html('Cek kembali inputan, pastikan semua huruf adalah besar dan angka sudah sesuai. Jika memang sesuai, mungkin order tersebut sedang on progress atau sudah selesai produksinya')
		                $('#smart_assist_recommendation').html("")
                	}
                },
                error: function(error) {
                    Swal.fire({
                      icon: 'error',
                      title: "Oops!",
                      text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                    })
                }
            });
		}

		$('.input-group-kdorder').on('click','.btn-next',function() {
			$('.formnya').css('display','unset')
			$('.input-group-kdorder').remove()
			$('#kode_order').addClass('readonly').attr('readonly','readonly')
		})
	    <?php 

	    if ($machine_list) {
			foreach ($machine_list as $key => $value) {
				?>

				$('.daftar_mesin').on('change','.checkboxshiftformachine<?php echo $value->mesin_id ?>', function() {
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