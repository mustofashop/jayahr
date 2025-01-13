<script type="text/javascript">
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_ekskul",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_ekskul').val(data.id_ekskul);
            $('#nama').val(data.nama_ekskul);
		}
	});
}
</script>
<?php if($this->session->flashdata('msg_input')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_input'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Ekskul</a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Ekskul</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = '1';
                    foreach($data->result() as $dt){ ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dt->nama_ekskul; ?></td>
                            <td>
                                <!-- edit -->
                                <a class="btn bg-olive btn-flat" href="#modal-edit" onclick="javascript:Edit('<?php echo $dt->id_ekskul;?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- modal edit -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_edit_ekskul">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_ekskul" id="id_ekskul">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Ekskul" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_ekskul" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body pre-scrollable">
                    <div class="row clearfix" id="formperusahaan">
                        <div class="col-sm-12">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama[]" placeholder="Nama Ekskul" required="required"/>
                                    </div>
                                </div>
                            </div>
                            <button class="add_field_button btn bg-blue btn-flat" type="button">
                                <i class="fa fa-plus"></i>
                            </button>
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
<script type="text/javascript">
    var max_fields      = 100; //maximum input boxes allowed
	var wrapper   		= $("#formperusahaan"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="col-sm-12"><div class="col-sm-10"><div class="form-group"><div class="form-line"><input type="text" class="form-control" name="nama[]" placeholder="Nama Ekskul" /></div></div></div><button class="remove_field btn bg-red btn-flat" type="button"><i class="fa fa-times"></i></button></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
</script>