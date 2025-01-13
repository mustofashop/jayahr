<script type="text/javascript">
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/master/edit_ca",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#ids').val(data.id);
            $('#userid').val(data.userid);
            $('#checktime').val(data.checktime);
            $('#checktype').val(data.checktype);
            $('#waktu_server').val(data.waktu_server);
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
        <h3><?php echo $nama; ?> | <?php echo $bulans; ?></h3> 
        <!-- <a class="btn bg-olive btn-flat" href="#modal-excel" data-toggle="modal" title="Upload Excel">
            Upload Excel
        </a>     -->
    </div>
    <div class="box-body">
        <table id="isi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Userid</th>
                    <th>Checktime</th>
                    <th>Checktype</th>
                    <th>Waktu Server</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    foreach ($data->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $dt->userid; ?></td>
                    <td><?php echo $dt->checktime; ?></td>
                    <?php if($dt->checktime == '0'){ ?>
                        <td>Masuk</td>
                    <?php }else{ ?>
                        <td>Keluar</td>
                    <?php } ?>
                    <td><?php echo $dt->waktu_server; ?></td>
                    <td><a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <!-- <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>master/delete_adms/<?php echo $dt->id; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a> -->
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modals">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/save_ca">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Userid</label>
                        <input type="text" class="form-control" id="userid" name="userid" required="required">
                        <input type="hidden" name="id" id="ids">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Checktime</label>
                        <input type="text" class="form-control" id="checktime" name="checktime" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Checktype</label>
                        <select name="checktype" id="checktype" class="form-control" required="required">
                            <option value="0">Masuk</option>
                            <option value="1">Keluar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Waktu Server</label>
                        <input type="text" class="form-control" id="waktu_server" name="waktu_server" required="required">
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