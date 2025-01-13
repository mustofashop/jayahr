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
                <a data-toggle="modal" data-target="#modal1" class="btn btn-app margin"><i class="fa fa-plus"></i> Tambah Level</a>
                <a class="btn btn-app margin" href="<?php echo base_url(); ?>menu_e">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->menu_e_model->list_level_menu_utama($id_m_p); 
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_level; ?></td>
                                <td>
                                    <a class="btn bg-red btn-flat" href="<?php echo base_url() ?>menu_e/delete_level_parent/<?php echo $dt->id_parent_level; ?>" title="delete level" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu_e/simpan_level_menu_utama" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Tambah Level</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_menu_parent" value="<?php echo $id_m_p; ?>">
                    <div class="form-group">
                        <label for="">Level | multiple click</label>
                        <select class="form-control select2" name="level[]" id="level" multiple="multiple" data-placeholder="Pilih Menu" required="required" style="width: 100%;">
                            <option value="1">Admin Head Office</option>
                            <option value="2">Admin Cabang</option>
                            <option value="3">Admin Keuangan</option>
                            <option value="4">Manager Keuangan</option>
                            <option value="5">Admin HRD</option>
                            <option value="6">Customer Service</option>
                            <option value="7">PIC</option>
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