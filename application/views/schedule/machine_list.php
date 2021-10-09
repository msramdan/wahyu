<style>
	
	.pos-stock-product {
	    height: 100%;
	    padding: 0.46875rem;
	}

	.pos-stock-product .pos-stock-product-container {
	    background: rgba(102, 102, 102, 0.75);
	    height: 100%;
	}

	.pos-stock-product .pos-stock-product-container .product {
	    height: 100%;
	    overflow: hidden;
	    display: -webkit-box;
	    display: -ms-flexbox;
	    display: flex;
	    -webkit-box-orient: vertical;
	    -webkit-box-direction: normal;
	    -ms-flex-direction: column;
	    flex-direction: column;
	    border-radius: 6px;
	}

	.pos-stock-product .pos-stock-product-container .product .product-img {
	   	padding-top: 15%;
	}

	.pos-stock-product .pos-stock-product-container .product .product-info {
	    padding: 0.9375rem 1.17188rem;
	    -webkit-box-flex: 1;
	    -ms-flex: 1;
	    flex: 1;
	}

	.pos-stock-product .pos-stock-product-container .product .product-info .title {
	    font-size: 0.875rem;
	    font-weight: 500;
	}

	.pos-stock-product .pos-stock-product-container .product .product-info .desc {
	    color: rgba(255, 255, 255, 0.5);
	    margin-bottom: 0.9375rem;
	}

	.pos-stock-product .pos-stock-product-container .product .product-option {
	    margin: 0 0 0.3125rem;
	}
	
	.pos-stock-product .pos-stock-product-container .product .product-option .option + .option {
	    padding-top: 0.9375rem;
	}

	.pos-stock-product .pos-stock-product-container .product .product-option .option {
	    padding: 0;
	    -webkit-box-flex: 1;
	    -ms-flex: 1;
	    flex: 1;
	    display: -webkit-box;
	    display: -ms-flexbox;
	    display: flex;
	    -ms-flex-align: center;
	    align-items: center;
	}

	.pos-stock-product .pos-stock-product-container .product .product-option .option .option-label {

	    font-weight: 500;
	    width: 90px;
	    padding-right: 0.61875rem;

	}

	.pos-stock-product .pos-stock-product-container .product .product-option .option .option-input {
	    -webkit-box-flex: 1;
	    -ms-flex: 1;
	    flex: 1;
	}

	.pos-stock-product .pos-stock-product-container .product .product-option .option .option-input .form-control {
	    padding: 0.23438rem 0.61875rem;
	}

	.pos-stock-product .pos-stock-product-container .product .product-action {
	    display: -webkit-box;
	    display: -ms-flexbox;
	    display: flex;
	}

	.pos-stock-product .pos-stock-product-container .product .product-action .btn {
	    padding: 0.70312rem 0;
	    -webkit-box-flex: 1;
	    -ms-flex: 1;
	    flex: 1;
	    border-radius: 0;
	}


	.animation-wrapper{
		margin: auto;
		text-align: center;
		text-transform: uppercase;
		font-weight: 500;
		transform: scale(1.4);
	}

	.fa-animation{
		height:70px; 
		width:70px; 
		margin:0 auto;
		position:relative;
	}

	.fa-animation .fa{position:absolute;}

	.fa-lg{font-size:45px; top:8px; left:0px;}
	.fa-md{font-size:30px; top:0px; left:40px;}
	.fa-sm{font-size:24px; top:30px; left:35px;}

	.spin-forward {
		animation: spin-forwrd 3s infinite linear;
	}

	.spin-revers {
		animation: spin-reverse 3s infinite linear;
	}

	.spin-forward-slow {
		animation: spin-forwrd 10s infinite linear;
	}

	.spin-revers-slow {
		animation: spin-reverse 10s infinite linear;
	}

	@keyframes spin-reverse {
		0% {
			transform: rotate(-360deg);
		}
		100% {
			transform: rotate(0deg);
		}
	}

	@keyframes spin-forwrd {
		0% {
			transform: rotate(360deg);
		}
		100% {
			transform: rotate(0deg);
		}
	}
</style>
<script src="<?php echo base_url() ?>assets/assets/plugins/select2/dist/js/select2.min.js"></script>
<div class="accordion" id="accordion">
  <div class="accordion-item border-0">
    <div class="accordion-header" id="headingOne">
      <button class="accordion-button bg-gray-900 text-white px-3 py-10px pointer-cursor" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
        <i class="fa fa-circle fa-fw text-blue me-2 fs-8px"></i> Machine-use Management
      </button>
    </div>
    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordion">
      <div class="accordion-body bg-gray-800 text-white wrapper_info">
      	<h3>Process</h3>
				<div class="row gx-0">

					<?php 
					if ($machine_list_production) {
						foreach ($machine_list_production as $key => $datamesinproduction) {
							?>
								<div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 wrapper_info_mesin">
									<form id="form_mesin_<?php echo $datamesinproduction->mesin_id ?>" method="post">
										<div class="pos-stock-product">
											<div class="pos-stock-product-container">
												<div class="product">
													<div class="product-img" style="text-align: center;">
														<?php 
														if ($datamesinproduction->status == 'READY') {
															?>
																<i class="fas fa-cogs fa-fw fa-6x"></i>
															<?php
														}
														if($datamesinproduction->status == 'PAUSED') {
															?>
															<div class="animation-wrapper">
														      <div class="fa-animation">
														        <i class="fa fa-cog fa-lg spin-forward-slow"></i>
														        <i class="fa fa-cog fa-md spin-revers-slow"></i>
														        <i class="fa fa-cog fa-sm spin-revers-slow"></i>
														      </div>
														    </div>
															<?php
														}
														if($datamesinproduction->status == 'IN USE') {
															?>
															<div class="animation-wrapper">
														      <div class="fa-animation">
														        <i class="fa fa-cog fa-lg spin-forward"></i>
														        <i class="fa fa-cog fa-md spin-revers"></i>
														        <i class="fa fa-cog fa-sm spin-revers"></i>
														      </div>
														    </div>
															<?php
														}
														?>
													</div>
													<?php 
													if ($datamesinproduction->status == 'READY') {
														?>
														<div class="product-info">
															<div class="title"><?php echo $datamesinproduction->nama_mesin.'('.$datamesinproduction->kd_mesin.')' ?></div>
															<div class="desc"><?php echo $datamesinproduction->Keterangan ?></div>
															<div class="product-option">
																<div class="option">
																	<div class="option-label">Operator</div>
																	<div class="option-input">
																		<select class="form-control" name="operator_name" required>
																			<option value="">-</option>
																			<?php
																			foreach($getalloperator as $v)
																			{
																			?>
																				<option value="<?php echo $v->karyawan_id ?>"><?php echo $v->nama_karyawan ?></option>
																			<?php
																			}
																			?>
																		}
																		</select>
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Produksi</div>
																	<div class="option-input">
																		<select class="default-select2-<?php echo $datamesinproduction->mesin_id ?> form-control" name="kode_produksi" required>
																			<option value="">-</option>
																			<?php
																			if ($datamesinproduction->jenis_mesin == 'PRODUCTION') {
																				foreach($getallreadyproduksi as $v)
																				{
																				?>
																					<option value="<?php echo $v->id ?>"><?php echo $v->id ?></option>
																				<?php
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Status:</div>
																	<div class="option-input" style="display: flex;">
																		<!-- <div class="form-check form-switch">
																			<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesinproduction->mesin_id ?>status" value="0">
																			<label class="form-check-label" for="product1"></label>
																		</div> -->
																		<label class="badge bg-danger">OFF</label>
																	</div>
																</div>
																<small class="text-gray"><i>Last action: <?php echo $datamesinproduction->tindakan_terakhir ?></i></small>
															</div>
														</div>
														<div class="product-action">
															<input type="hidden" name="id_mesin" value="<?php echo $datamesinproduction->mesin_id ?>">
															<button type="reset" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Batal</button>
															<button type="submit" machine-type="<?php echo $datamesinproduction->jenis_mesin ?>" action="activate" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</button>
														</div>							
															<script type="text/javascript">
																$(".default-select2-<?php echo $datamesinproduction->mesin_id ?>").select2();
															</script>
														<?php
													}

													if($datamesinproduction->status == 'IN USE') {
														?>
														<div class="product-info">
															<div class="title"><?php echo $datamesinproduction->nama_mesin.'('.$datamesinproduction->kd_mesin.')' ?></div>
															<div class="desc"><?php echo $datamesinproduction->Keterangan ?></div>
															<div class="product-option">
																<div class="option">
																	<div class="option-label">Operator</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly value="<?php echo $classnyak->getdataoperator($datamesinproduction->operator)->nama_karyawan.'('.$classnyak->getdataoperator($datamesinproduction->operator)->npk.')' ?>">
																		<input type="hidden" class="form-control" name="operator_name" value="<?php echo $datamesinproduction->operator ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Produksi</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly name="kode_produksi" value="<?php echo $datamesinproduction->kd_produksi ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Status:</div>
																	<div class="option-input" style="display: flex;">
																		<!-- <div class="form-check form-switch">
																			<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesinproduction->mesin_id ?>status" checked value="1">
																			<label class="form-check-label" for="product1"></label>
																		</div> -->
																		<label class="badge bg-success">ON</label>
																	</div>
																</div>
																<small class="text-gray"><i>Last action: <?php echo $datamesinproduction->tindakan_terakhir ?></i></small>
															</div>
														</div>
														<div class="product-action">
															<input type="hidden" name="id_mesin" value="<?php echo $datamesinproduction->mesin_id ?>">
															<button type="submit" machine-type="<?php echo $datamesinproduction->jenis_mesin ?>" action="stop" class="btn btn-danger"><i class="fa fa-clock fa-fw"></i> Selesai</button>
															<button type="submit" machine-type="<?php echo $datamesinproduction->jenis_mesin ?>" action="shift" class="btn btn-secondary"><i class="fa fa-sync fa-fw"></i> Shift</button>
															<button type="submit" machine-type="<?php echo $datamesinproduction->jenis_mesin ?>" action="pause" class="btn btn-primary"><i class="fa fa-pause fa-fw"></i> Pause</button>
														</div>
														<?php
													}

													if($datamesinproduction->status == 'PAUSED') {
														?>
														<div class="product-info">
															<div class="title"><?php echo $datamesinproduction->nama_mesin.'('.$datamesinproduction->kd_mesin.')' ?></div>
															<div class="desc"><?php echo $datamesinproduction->Keterangan ?></div>
															<div class="product-option">
																<div class="option">
																	<div class="option-label">Operator</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly value="<?php echo $classnyak->getdataoperator($datamesinproduction->operator)->nama_karyawan.'('.$classnyak->getdataoperator($datamesinproduction->operator)->npk.')' ?>">
																		<input type="hidden" class="form-control" name="operator_name" value="<?php echo $datamesinproduction->operator ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Produksi</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly name="kode_produksi" value="<?php echo $datamesinproduction->kd_produksi ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Status:</div>
																	<div class="option-input" style="display: flex;">
																		<!-- <div class="form-check form-switch">
																			<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesinproduction->mesin_id ?>status" checked value="1">
																			<label class="form-check-label" for="product1"></label>
																		</div> -->
																		<label class="badge bg-warning">PAUSING</label>
																	</div>
																</div>
																<small class="text-gray"><i>Last action: <?php echo $datamesinproduction->tindakan_terakhir ?></i></small>
															</div>
														</div>
														<div class="product-action">
															<input type="hidden" name="id_mesin" value="<?php echo $datamesinproduction->mesin_id ?>">
															<button type="submit" machine-type="<?php echo $datamesinproduction->jenis_mesin ?>" action="stop" class="btn btn-danger"><i class="fa fa-clock fa-fw"></i> Selesai</button>
															<button type="submit" machine-type="<?php echo $datamesinproduction->jenis_mesin ?>" action="activate" class="btn btn-success"><i class="fa fa-play fa-fw"></i> Continue</button>
														</div>
														<?php
													}
													?>

												</div>
											</div>
										</div>
									</form>
								</div>
							<?php
							?>

							
							<?php
						}
					}
					?>

				</div>
				<br>
				<h3>Finishing</h3>
				<div class="row gx-0">

					<?php 
					if ($machine_list_finishing) {
						foreach ($machine_list_finishing as $key => $datamesinfinishing) {
							?>
								<div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 wrapper_info_mesin">
									<form id="form_mesin_<?php echo $datamesinfinishing->mesin_id ?>" method="post">
										<div class="pos-stock-product">
											<div class="pos-stock-product-container">
												<div class="product">
													<div class="product-img" style="text-align: center;">
														<?php 
														if ($datamesinfinishing->status == 'READY') {
															?>
																<i class="fas fa-cogs fa-fw fa-6x"></i>
															<?php
														}
														if($datamesinfinishing->status == 'PAUSED') {
															?>
															<div class="animation-wrapper">
														      <div class="fa-animation">
														        <i class="fa fa-cog fa-lg spin-forward-slow"></i>
														        <i class="fa fa-cog fa-md spin-revers-slow"></i>
														        <i class="fa fa-cog fa-sm spin-revers-slow"></i>
														      </div>
														    </div>
															<?php
														}
														if($datamesinfinishing->status == 'IN USE') {
															?>
															<div class="animation-wrapper">
														      <div class="fa-animation">
														        <i class="fa fa-cog fa-lg spin-forward"></i>
														        <i class="fa fa-cog fa-md spin-revers"></i>
														        <i class="fa fa-cog fa-sm spin-revers"></i>
														      </div>
														    </div>
															<?php
														}
														?>
													</div>
													<?php 
													if ($datamesinfinishing->status == 'READY') {
														?>
														<div class="product-info">
															<div class="title"><?php echo $datamesinfinishing->nama_mesin.'('.$datamesinfinishing->kd_mesin.')' ?></div>
															<div class="desc"><?php echo $datamesinfinishing->Keterangan ?></div>
															<div class="product-option">
																<div class="option">
																	<div class="option-label">Operator</div>
																	<div class="option-input">
																		<select class="form-control" name="operator_name" required>
																			<option value="">-</option>
																			<?php
																			foreach($getalloperator as $v)
																			{
																			?>
																				<option value="<?php echo $v->karyawan_id ?>"><?php echo $v->nama_karyawan ?></option>
																			<?php
																			}
																			?>
																		}
																		</select>
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Produksi</div>
																	<div class="option-input">
																		<select class="default-select2-<?php echo $datamesinfinishing->mesin_id ?> form-control" name="kode_produksi" required>
																			<option value="">-</option>
																			<?php
																			if ($datamesinfinishing->jenis_mesin == 'FINISHING') {
																				foreach($getallreadyfinishingproduksi as $v)
																				{
																				?>
																					<option value="<?php echo $v->id ?>"><?php echo $v->id ?></option>
																				<?php
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Status:</div>
																	<div class="option-input" style="display: flex;">
																		<!-- <div class="form-check form-switch">
																			<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesinfinishing->mesin_id ?>status" value="0">
																			<label class="form-check-label" for="product1"></label>
																		</div> -->
																		<label class="badge bg-danger">OFF</label>
																	</div>
																</div>
																<small class="text-gray"><i>Last action: <?php echo $datamesinfinishing->tindakan_terakhir ?></i></small>
															</div>
														</div>
														<div class="product-action">
															<input type="hidden" name="id_mesin" value="<?php echo $datamesinfinishing->mesin_id ?>">
															<button type="reset" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Batal</button>
															<button type="submit" machine-type="<?php echo $datamesinfinishing->jenis_mesin ?>" action="activate" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</button>
														</div>							
															<script type="text/javascript">
																$(".default-select2-<?php echo $datamesinfinishing->mesin_id ?>").select2();
															</script>
														<?php
													}

													if($datamesinfinishing->status == 'IN USE') {
														?>
														<div class="product-info">
															<div class="title"><?php echo $datamesinfinishing->nama_mesin.'('.$datamesinfinishing->kd_mesin.')' ?></div>
															<div class="desc"><?php echo $datamesinfinishing->Keterangan ?></div>
															<div class="product-option">
																<div class="option">
																	<div class="option-label">Operator</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly value="<?php echo $classnyak->getdataoperator($datamesinfinishing->operator)->nama_karyawan.'('.$classnyak->getdataoperator($datamesinfinishing->operator)->npk.')' ?>">
																		<input type="hidden" class="form-control" name="operator_name" value="<?php echo $datamesinfinishing->operator ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Produksi</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly name="kode_produksi" value="<?php echo $datamesinfinishing->kd_produksi ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Status:</div>
																	<div class="option-input" style="display: flex;">
																		<!-- <div class="form-check form-switch">
																			<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesinfinishing->mesin_id ?>status" checked value="1">
																			<label class="form-check-label" for="product1"></label>
																		</div> -->
																		<label class="badge bg-success">ON</label>
																	</div>
																</div>
																<small class="text-gray"><i>Last action: <?php echo $datamesinfinishing->tindakan_terakhir ?></i></small>
															</div>
														</div>
														<div class="product-action">
															<input type="hidden" name="id_mesin" value="<?php echo $datamesinfinishing->mesin_id ?>">
															<button type="submit" machine-type="<?php echo $datamesinfinishing->jenis_mesin ?>" action="stop" class="btn btn-danger"><i class="fa fa-clock fa-fw"></i> Selesai</button>
															<button type="submit" machine-type="<?php echo $datamesinfinishing->jenis_mesin ?>" action="shift" class="btn btn-secondary"><i class="fa fa-sync fa-fw"></i> Shift</button>
															<button type="submit" machine-type="<?php echo $datamesinfinishing->jenis_mesin ?>" action="pause" class="btn btn-primary"><i class="fa fa-pause fa-fw"></i> Pause</button>
														</div>
														<?php
													}

													if($datamesinfinishing->status == 'PAUSED') {
														?>
														<div class="product-info">
															<div class="title"><?php echo $datamesinfinishing->nama_mesin.'('.$datamesinfinishing->kd_mesin.')' ?></div>
															<div class="desc"><?php echo $datamesinfinishing->Keterangan ?></div>
															<div class="product-option">
																<div class="option">
																	<div class="option-label">Operator</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly value="<?php echo $classnyak->getdataoperator($datamesinfinishing->operator)->nama_karyawan.'('.$classnyak->getdataoperator($datamesinfinishing->operator)->npk.')' ?>">
																		<input type="hidden" class="form-control" name="operator_name" value="<?php echo $datamesinfinishing->operator ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Produksi</div>
																	<div class="option-input">
																		<input type="text" class="form-control" readonly name="kode_produksi" value="<?php echo $datamesinfinishing->kd_produksi ?>">
																	</div>
																</div>
																<div class="option">
																	<div class="option-label">Status:</div>
																	<div class="option-input" style="display: flex;">
																		<!-- <div class="form-check form-switch">
																			<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesinfinishing->mesin_id ?>status" checked value="1">
																			<label class="form-check-label" for="product1"></label>
																		</div> -->
																		<label class="badge bg-warning">PAUSING</label>
																	</div>
																</div>
																<small class="text-gray"><i>Last action: <?php echo $datamesinfinishing->tindakan_terakhir ?></i></small>
															</div>
														</div>
														<div class="product-action">
															<input type="hidden" name="id_mesin" value="<?php echo $datamesinfinishing->mesin_id ?>">
															<button type="submit" machine-type="<?php echo $datamesinfinishing->jenis_mesin ?>" action="stop" class="btn btn-danger"><i class="fa fa-clock fa-fw"></i> Selesai</button>
															<button type="submit" machine-type="<?php echo $datamesinfinishing->jenis_mesin ?>" action="activate" class="btn btn-success"><i class="fa fa-play fa-fw"></i> Continue</button>
														</div>
														<?php
													}
													?>

												</div>
											</div>
										</div>
									</form>
								</div>
							<?php
							?>

							
							<?php
						}
					}
					?>

				</div>
      </div>
    </div>
  </div>
  
</div>

