<?php 
    
     //ubah timezone menjadi jakarta
                        // date_default_timezone_set("Asia/Jakarta");

                        //ambil jam dan menit
    $jam = date('H:i');

    //atur salam menggunakan IF
    if ($jam > '05:30' && $jam < '10:00') {
        $salam = 'Pagi';
    } elseif ($jam >= '10:00' && $jam < '15:00') {
        $salam = 'Siang';
    } elseif ($jam < '18:00') {
        $salam = 'Sore';
    } else {
        $salam = 'Malam';
    }

?>

<style>

.select-form-bulanan-1, .select-form-bulanan-2, .select-form-nya
{
    display: none;
}

.showed
{
    display: inline-block !important;
}

.recommended {
    animation: owoglow 800ms infinite alternate;
}

@keyframes owoglow {
  from {
    box-shadow: 1px 1px 5px -5px #fff;
  }
  to {
    box-shadow: 1px 1px 5px 5px #fff;
  }
}

</style>

<div id="content" class="app-content">
    <div class="accordion" id="accordion-work-calendar">
      <div class="accordion-item border-0">
        <div class="accordion-header" id="headingTne">
          <button class="accordion-button bg-gray-900 text-white px-3 py-10px pointer-cursor" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-work-calendar">
            <i class="fa fa-circle fa-fw text-blue me-2 fs-8px"></i> Calendar Work
          </button>
        </div>
        <div id="collapse-work-calendar" class="accordion-collapse collapse show" data-bs-parent="#accordion-work-calendar">
          <div class="accordion-body bg-gray-800 text-white">
            <table id="data-table-data" class="table table-bordered table-hover table-td-valign-middle text-white">
				<thead>
				    <tr>
				        <th>No</th>
						<th>Kd Mesin</th>
						<th>Nama Mesin</th>
						<th>Action</th>
				    </tr>
				</thead>
				<tbody>
					<?php $no = 1;
				    foreach ($mesin_data as $mesin)
				    {
				        ?>
				        <tr>
						    <td><?= $no++?></td>
						    <td><?php echo $mesin->kd_mesin ?></td>
						    <td><?php echo $mesin->nama_mesin ?></td>
						    <td>
						    	<input type="hidden" name="kd_mesin" class="kd_mesin" value="<?php echo $mesin->kd_mesin ?>">
				                <div class="input-group">
				                    <?php
				                        $arrtaun = [2019,2020,2021,2022,2023];
				                        $arrbulan = array(
				                            'Januari' => 1,
				                            'Februari' => 2,
				                            'Maret' => 3,
				                            'April' => 4,
				                            'Mei' => 5,
				                            'Juni' => 6,
				                            'Juli' => 7,
				                            'Agustus' => 8,
				                            'September' => 9,
				                            'Oktober' => 10,
				                            'November' => 11,
				                            'Desember' => 12
				                        );
				                    ?>
				                    <select class="form-control select-form-bulanan-1" name="month">
				                        <?php
				                        foreach($arrbulan as $key => $v) {
				                            ?>
				                                <option value="<?php echo $v ?>"><?php echo $key ?></option>
				                            <?php
				                        }
				                        ?>
				                    </select>
				                    <select class="form-control select-form-bulanan-2" name="year">
				                        <?php
				                        foreach($arrtaun as $v) {
				                            ?>
				                                <option value="<?php echo $v ?>"><?php echo $v ?></option>
				                            <?php
				                        }
				                        ?>
				                    </select>
				                    <div class="input-group-button">
				                       <button class="btn btn-primary buttonnya btn-select-bulan">
				                           <i class="fas fa-list" aria-hidden="true"></i> Bulan
				                       </button> 
				                    </div>
				                </div>
						    </td>
						    
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
</div>



 <script type="text/javascript">

	$(document).ready(function() {

	    $(document).on('click','.btn-select-taun', function(e) {

	        e.preventDefault()
	        $('.select-form-nya').removeClass('showed')
	        $('.select-form-bulanan-1').removeClass('showed')
	        $('.select-form-bulanan-2').removeClass('showed')

	        $('.btn-confirm-bulan').replaceWith('<button class="btn btn-primary buttonnya btn-select-bulan"><i class="fas fa-list" aria-hidden="true"></i> Bulan</button> ')
	        $(this).parents('td').children('.input-group').find('.select-form-nya').addClass('showed')
	    })

	    $(document).on('click','.btn-select-bulan', function(e) {

	        e.preventDefault()
	        $('.select-form-nya').removeClass('showed')
	        $('.select-form-bulanan-1').removeClass('showed')
	        $('.select-form-bulanan-2').removeClass('showed')

	        $('.btn-confirm-bulan').replaceWith('<button class="btn btn-primary buttonnya btn-select-bulan"><i class="fas fa-list" aria-hidden="true"></i> Bulan</button> ')
	        $(this).parents('td').children('.input-group').find('.select-form-bulanan-1').addClass('showed')
	        $(this).parents('td').children('.input-group').find('.select-form-bulanan-2').addClass('showed')
	        $(this).replaceWith('<button class="btn btn-confirm-bulan buttonnya btn-success"><i class="fas fa-check"></i></button>')
	    })


	    $(document).on('click','.btn-confirm-bulan', function() {

	        var kd_mesin = $(this).parents('td').find('.kd_mesin').val()
	        var bulan = $(this).parents('td').children('.input-group').find('.select-form-bulanan-1').val()
	        var tahun = $(this).parents('td').children('.input-group').find('.select-form-bulanan-2').val()

	        const url = "<?php echo base_url() ?>machine_schedule/detail/" + kd_mesin + '/' + bulan + '/' + tahun

	        //alert(url)
	        window.location.href = url
	    })
	})


	</script>