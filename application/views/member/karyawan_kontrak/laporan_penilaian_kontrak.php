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
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>pengaturan_pkk/lap_pkk">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <a class="btn bg-green btn-flat margin text-center" href="<?php echo base_url(); ?>Trans_pkk/download_data_pkk_excel/<?php echo $unit ?>">
            <i class="fa fa-download"></i>
            Excel
        </a>
    </div>
    <div class="box-body">
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>NRP</td>
                            <td>Unit</td>
                            <td>Ceklis</td>
                            <td>Nilai (angka)</td>
                            <td>Kriteria Nilai</td>
                            <td>Cetak Penilaian Ke</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = '1';
                        $status = '0';
                        $data = $this->master_model->list_member_rekap_pkk1($unit);
                        foreach ($data->result() as $dt) {
                            $data2 = $this->master_model->real_hasil_nilai($dt->nip, $dt->id_jenis_form)->row();
                            $data3 = $this->master_model->get_nilai_ceklis_by_nrp($dt->nip, $dt->id_jenis_form)->row();
                            $nilaiAkhir = (isset($data2->total_nilai_atasan_langsung) && isset($data2->total_nilai_atasan_tidak_langsung))
                                ? ($data2->total_nilai_atasan_langsung * 0.6) + ($data2->total_nilai_atasan_tidak_langsung * 0.4)
                                : 0.0;
                            $jumlah_ceklis = $data3->jumlah_ceklis;

                            if ($nilaiAkhir == 0 && $nilaiAkhir == NULL) {
                                $kriteria = '';
                            } elseif ($nilaiAkhir >= 90 && $nilaiAkhir <= 100) {
                                $kriteria = 'A';
                            } elseif ($nilaiAkhir >= 80 && $nilaiAkhir <= 89) {
                                $kriteria = 'B';
                            } elseif ($nilaiAkhir >= 60 && $nilaiAkhir <= 79) {
                                $kriteria = 'C';
                            } else {
                                $kriteria = 'D';
                            }
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->department; ?></td>
                                <td><?php echo $jumlah_ceklis; ?></td>
                                <td><?php echo number_format($nilaiAkhir, 1) ?></td>
                                <td><?php echo $kriteria; ?></td>
                                <td>
                                    <?php
                                    // Ambil daftar periode dan jenis form berdasarkan NRP
                                    $trans_pkk_list = $this->master_model->get_trans_pkk_by_nrp($dt->nip);

                                    // Konversi hasil query menjadi format asosiatif yang lebih mudah digunakan
                                    $trans_pkk_data = [];
                                    $trans_pkk_periode = [];
                                    foreach ($trans_pkk_list as $row) {
                                        $trans_pkk_data[$row['id_p_periode']] = $row['flag_jenis_form'];
                                        $trans_pkk_periode[$row['id_p_periode']] = $row['id_p_periode'];
                                    }

                                    for ($i = 1; $i <= 3; $i++) {
                                        if (isset($trans_pkk_data[$i])) {
                                            // Ambil flag_jenis_form berdasarkan id_p_periode
                                            $flag_jenis_form = $trans_pkk_data[$i];
                                            $flag_periode    = $trans_pkk_periode[$i];

                                            // Tentukan form link berdasarkan flag_jenis_form
                                            $form_link = ($flag_jenis_form == 1) ? "form_penilaian_1_2" : "form_penilaian_3_7";

                                            $disable_button = $this->master_model->cek_lap_nilai($dt->nip, $dt->id_jenis_form, $flag_periode)->row();
                                            $cek_lap_nilai = $disable_button->jumlah_data;

                                            if ($cek_lap_nilai > 0) {
                                    ?>
                                                <a class="btn bg-blue circle-btn"
                                                    href="<?php echo base_url(); ?>Pengaturan_pkk/view_nilai_pkk_periode/<?php echo $dt->nip; ?>/<?php echo $form_link; ?>/<?php echo $flag_periode ?>" target="_blank">
                                                    <?php echo $i; ?>
                                                </a>
                                            <?php
                                            } else { ?>
                                                <button class="btn bg-gray circle-btn alert-button"
                                                    data-message="Form Belum Diinput, Harap Hubungi Atasan Terkait"
                                                    title="Form belum tersedia">
                                                    <?php echo $i; ?>
                                                </button>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <button class="btn bg-gray circle-btn alert-button"
                                                data-message="Form Belum Tersedia, Harap Hubungi SDM"
                                                title="Form belum tersedia">
                                                <?php echo $i; ?>
                                            </button>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <a class="btn bg-blue circle-btn"
                                        href="<?php echo base_url(); ?>Pengaturan_pkk/view_nilai_pkk_periode/<?php echo $dt->nip; ?>/<?php echo $form_link; ?>/all" target="_blank">
                                        All
                                    </a>
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
    </div>
</div>

<style>
    .circle-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-align: center;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 0;
    }

    .bg-gray {
        background-color: #b0b0b0;
        /* Warna abu-abu untuk tombol alert */
        cursor: not-allowed;
        /* Ubah kursor agar menunjukkan tombol tidak aktif */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.alert-button').forEach(button => {
            button.addEventListener('click', function() {
                alert(this.getAttribute('data-message'));
            });
        });
    });
</script>