<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>dashboard">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>No. HP Karyawan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $id_p   = $this->session->userdata('id_perusahaan');
                    $no     = 1;
                    $data_1 = $this->dashboard_model->list_karyawan($id_p,$id_lokasi);
                    foreach($data_1->result() as $dt1){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt1->nip; ?></td>
                        <td><?php echo $dt1->nama_lengkap; ?></td>
                        <td><?php echo $dt1->no_telepon; ?></td>
                        <td>
                            <!-- lihat -->
                            <?php if($aksi2 == '2'){ ?>
                                <a class="btn btn-flat bg-blue" href="<?php echo base_url(); ?>dashboard/detail_karyawan/<?php echo $dt1->id_karyawan; ?>/<?php echo $id_lokasi; ?>" title="Lihat <?php echo $dt1->nama_lengkap; ?>">
                                    <i class="fa fa-search"></i>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>