<?php if ($this->session->flashdata('msg')) : ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('msg_error')) : ?>
    <div class="alert alert-danger alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
<style>
    .nav-tabs-custom {
        background-color: #1b2a47;
        padding: 10px;
        border-radius: 5px;
    }

    .nav-tabs-custom .nav-pills {
        margin: 0;
        padding: 0;
    }

    .nav-tabs-custom .nav-pills li {
        display: inline-block;
        margin-right: 5px;
    }

    .nav-tabs-custom .nav-pills li a {
        border: 1px solid #ccc;
        border-radius: 5px;
        color: #ffffff;
        background-color: #1b2a47;
        padding: 8px 15px;
        text-decoration: none;
    }

    .nav-tabs-custom .nav-pills li.active a {
        background-color: #17a2b8;
        color: white;
        border: 1px solid #17a2b8;
    }
</style>

<body>
    <div class="box">
        <form role="form" method="POST" action="<?php echo base_url(); ?>Trans_pkk/simpan_nilai_1_2" enctype="multipart/form-data">
            <div class="box-header">
                <button class="btn btn-app" title="Kembali" onclick="history.back(); return false;">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </button>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-pills">
                        <li class="active"><a data-toggle="tab" href="#menu1">Kriteria Penilaian</a></li>
                        <li><a data-toggle="tab" href="#menu2">Contoh</a></li>
                        <li><a data-toggle="tab" href="#menu3">Form</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_1_2/kriteria_penilaian.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_1_2/Contoh.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <table class="table table-bordered" style="border: 1px solid black;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid black;">No</th>
                                    <th style="border: 1px solid black;">Kriteria</th>
                                    <th style="border: 1px solid black;">Bobot</th>
                                    <th style="border: 1px solid black;">Pilihan Jawaban</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $data = $this->master_model->get_penilaian_1_2();
                                foreach ($data->result() as $dt) {
                                    // Cek apakah ada nilai sebelumnya
                                    $nilai_saat_ini = isset($nilai_terisi[$dt->id_nilai_pkk]) ? $nilai_terisi[$dt->id_nilai_pkk] : '';
                                ?>
                                    <tr style="border: 1px solid black;">
                                        <td style="border: 1px solid black; padding: 5px;"><?php echo $no; ?></td>
                                        <td style="border: 1px solid black; padding: 5px;"><?php echo $dt->nama_value; ?></td>
                                        <td style="border: 1px solid black; padding: 5px;"><?php echo $dt->bobot; ?>%</td>
                                        <td style="border: 1px solid black; padding: 5px;">
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="A" <?php echo ($nilai_saat_ini == 'A') ? 'checked' : ''; ?>> A</label>
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="B" <?php echo ($nilai_saat_ini == 'B') ? 'checked' : ''; ?>> B</label>
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="C" <?php echo ($nilai_saat_ini == 'C') ? 'checked' : ''; ?>> C</label>
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="D" <?php echo ($nilai_saat_ini == 'D') ? 'checked' : ''; ?>> D</label>

                                            <input type="hidden" name="id_nilai_pkk[]" value="<?php echo $dt->id_nilai_pkk; ?>">
                                            <input type="hidden" name="bobot[<?php echo $dt->id_nilai_pkk; ?>]" value="<?php echo $dt->bobot; ?>">
                                            <input type="hidden" name="isi_nilai_a[<?php echo $dt->id_nilai_pkk; ?>]" value="<?php echo $dt->nilai_a; ?>">
                                            <input type="hidden" name="isi_nilai_b[<?php echo $dt->id_nilai_pkk; ?>]" value="<?php echo $dt->nilai_b; ?>">
                                            <input type="hidden" name="isi_nilai_c[<?php echo $dt->id_nilai_pkk; ?>]" value="<?php echo $dt->nilai_c; ?>">
                                            <input type="hidden" name="isi_nilai_d[<?php echo $dt->id_nilai_pkk; ?>]" value="<?php echo $dt->nilai_d; ?>">
                                            <input type="hidden" name="id_periode" value="<?php echo $id_periode; ?>">
                                            <input type="hidden" name="id_p_periode" value="<?php echo $id_p_periode; ?>">
                                            <input type="hidden" name="flag_jenis_form" value="<?php echo $flag_jenis_form; ?>">
                                            <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">
                                        </td>
                                    </tr>

                                <?php $no++;
                                } ?>
                            </tbody>

                        </table>
                        <div class="form-group">
                            <label for="aspek_tambahan">Aspek Tambahan (Mohon diuraikan, bila ada):</label>
                            <textarea name="text_tambahan" id="text_tambahan" class="form-control" rows="3" placeholder="Berlaku Untuk SPV1 & SPV2"><?php echo isset($text_tambahan) ? htmlspecialchars($text_tambahan) : ''; ?></textarea>
                        </div>
                        <div class="form-group text-right" style="margin-top: 20px;">
                            <button type="submit" class="btn bg-green btn-success btn-flat-margin">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>