<script type="text/javascript">
$(document).ready(function(){
    // $("#tambah").click(function(){
	// 	$('#id_user').val('');
    //     $('#nama_lengkap').val('');
    //     $('#nip').val('');
    //     $('#no_telepon').val('');
    //     $('#badgenumber').val('');
    // });
});
function editUsers(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_guru",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_user_sekolah').val(data.id_user_sekolah);
            $('#nama').val(data.nama);
            $('#badgenumber').val(data.badgenumber);
            $('#userid').val(data.userid);
            $('#no_telepon').val(data.no_telepon);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-12">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('msg_error')): ?>
            <div class="alert alert-danger alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_error'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" href="<?php echo base_url(); ?>/sekolah/tambah_userid_guru/<?php echo $id_sekolah; ?>"><i class="fa fa-plus"></i> Tambah USERID</a>
                <a class="btn btn-app" href="<?php echo base_url(); ?>/sekolah/export_guru/<?php echo $id_sekolah; ?>"><i class="fa fa-file-excel-o"></i> Export Guru</a>
                <a class="btn btn-app" href="<?php echo base_url(); ?>/sekolah/hapus_guru/<?php echo $id_sekolah; ?>" onClick="return confirm('Anda yakin ingin menghapus semua data ini?')"><i class="fa fa-trash"></i> Hapus Guru</a>
                <!-- <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data</a> -->
                <!-- <div class="box-tools pull-right">
                    <button>test</button>
                </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Guru</th>
                        <th>Badgenumber</th>
                        <th>Userid</th>
                        <th>Nama Guru</th>
                        <th>No Telepon Guru</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        foreach ($data->result() as $dt) {
                    ?>
                    <tr>
                        <td><?php echo $dt->id_user_sekolah; ?></td>
                        <td><?php echo $dt->badgenumber; ?></td>
                        <td><?php echo $dt->userid; ?></td>
                        <td><?php echo $dt->name; ?></td>
                        <td><?php echo $dt->no_telepon; ?></td>
                        <td>
                            <a class="btn bg-olive btn-flat" href="#modal-tambah" onclick="javascript:editUsers('<?php echo $dt->id_user_sekolah;?>')" data-toggle="modal" title="Edit">
                                 <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/password_guru/<?php echo $dt->id_user_sekolah; ?>" title="Update Password (1234)">
                                <i class="fa fa-key"></i>
                            </a>
                            <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>sekolah/userid_guru/<?php echo $dt->id_user_sekolah; ?>/<?php echo $dt->badgenumber; ?>" title="Ambil userid dari USERINFO">
                                <i class="fa fa-user"></i>
                            </a>
                            <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>sekolah/delete_guru/<?php echo $dt->id_user_sekolah; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus Data">
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
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_guru">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Guru *jika tidak ada isi angka 0</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Guru</label>
                                <input type="hidden" name="id_user_sekolah" id="id_user_sekolah">
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Userid</label>
                                <input type="text" class="form-control" id="userid" name="userid" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Badgenumber</label>
                                <input type="text" class="form-control" id="badgenumber" name="badgenumber" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">No Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required="required">
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