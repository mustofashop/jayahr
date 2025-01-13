<script>
function goBack() {
  window.history.back();
}
</script>
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
        <a class="btn btn-app" onclick="goBack()">
            <i class="fa fa-arrow-left"></i> Kembali
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
                    $data   = $this->menu_e_model->list_trans_isi_menu($id_tpm);
                    foreach ($data->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $dt->nama_menu; ?></td>
                    <td><a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>setting_menu_e/delete_isi_menu/<?php echo $dt->id_trans_menu; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>setting_menu_e/simpan_isi_menu">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Tambah</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="perusahaan" value="<?php echo $id_p; ?>">
                    <input type="hidden" name="id_trans_parent_menu" value="<?php echo $id_tpm; ?>">
                    <label for="">Menu</label>
                    <select name="id_menu[]" id="id_menu" class="form-control select2" multiple="multiple" required="required" style="width: 100%;">
                        <?php
                            $isi_menu = $this->menu_e_model->list_isi_menu($id_pm);
                            foreach($isi_menu->result() as $im){
                        ?>
                            <option value="<?php echo $im->id_menu; ?>"><?php echo $im->nama_menu; ?></option>
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
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->