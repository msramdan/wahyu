<audio id="audio" style="display: none;" controls allow="autoplay"><source src="<?= base_url() ?>assets/assets/audio/popup.ogg" type="audio/mpeg"></audio>

<link href="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/common/main.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/daygrid/main.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/timegrid/main.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/list/main.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/bootstrap/main.min.css" rel="stylesheet" />

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
  <h1 class="page-header">Halaman Dashboard</h1>
  <div class="container">
    <div class="row">
      <div class="col-6">
        <div class="accordion" id="accordion-machine">
          <div class="accordion-item border-0">
            <div class="accordion-header" id="headingOne">
              <button class="accordion-button bg-gray-900 text-white px-3 py-10px pointer-cursor" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-machine">
                <i class="fa fa-circle fa-fw text-blue me-2 fs-8px"></i> Machine Used
              </button>
            </div>
            <div id="collapse-machine" class="accordion-collapse collapse show" data-bs-parent="#accordion-machine">
              <div class="accordion-body bg-gray-800 text-white schedule-wrapper">
                <div class="row">
                  <div class="col-lg">
                    <!-- select -->
                    <select class="form-select select-machine" id="select-machine">
                      <option>- Pilih Mesin -</option>
                      <?php 
                        foreach ($machine_list as $key => $value) {
                          ?>
                            <option value="<?= $value->kd_mesin ?>"><?= $value->nama_mesin ?></option>
                          <?php
                        }
                      ?>
                    </select>
                    <div id="infowrapper" class="text-white" style="margin-top: 3vh;">
                      <div class="info" style="display: flex;
                      flex-direction: column;
                      text-align: center;
                      height: 50vh;
                      justify-content: center;">
                          <div class="icon"><i class="fa fa-list" style="font-size: 65px"></i></div>
                          <h3 class="title mt-3" style="color: #9d9d9d; font-size: 12px;">Data Produksi sedang berjalan pada mesin yang dipilih akan muncul disini</h3>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="accordion" id="accordion-calendar">
          <div class="accordion-item border-0">
            <div class="accordion-header" id="headingOne">
              <button class="accordion-button bg-gray-900 text-white px-3 py-10px pointer-cursor" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-calendar">
                <i class="fa fa-circle fa-fw text-blue me-2 fs-8px"></i> Work Calendar
              </button>
            </div>
            <div id="collapse-calendar" class="accordion-collapse collapse show" data-bs-parent="#accordion-calendar">
              <div class="accordion-body bg-gray-800 text-white schedule-wrapper">
                <div class="row">
                  <div class="col-lg">
                    <div id="calendar" class="calendar"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_detail">
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
        <button class="btn btn-white close-moddal">Close</button>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url() ?>assets/assets/plugins/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/core/main.global.js"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/daygrid/main.global.js"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/timegrid/main.global.js"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/interaction/main.global.js"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/list/main.global.js"></script>
<script src="<?php echo base_url() ?>assets/assets/plugins/@fullcalendar/bootstrap/main.global.js"></script>

<script src="<?php echo base_url() ?>assets/assets/plugins/clipboard/dist/clipboard.min.js"></script>

<script type="text/javascript">

const fetchListofProductionUsedOnThisMachine = () => {
  const kd_mesin = $('#select-machine').val()
  $.ajax({
      type : "GET",
      url  : "<?php echo base_url() ?>produksi/get_productions_by_machine/" + kd_mesin,
      success: function(data){
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

$('.close-moddal').click(function() {
  $(".modal").modal("hide")
  $('.modal-title').text('...')
  $('.modal-body').html('')
})

$(document).on('click','.detail-produksi', function() {
  const id = $(this).attr('id')
  $('#modal_detail').modal('toggle');
  $.ajax({
    type: "GET",
    url: "<?php echo base_url() ?>dashboard/getdetailschedule/" + id,
    success: function(data){
      var dt = JSON.parse(data)
      $('.modal-title').text(dt.id)
      var string = `
        <table class="table table-bordered table-td-valign-middle text-dark">
          <tr>
            <td>Order</td>
            <td>:</td>
            <td>${dt.kd_order}</td>
          </tr>
          <tr>
            <td>Mulai Produksi</td>
            <td>:</td>
            <td>${dt.tanggal_produksi}</td>
          </tr>
          <tr>
            <td>Target Selesai</td>
            <td>:</td>
            <td>${dt.rencana_selesai}</td>
          </tr>
          <tr>
            <td>Total Barang Jadi</td>
            <td>:</td>
            <td>${dt.total_barang_jadi}</td>
          </tr>
          <tr>
            <td>Prioritas</td>
            <td>:</td>
            <td>${dt.priority}</td>
          </tr>
          <tr>
            <td>Status</td>
            <td>:</td>
            <td>${dt.status}</td>
          </tr>
          <tr>
            <td>Mesin Digunakan</td>
            <td>:</td>
            <td>
              <ul>
                ${dt.machine_use}
              </ul>
            </td>
          </tr>
        </table>
        `;

        $('.modal-body').html(string)
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

$('#select-machine').on('change', function() {
  fetchListofProductionUsedOnThisMachine()
})

var handleCalendarDemo=function(){

  var d = new Date();
  var month = d.getMonth() + 1;
  month = ( month < 10) ? '0' + month : month;
  var year = d.getFullYear();
  var day = d.getDate();
  var today = moment().startOf('day');
  var calendarElm = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarElm,{
    headerToolbar:{
      left:'dayGridMonth,timeGridWeek,timeGridDay',
      center:'title',
      right:'prev,next today'
    },
    buttonText:{
      today:'Today',
      month:'Month',
      week:'Week',
      day:'Day'
    },
    initialView : 'dayGridMonth',
    editable : false,
    droppable : false,
    themeSystem : 'bootstrap',
    views : {
      timeGrid:{
        eventLimit:6
      }
    },
    events:[
      <?php $classnyak->getallschedule() ?>
    ],
    eventClick: function(info) {
      info.jsEvent.preventDefault(); // don't let the browser navigate
      $('#modal_detail').modal('toggle');
      $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>dashboard/getdetailschedule/" + info.event.title,
        success: function(data){
          var dt = JSON.parse(data)
          $('.modal-title').text(dt.id)
          var string = `
            <table class="table table-bordered table-td-valign-middle text-dark">
              <tr>
                <td>Order</td>
                <td>:</td>
                <td>${dt.kd_order}</td>
              </tr>
              <tr>
                <td>Mulai Produksi</td>
                <td>:</td>
                <td>${dt.tanggal_produksi}</td>
              </tr>
              <tr>
                <td>Target Selesai</td>
                <td>:</td>
                <td>${dt.rencana_selesai}</td>
              </tr>
              <tr>
                <td>Total Barang Jadi</td>
                <td>:</td>
                <td>${dt.total_barang_jadi}</td>
              </tr>
              <tr>
                <td>Prioritas</td>
                <td>:</td>
                <td>${dt.priority}</td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td>${dt.status}</td>
              </tr>
              <tr>
                <td>Mesin Digunakan</td>
                <td>:</td>
                <td>
                  <ul>
                    ${dt.machine_use}
                  </ul>
                </td>
              </tr>
            </table>
            `;

            $('.modal-body').html(string)
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
  });
  calendar.render();
};

var Calendar=function(){
  "use strict";
  return{
    init:function(){
      handleCalendarDemo();
    }
  };
}();


$(document).ready(function(){
  Calendar.init();
})
</script>