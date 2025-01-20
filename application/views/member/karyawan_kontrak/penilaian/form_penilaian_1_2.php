<body>
    <div class="box">
        <form role="form" method="POST" action="<?php echo base_url(); ?>data_karyawan/simpan_karyawan" enctype="multipart/form-data">
            <div class="box-header">
<<<<<<< HEAD
=======
                <button class="btn btn-app" type="submit">
                    <i class="fa fa-floppy-o"></i>
                    Simpan
                </button>
                <button class="btn btn-app" title="Kembali" onclick="history.back(); return false;">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </button>
>>>>>>> 6228405ea5fec46d2a4093a15ebd55ef21fd45a5
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
                                $no = '1';
                                $data = $this->master_model->get_penilaian_1_2();
                                foreach ($data->result() as $dt) { ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $dt->nama_value; ?></td>
                                        <td><?php echo $dt->bobot; ?></td>
                                        <td>
                                            <label><input type="radio" name="id_nilai_pkk[<?php echo $dt->id_nilai_pkk; ?>]" value="A"> A</label>
                                            <label><input type="radio" name="id_nilai_pkk[<?php echo $dt->id_nilai_pkk; ?>]" value="B"> B</label>
                                            <label><input type="radio" name="id_nilai_pkk[<?php echo $dt->id_nilai_pkk; ?>]" value="C"> C</label>
                                            <label><input type="radio" name="id_nilai_pkk[<?php echo $dt->id_nilai_pkk; ?>]" value="D"> D</label>
                                        </td>
                                    </tr>
                                <?php $no++;
                                } ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label for="aspek_tambahan">Aspek Tambahan (Mohon diuraikan, bila ada):</label>
                            <textarea name="aspek_tambahan" id="aspek_tambahan" class="form-control" rows="3"></textarea>
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

</html>