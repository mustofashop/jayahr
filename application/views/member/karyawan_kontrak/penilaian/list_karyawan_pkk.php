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
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->department; ?></td>
                                <td><?php echo $dt->job_grade; ?></td>
                                <td>
                                    <!-- view -->
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>Pengaturan_pkk/form_penilaian/<?php echo $dt->id_karyawan; ?>/<?php echo $dt->nip; ?>/<?php echo $dt->flag_jenis_form; ?>" title="Set PKK <?php echo $dt->nama_lengkap; ?>">
                                        <i class="fa fa-plus"></i>
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