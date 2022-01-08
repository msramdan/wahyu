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
                    <div class="input-group" style="max-width: 70%;; margin: auto;">
					    <input type="text" id="tbkdorder" class="form-control" placeholder="Masukan Kode Order" value="<?php echo $kode_order ?>">
					    <span class="input-group-btn">
					        <button class="btn btn-primary" id="btnsearchkdorder" type="button">Cari</button>
					    </span>
					</div>

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
                setTimeout(function(){
                    $('#infowrapper').html(data);
                },2000)
            },
            error: function(e){
              setTimeout(function(){
                    $('#infowrapper').html(`
                    	<div class="info" style="display: flex;
						flex-direction: column;
						text-align: center;
						height: 50vh;
						justify-content: center;">
                        	<div class="icon"> <i class="fas fa-spinner fa-spin fa-3x"></i></div>
                        	<h3 class="title" style="color: #9d9d9d;s">Mohon Tunggu...</h3>
                    	<div>

                    	`);
                },2000)
            }
        });
    }

    $(document).ready(function() {

    	$('#btnsearchkdorder').on('click', function() {
    		initSearch()
    	})

    })



</script>