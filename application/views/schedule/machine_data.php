

	<form id="form_mesin_<?php echo $datamesin->mesin_id ?>" method="post">
		<div class="pos-stock-product">
			<div class="pos-stock-product-container">
				<div class="product">
					<div class="product-img" style="text-align: center;">
						<?php 
						if ($datamesin->status == 'READY' || $datamesin->status == 'PAUSED') {
							?>
								<i class="fas fa-cogs fa-fw fa-6x"></i>
							<?php
						} else {
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
					if ($datamesin->status == 'READY') {
						?>
						<div class="product-info">
							<div class="title"><?php echo $datamesin->nama_mesin.'('.$datamesin->kd_mesin.')' ?></div>
							<div class="desc"><?php echo $datamesin->Keterangan ?></div>
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
										<select class="form-control" name="kode_produksi" required>
											<option value="">-</option>
											<?php
											foreach($getallproduksi as $v)
											{
											?>
												<option value="<?php echo $v->id ?>"><?php echo $v->id ?></option>
											<?php
											}
											?>
										}
										</select>
									</div>
								</div>
								<div class="option">
									<div class="option-label">Status:</div>
									<div class="option-input" style="display: flex;">
										<!-- <div class="form-check form-switch">
											<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesin->mesin_id ?>status" value="0">
											<label class="form-check-label" for="product1"></label>
										</div> -->
										<label class="badge bg-danger">OFF</label>
									</div>
								</div>
								<small class="text-gray"><i>Last action: <?php echo $datamesin->tindakan_terakhir ?></i></small>
							</div>
						</div>
						<div class="product-action">
							<input type="hidden" name="id_mesin" value="<?php echo $datamesin->mesin_id ?>">
							<button type="reset" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Batal</button>
							<button type="submit" action="activate" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Update</button>
						</div>
						<?php
					}

					if($datamesin->status == 'IN USE') {
						?>
						<div class="product-info">
							<div class="title"><?php echo $datamesin->nama_mesin.'('.$datamesin->kd_mesin.')' ?></div>
							<div class="desc"><?php echo $datamesin->Keterangan ?></div>
							<div class="product-option">
								<div class="option">
									<div class="option-label">Operator</div>
									<div class="option-input">
										<input type="text" class="form-control" readonly value="<?php echo $classnyak->getdataoperator($datamesin->operator)->nama_karyawan.'('.$classnyak->getdataoperator($datamesin->operator)->npk.')' ?>">
										<input type="hidden" class="form-control" name="operator_name" value="<?php echo $datamesin->operator ?>">
									</div>
								</div>
								<div class="option">
									<div class="option-label">Produksi</div>
									<div class="option-input">
										<input type="text" class="form-control" readonly name="kode_produksi" value="<?php echo $datamesin->kd_produksi ?>">
									</div>
								</div>
								<div class="option">
									<div class="option-label">Status:</div>
									<div class="option-input" style="display: flex;">
										<!-- <div class="form-check form-switch">
											<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesin->mesin_id ?>status" checked value="1">
											<label class="form-check-label" for="product1"></label>
										</div> -->
										<label class="badge bg-success">ON</label>
									</div>
								</div>
								<small class="text-gray"><i>Last action: <?php echo $datamesin->tindakan_terakhir ?></i></small>
							</div>
						</div>
						<div class="product-action">
							<input type="hidden" name="id_mesin" value="<?php echo $datamesin->mesin_id ?>">
							<button type="submit" action="stop" class="btn btn-danger"><i class="fa fa-clock fa-fw"></i> Selesai</button>
							<button type="submit" action="shift" class="btn btn-secondary"><i class="fa fa-sync fa-fw"></i> Shift</button>
							<button type="submit" action="pause" class="btn btn-primary"><i class="fa fa-pause fa-fw"></i> Pause</button>
						</div>
						<?php
					}

					if($datamesin->status == 'PAUSED') {
						?>
						<div class="product-info">
							<div class="title"><?php echo $datamesin->nama_mesin.'('.$datamesin->kd_mesin.')' ?></div>
							<div class="desc"><?php echo $datamesin->Keterangan ?></div>
							<div class="product-option">
								<div class="option">
									<div class="option-label">Operator</div>
									<div class="option-input">
										<input type="text" class="form-control" readonly value="<?php echo $classnyak->getdataoperator($datamesin->operator)->nama_karyawan.'('.$classnyak->getdataoperator($datamesin->operator)->npk.')' ?>">
										<input type="hidden" class="form-control" name="operator_name" value="<?php echo $datamesin->operator ?>">
									</div>
								</div>
								<div class="option">
									<div class="option-label">Produksi</div>
									<div class="option-input">
										<input type="text" class="form-control" readonly name="kode_produksi" value="<?php echo $datamesin->kd_produksi ?>">
									</div>
								</div>
								<div class="option">
									<div class="option-label">Status:</div>
									<div class="option-input" style="display: flex;">
										<!-- <div class="form-check form-switch">
											<input class="form-check-input form-check-status-mesin" type="checkbox" name="status_mesin" id="mesin<?php echo $datamesin->mesin_id ?>status" checked value="1">
											<label class="form-check-label" for="product1"></label>
										</div> -->
										<label class="badge bg-warning">PAUSING</label>
									</div>
								</div>
								<small class="text-gray"><i>Last action: <?php echo $datamesin->tindakan_terakhir ?></i></small>
							</div>
						</div>
						<div class="product-action">
							<input type="hidden" name="id_mesin" value="<?php echo $datamesin->mesin_id ?>">
							<button type="submit" action="stop" class="btn btn-danger"><i class="fa fa-clock fa-fw"></i> Selesai</button>
							<button type="submit" action="activate" class="btn btn-success"><i class="fa fa-play fa-fw"></i> Continue</button>
						</div>
						<?php
					}
					?>

				</div>
			</div>
		</div>
	</form>