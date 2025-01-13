<script type="text/javascript">
$(document).ready(function(){
    $("#tambah").click(function(){
		$('#id_user').val('');
        $('#nama_lengkap').val('');
        $('#nip').val('');
        $('#no_telepon').val('');
        $('#badgenumber').val('');
    });
});
function editUsers(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/users/edit_guru",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_user').val(data.id_user);
            $('#badgenumber').val(data.badgenumber);
            $('#nama_lengkap').val(data.nama_lengkap);
            $('#nip').val(data.nip);
            $('#no_telepon').val(data.no_telepon);
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
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data</a>
                <a class="btn btn-app" id="import" data-toggle="modal" data-target="#modal-import"><i class="fa fa-file-excel-o"></i> Import Data</a>
                <a class="btn btn-app" id="walas" data-toggle="modal" data-target="#modal-walas"><i class="fa fa-user"></i> Walas</a>
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
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Username</th>
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
                        <?php if($dt->level == '6'){ ?>
                            <!-- <td><?php echo $dt->nama_lengkap; ?> | <?php echo $dt->nama_kelas; ?></td> -->
                            <td><?php echo $dt->nama_lengkap; ?></td>
                        <?php }else{ ?>
                            <td><?php echo $dt->nama_lengkap; ?></td>
                        <?php } ?>
                        <td><?php echo $dt->nip; ?></td>
                        <td><?php echo $dt->username; ?></td>
                        <td><?php echo $dt->ip_sekolah; ?></td>
                        <td>
                            <?php if($dt->level != '6'){ ?>
                                <a class="btn bg-olive btn-flat" href="#modal-tambah" onclick="javascript:editUsers('<?php echo $dt->id_user_sekolah;?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <?php } ?>
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
<!-- modal tambah -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>users/save_guru">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input type="hidden" name="id_user" id="id_user">
                        <input type="hidden" name="id_sekolah" value="<?php echo $id_sekolah; ?>">
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Badgenumber</label>
                        <input type="text" class="form-control" id="badgenumber" name="badgenumber" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No Telepon</label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" required="required">
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
<!-- modal import -->
<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>users/import_guru" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="text">Sample Upload</label>
                        <div class="row">
                            <div class="col-md-6">
                                <a class="btn btn-block btn-social bg-blue" href="<?php echo site_url('..\assets\excel\sample_upload_guru.xlsx');?>" download class="btn btn-default">
                                <i class="fa fa-download"></i>Download</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="id_sekolah" value="<?php echo $id_sekolah; ?>">
                        <label for="import">Import Guru</label>
                        <div class="col-md-12">
                            <?php echo form_upload('file_excel');?>
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
<!-- modal tambah -->
<div class="modal fade" id="modal-walas">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>users/save_walas">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Guru</label>
                        <input type="hidden" name="id_user" id="id_user">
                        <input type="hidden" name="id_sekolah" value="<?php echo $id_sekolah; ?>">
                        <select class="form-control" name="walas" id="walas" required="required" style="width: 100%;">
                            <option value="">-- Pilih Guru --</option>
                            <?php 
                                $data = $this->sischool_model->get_guru($id_sekolah);
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->no_telepon; ?>"><?php echo $dt->nama_lengkap; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Kelas</label>   
                        <select class="form-control" name="kelas" id="kelas" required="required" style="width: 100%;">
                            <option value="">-- Pilih Kelas --</option>
                            <?php 
                                $data = $this->sischool_model->get_kelas($id_sekolah);
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->kode_kelas; ?>"><?php echo $dt->nama_kelas; ?></option>
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