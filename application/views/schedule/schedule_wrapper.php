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

    <div class="accordion" id="accordion-calendar">
      <div class="accordion-item border-0">
        <div class="accordion-header" id="headingOne">
          <button class="accordion-button bg-gray-900 text-white px-3 py-10px pointer-cursor" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-calendar">
            <i class="fa fa-circle fa-fw text-blue me-2 fs-8px"></i> Schedule
          </button>
        </div>
        <div id="collapse-calendar" class="accordion-collapse collapse show" data-bs-parent="#accordion-calendar">
          <div class="accordion-body bg-gray-800 text-white schedule-wrapper">
            <div class="row">
              <div class="d-none d-lg-block" style="width: 255px">

                <div class="panel panel-inverse">
                  <div class="panel-heading">
                    <h4 class="panel-title">Smart Assist</h4>
                        <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        </div>
                    <div class="panel-body">
                        <div class="row">
                          <div class="col-4" style="text-align: center;"><i class="fab fa-github-alt fa-4x"></i></div>
                          <div class="col-8">
                            <h4 id="smart_assist_title" style="font-weight: bold;"><?php echo 'Selamat ' . $salam; ?></h4>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div id="smart_assist_message">klik pada salah satu jadwal yang ada pada kalendar untuk menampilkan informasi produksi.</div>
                            <div id="smart_assist_recommendation">
                                
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

              </div>
              <div class="col-lg">
                <div id="calendar" class="calendar"></div>
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

$('.close-moddal').click(function() {
  $(".modal").modal("hide")
  $('.modal-title').text('...')
  $('.modal-body').html('')
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
        url: "<?php echo base_url() ?>schedule/getdetailschedule/" + info.event.title,
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