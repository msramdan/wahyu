<?php
    if ($listofready) {
        foreach ($listofready as $key => $value) {
            ?>
            <div class="card border-0 mb-2 <?php if($value->DIFF <= 10){ echo 'recommended'; } ?>" style="text-align: left;">
                <div class="card-body">
                    <div class="input-group">
                        <input id="clipboard-default<?php echo $value->id ?>" type="text" class="form-control-plaintext" readonly value="<?php echo $value->id ?>" style="font-size: 1rem;flex: 1 0;" />    
                        <button class="btn btn-inverse" type="button" data-toggle="clipboard" data-clipboard-target="#clipboard-default<?php echo $value->id ?>"><i class="fa fa-clipboard"></i></button>
                    </div>
                    <p class="card-text">Target <?php echo $value->total_barang_jadi ?> pcs yang direncanakan selesai <b><?php echo $value->rencana_selesai ?></b> (<?php echo $value->DIFF ?> Hari done).</p>
                </div>
                <div class="card-footer fw-bold">
                    <i style="font-size: 0.6rem;color: gray;">Start at <?php echo $value->tanggal_produksi ?></i>
                    <div style="float: right;">
                        <label class="badge bg-danger">Ready</label>
                        <?php if($value->DIFF <= 10){ ?> <label class="badge bg-warning">Recommended</label> <?php } ?>
                    </div>
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
            <p>Belum ada jadwal produksi</p>
        </div>
        <?php
    }

?>