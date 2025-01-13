<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg2')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg2'); ?>
            </div>
        <?php endif; ?> 
        <div class="box">
            <div class="box-header">
                <a data-toggle="modal" data-target="#modal1" class="btn btn-app margin"><i class="fa fa-plus"></i> Tambah Level</a>
                <a href="<?php echo base_url(); ?>level_e" class="btn btn-app margin">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->level_e_model->list_level_detail($perusahaan);
                            foreach ($data->result() as $dt) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->kode_level_e ?> | <?php echo $dt->nama_level_e; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>level_e/hapus_detail_mapping/<?php echo $dt->id_level_e_trans; ?>" class="btn btn-flat bg-red" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
    </div>
</div>
<!-- modal1 -->
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>level_e/simpan_mapping_level" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Level | bisa pilih beberapa</label>
                        <input type="hidden" name="perusahaan" value="<?php echo $perusahaan; ?>">
                        <select name="level[]" id="" class="form-control select2" multiple="multiple" required="required" style="width:100%;">
                            <?php
                                $l = $this->level_e_model->list_level_ne($perusahaan);
                                foreach($l->result() as $lvl){
                            ?>
                                <option value="<?php echo $lvl->kode_level_e; ?>"><?php echo $lvl->kode_level_e; ?> | <?php echo $lvl->nama_level_e; ?></option>
                            <?php
                                }
                            ?>
                        </select>
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