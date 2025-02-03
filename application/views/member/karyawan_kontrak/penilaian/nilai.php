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
<?php if ($flag_jenis_form == 1): ?>
    <div style="background-color:rgb(226, 224, 224); font-size: 30px; margin-bottom: 5px;">
        <h2 style="background-color:rgb(226, 224, 224); font-size: 30px;">Penilaian Saya</h2>
    </div>
    <center>
        <div class="form-group">
            <button type="submit" class="btn bg-blue btn-success btn-flat-margin" style="font-size: 15px; margin-right: 100px;" onclick="location.href='penilaian1.php'">Penilaian ke 1</button>
            <button type="submit" class="btn bg-blue btn-success btn-flat-margin" style="font-size: 15px; margin-right: 50px; margin-left: 50px;" onclick="location.href='penilaian2.php'">Penilaian ke 2</button>
            <button type="submit" class="btn bg-blue btn-success btn-flat-margin" style="font-size: 15px; margin-left: 100px;" onclick="location.href='penilaian3.php'">Penilaian ke 3</button>
        </div>
    </center>
    <div style="border-bottom: 8px solid black; width: 100%;"></div>
    <div style="width: 80%; margin: auto; border: 2px solid black; padding: 20px; font-family: Arial, sans-serif; font-size: 14px;">
        <h2 style="text-align: center; font-weight: bold;">LAPORAN PENILAIAN PRESTASI KERJA</h2>
        <h4 style="text-align: center; font-weight: bold;">KARYAWAN KONTRAK KELOMPOK I - II</h4>

        <!-- Jenis Form Kel 1-2 -->
        <!-- Tabel Data Karyawan -->
        <table border="1" style="width: 50%; border-collapse: collapse; border: 2px solid black; margin-top: 30px; margin-bottom: 20px;">
            <tr>
                <th colspan="2" style="text-align: center; padding: 8px; font-size: 16px;">KARYAWAN YANG DINILAI</th>
            </tr>
            <tr>
                <td style="width: 40%; padding: 10px;">Nama</td>
                <?php
                $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                ?>
                <td style="padding: 10px;"><?php echo isset($row->nama_lengkap) ? $row->nama_lengkap : 'Nilai Belum Di Isi !'; ?></td>
            </tr>
            <tr>
                <td style="padding: 10px;">Jabatan</td>
                <?php
                $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                ?>
                <td style="padding: 10px;"><?php echo isset($row->job_grade) ? $row->job_grade : 'Nilai Belum Di Isi !'; ?></td>
            </tr>
            <tr>
                <td style="padding: 10px;">Tanggal Masuk</td>
                <?php
                $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                ?>
                <td style="padding: 10px;"><?php echo isset($row->tgl_hire) ? $row->tgl_hire : 'Nilai Belum Di Isi !'; ?></td>
            </tr>
        </table>

        <table border="2" style="width: 50%; border-collapse: collapse; ">
            <tr>
                <th colspan="2" style="text-align: center;  padding: 5px; font-size: 16px;">NAMA PENILAI</th>
            </tr>
            <tr>
                <td style="width: 40%; padding: 4px;">Atasan Langsung :</td>
                <?php
                $row = $data->row(); // Ambil baris pertama dari hasil query
                ?>
                <td style="padding: 4px;"><?php echo isset($row->spv1_nama) ? $row->spv1_nama : 'Nilai Belum Di Isi !'; ?></td>
            </tr>
            <tr>
                <td style="width: 40%; padding: 4px;">Atasan Tidak Langsung :</td>
                <?php
                $row = $data->row(); // Ambil baris pertama dari hasil query
                ?>
                <td style="padding: 4px;"><?php echo isset($row->spv2_nama) ? $row->spv2_nama : 'Nilai Belum Di Isi !'; ?></td>
            </tr>
            <tr>
                <td style="width: 40%; padding: 4px;">Unit :</td>
                <?php
                $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                ?>
                <td style="padding: 4px;"><?php echo isset($row->department) ? $row->department : 'Nilai Belum Di Isi !'; ?></td>
            </tr>
            <tr>
                <td style="width: 40%; padding: 4px;">Periode Penilaian :</td>
                <?php
                $row = $data->row(); // Ambil baris pertama dari hasil query
                ?>
                <td style="padding: 4px;"><?php echo isset($row->flag_penilaian) ? $row->flag_penilaian : 'Nilai Belum Di Isi !'; ?></td>
            </tr>
        </table>
        <!-- Tambahkan ini untuk memastikan bagian baru dimulai di halaman berikutnya -->
        <div style="page-break-before: always;"></div>

        <table border="2" style="width: 100%; border-collapse: collapse; page-break-inside: avoid;">
            <!-- Tabel lainnya di sini -->
        </table>


        <style>
            @media print {
                body {
                    margin: 0;
                    padding: 0;
                }

                table {
                    page-break-inside: avoid;
                }

                div {
                    page-break-inside: avoid;
                }
            }
        </style>


        <!-- Tabel Penilaian -->
        <table border="2" style="width: 100%; border-collapse: collapse; margin: 15px auto; margin-bottom: 15px;">
            <tr style="font-weight: bold; background-color: #f2f2f2;">
                <th style="text-align: center;">No</th>
                <th style="width: 50%; text-align: center; padding: 5px;">Aspek Yang Dinilai</th>
                <th style="width: 10%; text-align: center; padding: 5px;">Atasan Langsung</th>
                <th style="width: 10%; text-align: center; padding: 5px;">Nilai Atasan Langsung</th>
                <th style="width: 10%; text-align: center; padding: 5px;">Atasan Tidak Langsung</th>
                <th style="width: 10%; text-align: center; padding: 5px;">Nilai Atasan Tidak Langsung</th>
            </tr>
            <?php
            $no = 1; // Inisialisasi nomor
            foreach ($penilaian->result() as $row): ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no; ?></td> <!-- Kolom Nomor -->
                    <td style="padding: 4px;"><?php echo $row->aspek_dinilai; ?></td>
                    <td style="padding: 4px; text-align: center;"><?php echo $row->isi_nilai_atasan_langsung; ?></td>
                    <td style="padding: 4px; text-align: center;"><?php echo number_format($row->nilai_atasan_langsung, 1); ?></td>
                    <td style="padding: 4px; text-align: center;"><?php echo $row->isi_nilai_atasan_tidak_langsung; ?></td>
                    <td style="padding: 4px; text-align: center;"><?php echo number_format($row->nilai_atasan_tidak_langsung, 1); ?></td>
                </tr>
            <?php
                $no++; // Increment nomor
            endforeach; ?>
            <tfoot>
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td></td> <!-- Kosong untuk kolom nomor -->
                    <td style="padding: 4px; text-align: left;"><b>Total</b></td>
                    <td colspan="2" style="padding: 4px; text-align: center;">
                        <?php
                        echo isset($row->total_nilai_atasan_langsung)
                            ? number_format($row->total_nilai_atasan_langsung, 1)
                            : '0.0';
                        ?>
                    </td>
                    <td colspan="2" style="padding: 4px; text-align: center;">
                        <?php
                        echo isset($row->total_nilai_atasan_tidak_langsung)
                            ? number_format($row->total_nilai_atasan_tidak_langsung, 1)
                            : '0.0';
                        ?>
                    </td>
                </tr>
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td></td> <!-- Kosong untuk kolom nomor -->
                    <td style="padding: 4px; text-align: left;"><b>Hasil Akhir :</b></td>
                    <?php
                    // Menghitung Hasil Akhir dengan validasi
                    $hasil_akhir = (isset($row->total_nilai_atasan_langsung) && isset($row->total_nilai_atasan_tidak_langsung))
                        ? ($row->total_nilai_atasan_langsung * 0.6) + ($row->total_nilai_atasan_tidak_langsung * 0.4)
                        : 0.0;
                    ?>
                    <td colspan="4" style="padding: 4px; text-align: center;"><?php echo number_format($hasil_akhir, 1); ?></td>
                </tr>
            </tfoot>

        </table>
        <table border="2" style="width: 50%; border-collapse: collapse; margin-bottom: 15px;">
            <tr style="font-weight: bold;  background-color: #f2f2f2; text-align: center;">
                <td style="padding: 5px;">Kriteria</td>
                <td style="padding: 5px;">Nilai</td>
                <td style="padding: 5px;">Keterangan</td>
            </tr>
            <tr style="text-align: center;">
                <td style="font-weight: bold; padding: 3px;">A</td>
                <td style="padding: 3px;">90 s.d. 100</td>
                <td style="padding: 3px;">Istimewa</td>
            </tr>
            <tr style="text-align: center;">
                <td style="font-weight: bold; padding: 3px;">B</td>
                <td style="padding: 3px;">80 s.d. 89</td>
                <td style="padding: 3px;">Baik</td>
            </tr>
            <tr style="text-align: center;">
                <td style="font-weight: bold; padding: 3px;">C</td>
                <td style="padding: 3px;">60 s.d. 79</td>
                <td style="padding: 3px;">Cukup</td>
            </tr>
            <tr style="text-align: center;">
                <td style="font-weight: bold; padding: 3px;">D</td>
                <td style="padding: 3px;">40 s.d. 59</td>
                <td style="padding: 3px;">Kurang</td>
            </tr>
        </table>

        <table border="2" style="width: 100%; border-collapse: collapse; ">
            <tr>
                <td style="padding: 5px;">
                    <strong>Aspek-aspek Tambahan </strong>
                    (mohon diuraikan bila ada) :

                    <div style="margin-bottom: 15px;">
                        <strong>Atasan Langsung:</strong>
                        <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                            <?php echo !empty($row->text_tambahan_atasan_langsung) ? $row->text_tambahan_atasan_langsung : '&nbsp;'; ?>
                        </div>
                        <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                            &nbsp; <!-- Garis tambahan kosong -->
                        </div>
                        <strong>Atasan Tidak Langsung:</strong>
                        <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                            <?php echo !empty($row->text_tambahan_atasan_tidak_langsung) ? $row->text_tambahan_atasan_tidak_langsung : '&nbsp;'; ?>
                        </div>
                        <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                            &nbsp; <!-- Garis tambahan kosong -->
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <!-- Jenis Form Kel 1-2 -->
<?php else: ?>

    <!-- Jenis Form KELOMPOK III - VII -->
    <div style="background-color:rgb(226, 224, 224); font-size: 30px; margin-bottom: 3px;">
        <h2 style="background-color:rgb(226, 224, 224); font-size: 30px;">Penilaian Saya</h2>
    </div>
    <center>
        <div class="form-group">
            <button type="submit" class="btn bg-blue btn-success btn-flat-margin" style="font-size: 15px; margin-right: 100px;" onclick="location.href='penilaian1.php'">Penilaian ke 1</button>
            <button type="submit" class="btn bg-blue btn-success btn-flat-margin" style="font-size: 15px; margin-right: 50px; margin-left: 50px;" onclick="location.href='penilaian2.php'">Penilaian ke 2</button>
            <button type="submit" class="btn bg-blue btn-success btn-flat-margin" style="font-size: 15px; margin-left: 100px;" onclick="location.href='penilaian3.php'">Penilaian ke 3</button>
        </div>
    </center>
    <div style="border-bottom: 8px solid black; width: 100%;"></div>
    <div style="display: flex;">
        <div style="width: 60%; margin: auto; border: 2px solid black; padding: 20px; font-family: Arial, sans-serif; font-size: 14px; margin-top: 20px;">
            <h2 style="text-align: center; font-weight: bold;">LAPORAN PENILAIAN PRESTASI KERJA</h2>
            <h4 style="text-align: center; font-weight: bold;">KARYAWAN KONTRAK KELOMPOK III - VII</h4>

            <!-- Tabel Data Karyawan -->
            <table border="1" style="width: 50%; border-collapse: collapse; border: 2px solid black; margin-top: 30px; margin-bottom: 20px;">
                <tr>
                    <th colspan="2" style="text-align: center; padding: 8px; font-size: 16px;">KARYAWAN YANG DINILAI</th>
                </tr>
                <tr>
                    <td style="width: 40%; padding: 10px;">Nama :</td>
                    <?php
                    $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                    ?>
                    <td style="padding: 10px;"><?php echo isset($row->nama_lengkap) ? $row->nama_lengkap : 'Nilai Belum Di Isi !'; ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px;">Jabatan :</td>
                    <?php
                    $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                    ?>
                    <td style="padding: 10px;"><?php echo isset($row->job_grade) ? $row->job_grade : 'Nilai Belum Di Isi !'; ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px;">Tanggal Masuk :</td>
                    <?php
                    $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                    ?>
                    <td style="padding: 10px;"><?php echo isset($row->tgl_hire) ? $row->tgl_hire : 'Nilai Belum Di Isi !'; ?></td>
                </tr>
            </table>

            <table border="2" style="width: 50%; border-collapse: collapse; ">
                <tr>
                    <th colspan="2" style="text-align: center;  padding: 5px; font-size: 16px;">NAMA PENILAI</th>
                </tr>
                <tr>
                    <td style="width: 40%; padding: 4px;">Atasan Langsung :</td>
                    <?php
                    $row = $data2->row(); // Ambil baris pertama dari hasil query
                    ?>
                    <td style="padding: 4px;"><?php echo isset($row->spv1_nama) ? $row->spv1_nama : 'Nilai Belum Di Isi !'; ?></td>
                </tr>
                <tr>
                    <td style="width: 40%; padding: 4px;">Atasan Tidak Langsung :</td>
                    <?php
                    $row = $data2->row(); // Ambil baris pertama dari hasil query
                    ?>
                    <td style="padding: 4px;"><?php echo isset($row->spv2_nama) ? $row->spv2_nama : 'Nilai Belum Di Isi !'; ?></td>
                </tr>
                <tr>
                    <td style="width: 40%; padding: 4px;">Unit :</td>
                    <?php
                    $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
                    ?>
                    <td style="padding: 4px;"><?php echo isset($row->department) ? $row->department : 'Nilai Belum Di Isi !'; ?></td>
                </tr>
                <tr>
                    <td style="width: 40%; padding: 4px;">Periode Penilaian :</td>
                    <?php
                    $row = $data2->row(); // Ambil baris pertama dari hasil query
                    ?>
                    <td style="padding: 4px;"><?php echo isset($row->flag_penilaian) ? $row->flag_penilaian : 'Nilai Belum Di Isi !'; ?></td>
                </tr>
            </table>
            <!-- Tambahkan ini untuk memastikan bagian baru dimulai di halaman berikutnya -->
            <div style="page-break-before: always;"></div>

            <table border="2" style="width: 100%; border-collapse: collapse; page-break-inside: avoid;">
                <!-- Tabel lainnya di sini -->
            </table>


            <style>
                @media print {
                    body {
                        margin: 0;
                        padding: 0;
                    }

                    table {
                        page-break-inside: avoid;
                    }

                    div {
                        page-break-inside: avoid;
                    }
                }
            </style>


            <!-- Tabel Penilaian -->
            <table border="2" style="width: 100%; border-collapse: collapse; margin: 15px auto; margin-bottom: 15px;">
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <th style="text-align: center;">No</th>
                    <th style="width: 50%; text-align: center; padding: 5px;">Aspek Yang Dinilai</th>
                    <th style="width: 10%; text-align: center; padding: 5px;">Atasan Langsung</th>
                    <th style="width: 10%; text-align: center; padding: 5px;">Nilai Atasan Langsung</th>
                    <th style="width: 10%; text-align: center; padding: 5px;">Atasan Tidak Langsung</th>
                    <th style="width: 10%; text-align: center; padding: 5px;">Nilai Atasan Tidak Langsung</th>
                </tr>
                <?php
                $no = 1; // Inisialisasi nomor
                foreach ($penilaian2->result() as $row): ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $no; ?></td> <!-- Kolom Nomor -->
                        <td style="padding: 4px;"><?php echo $row->aspek_dinilai; ?></td>
                        <td style="padding: 4px; text-align: center;"><?php echo $row->isi_nilai_atasan_langsung; ?></td>
                        <td style="padding: 4px; text-align: center;">
                            <?php
                            $nilai_al = str_replace(',', '.', $row->nilai_atasan_langsung);
                            echo is_numeric($nilai_al) ? number_format($nilai_al, 1) : '0.0';
                            ?>
                        </td>
                        <td style="padding: 4px; text-align: center;"><?php echo $row->isi_nilai_atasan_tidak_langsung; ?></td>
                        <td style="padding: 4px; text-align: center;">
                            <?php
                            $nilai_atl = str_replace(',', '.', $row->nilai_atasan_tidak_langsung);
                            echo is_numeric($nilai_atl) ? number_format($nilai_atl, 1) : '0.0';
                            ?>
                        </td>

                    </tr>
                <?php
                    $no++; // Increment nomor
                endforeach; ?>
                <tfoot>
                    <tr style="font-weight: bold; background-color: #f2f2f2;">
                        <td></td> <!-- Kosong untuk kolom nomor -->
                        <td style="padding: 4px; text-align: left;"><b>Total</b></td>
                        <td colspan="2" style="padding: 4px; text-align: center;">
                            <?php
                            echo isset($row->total_nilai_atasan_langsung)
                                ? number_format($row->total_nilai_atasan_langsung, 1)
                                : '0.0';
                            ?>
                        </td>
                        <td colspan="2" style="padding: 4px; text-align: center;">
                            <?php
                            echo isset($row->total_nilai_atasan_tidak_langsung)
                                ? number_format($row->total_nilai_atasan_tidak_langsung, 1)
                                : '0.0';
                            ?>
                        </td>
                    </tr>
                    <tr style="font-weight: bold; background-color: #f2f2f2;">
                        <td></td> <!-- Kosong untuk kolom nomor -->
                        <td style="padding: 4px; text-align: left;"><b>Hasil Akhir :</b></td>
                        <?php
                        // Menghitung Hasil Akhir dengan validasi
                        $hasil_akhir = (isset($row->total_nilai_atasan_langsung) && isset($row->total_nilai_atasan_tidak_langsung))
                            ? ($row->total_nilai_atasan_langsung * 0.6) + ($row->total_nilai_atasan_tidak_langsung * 0.4)
                            : 0.0;
                        ?>
                        <td colspan="4" style="padding: 4px; text-align: center;"><?php echo number_format($hasil_akhir, 1); ?></td>
                    </tr>
                </tfoot>

            </table>
            <table border="2" style="width: 50%; border-collapse: collapse; margin-bottom: 30px;">
                <tr style="font-weight: bold;  background-color: #f2f2f2; text-align: center;">
                    <td style="padding: 5px;">Kriteria</td>
                    <td style="padding: 5px;">Nilai</td>
                    <td style="padding: 5px;">Keterangan</td>
                </tr>
                <tr style="text-align: center;">
                    <td style="font-weight: bold; padding: 3px;">A</td>
                    <td style="padding: 3px;">90 s.d. 100</td>
                    <td style="padding: 3px;">Istimewa</td>
                </tr>
                <tr style="text-align: center;">
                    <td style="font-weight: bold; padding: 3px;">B</td>
                    <td style="padding: 3px;">80 s.d. 89</td>
                    <td style="padding: 3px;">Baik</td>
                </tr>
                <tr style="text-align: center;">
                    <td style="font-weight: bold; padding: 3px;">C</td>
                    <td style="padding: 3px;">60 s.d. 79</td>
                    <td style="padding: 3px;">Cukup</td>
                </tr>
                <tr style="text-align: center;">
                    <td style="font-weight: bold; padding: 3px;">D</td>
                    <td style="padding: 3px;">40 s.d. 59</td>
                    <td style="padding: 3px;">Kurang</td>
                </tr>
            </table>

            <h4><b>Penilaian Kinerja Karyawan</b></h4>
            <table border="1" style="width: 100%; text-align: center; margin-bottom: 30px;">
                <?php
                $row1 = $menu3->row(0); // Mengambil baris pertama (index 0)
                $row2 = $menu3->row(1); // Mengambil baris kedua (index 1)
                $row3 = $form_a->row();
                ?>
                <tr>
                    <th style="text-align: center;">RENCANA KERJA</th>
                    <th style="text-align: center;">KESIMPULAN HASIL</th>
                    <th style="text-align: center;">%</th>
                    <th style="text-align: center;">KESIMPULAN DEVIASI</th>
                </tr>
                <tr>
                    <th colspan="4" style="background-color:rgb(218, 218, 218);">A. KINERJA
                        <br>(Didasarkan Sasaran Pekerjaan)
                        <br>
                        <span>1. <?php echo $row1->nama_value; ?></span>
                    </th>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <br>
                        <span style="margin-left: 10px;">a. <?php echo $row2->description; ?></span>
                        <br>
                        (hasil bisa dilihat dari kualitas keakuratan, dll)
                    </td>
                    <td><textarea name="hasil_kualitatif" style="width: 100%; height: 100px;" readonly><?php echo isset($row3->hasil_nilai_a) ? $row3->hasil_nilai_a : 'Nilai Belum Di Isi !'; ?></textarea></td>
                    <td><input type="text" name="persen_kualitatif" style="width: 100%; text-align: center;" value="<?php echo isset($row3->persen_a) ? $row3->persen_a : ''; ?>" placeholder="Nilai Belum Di Isi !" readonly></td>
                    <td><textarea name="deviasi_kualitatif" style="width: 100%; height: 100px;" readonly><?php echo isset($row3->deviasi_nilai_a) ? $row3->deviasi_nilai_a : 'Nilai Belum Di Isi !'; ?></textarea></td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <br>
                        <span style="margin-left: 10px;">b. Sasaran Pekerjaan Secara Kuantitatif</span>
                        <br>
                        (hasil bisa dilihat dari jumlah, nilai, lama waktu, dll)
                    </td>
                    <td><textarea name="hasil_kuantitatif" style="width: 100%; height: 100px;" readonly><?php echo isset($row3->hasil_nilai_b) ? $row3->hasil_nilai_b : 'Nilai Belum Di Isi !'; ?></textarea></td>
                    <td><input type="text" name="persen_kuantitatif" style="width: 100%; text-align: center;" value="<?php echo isset($row3->persen_b) ? $row3->persen_b : ''; ?>" placeholder="Nilai Belum Di Isi !" readonly></td>
                    <td><textarea name="deviasi_kuantitatif" style="width: 100%; height: 100px;" readonly><?php echo isset($row3->deviasi_b) ? $row3->deviasi_b : 'Nilai Belum Di Isi !'; ?></textarea></td>
                </tr>
                <tr>
                    <th colspan="4" style="background-color:rgb(218, 218, 218);"> 2. <?php echo $row2->nama_value; ?>
                        <br>(<?php echo $row2->description; ?>)
                    </th>
                </tr>
                <tr>
                    <td><textarea name="deskripsi_tugas_tambahan" style="width: 100%; height: 100px;" readonly><?php echo isset($row3->tugas_tambahan) ? $row3->tugas_tambahan : 'Nilai Belum Di Isi !'; ?></textarea></td>
                    <td><textarea name="hasil_tugas_tambahan" style="width: 100%; height: 100px;" readonly><?php echo isset($row3->hasil_tgs_tambahan) ? $row3->hasil_tgs_tambahan : 'Nilai Belum Di Isi !'; ?></textarea></td>
                    <td><input type="text" name="persen_tugas_tambahan" style="width: 100%; text-align: center;" value="<?php echo isset($row3->persen_tambahan) ? $row3->persen_tambahan : ''; ?>" placeholder="Nilai Belum Di Isi !" readonly></td>
                    <td><textarea name="deviasi_tugas_tambahan" style="width: 100%; height: 100px;" readonly><?php echo isset($row3->deviasi_tambahan) ? $row3->deviasi_tambahan : 'Nilai Belum Di Isi !'; ?></textarea></td>
                </tr>
            </table>

            <?php
            $row1 = $menu4->row(0); // Mengambil baris pertama
            $row2 = $menu4->row(1); // Mengambil baris kedua
            $row4 = $form_b->row();
            ?>
            <h4><b><?php echo $row2->nama_value; ?></b></h4>
            <table border="1" style="width: 100%; margin-bottom: 15px; margin-bottom: 30px;">
                <tr>
                    <td>
                        <p><?php echo $row2->description; ?></p>
                        <textarea name="kesimpulan_hasil_penilaian" style="width: 100%; height: 150px;" readonly><?php echo isset($row4->kesimpulan) ? $row4->kesimpulan : 'Nilai Belum Di Isi !'; ?></textarea>
                    </td>
                </tr>
            </table>

            <h4><b><?php echo $row1->nama_value; ?></b></h4>
            <table border="1" style="width: 100%; margin-bottom: 15px; margin-bottom: 30px;">
                <tr>
                    <td>
                        <p><?php echo $row1->description; ?></p>
                        <textarea name="penjelasan_hasil_kinerja" style="width: 100%; height: 150px;" readonly><?php echo isset($row4->penjelasan) ? $row4->penjelasan : 'Nilai Belum Di Isi !'; ?></textarea>
                    </td>
                </tr>
            </table>

            <h4><b>PENDAPAT / KOMENTAR</b></h4>
            <table border="1" style="width: 100%;">
                <?php
                $row1 = $menu6->row(0); // Mengambil baris pertama (index 0)
                $row2 = $menu6->row(1); // Mengambil baris kedua (index 1)
                ?>
                <tr>
                    <th>1. <?php echo $row1->nama_value; ?>
                        <p>Mintakan pendapat/komentar karyawan yang dinilai atas seluruh hasil penilaian tersebut di atas</p>
                    </th>
                </tr>
                <tr>
                    <td>
                        <textarea name="pendapat_karyawan" style="width: 100%; height: 150px;"></textarea>
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
        <!-- <br><br>
        <hr size="4" color="black" style="margin: 20px 0;"> -->
        <div style="width: 40%; padding: 10px; margin: right; margin-top: 10px;">
            <h4><b>PENDAPAT DARI KARYAWAN YANG DINILAI</b></h4>
            (Mintakan pendapat/komentar karyawan yang dinilai atas seluruh hasil penilaian tersebut)
            <table border=" 1" style="width: 100%;">
                <?php
                $row1 = $menu6->row(0); // Mengambil baris pertama (index 0)
                $row2 = $menu6->row(1); // Mengambil baris kedua (index 1)
                ?>
                <tr>
                    <td>
                        <textarea name="pendapat_karyawan" style="width: 100%; height: 150px;"></textarea>
                    </td>
                </tr>
            </table>
            <center>
                <div class="form-group" style="margin-top: 20px;">
                    <button type="submit" class="btn bg-blue btn-success btn-flat-margin">KIRIM</button>
                </div>
            </center>
        </div>
    </div>
<?php endif; ?>

<!-- download KEL 1-2-->
<?php if ($flag_jenis_form == 1): ?>
    <center>
        <a class="btn bg-red btn-flat margin text-center" href="<?php echo base_url(); ?>Trans_pkk/download_data_pkk/<?php echo $nrp ?>">
            <i class="fa fa-download"></i>
            Download data
        </a>
        <a class="btn bg-green btn-flat margin text-center" href="<?php echo base_url(); ?>Trans_pkk/download_data_pkk_excel/<?php echo $nrp ?>">
            <i class="fa fa-download"></i>
            Download data
        </a>
    </center>
<?php else: ?>
    <!-- download KEL 3-7-->
    <center>
        <a class="btn bg-red btn-flat margin text-center" href="<?php echo base_url(); ?>Trans_pkk/download_data_pkk_3_7/<?php echo $nrp ?>">
            <i class="fa fa-download"></i>
            Download data
        </a>
        <a class="btn bg-green btn-flat margin text-center" href="<?php echo base_url(); ?>Trans_pkk/download_data_pkk_excel/<?php echo $nrp ?>">
            <i class="fa fa-download"></i>
            Download data
        </a>
    </center>
<?php endif; ?>