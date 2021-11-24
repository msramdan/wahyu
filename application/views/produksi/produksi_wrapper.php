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

<div id="content" class="app-content">
    <h1 class="page-header">KELOLA DATA PRODUKSI</h1>
    <div class="row">
        <div class="col-md-8">
          <div class="panel panel-inverse">
              <div class="panel-heading">
                <h4 class="panel-title panel-title-produksi">Produksi</h4>
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
        <div class="col-md-4">
            <div class="panel panel-inverse">
              <div class="panel-heading">
                <h4 class="panel-title">Smart Assist</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    </div>
                <div class="panel-body">
                    <div class="row">
                      <div class="col-4" style="text-align: center;"><i class="fab fa-github-alt fa-4x"></i></div>
                      <div class="col-8">
                        <h4 id="smart_assist_title" style="font-weight: bold;"><?php echo 'Selamat ' . $salam; ?></h4>
                        <div id="smart_assist_message">Smart Assist membantu anda untuk melakkan tindakan dengan efisien. Kelihatannya semua terkendali!</div>
                        <div id="smart_assist_recommendation">
                            
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaldetailproduksi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title info_kdorder">-</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <table class="table table-sm text-gray">
            <tr><td style="width: 90px;">Barang</td><td style="width: 5px;">:</td><td class="info_barang"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Jumlah</td><td style="width: 5px;">:</td><td class="info_qty"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Tanggal Order</td><td style="width: 5px;">:</td><td class="info_tanggal_order"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Due Date</td><td style="width: 5px;">:</td><td class="info_due_date"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Pemesan</td><td style="width: 5px;">:</td><td class="info_nama_pemesan"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Bagian</td><td style="width: 5px;">:</td><td class="info_bagian"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Prioritas</td><td style="width: 5px;">:</td><td class="info_priority"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Approved by</td><td style="width: 5px;">:</td><td class="info_tanggal_order"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Status</td><td style="width: 5px;">:</td><td class="info_status"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Attachment</td><td style="width: 5px;">:</td><td class="info_attachment"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Tanggal Produksi</td><td style="width: 5px;">:</td><td class="info_tanggal_produksi"><i class="fas fa-sync fa-spin"></i></td></tr>
            <tr><td style="width: 90px;">Rencana Selesai</td><td style="width: 5px;">:</td><td class="info_rencana_selesai"><i class="fas fa-sync fa-spin"></i></td></tr>
        </table>
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white btn-close-modal-dtl-produksi" data-bs-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>

<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog-sketch-preview">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Dialog</h4>
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

            //THIS IS FOR PRODUKSI
            
            function changewindowtitle(text) {
                $('.panel-title-produksi').text(text);
            }
            

            $(document).ready(function() {
                <?php if ($kode_order) {
                    ?>
                    $('.tambah_data').click()
                    <?php
                } ?>
            })

            $(document).on('click','.modal-dtl-produksi-right', function() {
                    
                var kdorder = $(this).attr('idorder')
                var kdprod = $(this).attr('idproduksi')

                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>produksi/get_data_order/" + kdorder + "/" + kdprod,
                    success: function(data){
                        var dt = JSON.parse(data)
                        $('.info_kdorder').html(kdorder)
                        $('.info_tanggal_order').html(dt.tanggal_order)
                        $('.info_nama_pemesan').html(dt.nama_pemesan)
                        $('.info_bagian').html(dt.bagian)
                        $('.info_priority').html(dt.priority)
                        $('.info_status').html(dt.status)
                        $('.info_attachment').html(dt.attachment)
                        $('.info_barang').html(dt.barang)
                        $('.info_qty').html(dt.qty)
                        $('.info_due_date').html(dt.due_date)
                        $('.info_tanggal_produksi').html(dt.tanggal_produksi)
                        $('.info_rencana_selesai').html(dt.rencana_selesai)
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

            $(document).on('click','.btn-close-modal-dtl-produksi', function() {
                $('.info_kdorder').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_tanggal_order').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_nama_pemesan').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_bagian').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_priority').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_status').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_attachment').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_barang').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_qty').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_due_date').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_tanggal_produksi').html('<i class="fas fa-sync fa-spin"></i>')
                $('.info_rencana_selesai').html('<i class="fas fa-sync fa-spin"></i>')
            })

            $(document).on('click','.tambah_data', function() {
                $('.btn-loading').click()
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>produksi/create",
                    success: function(data){
                        $('#panel-body').html(data);
                        $('#smart_assist_title').text('Kode Order diperlukan')
                        $('#smart_assist_message').html('Harap isi kode order sesuai dengan yang sudah diinput pada laman "Order"')
                        $('#smart_assist_recommendation').html("")
                        changewindowtitle('Tambah Data Produksi')
                        <?php if ($kode_order) {
                            ?>
                            $('#kode_order').val('<?php echo $kode_order ?>')
                            var id = $('#kode_order').val()
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url() ?>produksi/cek_kode_order_ready",
                                data: {
                                    id: id,
                                },
                                success: function(data){
                                    var dt = JSON.parse(data)

                                    if (dt.status == 'ok') {
                                        // alert('sip')
                                        $('.button-ceg').replaceWith('<button type="button" class="btn btn-success button-ceg input-group-button" style="pointer-events: none;"><i class="fas fa-check"></i></button>')
                                        $('#smart_assist_title').text('Data Order')
                                        $('#smart_assist_message').html(dt.message)
                                        $('#smart_assist_recommendation').html("")
                                        $('.input-group-kdorder').html('<button type="button" class="btn btn-purple list-data tombol-kembali-input-kdorder">Kembali</button><button type="button" class="btn btn-success btn-next">Konfirmasi</button>')
                                        $('#priority').val(dt.priority)
                                        $('#qty_order').val(dt.qty)
                                    } else {
                                        // alert('no!')
                                        $('.button-ceg').replaceWith('<button type="button" class="btn btn-danger button-ceg input-group-button" style="pointer-events: none;"><i class="fas fa-times"></i></button>')
                                        $('#smart_assist_title').text('Order tidak ditemukan!')
                                        $('#smart_assist_message').html('Cek kembali inputan, pastikan semua huruf adalah besar dan angka sudah sesuai. Jika memang sesuai, mungkin order tersebut sedang on progress atau sudah selesai produksinya')
                                        $('#smart_assist_recommendation').html("")
                                    }
                                },
                                error: function(error) {
                                    Swal.fire({
                                      icon: 'error',
                                      title: "Oops!",
                                      text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                                    })
                                }
                            });
                            <?php
                        } ?>
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
                    url: "<?php echo base_url() ?>produksi/list",
                    success: function(data){
                        $('#panel-body').html(data);
                        $('#smart_assist_title').text('<?php echo 'Selamat ' . $salam; ?>')
                        $('#smart_assist_message').html('Smart Assist membantu anda untuk melakkan tindakan dengan efisien. Kelihatannya semua terkendali!')
                        $('#smart_assist_recommendation').html("")
                        changewindowtitle('List Produksi')
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
                    url: "<?php echo base_url() ?>produksi/read",
                    data: {
                        id:id,
                    },
                    success: function(data){
                        $('#panel-body').html(data);
                        changewindowtitle('Detail Produksi')
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
                        url: "<?php echo base_url() ?>produksi/delete",
                        data: {
                            id:id,
                        },
                        success: function(data){
                            Swal.fire({
                              icon: 'success',
                              title: "Sukses",
                              text: 'Data produksi berhasil dihapus'
                            })
                            $('#panel-body').html(data);
                            changewindowtitle('List Produksi')
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
                    dataString = $("#form_create_action").serialize();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>produksi/create_action",
                        data: dataString,
                        success: function(data){
                            Swal.fire({
                              icon: 'success',
                              title: "Sukses",
                              text: 'Data produksi berhasil tercatat'
                            })
                            changewindowtitle('List Produksi')
                            $('#panel-body').html(data);
                            $('#smart_assist_title').text('<?php echo 'Selamat ' . $salam; ?>')
                            $('#smart_assist_message').html('Smart Assist membantu anda untuk melakkan tindakan dengan efisien. Kelihatannya semua terkendali!')
                            $('#smart_assist_recommendation').html("")
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

            $(document).on('click', '.sketsa_preview', function() {
                var attachment = $(this).attr('picture')

                $('#modal-dialog-sketch-preview').find('.modal-body').html('<img style="width: 100%;" src="<?php echo base_url().'assets/internal' ?>/' + attachment + '"/>')

            })


        </script>