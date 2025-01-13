<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('msg_error')): ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a id="tambah" data-toggle="modal" data-target="#tambah-kategori" class="btn bg-blue btn-flat margin">Tambah Manual</a>
        <a href="<?php echo base_url(); ?>menu/tambah_submenu_default/<?php echo $id_parent; ?>/<?php echo $sekolah; ?>" class="btn bg-yellow btn-flat margin">Tambah Default</a>
    </div>
    <div class="box-body">
        <form id="checkform">
            <label>List Menu</label>
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sub Menu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $no     = 1;
                        foreach ($data->result() as $dt) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $dt->nama_menu; ?></td>
                        <td><a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>menu/delete_submenu_sekolah/<?php echo $dt->id_trans_menu_sub; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu/save_submenu_sekolah">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_sekolah" id="id_sekolah" value="<?php echo $sekolah; ?>">
                        <label for="exampleInputEmail1">Nama Sub Menu <i>*Bisa Klik Beberapa Submenu</i></label>
                        <select class="form-control select2" name="menu[]" id="menu" multiple="multiple" data-placeholder="Pilih Menu" required="required" style="width: 100%;">
                            <?php 
                                $datas = $this->sischool_model->get_submenu($id_parent);
                                foreach ($datas->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_menu; ?>"><?php echo $dt->nama_menu; ?></option>
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