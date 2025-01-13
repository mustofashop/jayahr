<div class="box">
    <div class="box-header">

    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Userid</td>
                    <td>Nama</td>
                    <td>Tanggal</td>
                    <td>Masuk</td>
                    <td>Keluar</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->userid; ?></td>
                        <td><?php echo $dt->nama_karyawan; ?></td>
                        <td><?php echo $dt->tgl; ?></td>
                        <td><?php echo $dt->masuk; ?></td>
                        <td><?php echo $dt->keluar; ?></td>
                        <td><?php echo $dt->status; ?></td>
                    </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>