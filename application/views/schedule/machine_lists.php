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

<div class="accordion" id="accordion">
  <div class="accordion-item border-0">
    <div class="accordion-header" id="headingOne">
      <button class="accordion-button bg-gray-900 text-white px-3 py-10px pointer-cursor" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
        <i class="fa fa-circle fa-fw text-blue me-2 fs-8px"></i> Machine List
      </button>
    </div>
    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordion">
      <div class="accordion-body bg-gray-800 text-white">
        <div class="row gx-0">
	
			<?php 
			if ($machine_list) {
				foreach ($machine_list as $key => $value) {
					?>
						<div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 wrapper_info_mesin">
							<?php
								$classnyak->show_machine($value->mesin_id);
							?>
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

<script type="text/javascript">
	
	$('.form-check-status-mesin').change(function(){
		var thisel = $(this)
		if (thisel.is(':checked')) {
			thisel.attr('value',1)
		} else {
			thisel.attr('value',0)
		}
	})

</script>

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

		            dataString = $("#form_mesin_<?php echo $value->mesin_id ?>").serialize()  + "&action=" + action
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

			                   thisel.parents('.wrapper_info_mesin').html(dt.page)
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