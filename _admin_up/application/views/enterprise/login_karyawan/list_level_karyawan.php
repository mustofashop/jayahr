<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app btn-margin" href="<?php echo base_url(); ?>users_k/list_user_karyawan?perusahaan=<?php echo $id_p; ?>">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
                <a class="btn btn-app btn-margin" data-toggle="modal" data-target="#modal-default">
                    <i class="fa fa-plus"></i>
                    Tambah Level
                </a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $data   = $this->enterprise_model->list_level_user($id_k);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $dt->nama_level_e; ?></td>
                                <td>
                                    <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>users_k/hapus_level_user/<?php echo $dt->id_level_login; ?>" title="Hapus <?php echo $dt->nama_level_e; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
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
                    <h4 class="modal-title"><?php echo $header; ?> | Tambah Level</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="karyawan" value="<?php echo $id_k; ?>">
                        <label for="">Level</label>
                        <select name="level[]" class="form-control select2" multiple="multiple" required="required" style="width:100%;">
                            <?php
                                $data = $this->enterprise_model->list_level_user_ne($id_k,$id_p);
                                foreach($data->result() as $dt){
                            ?>
                                <option value="<?php echo $dt->kode_level_e; ?>"><?php echo $dt->nama_level_e; ?></option>
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
        </form>
    </div>
</div>
<!-- end modal -->