<script type="text/javascript">
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/master/edit_izin",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#ids').val(data.izin_id);
            $('#izin_tgl_awal').val(data.izin_tgl_awal);
            $('#izin_tgl_akhir').val(data.izin_tgl_akhir);
            $('#izin_jenis_id').val(data.izin_jenis_id);
            $('#izin_catatan').val(data.izin_catatan);
		}
	});
}
</script>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class='box-header'>
        <h3>List Izin | <?php echo $bulans; ?></h3> 
        <!-- <a class="btn bg-olive btn-flat" href="#modal-excel" data-toggle="modal" title="Upload Excel">
            Upload Excel
        </a>     -->
    </div>
    <div class="box-body">
        <table id="isi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Userid</th>
                    <th>Tanggal Awal Izin</th>
                    <th>Tanggal Akhir Izin</th>
                    <th>Jenis</th>
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php  
                    foreach ($data->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $dt->nama; ?></td>
                    <td><?php echo $dt->userid; ?></td>
                    <td><?php echo $dt->izin_tgl_awal; ?></td>
                    <td><?php echo $dt->izin_tgl_akhir; ?></td>
                    <td><?php echo $dt->izin_jenis_name; ?></td>
                    <!-- <td><a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->izin_id;?>')" data-toggle="modal" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a> -->
                        <!-- <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>master/delete_adms/<?php echo $dt->id; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a> -->
                    <!-- </td> -->
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modals">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/save_do">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal Awal Izin</label>
                                <input type="date" class="form-control" id="izin_tgl_awal" name="izin_tgl_awal" required="required">
                                <input type="hidden" name="id" id="ids">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal Akhir Izin</label>
                                <input type="date" class="form-control" id="izin_tgl_akhir" name="izin_tgl_akhir" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Status</label>
                                <select name="status" id="status" class="form-control" required="required">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Tidak Hadir">Tidak Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="catatan">Catatan Izin</label>
                                <textarea name="izin_catatan" id="izin_catatan" class="form-control" cols="20" rows="10"></textarea>
                            </div>
                        </div>
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