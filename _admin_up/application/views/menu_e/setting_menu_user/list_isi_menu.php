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
                <a class="btn btn-app" data-toggle="modal" data-target="#modal">
                    <i class="fa fa-plus"></i> 
                    Tambah Isi Menu
                </a>
                <a class="btn btn-app" href="<?php echo base_url(); ?>setting_menu_e/setting_menu_u/<?php echo $id_k; ?>/<?php echo $id_p; ?>">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Isi Menu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->menu_e_model->list_isi_menu_user($id_pr,$id_k);
                            foreach($data->result() as $dt){ 
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_menu; ?></td>
                                <td>
                                <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>setting_menu_e/delete_isi_menu_user/<?php echo $dt->id_menu_e_user; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Isi Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>setting_menu_e/simpan_isi_menu_user">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Isi Menu | *bisa pilih beberapa</label>
                        <input type="hidden" name="id_menu_parent" value="<?php echo $id_pr; ?>">
                        <input type="hidden" name="id_karyawan" value="<?php echo $id_k; ?>">
                        <select class="form-control select2" name="isi[]" multiple="multiple" data-placeholder="Pilih Menu" required="required" style="width: 100%;">
                            <?php
                                $list_isi   = $this->menu_e_model->list_isi_menu_user_ne($id_pr,$id_k);
                                foreach($list_isi->result() as $li){
                            ?>
                                <option value="<?php echo $li->id_menu; ?>"><?php echo $li->nama_menu; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>