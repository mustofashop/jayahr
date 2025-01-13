<script type="text/javascript">
function Tahun_a(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_daftar_ujian",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_ujian').val(data.id_ujian);
            $('#nama_ujian').val(data.judul_ujian);
            $('#tahun').val(data.tahun_ajaran);
            $('#semester').val(data.semester);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-8">
    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Judul Ujian</td>
                            <td>Tahun Ajaran</td>
                            <td>Semester</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = '1';
                            foreach($data->result() as $dt){ ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->judul_ujian; ?></td>
                                <td><?php echo $dt->tahun_ajaran; ?></td>
                                <?php if($dt->semester == '1'){ ?>
                                    <td>Ganjil</td>
                                <?php }else{ ?>
                                    <td>Genap</td>
                                <?php } ?>
                                <td>
                                    <a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Tahun_a('<?php echo $dt->id_ujian;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_daftar_ujian/<?php echo $dt->id_ujian; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_daftar_ujian" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Daftar Ujian</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Ujian</label>
                        <input type="hidden" name="id_ujian" id="id_ujian">
                        <input type="hidden" name="id_jenis" id="id_jenis" value="<?php echo $id_jenis; ?>">
                        <input type="text" name="nama_ujian" id="nama_ujian" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="tahun ajaran">Tahun Ajaran</label>
                        <select class="form-control" name="tahun" id="tahun" required="required" style="width: 100%;">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php 
                                $data       = $this->sischool_model->get_tahun_ajaran();
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->tahun_ajaran; ?>"><?php echo $dt->tahun_ajaran; ?></option>
                            <?php } ?>
                        </select>        
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value="1">Ganjil</option>
                            <option value="2">Genap</option>
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