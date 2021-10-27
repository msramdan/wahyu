
<tr class="available-machine" id="<?php echo $value->mesin_id ?>">
	<td>
		<div class="form-check">
			<input class="form-check-input checkboxmachine" name="machine_use[]" type="checkbox" id="checkbox<?php echo $value->mesin_id ?>" value="<?php echo $value->mesin_id ?>"/>
			<label class="form-check-label" for="checkbox<?php echo $value->mesin_id ?>"><?php echo $value->nama_mesin ?></label>
		</div>
	</td>
	<td hidden>
		<input type="text" name="machineusedfor[]" class="form-control-plaintext" readonly value="<?php echo $value->used_for ?>">	
	</td>
	<td>
		<div class="input-group">
			<input type="number" name="troughputperproduct[]" class="form-control troughputperproduct readonly" readonly value="0" min="0">
			<span class="input-group-text">
				Minute(s)/Pd.
			</span>
		</div>
	</td>
	<td>
		<div class="form-check form-check-inline">
			<input class="form-check-input checkboxshiftformachine<?php echo $value->mesin_id ?> readonly" readonly name="shift1machine<?php echo $value->mesin_id ?>" type="checkbox" id="shift1machine<?php echo $value->mesin_id ?>" checked value="1" />
			<label class="form-check-label" for="shift1machine<?php echo $value->mesin_id ?>">1</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input checkboxshiftformachine<?php echo $value->mesin_id ?> readonly" readonly name="shift2machine<?php echo $value->mesin_id ?>" type="checkbox" id="shift2machine<?php echo $value->mesin_id ?>" value="0"/>
			<label class="form-check-label" for="shift2machine<?php echo $value->mesin_id ?>">2</label>
		</div>
	</td>
	<td>
		<input type="number" name="materialallocated[]" class="form-control materialallocated readonly" readonly value="0">
	</td>
	<td>
		<input type="text" name="goodsallocated[]" readonly class="form-control-plaintext goodsallocated readonly" readonly value="0">
	</td>
	<td>
		<div class="input-group">
			<input type="text" name="timespentpermachine[]" class="form-control-plaintext readonly" readonly>
		</div>
	</td>
	<td hidden>
		<input type="number" name="totalminutes" class="totalminutespermachine readonly" readonly value="0">
	</td>

</tr>