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
		url		: "<?php echo site_url(); ?>/sekolah/edit_murid",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_murid').val(data.id_murid);
            $('#nama').val(data.nama);
            $('#badgenumber').val(data.badgenumber);
            $('#userid').val(data.userid);
            $('#telepon_murid').val(data.telepon_murid);
            $('#telepon_ortu').val(data.telepon_ortu);
            $('#id_parent').val(data.id_parent);
            $('#no_rekening').val(data.no_rekening);
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
                <a class="btn btn-app" href="<?php echo base_url(); ?>/sekolah/tambah_userid/<?php echo $id_sekolah; ?>"><i class="fa fa-plus"></i> Tambah USERID</a>
                <a class="btn btn-app" id="export" data-toggle="modal" data-target="#modal-export"><i class="fa fa-file-excel-o"></i> Export Murid (PopUp)</a>
                <a class="btn btn-app" id="delete" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash"></i> Hapus Murid (PopUp)</a>
                <!-- <div class="box-tools pull-right">
                    <button>test</button>
                </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>ID Murid</th>
                        <th>Badgenumber</th>
                        <th>Userid</th>
                        <th>Nama Murid</th>
                        <th>VA</th>
                        <th>No Telepon Murid</th>
                        <th>No Telepon Ortu</th>
                        <th>ID Parent</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        foreach ($data->result() as $dt) {
                    ?>
                    <tr>
                        <td><?php echo $dt->nama_kelas; ?></td>
                        <td><?php echo $dt->id_murid; ?></td>
                        <td><?php echo $dt->badgenumber; ?></td>
                        <td><?php echo $dt->userid; ?></td>
                        <td><?php echo $dt->name; ?></td>
                        <td><?php echo $dt->va; ?></td>
                        <td><?php echo $dt->telepon_murid; ?></td>
                        <td><?php echo $dt->telepon_ortu; ?></td>
                        <td><?php echo $dt->id_parent; ?></td>
                        <td>
                            <a class="btn bg-olive btn-flat" href="#modal-tambah" onclick="javascript:editUsers('<?php echo $dt->id_murid;?>')" data-toggle="modal" title="Edit">
                                 <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/password_murid/<?php echo $dt->id_murid; ?>" title="Update Password (1234)">
                                <i class="fa fa-key"></i>
                            </a>
                            <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>sekolah/userid_murid/<?php echo $dt->id_murid; ?>/<?php echo $dt->badgenumber; ?>" title="Ambil userid dari USERINFO">
                                <i class="fa fa-user"></i>
                            </a>
                            <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>sekolah/delete_murid/<?php echo $dt->id_murid; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus Data">
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
<div class="modal fade" id="modal-export">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Export Murid</h4>
            </div>
            <form action="<?php echo base_url(); ?>sekolah/export_murid" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Kelas">Kelas</label>
                        <input type="hidden" name="sekolah" id="sekolah" value="<?php echo $id_sekolah; ?>">
                        <select name="kelas" id="kelas" class="form-control">
                            <option value="0">-- Semua --</option>
                            <?php 
                                $kelas  = $this->sischool_model->get_kelas($id_sekolah);
                                foreach($kelas->result() as $k){ 
                            ?>
                                <option value="<?php echo $k->kode_kelas; ?>"><?php echo $k->nama_kelas; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Export</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus Murid</h4>
            </div>
            <form action="<?php echo base_url(); ?>sekolah/hapus_murid" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Kelas">Kelas</label>
                        <input type="hidden" name="sekolah" id="sekolah" value="<?php echo $id_sekolah; ?>">
                        <select name="kelas" id="kelas" class="form-control">
                            <option value="0">-- Semua --</option>
                            <?php 
                                $kelas  = $this->sischool_model->get_kelas($id_sekolah);
                                foreach($kelas->result() as $k){ 
                            ?>
                                <option value="<?php echo $k->kode_kelas; ?>"><?php echo $k->nama_kelas; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onClick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_murid">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Murid *jika tidak ada isi angka 0</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Murid</label>
                                <input type="hidden" name="id_murid" id="id_murid">
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
                            <div class="form-group">
                                <label for="">No. Rekening</label>
                                <input type="number" class="form-control" name="no_rekening" id="no_rekening">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telepon Murid</label>
                                <input type="text" class="form-control" id="telepon_murid" name="telepon_murid">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telepon Ortu</label>
                                <input type="text" class="form-control" id="telepon_ortu" name="telepon_ortu" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">ID Parent</label>
                                <input type="text" class="form-control" id="id_parent" name="id_parent" required="required">
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