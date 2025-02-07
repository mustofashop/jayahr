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
    <div class="box-body">
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>NRP</td>
                            <td>Nama Karyawan</td>
                            <td>Status</td>
                            <td>PKK</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = 1;
                        $nrp    = $this->session->userdata('nrp');
                        $atasan = $this->session->userdata('nrp');
                        $data   = $this->master_model->list_member_pkk_2($nrp);
                        $dt2    = $set_pkk->row();
                        foreach ($data->result() as $dt) {
                            // Mengambil hasil submit berdasarkan NRP
                            $nilai_submit = $this->master_model->get_nilai_submit_by_nrp($dt->nip);
                            $hasil_submit = isset($nilai_submit->hasil) ? $nilai_submit->hasil : '0/6';
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->status_jaya; ?></td>
                                <td>
                                    <p style="font-weight: bold; color: <?php echo ($hasil_submit === '3/3') ? 'green' : 'red'; ?>">
                                        <?php echo $hasil_submit; ?>
                                    </p>
                                </td>
                                <td>
                                    <?php
                                    // Ambil daftar periode dan jenis form berdasarkan NRP
                                    $trans_pkk_list = $this->master_model->get_trans_pkk_by_nrp($dt->nip);

                                    // Konversi hasil query menjadi format asosiatif yang lebih mudah digunakan
                                    $trans_pkk_data = [];
                                    foreach ($trans_pkk_list as $row) {
                                        $trans_pkk_data[$row['id_p_periode']] = $row['flag_jenis_form'];
                                    }

                                    for ($i = 1; $i <= 3; $i++) {
                                        if (isset($trans_pkk_data[$i])) {
                                            // Ambil flag_jenis_form berdasarkan id_p_periode
                                            $flag_jenis_form = $trans_pkk_data[$i];

                                            // Tentukan form link berdasarkan flag_jenis_form
                                            $form_link = ($flag_jenis_form == 1) ? "form_penilaian_1_2" : "form_penilaian_3_7";
                                    ?>
                                            <a class="btn bg-blue circle-btn"
                                                href="<?php echo base_url(); ?>Pengaturan_pkk/<?php echo $form_link; ?>/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt2->id_periode; ?>/<?php echo $flag_jenis_form; ?>/<?php echo $i; ?>/<?php echo $atasan; ?>"
                                                title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        <?php
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