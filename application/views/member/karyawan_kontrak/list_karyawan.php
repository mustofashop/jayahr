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
                            <td>Unit</td>
                            <td>Job Grade</td>
                            <td>Submit</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = '1';
                        $status = '0';
                        $data   = $this->master_model->list_member_pkk();
                        foreach ($data->result() as $dt) {
                            $cek_pkk = $this->master_model->cek_submit_pkk($dt->nip);
                            $cek_fpkk = $this->master_model->cek_sent_set_pkk($dt->nip);

                            // Pastikan row() tidak NULL sebelum mengakses propertinya
                            $row_cek_pkk = $cek_pkk->row();
                            $hasil = isset($row_cek_pkk->hasil) ? $row_cek_pkk->hasil : '0/3';
                            $cek = isset($row_cek_pkk->cek) ? $row_cek_pkk->cek : '0';

                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->department; ?></td>
                                <td><?php echo $dt->job_grade; ?></td>
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
                                    <?php if ($hasil === '3/3') { ?>
                                        <!-- Tombol Tidak Aktif dengan Pesan -->
                                        <button class="btn bg-blue btn-flat" onclick="alert('Maaf semua nilai sudah di submit'); return false;">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    <?php } else { ?>
                                        <!-- Tombol Aktif -->
                                        <a class="btn bg-green btn-flat"
                                            href="<?php echo base_url(); ?>Pengaturan_pkk/setting_pkk/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>"
                                            title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                            <i class="fa fa-pencil"></i>
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