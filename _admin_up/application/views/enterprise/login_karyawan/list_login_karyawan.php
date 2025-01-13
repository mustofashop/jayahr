<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
		
        <a class="btn btn-app" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah User</a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Karyawan</td>
                    <td>Job Grade</td>
                    <td>Job Title</td>
                    <td>Status</td>
                    <td>Level Login</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->enterprise_model->list_users_karyawan($perusahaan);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama_lengkap; ?></td>
                        <td><?php echo $dt->job_grade; ?></td>
                        <td><?php echo $dt->job_title; ?></td>
                        <td><?php echo $dt->status_jaya; ?></td>
                        <td><?php echo $dt->nama_level; ?></td>
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>users_k/edit_level/<?php echo $dt->id_karyawan ?>/<?php echo $perusahaan; ?>" title="Edit Level <?php echo $dt->nama_lengkap; ?>">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- reset password -->
                            <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>Enterprise/karyawan/reset_password/<?php echo $dt->id_karyawan; ?>" onClick="return confirm('Anda yakin ingin mereset password <?php echo $dt->nama_lengkap; ?> ?')" title="Reset Password (1234)">
                                <i class="fa fa-key"></i>
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>users_k/delete_user_k/<?php echo $dt->id_karyawan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                <i class="fa fa-trash"></i>
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
<!-- modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>users_k/simpan_level_user" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Tambah User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Karyawan</label>
                        <select name="karyawan" class="form-control select2" required="required" style="width:100%;">
                            <option value="">-- Pilih --</option>
                            <?php
                                $k  = $this->enterprise_model->list_user_karyawan($perusahaan);
                                foreach ($k->result() as $dk) {
                            ?>
                                    <option value="<?php echo $dk->id_karyawan; ?>"><?php echo $dk->nama_lengkap; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Level</label>
                        <select name="level[]" class="form-control select2" multiple="multiple" required="required" style="width:100%;">
                            <?php 
                                $list_l = $this->level_e_model->list_level_detail($perusahaan);
                                foreach($list_l->result() as $ll){
                            ?>
                                <option value="<?php echo $ll->kode_level_e; ?>"><?php echo $ll->nama_level_e; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->