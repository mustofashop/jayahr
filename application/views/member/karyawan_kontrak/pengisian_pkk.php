<div class="box">
    <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>Trans_pkk/download_set_pkk/">
        <i class="fa fa-download"></i>
        Excel
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
                        $data = $this->master_model->list_isi_pkk();
                        if ($data->num_rows() > 0) {
                            foreach ($data->result() as $dt) {
                                $cek_flag_sent = $this->master_model->get_fb_karyawan($dt->nrp, $dt->id_p_periode);
                                $submit_kel_1_2 = $this->master_model->get_submit_1_2($dt->nrp, $dt->id_p_periode, $dt->insert_by);
                                $submit_kel_3_7 = $this->master_model->get_submit_3_7($dt->nrp, $dt->id_p_periode, $dt->insert_by);
                        ?>
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
                                        <?php
                                        $spv1_submit = ($dt->flag_jenis_form == 1) ?
                                            $this->master_model->get_submit_1_2($dt->nrp, $dt->id_p_periode, $dt->spv1) :
                                            $this->master_model->get_submit_3_7($dt->nrp, $dt->id_p_periode, $dt->spv1);

                                        if (!empty($spv1_submit) && isset($spv1_submit->flag_sent) && $spv1_submit->flag_sent == 1) { ?>
                                            <i class="fa fa-check text-success"></i> <!-- SPV1 sudah mengisi -->
                                        <?php } else { ?>
                                            <i class="fa fa-times text-danger"></i> <!-- SPV1 belum mengisi -->
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <!-- Kolom SPV2 -->
                                        <?php
                                        $spv2_submit = ($dt->flag_jenis_form == 1) ?
                                            $this->master_model->get_submit_1_2($dt->nrp, $dt->id_p_periode, $dt->spv2) :
                                            $this->master_model->get_submit_3_7($dt->nrp, $dt->id_p_periode, $dt->spv2);

                                        if (!empty($spv2_submit) && isset($spv2_submit->flag_sent) && $spv2_submit->flag_sent == 1) { ?>
                                            <i class="fa fa-check text-success"></i> <!-- SPV2 sudah mengisi -->
                                        <?php } else { ?>
                                            <i class="fa fa-times text-danger"></i> <!-- SPV2 belum mengisi -->
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php
                                        if (!empty($cek_flag_sent) && isset($cek_flag_sent->flag_sent) && $cek_flag_sent->flag_sent == 1) { ?>
                                            <i class="fa fa-check text-success"> Setuju</i> <!-- Tampilkan ceklis hijau jika flag_sent == 1 -->
                                        <?php } else { ?>
                                            <i class="fa fa-times text-danger"></i> <!-- Tampilkan silang merah jika flag_sent kosong atau bukan 1 -->
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3" style="text-align: center;">Tidak ada data tersedia</td>
                            </tr>
                        <?php

                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>