<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" data-toggle="modal" data-target="#tambah">
            <i class="fa fa-plus"></i> Tambah
        </a>
        <a class="btn btn-app" href="<?php echo base_url(); ?>setting_menu_e">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="box-body">
        <table id="list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu Utama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no     = 1;
                    $list   = $this->menu_e_model->list_trans_menu_utama($p);
                    foreach ($list->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $dt->nama_parent; ?></td>
                    <td>
                        <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>setting_menu_e/delete_menu_e/<?php echo $dt->id_trans_parent_menu; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                        <a class="btn bg-green btn-flat" href="<?php echo base_url(); ?>setting_menu_e/list_submenu/<?php echo $dt->id_trans_parent_menu; ?>/<?php echo $dt->id_menu_parent; ?>/<?php echo $p; ?>" title="Hapus">
                            Tambah Sub Menu
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.modal -->
<div class="modal fade" id="tambah">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>setting_menu_e/simpan_menu_utama">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Tambah</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="perusahaan" id="perusahaan" value="<?php echo $p; ?>">
                        <label for="menu_u">Menu Utama <i>*Bisa Klik Beberapa Menu</i></label>
                        <select class="form-control select2" name="menu_u[]" id="menu_u" multiple="multiple" data-placeholder="Pilih Menu" required="required" style="width: 100%;">
                            <?php 
                                $datas = $this->menu_e_model->list_menu_utama();
                                foreach ($datas->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_menu_parent; ?>"><?php echo $dt->nama_parent; ?></option>
                            <?php } ?>
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