<script type="text/javascript">
function Tahun_a(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_pertanyaan",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_pertanyaan').val(data.id_pertanyaan);
            $('#nama_pertanyaan').val(data.konten_pertanyaan);
            $('#singkat').val(data.kode_kelas);
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
                            <td>Nama Pertanyaan</td>
                            <td>Kelas</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = '1';
                            foreach($data->result() as $dt){ ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->konten_pertanyaan; ?></td>
                                <td><?php echo $dt->kode_kelas; ?></td>
                                <td>
                                    <a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Tahun_a('<?php echo $dt->id_pertanyaan;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_pertanyaan/<?php echo $dt->id_pertanyaan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <!-- active pertanyaan -->
                                    <?php 
                                        $check_active   = $this->sischool_model->get_trans_pertanyaan($dt->id_pertanyaan);
                                        //kalo ada
                                        if($check_active->num_rows() > 0){
                                    ?>
                                        <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>sekolah/cancel_pertanyaan/<?php echo $dt->id_pertanyaan; ?>" onClick="return confirm('Anda yakin ingin mematikan data ini?')" title="Matiin">
                                        <i class="fa fa-times"></i>
                                        </a>
                                    <?php }else{ ?>
                                        <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>sekolah/approve_pertanyaan/<?php echo $dt->id_pertanyaan; ?>/<?php echo $dt->id_sekolah; ?>" title="Aktifin">
                                        <i class="fa fa-check"></i>
                                        </a>
                                    <?php } ?>
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_pertanyaan" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Pertanyaan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Pertanyaan</label>
                        <input type="hidden" name="id_pertanyaan" id="id_pertanyaan">
                        <input type="hidden" name="id_sekolah" id="id_sekolah" value="<?php echo $id_sekolah; ?>">
                        <input type="text" name="nama_pertanyaan" id="nama_pertanyaan" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="tahun ajaran">Kelas</label>
                        <select class="form-control" name="singkat" id="singkat" required="required" style="width: 100%;">
                            <option value="">-- Pilih Kelas --</option>
                            <?php 
                                $data       = $this->sischool_model->get_singkat_kelas($id_sekolah);
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->singkat; ?>"><?php echo $dt->singkat; ?></option>
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