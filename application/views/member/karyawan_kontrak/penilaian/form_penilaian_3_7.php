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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#simpanFeedback").click(function() {
            var isi_feedback = $("#isi_feedback").val();
            var id_p_periode = $("#id_p_periode").val();
            var nrp = $("#nrp").val();

            // Debugging: Cek apakah data dikirim
            console.log("Data yang dikirim:", {
                isi_feedback,
                id_p_periode,
                nrp
            });

            $.ajax({
                url: "<?php echo base_url(); ?>Trans_pkk/fb_atasan",
                type: "POST",
                data: {
                    isi_feedback: isi_feedback,
                    id_p_periode: id_p_periode,
                    nrp: nrp
                },
                dataType: "json",
                success: function(response) {
                    console.log("Respon dari server:", response);
                    if (response.status === "success") {
                        $("#feedbackAlert").text(response.message)
                            .removeClass("alert-danger")
                            .addClass("alert-success")
                            .show().delay(2000).fadeOut(500, function() {
                                // Redirect setelah sukses
                                window.location.href = "<?php echo base_url(); ?>Pengaturan_pkk/list_karyawan_pkk";
                            });
                    } else {
                        $("#feedbackAlert").text(response.message)
                            .removeClass("alert-success")
                            .addClass("alert-danger")
                            .show().delay(3000).fadeOut();
                    }
                },
                error: function(xhr, status, error) {
                    $("#feedbackAlert").text("Terjadi kesalahan: " + error)
                        .addClass("alert-danger")
                        .show().delay(3000).fadeOut();
                }
            });
        });
    });
</script>
<!-- ALERT -->
<div id="feedbackAlert" class="alert alert-success" style="display:none; margin-top: 10px;"></div>
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>Trans_pkk/simpan_nilai_3_7">
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
                        <li><a data-toggle="tab" href="#menu3">Form Isi A</a></li>
                        <li><a data-toggle="tab" href="#menu4">Form Isi B</a></li>
                        <li><a data-toggle="tab" href="#menu5">Form Penilaian</a></li>
                        <li><a data-toggle="tab" href="#menu6">Feedback Karyawan</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <!-- MENU 1: Kriteria Penilaian -->
                    <div id="menu1" class="tab-pane fade in active">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_3_7/Contoh_penilaian_3_7.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>

                    <!-- MENU 2: Contoh -->
                    <div id="menu2" class="tab-pane fade">
                        <iframe src="<?php echo base_url('assets/form_penilaian/penilaian_3_7/Contoh_Penilaian_3_7.pdf'); ?>" width="100%" height="600px" frameborder="0"></iframe>
                    </div>

                    <!-- FORM A: MENU 3 -->
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
                                <th> 1. <?php echo $row1->nama_value; ?></th>
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
                                <!-- FORM A -->
                                <td><textarea name="hasil_nilai_a" style="width: 100%; height: 100px;" placeholder="Isi Di Sini"><?php echo isset($form_a->hasil_nilai_a) ? htmlspecialchars($form_a->hasil_nilai_a) : ''; ?></textarea></td>
                                <!-- <td><input type="number" name="persen_a" style="width: 100%; text-align: center;" value="<?php echo isset($form_a->persen_a) ? htmlspecialchars($form_a->persen_a) : '0'; ?>"></td> -->
                                <td><input type="number" name="persen_a"
                                        style="width: 100%; text-align: center;"
                                        value="<?php echo isset($form_a->persen_a) ? htmlspecialchars($form_a->persen_a) : '0'; ?>"
                                        min="0" max="100"
                                        onkeydown="return enforceLimits(event)"
                                        oninput="validateInput(this)">
                                </td>
                                <td><textarea name="deviasi_nilai_a" style="width: 100%; height: 100px;" placeholder="Isi Di Sini"><?php echo isset($form_a->deviasi_nilai_a) ? htmlspecialchars($form_a->deviasi_nilai_a) : ''; ?></textarea></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    <br>
                                    <span style="margin-left: 10px;">b. Sasaran Pekerjaan Secara Kuantitatif</span>
                                    <br>
                                    (hasil bisa dilihat dari jumlah, nilai, lama waktu, dll)
                                </td>
                                <td><textarea name="hasil_nilai_b" style="width: 100%; height: 100px;" placeholder="Isi Di Sini"><?php echo isset($form_a->hasil_nilai_b) ? htmlspecialchars($form_a->hasil_nilai_b) : ''; ?></textarea></td>
                                <!-- <td><input type="number" name="persen_b" style="width: 100%; text-align: center;" value="<?php echo isset($form_a->persen_b) ? htmlspecialchars($form_a->persen_b) : '0'; ?>"></td> -->
                                <td><input type="number" name="persen_b"
                                        style="width: 100%; text-align: center;"
                                        value="<?php echo isset($form_a->persen_b) ? htmlspecialchars($form_a->persen_b) : '0'; ?>"
                                        min="0" max="100"
                                        onkeydown="return enforceLimits(event)"
                                        oninput="validateInput(this)">
                                </td>
                                <td><textarea name="deviasi_b" style="width: 100%; height: 100px;" placeholder="Isi Di Sini"><?php echo isset($form_a->deviasi_b) ? htmlspecialchars($form_a->deviasi_b) : ''; ?></textarea></td>
                            </tr>
                            <tr>
                                <th colspan="4"> 2. <?php echo $row2->nama_value; ?></th>
                            </tr>
                            <tr>
                                <th>(<?php echo $row2->description; ?>)</th>
                                <th></th>
                                <th style="text-align: center;">%</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><textarea name="tugas_tambahan" style="width: 100%; height: 100px;" placeholder="Isi Di Sini"><?php echo isset($form_a->tugas_tambahan) ? htmlspecialchars($form_a->tugas_tambahan) : ''; ?></textarea></td>
                                <td><textarea name="hasil_tgs_tambahan" style="width: 100%; height: 100px;" placeholder="Isi Di Sini"><?php echo isset($form_a->hasil_tgs_tambahan) ? htmlspecialchars($form_a->hasil_tgs_tambahan) : ''; ?></textarea></td>
                                <td><input type="number" name="persen_tambahan" id="persen_tambahan"
                                        style="width: 100%; text-align: center;"
                                        value="<?php echo isset($form_a->persen_tambahan) ? htmlspecialchars($form_a->persen_tambahan) : '0'; ?>"
                                        min="0" max="100"
                                        onkeydown="return enforceLimits(event)"
                                        oninput="validateInput(this)">
                                </td>
                                <td><textarea name="deviasi_tambahan" style="width: 100%; height: 100px;" placeholder="Isi Di Sini"><?php echo isset($form_a->deviasi_tambahan) ? htmlspecialchars($form_a->deviasi_tambahan) : ''; ?></textarea></td>
                                <input type="hidden" name="id_periode" value="<?php echo $id_periode; ?>">
                                <input type="hidden" name="flag_jenis_form" value="<?php echo $flag_jenis_form; ?>">
                                <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">
                                <input type="hidden" name="id_p_periode" value="<?php echo $id_p_periode; ?>">
                            </tr>
                        </table>
                    </div>

                    <!-- FORM B: MENU 4 -->
                    <div id="menu4" class="tab-pane fade">
                        <h4><b>Penjelasan dan Kesimpulan</b></h4>
                        <table border="1" style="width: 100%;">
                            <?php
                            $row1 = $menu4->row(0); // Mengambil baris pertama
                            $row2 = $menu4->row(1); // Mengambil baris kedua
                            ?>
                            <tr>
                                <th><b>III. <?php echo $row1->nama_value; ?></b></th>
                            </tr>
                            <tr>
                                <td>
                                    <p><?php echo $row1->description; ?></p>
                                    <textarea name="kesimpulan" placeholder="Isi Di Sini" style="width: 100%; height: 150px;"><?php echo isset($form_b->kesimpulan) ? htmlspecialchars($form_b->kesimpulan) : ''; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><b>IV. <?php echo $row2->nama_value; ?></b></th>
                            </tr>
                            <tr>
                                <td>
                                    <p><?php echo $row2->description; ?></p>
                                    <textarea name="penjelasan" placeholder="Isi Di Sini" style="width: 100%; height: 150px;"><?php echo isset($form_b->penjelasan) ? htmlspecialchars($form_b->penjelasan) : ''; ?></textarea>
                                    <input type="hidden" name="id_periode" value="<?php echo $id_periode; ?>">
                                    <input type="hidden" name="flag_jenis_form" value="<?php echo $flag_jenis_form; ?>">
                                    <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">
                                    <input type="hidden" name="id_p_periode" value="<?php echo $id_p_periode; ?>">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- FORM PENILAIAN & FEEDBACK -->
                    <div id="menu5" class="tab-pane fade">
                        <table border="1" style="width: 100%; text-align: center;">
                            <!-- Bagian A. KINERJA -->
                            <tr>
                                <th colspan="2">A. KINERJA</th>
                            </tr>
                            <?php
                            $count_kinerja = 1;
                            foreach ($menu5_data->result() as $dt1) {
                                if (strtolower($dt1->nama_value) == 'tugas pokok' || strtolower($dt1->nama_value) == 'tugas tambahan') {
                                    // Cek apakah ada nilai sebelumnya
                                    $nilai_saat_ini = isset($nilai_terisi[$dt1->id_form_penilaian]) ? $nilai_terisi[$dt1->id_form_penilaian] : '';
                            ?>
                                    <tr>
                                        <td style="text-align: left;" colspan="2"><?php echo $count_kinerja . '. ' . $dt1->nama_value; ?></td>
                                        <td><input type="radio" name="kinerja[<?php echo $dt1->id_form_penilaian; ?>]" value="A" <?php echo ($nilai_saat_ini == 'A') ? 'checked' : ''; ?> required> A</td>
                                        <td><input type="radio" name="kinerja[<?php echo $dt1->id_form_penilaian; ?>]" value="B" <?php echo ($nilai_saat_ini == 'B') ? 'checked' : ''; ?> required> B</td>
                                        <td><input type="radio" name="kinerja[<?php echo $dt1->id_form_penilaian; ?>]" value="C" <?php echo ($nilai_saat_ini == 'C') ? 'checked' : ''; ?> required> C</td>
                                        <td><input type="radio" name="kinerja[<?php echo $dt1->id_form_penilaian; ?>]" value="D" <?php echo ($nilai_saat_ini == 'D') ? 'checked' : ''; ?> required> D</td>
                                    </tr>
                            <?php
                                    $count_kinerja++;
                                }
                            }
                            ?>

                            <!-- Bagian B. KOMPETENSI -->
                            <tr>
                                <th colspan="2">B. KOMPETENSI</th>
                            </tr>
                            <?php
                            $count_kompetensi = 1;
                            foreach ($menu5_data->result() as $dt1) {
                                if (!in_array(strtolower($dt1->nama_value), ['tugas pokok', 'tugas tambahan'])) {
                                    // Cek apakah ada nilai sebelumnya
                                    $nilai_saat_ini = isset($nilai_terisi[$dt1->id_form_penilaian]) ? $nilai_terisi[$dt1->id_form_penilaian] : '';
                            ?>
                                    <tr>
                                        <td style="text-align: left;" colspan="2"><?php echo $count_kompetensi . '. ' . $dt1->nama_value; ?></td>
                                        <td><input type="radio" name="kompetensi[<?php echo $dt1->id_form_penilaian; ?>]" value="A" <?php echo ($nilai_saat_ini == 'A') ? 'checked' : ''; ?> required> A</td>
                                        <td><input type="radio" name="kompetensi[<?php echo $dt1->id_form_penilaian; ?>]" value="B" <?php echo ($nilai_saat_ini == 'B') ? 'checked' : ''; ?> required> B</td>
                                        <td><input type="radio" name="kompetensi[<?php echo $dt1->id_form_penilaian; ?>]" value="C" <?php echo ($nilai_saat_ini == 'C') ? 'checked' : ''; ?> required> C</td>
                                        <td><input type="radio" name="kompetensi[<?php echo $dt1->id_form_penilaian; ?>]" value="D" <?php echo ($nilai_saat_ini == 'D') ? 'checked' : ''; ?> required> D</td>
                                        <input type="hidden" name="id_periode" value="<?php echo $id_periode; ?>">
                                        <input type="hidden" name="id_p_periode" value="<?php echo $id_p_periode; ?>">
                                        <input type="hidden" name="flag_jenis_form" value="<?php echo $flag_jenis_form; ?>">
                                        <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">

                                    </tr>
                            <?php
                                    $count_kompetensi++;
                                }
                            }
                            ?>
                        </table>
                        <!-- SUBMIT BUTTON -->
                        <div class="form-group text-right" style="margin-top: 10px;">
                            <button type="submit" class="btn bg-green btn-success btn-flat-margin">Simpan</button>
                        </div>
                    </div>
                    <!-- FORM FEEDBACK (Masih di dalam form yang sama) -->
                    <div id="menu6" class="tab-pane fade">
                        <h4><b>V. Pendapat / Komentar</b></h4>
                        <table border="1" style="width: 100%;">
                            <?php
                            $row1 = $menu6->row(0);
                            $row2 = $menu6->row(1);
                            ?>
                            <tr>
                                <th>1. <?php echo $row1->nama_value; ?></th>
                            </tr>
                            <tr>
                                <td>
                                    <p>Mintakan pendapat/komentar karyawan yang dinilai atas seluruh hasil penilaian tersebut di atas</p>
                                    <textarea name="isi_feedback" style="width: 100%; height: 150px;" placeholder="Karyawan Belum Mengisi Feedback" readonly><?php echo isset($fb_k->isi_feedback) ? htmlspecialchars($fb_k->isi_feedback) : ''; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>2. <?php echo $row2->nama_value; ?></th>
                            </tr>
                            <tr>
                                <td>
                                    <textarea id="isi_feedback" style="width: 100%; height: 150px;" placeholder="Isi Disini"
                                        <?php echo empty($fb_k->isi_feedback) ? 'readonly' : ''; ?>><?php echo isset($fb_a->isi_feedback) ? htmlspecialchars($fb_a->isi_feedback) : ''; ?></textarea>
                                    <input type="hidden" id="id_p_periode" value="<?php echo $id_p_periode; ?>">
                                    <input type="hidden" id="nrp" value="<?php echo $idp_nrp; ?>">
                                </td>
                            </tr>

                        </table>
                        <!-- SUBMIT BUTTON UNTUK MENU 6 -->
                        <div class="form-group text-right" style="margin-top: 10px;">
                            <button type="button" id="simpanFeedback" class="btn bg-blue btn-primary btn-flat-margin">Simpan Feedback</button>
                        </div>
                    </div>
                </div> <!-- END TAB-CONTENT -->
            </div>
        </form> <!-- END FORM -->
    </div>
</body>

<script>
    function enforceLimits(event) {
        let key = event.key;

        // Izinkan tombol navigasi dan edit teks
        if (
            key === "Backspace" || key === "Delete" || key === "ArrowLeft" || key === "ArrowRight" ||
            key === "Tab" || key === "Enter"
        ) {
            return true;
        }

        // Izinkan hanya angka (0-9)
        if (!/^[0-9]$/.test(key)) {
            return false;
        }
    }

    function validateInput(input) {
        if (input.value !== "") {
            let value = parseInt(input.value);

            // Jika nilai lebih dari 100, batasi ke 100
            if (value > 100) {
                input.value = 100;
            }
            // Jika kurang dari 0, batasi ke 0
            else if (value < 0 || isNaN(value)) {
                input.value = 0;
            }
        }
    }
</script>