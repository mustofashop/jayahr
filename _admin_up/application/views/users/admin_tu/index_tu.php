<script type="text/javascript">
$(document).ready(function(){
    $("#tambah").click(function(){
		$('#id_user').val('');
        $('#nama_lengkap').val('');
        $('#username').val('');
        $('#password').val('');
    });
});
function editUsers(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/users/edit_admin_sekolah",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_user').val(data.id_user);
            $('#sekolah').val(data.id_sekolah);
            $('#nama_lengkap').val(data.nama_lengkap);
            $('#username').val(data.username);
            $('#leader').val(data.leader);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-12">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <!-- <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-parent"><i class="fa fa-plus"></i> Tambah Data (lebih dari 1 sekolah)</a> -->
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-add1"><i class="fa fa-plus"></i> Tambah Data</a>
                <!-- <div class="box-tools pull-right">
                    <button>test</button>
                </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Sekolah</th>
                        <th>IP Sekolah</th>
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
                        <td><?php echo $dt->username; ?></td>
                        <td><?php echo $dt->nama_sekolah; ?></td>
                        <td><?php echo $dt->ip_sekolah; ?></td>
                        <td>
                            <!-- <?php if($dt->id_sekolah == '0'){ ?>
                                <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>users/edit_user_tu/<?php echo $dt->id_user_sekolah;?>" title="Edit">
                                <i class="fa fa-pencil"></i>
                                </a>
                            <?php }else{ ?> -->
                                <a class="btn bg-olive btn-flat" href="#modal-add1" onclick="javascript:editUsers('<?php echo $dt->id_user_sekolah;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                                </a>
                            <!-- <?php } ?> -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>users/delete_user/<?php echo $dt->id_user_sekolah; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box parent menu -->
    </div>
</div>
<div class="modal fade" id="modal-parent">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>users/save_admin_tu">
            <div class="modal-content modal-lg">
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
                                <label for="exampleInputEmail1">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Username</label>
                                <input type="text" class="form-control" name="username" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" class="form-control" name="password" required="required">
                            </div>
                            <div class="form-group">
                                <label for="leader">Status Leader</label>
                                <select name="leader" class="form-control" required="required">
                                    <option value="">-- Status Leader</option>
                                    <option value="0">Bukan Leader</option>
                                    <option value="1">Leader (Approve Keuangan)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row" id="list_sekolah">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Sekolah</label>
                                        <select class="form-control" name="sekolah[]" required="required" style="width: 100%;">
                                            <?php 
                                                $data = $this->sischool_model->get_sekolah();
                                                foreach ($data->result() as $dt) {
                                                ?>
                                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="button" class="add_field_button btn btn-success">Tambah</button>
                                </div>
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
<script type="text/javascript">
$(document).ready(function() {
	var max_fields      = 100; //maximum input boxes allowed
	var wrapper   		= $("#list_sekolah"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="col-md-12"><div class="form-group"><label for="exampleInputEmail1">Nama Sekolah</label><select class="form-control" name="sekolah[]" required="required" style="width: 100%;"><?php $data=$this->sischool_model->get_sekolah();foreach ($data->result() as $dt) {?><option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option><?php } ?></select></div><button type="button" class="remove_field btn btn-danger">hapus</button></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
</script>
<div class="modal fade" id="modal-add1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>users/save_admin_tu_1">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Sekolah</label>
                            <select class="form-control" name="sekolah" id="sekolah" required="required" style="width: 100%;">
                                <?php 
                                    $data = $this->sischool_model->get_sekolah();
                                    foreach ($data->result() as $dt) {
                                    ?>
                                        <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required="required">
                            <input type="hidden" name="id_user" id="id_user">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required="required">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required="required">
                        </div>
                        <div class="form-group">
                            <label for="leader">Status Leader</label>
                            <select name="leader" id="leader" class="form-control" required="required">
                                <option value="">-- Status Leader</option>
                                <option value="0">Bukan Leader</option>
                                <option value="1">Leader (Approve Keuangan)</option>
                            </select>
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