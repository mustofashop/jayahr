<?php if($this->session->flashdata('msg_p')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_p'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a id="tambah" data-toggle="modal" data-target="#tambah-kategori" class="btn bg-blue btn-flat margin">Tambah</a>
        <a href="<?php echo base_url(); ?>menu/child_menu" class="btn bg-yellow btn-flat margin">Kembali</a>
    </div>
    <div class="box-body">
        <form id="checkform">
            <label>List Menu</label>
            <table id="list" class="table table-bordered table-striped">
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
                        foreach ($list as $dt) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $dt->level; ?></td>
                        <td><a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>menu/delete_level_isi_menu/<?php echo $dt->id_isi_menu_level; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<!-- /.modal -->
<div class="modal fade" id="tambah-kategori">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu/save_level_isi_menu">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_menu" id="id_menu" value="<?php echo $id_menu; ?>">
                        <label for="exampleInputEmail1">Nama Level <i>*Bisa Klik Beberapa Level</i></label>
                        <select class="form-control select2" name="level[]" id="level" multiple="multiple" data-placeholder="Pilih Menu" required="required" style="width: 100%;">
                            <option value="0">Admin Sekolah</option>
                            <option value="1">Yayasan</option>
                            <option value="2">Kepsek</option>
                            <option value="3">Guru</option>
                            <option value="4">TU</option>
                            <option value="5">BP</option>
                            <option value="6">Walas</option>
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