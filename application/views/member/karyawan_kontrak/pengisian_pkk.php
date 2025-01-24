<div class="box">
    <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>Pengaturan_pkk/download_data_pkk/">
        <i class="fa fa-download"></i>
        Download data
    </a>
    <div class="box-body">
        <!-- custom tab -->
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td rowspan="2">No</td>
                            <td rowspan="2">NRP</td>
                            <td rowspan="2">Nama Karyawan</td>
                            <td rowspan="2">Penilaian Ke</td>
                            <td rowspan="2">Submit</td>
                            <td colspan="3" class="text-center">Ceklis</td>
                        </tr>
                        <tr>
                            <td>SPV 1</td>
                            <td>SPV 2</td>
                            <td>Karyawan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = 1;
                        $data = $this->master_model->list_isi_pkk($atasan);
                        if ($data->num_rows() > 0) {
                            foreach ($data->result() as $dt) { ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $dt->nrp; ?></td>
                                    <td><?php echo $dt->nama_lengkap; ?></td>
                                    <?php if ($dt->flag_penilaian == 1) { ?>
                                        <td>1</td>
                                    <?php } elseif ($dt->flag_penilaian == 2) { ?>
                                        <td>2</td>
                                    <?php } elseif ($dt->flag_penilaian == 3) { ?>
                                        <td>3</td>
                                    <?php } ?>

                                    <td>
                                        <?php if ($dt->flag_sent == 1) { ?>
                                            <i class="fa fa-check text-success"></i> <!-- SPV1 sudah mengisi -->
                                        <?php } else { ?>
                                        <?php } ?>
                                    </td>
                                    <!-- Checkbox otomatis dicentang berdasarkan nilai dari database -->
                                    <td>
                                        <!-- Kolom SPV1 -->
                                        <?php if ($dt->spv1  && $dt->flag_sent == 1) { ?>
                                            <i class="fa fa-check text-success"></i> <!-- SPV1 sudah mengisi -->
                                        <?php } else { ?>
                                            <i class="fa fa-times text-danger"></i> <!-- SPV1 belum mengisi -->
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <!-- Kolom SPV2 -->
                                        <?php if ($dt->spv2  && $dt->flag_sent == 1) { ?>
                                            <i class="fa fa-check text-success"></i> <!-- SPV2 sudah mengisi -->
                                        <?php } else { ?>
                                            <i class="fa fa-times text-danger"></i> <!-- SPV2 belum mengisi -->
                                        <?php } ?>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3" style="text-align: center;">Tidak ada data tersedia</td>
                            </tr>
                        <?php
                            $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>