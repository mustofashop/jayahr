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
        <a class="btn btn-app" href="<?php echo base_url(); ?>people_rev">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>

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

                        $no     = 1;
                        $status = 0;
                        $nrp    = $this->session->userdata('nrp');
                        $data_1 = $this->master_model->list_member($nrp);
                        foreach ($data_1->result() as $dt1) {

                            $cek_idp = $this->master_model->cek_idp($tahun, $dt1->nip, $nrp);
                            $cek_fidp = $this->master_model->cek_sent_idp($tahun, $dt1->nip, $nrp);
                            $hasil = $cek_idp->row()->hasil;
                            $cek = $cek_idp->row()->cek;

                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->nip; ?></td>
                                <td><?php echo $dt1->nama_lengkap; ?></td>
                                <td><?php echo $dt1->status_jaya; ?></td>
                                <td><?php
                                    if ($cek_fidp->num_rows() > 0 && $cek == 0) {
                                        if ($cek_fidp->row()->f_sent == '0') { ?>
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
                                    <!-- lihat IDP -->
                                    <?php if ($cek_fidp->num_rows() > 0 && $cek_fidp->row()->f_sent == '1' && $cek == 0) { ?>
                                        <a class="btn bg-gray btn-flat" href="<?php echo base_url(); ?>people_rev/entry_idp/<?php echo $tahun; ?>/<?php echo $dt1->nip; ?>" title="Detail IDP <?php echo $dt1->nama_lengkap; ?>">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    <?php } ?>
                                    <!-- Sent IDP -->
                                    <?php if ($cek_fidp->num_rows() > 0 && $cek_fidp->row()->f_sent == '0') { ?>
                                        <a class="btn bg-green btn-flat" href="<?php echo base_url(); ?>people_rev/entry_idp/<?php echo $tahun; ?>/<?php echo $dt1->nip; ?>" title="Detail IDP <?php echo $dt1->nama_lengkap; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>people_rev/sent_idp/<?php echo $tahun; ?>/<?php echo $dt1->nip; ?>/<?php echo $nrp; ?>" onClick="return confirm('Anda yakin ingin submit penilaian ini?')" title="Submit">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    <?php } ?>
                                    <!-- lihat IDP -->
                                    <?php if ($cek > 0) { ?>
                                        <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>people_rev/entry_idp/<?php echo $tahun; ?>/<?php echo $dt1->nip; ?>" title="Isi IDP <?php echo $dt1->nama_lengkap; ?>">
                                            <i class="fa fa-plus"></i>
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