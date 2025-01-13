<div class="box">
    <div class="box-body">
        <table id="isi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Userid</th>
                    <th>Badgenumber</th>
                    <th>Nama</th>
                    <th>Kartu</th>
                    <th>Sn</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    foreach ($data->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $dt->userid; ?></td>
                    <td><?php echo $dt->badgenumber; ?></td>
                    <td><?php echo $dt->name; ?></td>
                    <td><?php echo $dt->card; ?></td>
                    <td><?php echo $dt->sn;?></td>
                    <td><?php echo $dt->utime;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>