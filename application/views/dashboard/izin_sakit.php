<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>dashboard">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <a class="btn btn-app" href="<?php echo base_url() ?>dashboard/list_izin_sakit/<?php echo $id_lokasi ?>">
            <i class="fa fa-refresh"></i>
            Refresh
        </a>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Karyawan</th>
                    <th>Jenis Izin</th>
                    <th>Tanggal Mulai Izin</th>
                    <th>Tanggal Selesai Izin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    $data   = $this->dashboard_model->list_izin($id_lokasi);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nip; ?></td>
                        <td><?php echo $dt->nama_lengkap; ?></td>
                        <td><?php echo $dt->jenis_izin; ?></td>
                        <td><?php echo $dt->izin_tgl_awal; ?></td>
                        <td><?php echo $dt->izin_tgl_akhir; ?></td>
                    </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>