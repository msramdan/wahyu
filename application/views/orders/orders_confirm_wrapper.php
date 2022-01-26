<div id="content" class="app-content">
    <h1 class="page-header">ORDER</h1>  
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title panel-title-orders">Konfirmasi Penyelesaian Order</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-success btn-loading" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body" id="panel-body">
                    <form id="search_kd_order_form">
                        <div class="input-group" style="max-width: 70%;; margin: auto;">
    					    <input type="text" required id="tbkdorder" class="form-control" placeholder="Masukan Kode Order" value="<?php echo $kode_order ?>">
    					    <span class="input-group-btn">
    					        <button type="submit" class="btn btn-primary" id="btnsearchkdorder">Cari</button>
    					    </span>
    					</div>
                    </form>

					<div id="infowrapper" class="text-white" style="margin-top: 3vh;">
					    <div class="info" style="display: flex;
							flex-direction: column;
							text-align: center;
							height: 50vh;
							justify-content: center;">
					        <div class="icon"><i class="fa fa-search" style="font-size: 65px"></i></div>
					        <h3 class="title" style="color: #9d9d9d;s">Data Order akan muncul disini</h3>
					        <p>Kesulitan menginput kode order? coba cari di <a class="btn btn-warning btn-xs" href="<?php echo base_url().'Orders' ?>">Daftar Order</a></p>        
					    </div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	
	 function showloading() {
        $('#infowrapper').html(`<div class="info" style="display: flex;
								flex-direction: column;
								text-align: center;
								height: 50vh;
								justify-content: center;">
	                            	<div class="icon"> <i class="fas fa-spinner fa-spin fa-3x"></i></div>
	                            	<h3 class="title" style="color: #9d9d9d;s">Mohon Tunggu...</h3>
	                        	<div>`);
    }

	const initSearch = () => {
        const kode_order = $('#tbkdorder').val()
        showloading()
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url() ?>Orders/get_order_toconfirm_data",
            data : {
                kd_order: kode_order
            },
            success: function(data){
                // const dt = JSON.parse(data)
                const dt = JSON.parse(data)

                if (dt.status == 'ok') {
                    setTimeout(function(){
                        $('#infowrapper').html(dt.page);
                    },2000)
                } else {
                    $('#infowrapper').html(`
                        <div class="info" style="display: flex;
                        flex-direction: column;
                        text-align: center;
                        height: 50vh;
                        justify-content: center;">
                            <div class="icon"> <i class="fas fa-times"></i></div>
                            <h3 class="title" style="color: #9d9d9d;s">Data tidak ditemukan</h3>
                        <div>
                        `);
                }

            },
            error: function(e){
              setTimeout(function(){
                    $('#infowrapper').html(`
                    	<div class="info" style="display: flex;
						flex-direction: column;
						text-align: center;
						height: 50vh;
						justify-content: center;">
                        	<div class="icon"> <i class="fas fa-times"></i></div>
                        	<h3 class="title" style="color: #9d9d9d;s">Ada masalah dengan server, silahkan coba lagi</h3>
                    	<div>

                    	`);
                },2000)
            }
        });
    }

    $(document).ready(function() {

    	$('#search_kd_order_form').on('submit', function(e) {

            e.preventDefault()
                
            if ($(this).valid) return false;
    		
            initSearch()
    	})

          $(document).on('submit','#form_confirm_order', function(e) {
              e.preventDefault()
                
                if ($(this).valid) return false;

                var a = this

                var btnselected = $(document.activeElement)

                Swal.fire({
                    title: 'Konfirmasi Tindakan',
                    text: 'Yakin ingin menuntaskan order ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {

                        btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>orders/order_confirm_action",
                            data:new FormData(a), //penggunaan FormData
                            processData:false,
                            contentType:false,
                            cache:false,
                            async:false,
                            success: function(data) {
                                var dt = JSON.parse(data)

                                if (dt.status == 'ok') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "Sukses",
                                        text: 'Data orders berhasil diupdate'
                                    })
                                    initSearch()
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: "Terjadi kesalahan",
                                        text: 'Server mengembalikan respon yang bukan seharusnya...'
                                    })
                                    btnselected.html('Konfirmasi Selesai').removeClass('disabled').removeAttr('disabled')
                                }
                                                                
                            },
                            error: function(error) {
                                Swal.fire({
                                  icon: 'error',
                                  title: "Oops!",
                                  text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                                })
                                btnselected.html('Konfirmasi Selesai').removeClass('disabled').removeAttr('disabled')
                            }
                        });
                    }
                })  
            })
    })



</script>