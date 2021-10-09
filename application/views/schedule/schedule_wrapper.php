<style>
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
    <div class="wrapper-info-mesin">
	   <?php $classnyak->machine_list() ?> 
    </div>
    <h1 class="page-header"></h1>  
    <div class="accordion" id="accordiontwo">
      <div class="accordion-item border-0">
        <div class="accordion-header" id="headingOne">
          <button class="accordion-button bg-gray-900 text-white px-3 py-10px pointer-cursor" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
            <i class="fa fa-circle fa-fw text-blue me-2 fs-8px"></i> Schedule
          </button>
        </div>
        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordiontwo">
          <div class="accordion-body bg-gray-800 text-white schedule-wrapper" style="display: flex;overflow-x: auto;">
            <?php $classnyak->schedule_list() ?>
          </div>
        </div>
      </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/assets/plugins/clipboard/dist/clipboard.min.js"></script>

        <?php

if ($machine_list) {
    foreach ($machine_list as $key => $value) {

        ?>
        <script type="text/javascript">
    
            $(document).on('submit','#form_mesin_<?php echo $value->mesin_id ?>', function(e) {

                e.preventDefault()
                
                if ($(this).valid) return false;
                var thisel = $(this)

                var action = $(document.activeElement).attr('action')
                var machine_type = $(document.activeElement).attr('machine-type')

                Swal.fire({
                  title: 'Konfirmasi Tindakan',
                  text: "Yakin menjalankan tindakan " + action + "?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes'
                }).then((result) => {
                  if (result.isConfirmed) {

                     Swal.fire({
                          title: 'Sedang memproses',
                          text: "Harap Tunggu",
                          icon: 'warning',
                          showCancelButton: false,
                                showConfirmButton: false
                        })

                    dataString = $("#form_mesin_<?php echo $value->mesin_id ?>").serialize()  + "&action=" + action + "&machine_type=" + machine_type
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>schedule/update_machine",
                        data: dataString,
                        success: function(data){
                            var dt = JSON.parse(data)

                            if (dt.status == 'ok') {
                                Swal.fire({
                                  icon: 'success',
                                  title: "Sukses",
                                  text: dt.msg
                                })

                               thisel.parents('.wrapper-info-mesin').html(dt.page)

                               $.ajax({
                                    type: "GET",
                                    url: "<?php echo base_url() ?>schedule/schedule_list",
                                    success: function(data){
                                        $('.schedule-wrapper').html(data);
                                    }
                                });
                            }

                            if (dt.status == 'error') {
                                Swal.fire({
                                  icon: 'error',
                                  title: "Gagal",
                                  text: dt.msg
                                })
                            }

                            // changewindowtitle('List Produksi')
                            // $('#panel-body').html(data);
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
                })

            })

        </script>
        <?php

    }
}

?>