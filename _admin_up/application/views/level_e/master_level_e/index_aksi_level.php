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
                <a data-toggle="modal" data-target="#modal" class="btn btn-app margin"><i class="fa fa-plus"></i> Tambah Aksi</a>
                <a href="<?php echo base_url(); ?>level_e" class="btn btn-app margin">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>Nama Aksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $data   = $this->level_e_model->list_aksi_level($kode_level);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $dt->aksi; ?></td>
                                <td>
                                    <!-- hapus -->
                                    <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>level_e/hapus_aksi_level/<?php echo $dt->id_level_e_aksi ?>" title="Hapus Aksi" onClick="return confirm('Anda yakin ingin data ini?')">
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
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>level_e/simpan_aksi_level" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Aksi</label>
                        <input type="hidden" name="kode_level_e" value="<?php echo $kode_level; ?>">
                        <select name="aksi[]" class="form-control select2" multiple="multiple" required="required" style="width:100%;">
                            <option value="1">Tambah Data</option>
                            <option value="2">Lihat Data</option>
                            <option value="3">Edit Data</option>
                            <option value="4">Hapus Data</option>
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
</div>
<!-- end modal -->