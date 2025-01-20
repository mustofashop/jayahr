<body>
    <div class="box">
        <form role="form" method="POST" action="<?php echo base_url(); ?>data_karyawan/simpan_karyawan" enctype="multipart/form-data">
            <div class="box-header">
            </div>
            <div class="box-body">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" href="#menu1">Kriteria Penilaian</a></li>
                    <li><a data-toggle="tab" href="#menu2">Contoh</a></li>
                    <li><a data-toggle="tab" href="#menu3">Form A</a></li>
                    <li><a data-toggle="tab" href="#menu4">Form B</a></li>
                    <li><a data-toggle="tab" href="#menu5">Form Penilaian</a></li>
                    <li><a data-toggle="tab" href="#menu6">Feedback Karyawan</a></li>
                </ul>
                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_3_7/Penilaian_ 3_7.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_3_7/Contoh_Penilaian_3_7.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <h4><b>II. Penilaian Kinerja Karyawan</b></h4>
                        <table border="1" style="width: 100%; text-align: center;">
                            <tr>
                                <th colspan="4">A. KINERJA (Didasarkan Sasaran Pekerjaan)</th>
                            </tr>
                            <?php
                            $row1 = $menu3->row(0); // Mengambil baris pertama (index 0)
                            $row2 = $menu3->row(1); // Mengambil baris kedua (index 1)
                            ?>
                            <tr>
                                <th> 1. <?php echo $row2->nama_value; ?></th>
                                <th style="text-align: center;">KESIMPULAN HASIL</th>
                                <th style="text-align: center;">%</th>
                                <th style="text-align: center;">KESIMPULAN DEVIASI</th>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    <br>
                                    <span style="margin-left: 10px;">a. <?php echo $row2->description; ?></span>
                                    <br>
                                    (hasil bisa dilihat dari kualitas keakuratan, dll)
                                </td>
                                <td><textarea name="hasil_kualitatif" style="width: 100%; height: 100px;"></textarea></td>
                                <td><input type="text" name="persen_kualitatif" style="width: 100%;"></td>
                                <td><textarea name="deviasi_kualitatif" style="width: 100%; height: 100px;"></textarea></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    <br>
                                    <span style="margin-left: 10px;">b. Sasaran Pekerjaan Secara Kuantitatif</span>
                                    <br>
                                    (hasil bisa dilihat dari jumlah, nilai, lama waktu, dll)
                                </td>
                                <td><textarea name="hasil_kuantitatif" style="width: 100%; height: 100px;"></textarea></td>
                                <td><input type="text" name="persen_kuantitatif" style="width: 100%;"></td>
                                <td><textarea name="deviasi_kuantitatif" style="width: 100%; height: 100px;"></textarea></td>
                            </tr>
                            <tr>
                                <th colspan="4"> 2. <?php echo $row1->nama_value; ?></th>
                            </tr>
                            <tr>
                                <th>(<?php echo $row2->description; ?>)</th>
                                <th></th>
                                <th style="text-align: center;">%</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><textarea name="deskripsi_tugas_tambahan" style="width: 100%; height: 100px;"></textarea></td>
                                <td><textarea name="hasil_tugas_tambahan" style="width: 100%; height: 100px;"></textarea></td>
                                <td><input type="text" name="persen_tugas_tambahan" style="width: 100%;"></td>
                                <td><textarea name="deviasi_tugas_tambahan" style="width: 100%; height: 100px;"></textarea></td>
                            </tr>
                        </table>
                    </div>
                    <div id="menu4" class="tab-pane fade">
                        <h4><b>Penjelasan dan Kesimpulan</b></h4>
                        <table border="1" style="width: 100%;">
                            <?php
                            $row1 = $menu4->row(0); // Mengambil baris pertama
                            $row2 = $menu4->row(1); // Mengambil baris kedua
                            ?>
                            <tr>
                                <th><b>III. <?php echo $row2->nama_value; ?></b></th>
                            </tr>
                            <tr>
                                <td>
                                    <p><?php echo $row2->description; ?></p>
                                    <textarea name="penjelasan_hasil_kinerja" style="width: 100%; height: 150px;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><b>IV. <?php echo $row1->nama_value; ?></b></th>
                            </tr>
                            <tr>
                                <td>
                                    <p><?php echo $row1->description; ?></p>
                                    <textarea name="kesimpulan_hasil_penilaian" style="width: 100%; height: 150px;"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="menu5" class="tab-pane fade">
                        <h4>Penilaian Kompetensi</h4>
                        <table border="1" style="width: 100%; text-align: center;">
                            <?php foreach ($menu5->result() as $row) { ?>
                                <tr>
                                    <td><?php echo $row->kriteria; ?></td>
                                    <td>
                                        <input type="radio" name="kompetensi[<?php echo $row->id; ?>]" value="A" <?php echo $row->nilai == 'A' ? 'checked' : ''; ?>> A
                                        <input type="radio" name="kompetensi[<?php echo $row->id; ?>]" value="B" <?php echo $row->nilai == 'B' ? 'checked' : ''; ?>> B
                                        <input type="radio" name="kompetensi[<?php echo $row->id; ?>]" value="C" <?php echo $row->nilai == 'C' ? 'checked' : ''; ?>> C
                                        <input type="radio" name="kompetensi[<?php echo $row->id; ?>]" value="D" <?php echo $row->nilai == 'D' ? 'checked' : ''; ?>> D
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div id="menu6" class="tab-pane fade">
                        <h4><b>V. Pendapat / Komentar</b></h4>
                        <table border="1" style="width: 100%;">
                            <?php
                            $row1 = $menu6->row(0); // Mengambil baris pertama (index 0)
                            $row2 = $menu6->row(1); // Mengambil baris kedua (index 1)
                            ?>
                            <tr>
                                <th>1. <?php echo $row1->nama_value; ?></th>
                            </tr>
                            <tr>
                                <td>
                                    <p>Mintakan pendapat/komentar karyawan yang dinilai atas seluruh hasil penilaian tersebut di atas</p>
                                    <textarea name="pendapat_karyawan" style="width: 100%; height: 150px;">"Isi dari feedback yang sudah dikirimkan karyawan"</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>2. <?php echo $row2->nama_value; ?></th>
                            </tr>
                            <tr>
                                <td>
                                    <textarea name="komentar_atasan" style="width: 100%; height: 150px;"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>