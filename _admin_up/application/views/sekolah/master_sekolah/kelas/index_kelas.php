<script type="text/javascript">
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_kelas",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#kode').val(data.kode_kelas);
            $('#singkat').val(data.singkat);
            $('#sub').val(data.sub_singkat);
		}
	});
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
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah Kelas</a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Kode Kelas</td>
                    <td>Nama Kelas</td>
                    <td>Singkat</td>
                    <td>Sub Singkat</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach($data->result() as $dt){ ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $dt->kode_kelas; ?></td>
                        <td><?php echo $dt->nama_kelas; ?></td>
                        <td><?php echo $dt->singkat; ?></td>
                        <td><?php echo $dt->sub_singkat; ?></td>
                        <td>
                            <a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->kode_kelas;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_kelas/<?php echo $dt->kode_kelas; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_kelas" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="formKelas">
                        <div class="isi">
                            <input type="hidden" name="ids" value="<?php echo $id_sekolah; ?>">
                            <input type="text" name="singkat[]" placeholder="Singkat" required="required">
                            <input type="text" name="subsingkat[]" placeholder="Sub Singkat" required="required">
                            <a class="add_field_button btn bg-olive btn-flat" title="Tambah">
                                <i class="fa fa-plus"></i>
                            </a>
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
<div class="modal fade" id="modals">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_edit_kelas" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Singkat</label>
                        <input type="hidden" name="kode" id="kode">
                        <input type="text" class="form-control" name="singkat" id="singkat">
                    </div>
                    <div class="form-group">
                        <label for="sub">Sub Singkat</label>
                        <input type="text" class="form-control" name="sub" id="sub">
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
$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $("#formKelas"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="isi"><input type="text" name="singkat[]" placeholder="Singkat" required="required">&nbsp;<input type="text" name="subsingkat[]" placeholder="Sub Singkat" required="required">&nbsp;<a class="remove_field btn bg-maroon btn-flat" title="Tambah"><i class="fa fa-minus"></i></a></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
</script>