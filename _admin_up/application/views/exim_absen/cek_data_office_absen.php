<div class="box">
    <div class="box-header">

    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Checktime</th>
                    <th>Checktype</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama_lengkap; ?></td>
                        <td><?php echo $dt->checktime; ?></td>
                        <td><?php echo $dt->checktype; ?></td>
                    </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>