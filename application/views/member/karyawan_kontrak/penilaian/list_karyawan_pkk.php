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
                <!-- available -->
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
                        $no     = '1';
                        $status = '0'; //0 = available, 1 = resign, 2 = phk, 3 = hapus 
                        //jenis (1 = karyawan tetap, 2 = project, 3 kontrak)
                        $nrp    = $this->session->userdata('nrp');
                        $data   = $this->master_model->list_member_pkk_2($nrp);
                        foreach ($data->result() as $dt) {
                            $cek_pkk = $this->master_model->cek_nilai_1_2($dt->nip,  $dt->insert_by);
                            $cek_fpkk = $this->master_model->cek_sent_nilai_1_2($dt->nip, $dt->insert_by);
                            $hasil = $cek_pkk->row()->hasil;
                            $cek = $cek_pkk->row()->cek;
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->status_jaya; ?></td>
                                <td><?php
                                    if ($cek_fpkk->num_rows() > 0 && $cek == 0) {
                                        if ($cek_fpkk->row()->f_sent == '0') { ?>
                                            <p style="color:red"><b> <?php echo $hasil . ' (Belum Submit)'; ?> </b></p>
                                        <?php } else { ?>
                                            <p style="color:green"> <?php echo $hasil . ' (Sudah Submit)'; ?> </p>
                                    <?php }
                                    } else {
                                        echo 'Belum Diisi';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <!-- view -->
                                    <?php if ($dt->flag_jenis_form == 1) { ?>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            1
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            2
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            3
                                        </a>
                                    <?php } elseif ($dt->flag_jenis_form == 2) { ?>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_3_7/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            1
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            2
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            3
                                        </a>
                                    <?php } elseif ($dt->flag_jenis_form == 3) { ?>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_3_7/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            1
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            2
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            3
                                        </a>
                                    <?php } elseif ($dt->flag_jenis_form == 4) { ?>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_3_7/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            1
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            2
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            3
                                        </a>
                                    <?php } elseif ($dt->flag_jenis_form == 5) { ?>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_3_7/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            1
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            2
                                        </a>
                                        <a class="btn bg-blue circle-btn" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian_1_2/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->id_periode; ?>/<?php echo $dt->flag_jenis_form; ?>/<?php echo $dt->id_p_periode; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            3
                                        </a>
                                    <?php } ?>
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
        /* Atur ukuran tombol */
        height: 40px;
        /* Ukuran harus sama agar membentuk lingkaran */
        border-radius: 50%;
        /* Membentuk lingkaran */
        text-align: center;
        /* Memastikan teks berada di tengah */
        display: inline-flex;
        /* Flex untuk center */
        justify-content: center;
        /* Center horizontal */
        align-items: center;
        /* Center vertical */
        padding: 0;
        /* Hapus padding bawaan */
    }
</style>