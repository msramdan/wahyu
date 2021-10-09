<?php
    
    $randcolor = array('bg-danger','bg-warning','bg-yellow','bg-lime','bg-green','bg-success','bg-primary','bg-info','bg-purple','bg-indigo','bg-dark','bg-pink','bg-secondary','bg-default','bg-light');

    if ($listofongoing) {
        foreach ($listofongoing as $key => $value) {
            ?>
            <div class="card border-0 mb-2" style="text-align: left;">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $value->id ?></h4>
                    <p class="card-text">Target <?php echo $value->total_barang_jadi ?> pcs yang direncanakan selesai <b><?php echo $value->rencana_selesai ?></b> (<?php echo $value->DIFF ?> Hari done).</p>
                </div>
                <div class="card-footer fw-bold">
                    <i style="font-size: 0.6rem;color: gray;"><?php 
                    $cekapakahmegangmesin = $classnyak->cekkodeproduksipadamesin($value->id);

                    $a = null;

                    $date1 = new DateTime(date('Y-m-d'));
                    $date2 = new DateTime(date('Y-m-d',strtotime($value->rencana_selesai)));
                    

                    if ($a < 0) {
                        
                        echo $date2->diff($date1)->format('%a'); ?> Day(s) late
                        <?php

                    } else {
                        echo $date2->diff($date1)->format('%a');
                        ?>
                         Day(s) remaining
                        <?php
                    }
                    if ($cekapakahmegangmesin) {
                        $a = $classnyak->getdataoperator($cekapakahmegangmesin->operator)->nama_karyawan;
                        if ($cekapakahmegangmesin->status == 'PAUSED') {
                             ?>
                             <span class="badge bg-warning">break</span>
                             <?php
                         }
                    }

                     ?></i><?php
                     if ($value->status_produksi == 'FINISHING') {
                         ?>
                         <span class="badge bg-purple">finishing</span>
                         <?php
                     }
                     if ($value->status_produksi == 'READY FINISHING') {
                         ?>
                         <span class="badge bg-primary">ready finishing</span>
                         <?php
                     }

                     if ($a) {
                         ?>
                         <span class="badge <?php echo $randcolor[array_rand($randcolor, 1)] ?>" style="transform: scale(1.4);
                            float: right;
                            border-radius: 50%;
                            height: 18px;
                            width: 18px;"><?php echo $a[0] ?></span>
                         <?php
                     }

                     ?>

                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div style="width: 100%; height: 200px; text-align: center; padding: 40px 0;">
            <div style="margin: 14px;">
                <i class="fas fa-thumbs-up fa-3x" style="color: gray;"></i>
            </div>
            <p>Belum ada produksi yang berjalan</p>
        </div>
        <?php
    }

?>