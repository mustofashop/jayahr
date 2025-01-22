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
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" href="#menu1">Kriteria Penilaian</a></li>
                    <li><a data-toggle="tab" href="#menu2">Contoh</a></li>
                    <li><a data-toggle="tab" href="#menu3">Form</a></li>
                </ul>
                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_1_2/kriteria_penilaian.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_1_2/Contoh.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kriteria</th>
                                    <th>Bobot</th>
                                    <th>Pilihan Jawaban</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $data = $this->master_model->get_penilaian_1_2();
                                foreach ($data->result() as $dt) {
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $dt->nama_value; ?></td>
                                        <td><?php echo $dt->bobot; ?>%</td>
                                        <td>
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="A"> A</label>
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="B"> B</label>
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="C"> C</label>
                                            <label><input type="radio" name="isi_nilai_kel_1_2[<?php echo $dt->id_nilai_pkk; ?>]" value="D"> D</label>
                                            <input type="hidden" name="id_nilai_pkk[]" value="<?php echo $dt->id_nilai_pkk; ?>">
                                            <input type="hidden" name="id_periode" value="<?php echo $id_periode; ?>">
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
                            <textarea name="text_tambahan" id="text_tambahan" class="form-control" rows="3"></textarea>
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