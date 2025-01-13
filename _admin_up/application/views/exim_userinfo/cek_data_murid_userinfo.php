<div class="box">
    <div class="box-header">

    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama</td>
                    <td>Kelas</td>
                    <td>Userid</td>
                    <td>Badgenumber</td>
                    <td>SN</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->name; ?></td>
                        <td><?php echo $dt->nama_kelas; ?></td>
                        <td><?php echo $dt->userid; ?></td>
                        <td><?php echo $dt->badgenumber; ?></td>
                        <td><?php echo $dt->sn; ?></td>
                    </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>