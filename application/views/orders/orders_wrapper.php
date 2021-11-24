<style>
    
    .need-attention {
        animation: glow 1s infinite alternate;
    }

    @keyframes glow {
      from {
        box-shadow: 0 0 5px -5px #ff7b01;
      }
      to {
        box-shadow: 0 0 5px 5px #ff7b01;
      }
    }

</style>

<?php
$title = ''; 
if ($action == 'create') {
    $title = 'Tambah Data Order';
}

if ($action == 'waiting') {
    $title = 'Waiting Data Order';
}

if ($action == null) {
    $title = 'List Data Order';
}
?>
<div id="content" class="app-content">
    <h1 class="page-header">ORDER</h1>  
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title panel-title-orders"><?php echo $title ?></h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-success btn-loading" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body" id="panel-body">
                    <?php 
                    if ($action == 'create') {
                        $classnyak->create();
                    }

                    if ($action == 'waiting') {
                        $classnyak->waiting();
                    }

                    if ($action == null) {
                        $classnyak->list();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailOrder">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalDetailOrderLabel">Fetching Detail...</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <div id="detail-order-wrapper">
        
        </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalMaterialFinder">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalMaterialFinderLabel">Material Finder</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="txtsearchmaterial" id="txtsearchmaterial" class="form-control mb-15px" placeholder="Cari Material" style="color: black;background: #a8a8a8;">
            <div class="listsuggestionnya" style="position: relative; display: none;">
                <label style="font-weight: bold;">Result :</label>
                <div class="container list-suggestion-material" style="border: solid 1px gray; border-radius: 8px; padding: 10px;">
                    
                </div>
            </div>
            <div class="listpinnedmaterial">
                <div class="table-responsive">
                    <table id="data-table-material" class="table table-sm table-hover text-black">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Weight</th>
                                <th>D/T</th>
                                <th>P</th>
                                <th>L</th>
                                <th>Masa</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="materials-pinned">
                            <tr class="materials-info-tr">
                                <td colspan="8"><p style="text-align: center;"><i class="fas fa-exclamation-triangle"></i> Mulai ketik material dan pilih untuk mencatat material</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>

<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog-sketch-preview">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Attachment Preview</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-reject-reason">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="reject-form">
          <div class="modal-header">
            <h4 class="modal-title">Reject Reason</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
          </div>
          <div class="modal-body">
            <label class="form-label mb-15px">Silahkan masukan alasan reject pada kotak dibawah :</label>
            <textarea class="form-control" id="txtrejectreason" name="txtrejectreason" rows="3" placeholder="Enter your Reject Reason here..." style="border: solid 1px gray; color: gray;"></textarea>
            <input type="hidden" name="id" id="id" value="">
          </div>
          <div class="modal-footer">
            <p style="color: red;">* Dengan menekan reject, tindakan akan langsung dilakukan</p>
            <button type="submit" class="btn btn-danger">Reject</button>
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
          </div>
        </form>
    </div>
  </div>
</div>




        <?php
        if (is_allowed_button($this->uri->segment(1),'read')<1) { ?>
            <script>
                    $('.read_data').css('display','none')
            </script>
        <?php } ?>

        <?php
        if (is_allowed_button($this->uri->segment(1),'create')<1) { ?>
            <script>
                    $('.tambah_data').css('display','none')
            </script>
        <?php } ?>

        <?php
        if (is_allowed_button($this->uri->segment(1),'export')<1) { ?>
            <script>
                    $('.export_data').css('display','none')
            </script>
        <?php } ?>

        <?php
        if (is_allowed_button($this->uri->segment(1),'update')<1) { ?>
            <script>
                    $('.update_data').css('display','none')
            </script>
        <?php } ?>

        <?php
        if (is_allowed_button($this->uri->segment(1),'delete')<1) { ?>
            <script>
                    $('.delete_data').css('display','none')
            </script>
        <?php } ?>

        <script type="text/javascript">

            function checkmaterialpinned() {

                let arrpinned = []

                $('.material-pinned').each(function() {
                    var km = $(this).attr('id')
                    arrpinned.push(km)
                })

                $('.btn-fetch-material').each(function() {

                    var thisel = $(this)

                    var km = thisel.data('kdmaterial')

                    if (arrpinned.includes(km)) {
                        thisel.attr('disabled','')
                    } else {
                        thisel.removeAttr('disabled')
                    }
                })
            }

            function changewindowtitle(text) { 
                $('.panel-title-orders').text(text);
            }
            
            $(document).on('click','.tambah_data', function() {
                $('.btn-loading').click()
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>orders/create",
                    success: function(data){
                        $('#panel-body').html(data);
                        changewindowtitle('Form Order Baru')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                });
            })

            $(document).on('click','.list-data', function(e) {
                e.preventDefault()
                $('.btn-loading').click()
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>orders/list",
                    success: function(data){
                        $('#panel-body').html(data);
                        changewindowtitle('List Data orders')
                        
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                })
            })

            $(document).on('click','.read_data', function() {

                const id = $(this).attr('id')
                $('.btn-loading').click()
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>orders/read",
                    data: {
                        id:id,
                    },
                    success: function(data){
                        $('#panel-body').html(data);
                        changewindowtitle('Read Data orders')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                });
            })

            $(document).on('click','.update_data', function() {

                const id = $(this).attr('id')
                $('.btn-loading').click()
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>orders/update",
                    data: {
                        id:id,
                    },
                    success: function(data){
                        $('#panel-body').html(data);
                        changewindowtitle('Edit data orders')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                });
            })

            $(document).on('click','.delete_data', function() {
                Swal.fire({
                  title: 'Yakin dihapus?',
                  text: "Data tidak dapat dikembalikan jika terhapus",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes'
                }).then((result) => {
                  if (result.isConfirmed) {
                    const id = $(this).attr('id')
                    $('.btn-loading').click()
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>orders/delete",
                        data: {
                            id:id,
                        },
                        success: function(data){
                            Swal.fire({
                              icon: 'success',
                              title: "Sukses",
                              text: 'Data orders berhasil dihapus'
                            })
                            $('#panel-body').html(data);
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

            $(document).on('click', '.reject_waiting_data', function() {
                $('#id').val($(this).attr('id'))
            })

            $(document).on('submit','#modal-reject-reason', function(e) {
                e.preventDefault()
                
                if ($(this).valid) return false;

                var formData = new FormData($('#reject-form')[0])

                var btnselected = $(document.activeElement)

                btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>orders/update_approve",
                    data:formData, //penggunaan FormData
                    processData:false,
                    contentType:false,
                    cache:false,
                    async:false,
                    success: function(data){
                        // alert(data)
                        $('.modal').modal('hide');
                        Swal.fire({
                          icon: 'success',
                          title: "Sukses",
                          text: 'Data orders berhasil diupdate'
                        })
                        $('#panel-body').html(data);
                        changewindowtitle('List Data orders')
                        btnselected.html('<i class="fas fa-sync fa-spin"></i>').removeClass('disabled').removeAttr('disabled')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                });
            })

            $(document).on('submit','#form-approve', function(e) {
              e.preventDefault()
                
                if ($(this).valid) return false;

                var a = this

                var btnselected = $(document.activeElement)
                
                var action = btnselected.attr('action')

                var owo = 0

                var message = ''
                $('.approve-check').each(function() {
                    if (!this.checked) {
                        owo = 1
                    }
                })

                if (owo == 1) {
                    message = 'Beberapa hal tidak terpenuhi terdeteksi. Dengan menyimpan status approve ini secara otomatis akan me-reject order, pastikan alasan reject sudah terisi.'
                }

                if (owo == 0) {
                    message = 'Semua requirement terpenuhi, konfirmasi tindakan?'
                }

                Swal.fire({
                    title: 'Konfirmasi Tindakan',
                    text: message,
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
                            url: "<?php echo base_url() ?>orders/update_approve/" + action,
                            data:new FormData(a), //penggunaan FormData
                            processData:false,
                            contentType:false,
                            cache:false,
                            async:false,
                            success: function(data){
                                var dt = JSON.parse(data)

                                Swal.fire({
                                  icon: 'success',
                                  title: "Sukses",
                                  text: 'Data orders berhasil diupdate'
                                })
                                $('#panel-body').html(dt.page);
                                changewindowtitle('List Data orders')                                
                            },
                            error: function(error) {
                                Swal.fire({
                                  icon: 'error',
                                  title: "Oops!",
                                  text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                                })
                                btnselected.html('Reject').removeClass('disabled').removeAttr('disabled')
                            }
                        });
                    }
                })  
            })

            $(document).on('submit','#form_create_action', function(e) {

                e.preventDefault()
                
                if ($(this).valid) return false;

                var a = this

                var btnselected = $(document.activeElement)

                Swal.fire({
                  title: 'Konfirmasi Tindakan',
                  text: "Yakin disimpan?",
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
                        url: "<?php echo base_url() ?>orders/create_action",
                        data:new FormData(a), //penggunaan FormData
                        processData:false,
                        contentType:false,
                        cache:false,
                        async:false,
                        success: function(data){
                        
                            Swal.fire({
                              icon: 'success',
                              title: "Sukses",
                              text: 'Data orders berhasil tercatat'
                            })
                            $('#panel-body').html(data);
                            changewindowtitle('List Data orders')
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

            $(document).on('submit','#form_update_action', function(e) {

                e.preventDefault()
                
                if ($(this).valid) return false;

                 var a = this

                Swal.fire({
                  title: 'Konfirmasi Tindakan',
                  text: "Yakin diupdate?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes'
                }).then((result) => {
                  if (result.isConfirmed) {
                    dataString = $("#form_update_action").serialize();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>orders/update_action",
                        data:new FormData(a), //penggunaan FormData
                        processData:false,
                        contentType:false,
                        cache:false,
                        async:false,
                        success: function(data){
                            Swal.fire({
                              icon: 'success',
                              title: "Sukses",
                              text: 'Data orders berhasil diupdate'
                            })
                            $('#panel-body').html(data);
                            changewindowtitle('List Data orders')
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

            $(document).on('click','.read_waiting_data', function() {

                const id = $(this).attr('id')
                $('.btn-loading').click()
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>orders/read_w_order",
                    data: {
                        id:id,
                    },
                    success: function(data){
                        $('#panel-body').html(data);
                        changewindowtitle('Read data orders')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                });
            })

            $(document).on('click','#form_waiting_data', function() {
                e.preventDefault()
                
                var a = this

                if ($(this).valid) return false;

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>orders/update_waiting_action",
                    data:new FormData(a), //penggunaan FormData
                    processData:false,
                    contentType:false,
                    cache:false,
                    async:false,
                    success: function(data){
                        Swal.fire({
                          icon: 'success',
                          title: action + "Sukses",
                          text: 'Data orders berhasil di ' + action
                        })
                        $('#panel-body').html(data);
                        changewindowtitle('Read data orders')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                });
            })

            $(document).on('click','.waiting-list-data', function(e) {
                e.preventDefault()
                $('.btn-loading').click()
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>orders/waiting",
                    success: function(data){
                        $('#panel-body').html(data);
                        changewindowtitle('Waiting orders')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                });
            })

            $(document).on('click','.sketsa_preview', function() {
                var attachment = $(this).attr('picture')

                $('#modal-dialog-sketch-preview').find('.modal-body').html('<img style="width: 100%;" src="<?php echo base_url().'assets/internal' ?>/' + attachment + '"/>')

            })

            $(document).on('input','#txtsearchmaterial', function(e) {
                e.preventDefault()

                var search_text = $(this).val()

                if (search_text.length > 0) {
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>orders/search_material/" + search_text,
                        success: function(data){
                            var dt = JSON.parse(data)
                            
                            $('.listsuggestionnya').css('display','block')
                            
                            if (dt.response == 'not found') {
                                $('.list-suggestion-material').html(dt.message)
                            }

                            if (dt.response == 'found') {
                                $('.list-suggestion-material').html(dt.search_result)
                                checkmaterialpinned()
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                              icon: 'error',
                              title: "Oops!",
                              text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                            })
                        }
                    })
                } else {
                    $('.listsuggestionnya').css('display','none')
                }

            })

            $(document).on('click','.btn-fetch-material', function() {
                 $('.materials-info-tr').attr('hidden','')

                 var kdmaterial = $(this).data('kdmaterial')
                 var diametertebal = $(this).data('diametertebal')
                 var panjang = $(this).data('panjang')
                 var lebar = $(this).data('lebar')
                 var weight = $(this).data('weight')
                 var stok = $(this).data('stok')
                 var massamaterial = $(this).data('massamaterial')

                 var row = `
                    <tr class="material-pinned" id="${kdmaterial}">
                        <td>${kdmaterial}</td>
                        <td>${weight}</td>
                        <td>${diametertebal}</td>
                        <td>${panjang}</td>
                        <td>${lebar}</td>
                        <td>${massamaterial}</td>
                        <td>${stok}</td>
                        <td><button class="btn btn-xs btn-danger btn-remove-material"><i class="fas fa-times"></i></button></td>
                    </tr>
                 `

                 $('#materials-pinned').append(row)

                 checkmaterialpinned()

            })

            $(document).on('click','.btn-remove-material',function() {
                $(this).parents('tr').remove()

                if ($('.material-pinned').length < 1) {
                    $('.materials-info-tr').removeAttr('hidden')                    
                }
                checkmaterialpinned()

            })

            $(document).on('click','.btn-info-order', function(e) {
                e.preventDefault()

                var kd_order = $(this).attr('id')

                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>orders/detail_order/" + kd_order,
                    success: function(data){
                        $('#detail-order-wrapper').html(data);
                        $('#modalDetailOrderLabel').text(kd_order)                        
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                    }
                })
            })


        </script>