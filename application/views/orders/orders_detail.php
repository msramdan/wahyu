<table class="table table-bordered table-td-valign-middle text-gray-900">
    <tr><td>Nama Pemesan</td><td><?php echo $nama_pemesan; ?></td></tr>
    <tr><td>Bagian</td><td><?php echo $classnyak->getbagiandata($bagian)->nama_bagian; ?></td></tr>
    <tr><td>No. Kontak</td><td><?php echo $no_kontak; ?></td></tr>

    <tr><td>Nama Barang</td><td><?php echo $nama_barang; ?></td></tr>
    <tr><td>Quantity</td><td><?php echo $qty; ?></td></tr>
    <tr><td>Due Date</td><td><?php echo $due_date; ?></td></tr>
    <tr><td>Note</td><td><?php echo $note; ?></td></tr>
    <tr><td>Priority</td><td><?php 

    $op = $priority;
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
    <tr><td>Keterangan</td><td><?php 
    if ($keterangan == 1) {
        echo 'Part Baru';
    }

    if ($keterangan == 2) {
        echo 'Repair';
    }

    if ($keterangan == 3) {
        echo 'Modifikasi';
    }
     ?></td></tr>

    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
</table>