<div id="content" class="app-content">
    <h1 class="page-header">KELOLA DATA ORDERS</h1>  
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <h4 class="panel-title panel-title-orders">List Data orders </h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-success btn-loading" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            </div>
        <div class="panel-body" id="panel-body">
            <?php $classnyak->list() ?>
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
                        changewindowtitle('Tambah Order Baru - Identitas')
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
                });
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

            $(document).on('submit','#form_create_action', function(e) {

                e.preventDefault()
                
                if ($(this).valid) return false;

                var a = this
                var action = $(document.activeElement).attr('action')

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

                    if (action == 'save') {
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

                    if (action == 'savethenproduction') {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>orders/create_action_then_production",
                            data:new FormData(a), //penggunaan FormData
                            processData:false,
                            contentType:false,
                            cache:false,
                            async:false,
                            success: function(data){
                                // alert(data)
                                var dt = JSON.parse(data)
                                Swal.fire({
                                  icon: 'success',
                                  title: "Sukses",
                                  text: 'Data orders berhasil tercatat, sedang mengarahkan ke form tambah produksi...'
                                })
                                window.location.href = '<?php echo base_url() ?>orders/redirect/productionaddform/' + dt.kode_order
                            
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

                    // dataString = $("#form_create_action").serialize() + "&action=" + action;

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
        </script>