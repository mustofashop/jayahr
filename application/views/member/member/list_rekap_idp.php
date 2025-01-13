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
        <a class="btn btn-app" href="<?php echo base_url(); ?>lap_idp/rekap_idp">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <!-- <?php

                if ($this->session->userdata('level') == '1') {    ?>
            <a class="btn bg-red btn-flat margin" href="<?php echo base_url(); ?>People_rev/download_rekap_idp/<?php echo $tahun; ?>/<?php echo $nrp; ?>">
                <i class="fa fa-download"></i>
                Download data
            </a>
        <?php } else { ?>
            <a class="btn bg-red btn-flat margin" href="<?php echo base_url(); ?>People_rev/download_rekap_idp_admin/<?php echo $unit; ?>">
                <i class="fa fa-download"></i>
                Download data
            </a>
        <?php }
        ?> -->

        <?php

        if ($this->session->userdata('level') == '1') {    ?>
            <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>People_rev/download_rekap_idp_old/<?php echo $tahun; ?>/<?php echo $nrp; ?>">
                <i class="fa fa-download"></i>
                Download data
            </a>
        <?php } else { ?>
            <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>People_rev/download_rekap_idp_admin_excel/<?php echo $unit; ?>">
                <i class="fa fa-download"></i>
                Download data
            </a>
        <?php }
        ?>

    </div>
    <div class="box-body">

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NRP</th>
                            <th>Nama Karyawan</th>
                            <th>Status</th>
                            <th>IDP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $status = 0;
                        $nrp = $this->session->userdata('nrp');
                        $data_1 = $this->master_model->list_member_rekap($unit);

                        foreach ($data_1->result() as $dt1) {
                            $cek_idp = $this->master_model->cek_idp_rekap($tahun, $dt1->nip, $nrp);
                            $cek_fidp = $this->master_model->cek_sent_idp_rekap($tahun, $dt1->nip, $nrp);
                            $hasil = $cek_idp->row()->hasil;
                            $cek = $cek_idp->row()->cek;
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->nip; ?></td>
                                <td><?php echo $dt1->nama_lengkap; ?></td>
                                <td><?php echo $dt1->status_jaya; ?></td>
                                <td>
                                    <?php
                                    if ($cek_fidp->num_rows() > 0) {
                                        if ($cek_fidp->row()->f_sent == '0') {
                                    ?>
                                            <p style="color:red"><b><?php echo $hasil . ' (Belum Submit)'; ?></b></p>
                                        <?php
                                        } else if ($cek_fidp->row()->f_sent == '1' && $cek == 0) {
                                        ?>
                                            <p style="color:green"><b><?php echo $hasil . ' (Sudah Submit)'; ?></b></p>
                                        <?php
                                        } else {
                                        ?>
                                            <p style="color:green"><?php echo $hasil . ' (Sudah Submit & Sudah Diisi)'; ?></p>
                                    <?php
                                        }
                                    } else {
                                        echo 'Belum Diisi';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($cek_fidp->num_rows() > 0 && $cek_fidp->row()->f_sent == '1' && $cek == -4) { ?>
                                        <a class="btn bg-gray btn-flat" href="<?php echo base_url(); ?>people_rev/entry_idp2/<?php echo $tahun; ?>/<?php echo $dt1->nip; ?>" title="Detail IDP <?php echo $dt1->nama_lengkap; ?>">
                                            <i class="fa fa-search"></i>
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