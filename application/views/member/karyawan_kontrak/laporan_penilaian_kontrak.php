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
                            <td>Nama</td>
                            <td>NRP</td>
                            <td>Unit</td>
                            <td>Ceklis</td>
                            <td>Nilai (angka)</td>
                            <td>Kriteria Nilai</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = '1';
                        $status = '0';
                        $data = $this->master_model->list_member_rekap_pkk($unit);
                        foreach ($data->result() as $dt) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->department; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <!-- view -->
                                    <!-- <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->flag_jenis_form; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                        <i class="fa fa-plus"></i>
                                    </a> -->
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