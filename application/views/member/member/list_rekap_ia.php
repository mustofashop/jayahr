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
        <a class="btn btn-app" href="<?php echo base_url(); ?>lap_inass/rekap_ia">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <!-- <a class="btn bg-red btn-flat margin" href="<?php echo base_url(); ?>Int_assessment/download_rekap_ia/<?php echo $tahun; ?>/<?php echo $nrp; ?>">
            <i class="fa fa-download"></i>
            Download data
        </a> -->
        <?php

        if ($this->session->userdata('level') == '1') {    ?>
            <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>Int_assessment/download_rekap_ia_old/<?php echo $tahun; ?>/<?php echo $nrp; ?>">
                <i class="fa fa-download"></i>
                Download data
            </a>
        <?php } else { ?>
            <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>Int_assessment/download_rekap_ia_admin/<?php echo $unit; ?>/<?php echo $nrp; ?>">
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
                            <!-- <th>Inass</th> -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $no     = 1;
                        $status = 0;
                        $nrp    = $this->session->userdata('nrp');
                        $data_1 = $this->master_model->list_member_rekap($unit);
                        foreach ($data_1->result() as $dt1) {

                            $cek_finass = $this->master_model->cek_sent_inass($tahun, $dt1->nip, $nrp);
                            $cek_finass2 = $this->master_model->cek_sent_inass_rekap($tahun, $dt1->nip);
                            // $hasil = $cek_finass2->row()->hasil;

                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->nip; ?></td>
                                <td><?php echo $dt1->nama_lengkap; ?></td>
                                <td><?php echo $dt1->status_jaya; ?></td>
                                <!-- <td><?php
                                            if ($cek_finass2->num_rows() > 0) {
                                                if ($cek_finass2->row()->f_sent == '0') { ?>
                                            <p style="color:red"><b> <?php echo $hasil . ' (Belum Submit)'; ?> </b></p>
                                        <?php } else { ?>
                                            <p style="color:green"> <?php echo $hasil . ' (Sudah Submit)'; ?> </p>
                                    <?php }
                                            } else {
                                                echo 'Belum Diisi';
                                            }
                                    ?>
                                </td> -->
                                <td>
                                    <!-- lihat -->
                                    <?php if ($cek_finass2->num_rows() > 0 && $cek_finass2->row()->f_sent == '1') {
                                    ?> <a class="btn btn-flat bg-gray" href="<?php echo base_url(); ?>int_assessment/lihat_inass2/<?php echo $dt1->nip; ?>/<?php echo $tahun; ?>" title="Lihat <?php echo $dt1->nama_lengkap; ?>">
                                            <i class="fa fa-search"></i>
                                        </a> <?php

                                            } ?>
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