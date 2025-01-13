<div class="box">
    <div class="box-header">
        <a id="tambah" data-toggle="modal" data-target="#tambah-kategori" class="btn bg-blue btn-flat margin">Tambah</a>
        <a href="<?php echo base_url(); ?>menu/setting_menu" class="btn bg-yellow btn-flat margin">Kembali</a>
    </div>
    <div class="box-body">
        <form id="checkform">
            <label>List Menu</label>
            <table id="list" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori Menu</th>
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
                        <td><?php echo $dt->nama_parent; ?></td>
                        <td><a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>menu/delete_menu_sekolah/<?php echo $dt->id_trans_menu; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a class="btn bg-green btn-flat" href="<?php echo base_url(); ?>menu/add_submenu_sekolah/<?php echo $dt->id_parent; ?>/<?php echo $id_s; ?>" title="Hapus">
                                Tambah Sub Menu
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu/save_category_setting_menu">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_sekolah" id="id_sekolah" value="<?php echo $id_s; ?>">
                        <label for="exampleInputEmail1">Nama Kategori <i>*Bisa Klik Beberapa Kategori</i></label>
                        <select class="form-control select2" name="kategori[]" id="kategori" multiple="multiple" data-placeholder="Pilih Menu" required="required" style="width: 100%;">
                            <?php 
                                $datas = $this->sischool_model->get_parent_menu();
                                foreach ($datas->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_parent; ?>"><?php echo $dt->nama_parent; ?></option>
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
<script type="text/javascript">

$(document).ready(function () {
    $('#list').DataTable()
});

</script>