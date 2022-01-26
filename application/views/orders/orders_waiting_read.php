<link href="<?php echo base_url() ?>assets/assets/plugins/bootstrap-clockpicker/src/clockpicker.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>assets/assets/plugins/bootstrap-clockpicker/src/standalone.css" rel="stylesheet" />
<style type="text/css">

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

.hori-timeline {
    margin-top: 15px;
}

.hori-timeline .events {
    border-top: 3px solid #e9ecef;
    display: block;
}
.hori-timeline .events .event-list {
    display: block;
    position: relative;
    text-align: center;
    padding-top: 70px;
    margin-right: 0;
}
.hori-timeline .events .event-list:before {
    content: "";
    position: absolute;
    height: 36px;
    border-right: 2px dashed #dee2e6;
    top: 0;
}
.hori-timeline .events .event-list .event-date {
    position: absolute;
    top: 38px;
    left: 0;
    right: 0;
    width: 75px;
    margin: 0 auto;
    border-radius: 4px;
    padding: 2px 4px;
}
@media (min-width: 768px) {
    
    .hori-timeline .events {
        display: flex !important;
        justify-content: center;
        align-items: center;
    }

    .hori-timeline .events .event-list {
        display: inline-block !important;
        width: 24%;
        padding-top: 45px;
    }
    .hori-timeline .events .event-list .event-date {
        top: -12px;
    }
}
.bg-soft-primary {
    background-color: rgba(64,144,203,.3)!important;
}
.bg-soft-success {
    background-color: rgba(71,189,154,.3)!important;
}
.bg-soft-danger {
    background-color: rgba(231,76,94,.3)!important;
}
.bg-soft-warning {
    background-color: rgba(249,213,112,.3)!important;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="input-group mb-25px">
            <input type="text" class="form-control" name="kode_order" id="kode_order" value="<?php echo $kd_order ?>" />
            <button type="button" id="<?php echo $kd_order ?>" class="btn btn-warning btn-info-order input-group-button" data-toggle="modal" data-target="#modalDetailOrder"><i class="fas fa-info-circle"></i></button>
        </div>

        <div class="hori-timeline" dir="ltr">
            <ul class="list-inline events">

        <?php 
            $wh = json_decode($whoisreviewing, true);
            //print_r($wh);
            foreach ($wh as $key => $value) {
                if ($value['status'] == '-') {
                    ?>
                    <li class="list-inline-item event-list">
                        <div class="px-4">

                            <?php

                            if ($value['tanda_tangan'] == 'sekarang') {
                                ?>
                                <div class="event-date bg-warning need-attention">
                                    In Review
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="event-date bg-primary">
                                    Pending
                                </div>
                                <?php   
                            }

                            ?>
                            <h5 class="font-size-13"><?php echo $classnyak->getlevelname($value['level_id'])->nama_level ?></h5>
                        </div>
                    </li>
                    <?php
                }

                if ($value['status'] == 'true') {
                    ?>
                    <li class="list-inline-item event-list">
                        <div class="px-4">
                            <div class="event-date bg-success">
                                Approved
                            </div>
                            <h5 class="font-size-13"><?php echo $classnyak->getlevelname($value['level_id'])->nama_level ?></h5>
                        </div>
                    </li>
                    <?php
                }

                if ($value['status'] == 'false') {
                    ?>
                    <li class="list-inline-item event-list">
                        <div class="px-4">
                            <a class="btn btn-danger event-date" data-bs-toggle="modal" href="#message-disapproved-dialog">
                                Dissaproved
                            </a>
                            <h5 class="font-size-13"><?php echo $classnyak->getlevelname($value['level_id'])->nama_level ?></h5>
                        </div>
                    </li>
                        
                    <?php
                }
            }
        ?>
            </ul>
        </div>
        <form id="form-approve">

                <?php

                if ($status == 'WAITING') {
                    $roleini = $this->session->userdata('level_id');

                    $whomustsignthisorder = '';
                    $signstatus = '';

                    if ($roleini == 1) {
                        foreach ($wh as $key => $value) {
                            if (array_search('sekarang', $value)) {
                                // echo 'kau admin kh? good! here is da level id that must be sign this shit'.$value['level_id'];

                                $whomustsignthisorder = $value['level_id'];
                                $signstatus = $value['tanda_tangan'];
                            }
                        }
                    } else {
                        foreach ($wh as $key => $value) {
                            if (array_search($roleini, $value)) {
                                $whomustsignthisorder = $value['level_id'];
                                $signstatus = $value['tanda_tangan'];
                            }
                        }
                    }

                    if ($whomustsignthisorder == 220) { //admin wm
                        if ($signstatus == 'sekarang') {
                            
                            ?>
                            <div class="formnya container">
                                <input type="hidden" name="signer" value="<?php echo $whomustsignthisorder ?>">
                                <input type="hidden" name="id" value="<?php echo $order_id ?>">
                                <input type="hidden" name="kd_order" value="<?php echo $kd_order ?>">
                                <input type="hidden" name="priority" value="<?php echo $priority ?>">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="row mb-15px">
                                            <label class="form-label col-form-label col-md-2">Check</label>
                                            <div class="col-md-10">
                                                <div style="display: inline-flex;">
                                                    <div class="form-check form-check-inline mb-15px">
                                                        <input type="checkbox" class="form-check-input approve-check" name="attachmentapprovestatus" id="attachmentapprovestatus">
                                                        <label for="attachmentapprovestatus" class="form-check-label">Gambar Sesuai</label>
                                                        <a class="btn btn-primary btn-xs sketsa_preview" href="#modal-dialog-sketch-preview" picture="<?php echo $attachment; ?>" data-bs-toggle="modal"><i class="fas fa-eye"></i></a>
                                                    </div>

                                                    <div class="form-check form-check-inline mb-15px">
                                                        <input type="checkbox" class="form-check-input approve-check" name="materialavailablestatus" id="materialavailablestatus">
                                                        <label for="materialavailablestatus" class="form-check-label">Material Tersedia</label>
                                                        <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalMaterialFinder"><i class="fas fa-search"></i> </button>
                                                    </div>

                                                    <div class="form-check form-check-inline mb-15px">
                                                        <input type="checkbox" class="form-check-input approve-check" readonly name="kalkulasi" id="kalkulasi" style="pointer-events: none;">
                                                        <label for="kalkulasi" class="form-check-label" style="pointer-events: none;">Kalkulasi Selesai</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mb-15px">
                                            <label class="form-label col-form-label col-md-2">Tanggal Produksi <?php echo form_error('tanggal_produksi') ?></label>
                                            <div class="col-md-7">
                                                <input required type="date" class="form-control" name="tanggal_produksi" id="tanggal_produksi" placeholder="Tanggal Produksi" value="<?php echo $tanggal_produksi; ?>" />
                                            </div>
                                            <div class="col-md-3">

                                                <div class="input-group clockpicker">
                                                  <input type="text" class="form-control jam-awal" name="jam_awal" value="08:00"/>
                                                  <span class="input-group-text input-group-addon">
                                                    <i class="fa fa-clock"></i>
                                                  </span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row mb-15px">
                                            <label class="form-label col-form-label col-md-2">Target Selesai</label>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="input-group">
                                                      <input required type="date" class="form-control" readonly name="rencana_selesai" id="rencana_selesai" placeholder="Tanggal Produksi" value="<?php echo $rencana_selesai; ?>"/>
                                                      <span class="input-group-text">/</span>
                                                      <input type="date" class="form-control" readonly name="due_date" id="due_date" value="<?php echo $due_date ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                  <input type="text" class="form-control masked-input-date jam-akhir" readonly name="jam_akhir" value="16:00" />
                                                  <span class="input-group-text input-group-addon">
                                                    <i class="fa fa-clock"></i>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-15px">
                                            <label class="form-label col-form-label col-md-2">Qty Order</label>
                                            <div class="col-md-7">
                                                <input required type="number" class="form-control" readonly name="qty_order" id="qty_order" placeholder="Qty order" value="<?php echo $qty ?>"/>
                                            </div>
                                            <div class="col-md-3">
                                                
                                            </div>
                                        </div>
                                        <div class="reject-note-wrapper mb-25px">
                                            <textarea class="form-control" name="txtrejectreason" rows="3"></textarea>
                                        </div>
                                        <div class="input-group input-group-button-action">
                                            <button type="submit" class="btn btn-success btn-approve" action="approve" style="display:none; flex: 15%;">Approve</button>
                                            <button style="flex: 15%;" type="submit" action="reject" class="btn btn-danger">Reject</button>
                                            <button style="flex: 15%;" type="button" class="btn btn-info waiting-list-data">Kembali</button>
                                        </div> 
                                    </div>

                                    <div class="col-5">
                                        <div id="available-schedule-wrapper" class="mb-25px">

                                        </div>
                                        <div class="alertnya mb-25px">
                                    
                                        </div>

                                        <table class="table table-hover table-sm tabel-machine">
                                            <thead>
                                                <tr>
                                                    <th>Machine</th>
                                                    <th>Throughput</th>
                                                    <th class="shiftmachine" hidden>Shift</th>
                                                    <th hidden>Material Processed</th>
                                                    <!-- <th>Products</th> -->
                                                    <th>Time</th>
                                                    <th hidden="hidden">T. Minutes</th>
                                                </tr>
                                            </thead>
                                            <tbody class="daftar_mesin">
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="shiftmachine" hidden></td>
                                                    <td></td>
                                                    <td style="text-align: right; font-size: 14px;"><b>Total</b></td>
                                                    <td hidden><input type="text" name="totalmaterialused" class="form-control-plaintext totalmaterialused"></td>
                                                    <td><input type="text" readonly name="predictiondone" class="form-control-plaintext predictiondone"></td>
                                                    <td hidden><input type="number" name="totalminuteseverymachine" class="totalminuteseverymachine" value="0"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php

                        } else {
                            $dataprod = $classnyak->read_data_produksi($kd_order);
                            ?>
                            <div class="alert alert-success">
                                Admin WM sudah meng-approve order ini
                            </div>


                            <table id="data-table-default" class="table table-bordered table-td-valign-middle">
                                <tr><td>Id</td><td><?php echo $dataprod['id']; ?></td></tr>
                                <tr><td>Tanggal Produksi</td><td><?php echo $dataprod['tanggal_produksi']; ?></td></tr>
                                <tr><td>Rencana Selesai</td><td><?php echo $dataprod['rencana_selesai']; ?></td></tr>
                                <tr><td>Total Barang Jadi</td><td><?php echo $dataprod['total_barang_jadi']; ?></td></tr>
                                <tr><td>Priority</td><td>
                                    
                                    <?php 

                                    $op = $dataprod['priority'];
                                    $badge = '';
                                    if ($op == 1) {
                                        $badge = '<label class="badge bg-success">Biasa</label>';
                                    }
                                    if ($op == 2) {         
                                        $badge = '<label class="badge bg-warning">Urgent</label>';
                                    }
                                    if ($op == 3) {
                                        $badge = '<label class="badge bg-danger">Top Urgent</label>';
                                    }
                                    
                                    echo $badge;
                                    ?>
                                </td></tr>
                                <tr>
                                    <td>Mesin Digunakan</td>
                                    <td>
                                        <ul>
                                            <?php

                                            $mu = json_decode($dataprod['machine_used'], TRUE);

                                            foreach ($mu as $key => $value) {
                                                ?>
                                                <li><?php echo $classnyak->getmachinedetail($value['machine_id'])->kd_mesin ?></li>
                                                <table class="table table-sm table-hover">
                                                    <tr>
                                                        <td>Estimasi Selesai per-barang</td>
                                                        <td><?php echo $value['estimateddonepergoods'] ?> Minute(s)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shift</td>
                                                        <td><?php if ($value['shift1']) {
                                                            ?>
                                                            <label class="badge bg-success">Shift 1</label>
                                                            <?php
                                                        } ?>
                                                        <?php if ($value['shift2']) {
                                                            ?>
                                                            <label class="badge bg-success">Shift 2</label>
                                                            <?php
                                                        } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estimasi</td>
                                                        <td><?php echo $value['etapermachine'] ?></td>
                                                    </tr>
                                                </table>
                                                <?php
                                            }

                                            ?>
                                        </ul>
                                    </td>
                                </tr>

                                <tr><td></td><td><button type="button" class="btn btn-info waiting-list-data"><i class="fas fa-undo"></i> Kembali</button></td></tr>
                            </table>
                            <?php
                        }
                    }

                    if ($whomustsignthisorder == 221) { //kepaladev

                        $dataprod = $classnyak->read_data_produksi($kd_order);

                        ?>
                        <input type="hidden" name="id" value="<?php echo $order_id ?>">

                        <input type="checkbox" checked="true" class="form-check-input approve-check" name="attachmentapprovestatus" id="attachmentapprovestatus" style="visibility: hidden; position: absolute;">
                        <input type="checkbox" checked="true" class="form-check-input approve-check" name="materialavailablestatus" id="materialavailablestatus" style="visibility: hidden; position: absolute;">
                        <input type="checkbox" checked="true" class="form-check-input approve-check" readonly name="kalkulasi" id="kalkulasi" style="visibility: hidden; position: absolute;">

                        <input type="hidden" name="signer" value="<?php echo $whomustsignthisorder ?>">
                        <input type="hidden" name="kd_order" value="<?php echo $kd_order ?>">
                        <table id="data-table-default" class="table table-bordered table-td-valign-middle">
                            <tr><td>Id Produksi</td><td><?php echo $dataprod['id']; ?><input type="hidden" name="idproduksi" value="<?php echo $dataprod['id']; ?>"></td></tr>
                            <tr><td>Tanggal Produksi</td><td><?php echo $dataprod['tanggal_produksi']; ?></td></tr>
                            <tr><td>Rencana Selesai</td><td><?php echo $dataprod['rencana_selesai']; ?></td></tr>
                            <tr><td>Total Barang Jadi</td><td><?php echo $dataprod['total_barang_jadi']; ?></td></tr>
                            <tr><td>Priority</td><td><?php 

                            $op = $dataprod['priority'];
                            $badge = '';
                            if ($op == 1) {
                                $badge = '<label class="badge bg-success">Biasa</label>';
                            }
                            if ($op == 2) {         
                                $badge = '<label class="badge bg-warning">Urgent</label>';
                            }
                            if ($op == 3) {
                                $badge = '<label class="badge bg-danger">Top Urgent</label>';
                            }
                            
                            echo $badge;
                            ?></td></tr>
                            <tr>
                                <td>Mesin Digunakan</td>
                                <td>
                                    <ul>
                                        <?php

                                        $mu = json_decode($dataprod['machine_used'], TRUE);

                                        foreach ($mu as $key => $value) {
                                            ?>
                                            <li><?php echo $classnyak->getmachinedetail($value['machine_id'])->kd_mesin ?></li>
                                            <table class="table table-sm table-hover">
                                                <tr>
                                                    <td>Estimasi Selesai per-barang</td>
                                                    <td><?php echo $value['estimateddonepergoods'] ?> Minute(s)</td>
                                                </tr>
                                                <tr>
                                                    <td>Shift</td>
                                                    <td><?php if ($value['shift1']) {
                                                        ?>
                                                        <label class="badge bg-success">Shift 1</label>
                                                        <?php
                                                    } ?>
                                                    <?php if ($value['shift2']) {
                                                        ?>
                                                        <label class="badge bg-success">Shift 2</label>
                                                        <?php
                                                    } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Estimasi</td>
                                                    <td><?php echo $value['etapermachine'] ?></td>
                                                </tr>
                                            </table>
                                            <?php
                                        }

                                        ?>
                                    </ul>
                                </td>
                            </tr>
                            <tr><td>User Id</td><td><?php echo $dataprod['user_id']; ?></td></tr>
                            <tr><td>Status</td><td>
                                <select class="form-control approve_choice mb-15px" name="approve_status">
                                    <option value="approve" selected>Approve</option>
                                    <option value="reject">Reject</option>
                                </select>

                                <div class="reject-note-wrapper">
                                    
                                </div>
                            </td></tr>
                            <tr><td></td><td><button type="button" class="btn btn-info waiting-list-data"><i class="fas fa-undo"></i> Kembali</button> <button type="submit" action="approve" class="btn btn-success tombolsubmit">Update</button></td></tr>
                        </table>
                        <?php

                    }
                }

                ?>
        </form>        
    </div>
</div>

<script src="<?php echo base_url() ?>assets/assets/plugins/bootstrap-clockpicker/src/clockpicker.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                        
                    </div>
<script src="<?php echo base_url() ?>assets/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>

<script type="text/javascript">

    function checkApproveRequirement() {
        var owo = 0

        $('.approve-check').each(function() {
            if (!this.checked) {
                owo = 1
            }
        })

        if (owo == 1) {
            $('.input-group-button-action').html(`<button type="submit" class="btn btn-success btn-approve" action="approve" style="flex: 15%;">Approve</button>
                            <button style="flex: 15%;" type="submit" action="reject" class="btn btn-danger">Reject</button>
                            <button style="flex: 15%;" type="button" class="btn btn-info waiting-list-data">Kembali</button>`)
            $('.btn-approve').css('display','none')
            $('.reject-note-wrapper').html(`
                <textarea class="form-control" name="txtrejectreason" rows="3"></textarea>
                `)

        }

        if (owo == 0) {
            $('.btn-approve').css('display','block')
            $('.reject-note-wrapper').html(``)
        }
    }

    $('.approve-check').click(function() {
        checkApproveRequirement()
    })
</script>

<script type="text/javascript">

    $(document).ready(function() {

        $('.loading-material').remove()
        $('.list-material').css('display', 'block')

        $(".masked-input-date").mask("99:99");

        function deteksiMelebihiDueDate() {
            if ($('#rencana_selesai').val() > $('#due_date').val()) {
                $('.alertnya').html('<div class="alert alert-danger"><b>Rencana selesai melebihi due date.</b> Silahkan sesuaikan tanggal produksi agar tidak melebihi batas due date permintaan customer.</div>')
            } else {
                $('.alertnya').html('')
            }
        }

        function getMachine(machine_id) {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>orders/get_machine_data/" + machine_id,
                success: function(data){
                    $('.daftar_mesin').append(data)
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

        function enableDisableInputMachine(thisel) {
            if (thisel.parents('tr').hasClass('checked')) {
                thisel.parents('tr').find('td').eq(1).find('input').removeAttr('readonly')
                thisel.parents('tr').find('td').eq(3).find('input').removeAttr('readonly')
                thisel.parents('tr').find('td').eq(4).find('input').removeAttr('readonly')
                thisel.parents('tr').find('td').eq(5).find('input').removeAttr('readonly')
            } else {
                thisel.parents('tr').find('td').eq(1).find('input').attr('readonly','readonly')
                thisel.parents('tr').find('td').eq(3).find('input').attr('readonly','readonly')
                thisel.parents('tr').find('td').eq(4).find('input').attr('readonly','readonly')
                thisel.parents('tr').find('td').eq(5).find('input').attr('readonly','readonly')
            }
        }

        function refreshMachineList() {
            var start_date = $('#tanggal_produksi').val() + ' ' + $('.jam-awal').val() + ':00'
            var end_date = $('#rencana_selesai').val() + ' ' + $('.jam-akhir').val() + ':00'

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>orders/get_machine_list",
                data: {
                    ds: start_date,
                    de: end_date
                },
                success: function(data){
                    var dt = JSON.parse(data)

                    if ($('.available-machine').length <= 0) {
                        console.log('no machine available, generating...')

                        for (let i = 0; i < dt.length; i++) {
                            // $('.daftar_mesin').append('<div class="available-machine" id="' + dt[i] + '"><input type="checkbox" name="cb"/>' + dt[i] + '</div>')
                            getMachine(dt[i])
                        }
                    } else {
                        console.log('machine available, detecting...')

                        //buat array daftar available machine (termasuk yang sudah dicopot)

                        var arravailablemachinesaatini = []

                        $('.available-machine').each(function() {

                            var thisel = $(this)

                            var thisid = $(this).attr('id')

                            //jika element ini sudah tidak ada di dt, hapus ae
                            if (!dt.includes(thisid)) {
                                thisel.remove()
                            }

                            //dorong ke arrayavailablemachinesaatini
                            arravailablemachinesaatini.push(thisid)
                        })

                        //cari data mesin baru

                        // dt di filter arraynya untuk menampilkan arraiabilablemachinesaatini tidak ada di dt (shit, it's been a long time i'm not learning this)
                        var foundnew = dt.filter( ai => !arravailablemachinesaatini.includes(ai) );

                        console.log(arravailablemachinesaatini)
                        console.log(foundnew)

                        //jika ada data mesin baru dari server
                        if (foundnew) {
                            for (let i = 0; i < foundnew.length; i++) {
                                getMachine(foundnew[i])
                            }
                        } else {
                            $('.daftar_mesin').append('<tr><td colspan="6">No Machine Available</td></tr>')
                        }
                    }

                    // $('.daftar_mesin').html(dt.machinelist)
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

        function deteksiKetersediaanJadwal() {
            var start_date = $('#tanggal_produksi').val() + ' ' + $('.jam-awal').val() + ':00'
            var end_date = $('#rencana_selesai').val() + ' ' + $('.jam-akhir').val() + ':00'

            console.log(start_date + '/' + end_date)

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>orders/deteksi_ketersediaan_jadwal",
                data: {
                    ds: start_date,
                    de: end_date
                },
                success: function(data){
                    var dt = JSON.parse(data)
                    $('#available-schedule-wrapper').html(dt.smart_assist_message)
                    // alert(dt.message)
                    // $('.daftar_mesin').html(dt.machinelist)
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

        function sumthismachineETA(thisel) {
            var getrow = thisel
            var idmesin = getrow.attr('id')
            var minutesperproduction = getrow.find('td').eq(1).find('input').val()
            var productionpermachine = $('#qty_order').val()

            var o = 0

            if (productionpermachine > 0) {
                o = parseInt(minutesperproduction) * parseInt(productionpermachine)
            } else {
                o = parseInt(productionpermachine) * 1
            }

            console.log(o)

            getrow.find('td').eq(5).find('input').val(o)

            var duration = moment.duration(o, 'minutes');

            // var workhour = duration.hours()
            // if (detectedhours) {}
            
            var timeString = duration.days() + ':' + duration.hours() + ':' + duration.minutes() + ':' + duration.seconds()
            var eta = timeString
            getrow.find('td').eq(4).find('input').val(eta)

        }

        function sumETA() {

            var arrminutes = []
            var summinutes = 0;

            var sumproduction = $('#qty_order').val()

            var dateawal = moment($('#tanggal_produksi').val() + ' ' + $('.jam-awal').val(), 'YYYY-MM-DD HH:mm')

            var datetemp = moment($('#tanggal_produksi').val() + ' ' + $('.jam-awal').val(), 'YYYY-MM-DD HH:mm')

            $('.available-machine').each(function() {
                var thisel = $(this)

                if (thisel.hasClass('checked')) {
                    sumthismachineETA(thisel)
                    //kumpulin menit dulu terus jumlah

                    var getminutestotal = thisel.find('td').eq(5).find('input').val()

                    if (!getminutestotal) {
                        getminutestotal = 0
                    }

                    summinutes += parseInt(getminutestotal)
                    arrminutes.push(getminutestotal)

                    //umpulin produksi yang dihasilan dulu, terus jumlah

                } else {
                    arrminutes.push(0)
                }
            })

            // console.log(arrminutes)

            var tot = moment.duration(0);

            for (i = 0; i < arrminutes.length; i++) {                  
                var durasimasingmasingmesin = arrminutes[i].toString();

                // summinutes += parseInt(durasimasingmasingmesin)

                tot.add(durasimasingmasingmesin, 'minutes');
            }

            //set total durasi pengerjaan
            $('.predictiondone').val(tot.days() + ':' + tot.hours() + ':' + tot.minutes() + ':' + tot.seconds())

            //it really not useful at all but it may be lmao
            $('.totalminuteseverymachine').val(summinutes)

            //JIKA melebihi dari jumlah jam kerja shift 1 dan shift 2, tambah waktu durasinya hingga besok sampe jam masuk kerja (majuin 8 jem)

            // datetemp.add(summinutes, 'minutes')

            //8 jam ga ada kerja
            ////////////////////////ANUO
            // var test = summinutes - 900 //8 jam ga ada kerja
            // console.log(test)
            // if (test > 0) {
            //     datetemp.add(540, 'minutes')
            //     console.log('NEXT DAY!')
            // }

            // var dateakhir = datetemp

            const tanggal_awal = dateawal

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>orders/count_estimate_minutes",
                data: {
                    date_awal: moment(tanggal_awal).format('YYYY-MM-DD HH:mm'),
                    add_minutes: summinutes
                },
                success: function(data){

                    var dt = JSON.parse(data)
                    console.log(dt.target_selesai)
                    $('#rencana_selesai').val(moment(dt.target_selesai).format('YYYY-MM-DD'))
                    $('.jam-akhir').val(moment(dt.target_selesai).format('HH:mm'))
                }
            })
        }


        function checkdisablecreateproductionbutton() {
            if ($('.available-machine').length > 0 ){
                $('.btn-create-produksi').removeAttr('disabled').removeClass('disabled');
            } else {
                $('.btn-create-produksi').attr('disabled',true).addClass('disabled');
            }
        }

        $('.daftar_mesin').on('input','.troughputperproduct',function() {
            
            var thisel = $(this)

            if (thisel.parents('tr').hasClass('checked')) {
                var throughtputvalue = thisel.parents('tr').find('td').eq(1).find('input').val()
                if (throughtputvalue > 0 || throughtputvalue) {
                    $('.approve-check#kalkulasi').prop('checked',true)
                } else {
                    $('.approve-check#kalkulasi').prop('checked',false)
                }
                checkApproveRequirement()
                sumETA()
                deteksiMelebihiDueDate()

            }
        })

        $('.daftar_mesin').on('change','.checkboxmachine', function() {
            
            var thisel = $(this)

            if (this.checked) {
                thisel.parents('tr').addClass('checked')
            } else {
                thisel.parents('tr').removeClass('checked')
                thisel.parents('tr').find('td').eq(1).find('input').val(0)
                thisel.parents('tr').find('td').eq(3).find('input').val(0)
                thisel.parents('tr').find('td').eq(4).find('input').val('')
                thisel.parents('tr').find('td').eq(5).find('input').val(0)
                $('.approve-check#kalkulasi').prop('checked',false)
                checkApproveRequirement()
            }
            sumETA()
            enableDisableInputMachine(thisel)
        })

        $('#tanggal_produksi').on('change', function() {
            sumETA()
            deteksiKetersediaanJadwal()
            refreshMachineList()
            setTimeout(function() {
                sumETA()
                checkdisablecreateproductionbutton()
                deteksiMelebihiDueDate()
            },500)
        })

        $(document).on('click','.btn-reject', function() {
            $('.reject-note-wrapper').html(`
                <textarea class="form-control" name="txtrejectreason" rows="3"></textarea>
                `)
            $('.input-group-button-action').html(`
                <button style="flex: 50%;" type="submit" class="btn btn-success save-waiting-data-approve" id="<?php echo encrypt_url($order_id) ?>" action="reject"><i class="fas fa-times"></i> Reject</button> 
                <button style="flex: 50%;" type="button" class="btn btn-info btn-batal-reject"><i class="fas fa-undo"></i> Batal</button>
                `)
        })

        $(document).on('click','.btn-batal-reject', function() {
            $('.reject-note-wrapper').html(``)
            $('.input-group-button-action').html(`<button type="submit" class="btn btn-success btn-approve" action="approve" style="flex: 15%;">Approve</button>
                            <button style="flex: 15%;" type="button" class="btn btn-danger btn-reject">Reject</button>
                            <button style="flex: 15%;" type="button" class="btn btn-info waiting-list-data">Kembali</button>`)
        })

        $('.input-group-kdorder').on('click','.btn-next',function() {
            $('.formnya').css('display','unset')
            $('.input-group-kdorder').remove()
            $('#kode_order').addClass('readonly').attr('readonly','readonly')
        })

        $('.clockpicker').clockpicker({
            autoclose: true,
            afterDone: function() {
                sumETA()
                deteksiKetersediaanJadwal()
                refreshMachineList()
                setTimeout(function() {
                    sumETA()
                    checkdisablecreateproductionbutton()
                    deteksiMelebihiDueDate()
                },500)
            }
        })

        $('.approve_choice').change(function() {

            var thisval = $(this).val()

            $('.reject-note-wrapper').html(``)
            if (thisval == 'reject') {
                $('.reject-note-wrapper').html(`
                    <textarea class="form-control" name="txtrejectreason" rows="3" placeholder="Masukan reject reason"></textarea>
                `)
            }

            $('.tombolsubmit').attr('action',thisval)
        })
        <?php 

        if ($machine_list) {
            foreach ($machine_list as $key => $value) {
                ?>

                $('.daftar_mesin').on('change','.checkboxshiftformachine<?php echo $value->mesin_id ?>', function() {
                    var thisel = $(this)

                    if (this.checked) {
                        thisel.val(1)
                    } else {
                        thisel.val(0)
                    }
                    sumETA()
                })

                <?php
            }
        }

        ?>
    })
</script>