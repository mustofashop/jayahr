<script type="text/javascript">
function Edit1(ID){
	var id	    = ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_link_sekolah",
		data	: "id="+id,
		dataType: "json",
		success	: function(data){
            $('#id_link1').val(data.id_link);
            $('#id_sekolah1').val(data.id_sekolah);
            $('#nama_sekolah1').val(data.nama_sekolah);
            $('#link1').val(data.link);
            $('#jenis1').val(data.jenis_link);
		}
	});
}
function Edit2(ID2) {
    var id2     = ID2;
    $.ajax({
        type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_link_kelas",
		data	: "id2="+id2,
		dataType: "json",
		success	: function(data){
            $('#id_link2').val(data.id_link);
            $('#id_sekolah2').val(data.id_sekolah);
            $('#nama_sekolah2').val(data.nama);
            $('#link2').val(data.link);
            $('#jenis2').val(data.kategori);
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
        <div class="box-tools pull-right">
            <a class="btn btn-box-tool" href="<?php echo base_url() ?>beone/add_link"><i class="fa fa-plus"></i> Tambah Data</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Sekolah</h3>
                    </div>   
                    <div class="box-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sekolah</th>
                                    <th>Link</th>
                                    <th>Jenis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $data_sekolah = $this->beone_model->list_link_meeting_sekolah();
                                    foreach ($data_sekolah->result() as $ds) {
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $ds->nama_sekolah; ?></td>
                                        <td><?php echo $ds->link; ?></td>
                                        <td><?php echo $ds->jenis; ?></td>
                                        <td>
                                            <!-- edit -->
                                            <a class="btn bg-olive btn-flat" href="#modal-edit1" onclick="javascript:Edit1('<?php echo $ds->id_link_meeting_sekolah;?>')" data-toggle="modal" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>beone/delete_link_sekolah/<?php echo $ds->id_link_meeting_sekolah; ?>" title="delete" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Kelas</h3>
                    </div>   
                    <div class="box-body">
                        <table id="isi" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sekolah</th>
                                    <th>Kelas</th>
                                    <th>Link</th>
                                    <th>Jenis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $data_kelas = $this->beone_model->list_link_meeting_kelas();
                                    foreach ($data_kelas->result() as $dk) {
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $dk->nama_sekolah; ?></td>
                                        <td><?php echo $dk->nama_kelas; ?></td>
                                        <td><?php echo $dk->link; ?></td>
                                        <td><?php echo $dk->jenis; ?></td>
                                        <td>
                                            <!-- edit -->
                                            <a class="btn bg-olive btn-flat" href="#modal-edit2" onclick="javascript:Edit2('<?php echo $dk->id_link;?>')" data-toggle="modal" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>beone/delete_link_kelas/<?php echo $dk->id_link; ?>" title="delete" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
    
    </div>
</div>
<!-- modal edit 1 -->
<div class="modal fade" id="modal-edit1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_link_sekolah" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Sekolah</label>
                        <input type="text" id="nama_sekolah1" class="form-control" readonly>
                        <input type="hidden" name="id_link_meeting_sekolah" id="id_link1">
                        <input type="hidden" name="sekolah" id="id_sekolah1">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis</label>
                        <select name="jenis_link" id="jenis1" class="form-control">
                            <option value="1">ZOOM</option>
                            <option value="2">Google Meet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Link</label>
                        <input type="text" name="link" id="link1" class="form-control" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal edit 2 -->
<div class="modal fade" id="modal-edit2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_edit_link_kelas" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Sekolah | Nama Kelas</label>
                        <input type="text" id="nama_sekolah2" class="form-control" readonly>
                        <input type="hidden" name="id_link" id="id_link2"> 
                        <input type="hidden" name="id_sekolah" id="id_sekolah2">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis</label>
                        <select name="jenis" id="jenis2" class="form-control">
                            <option value="1">ZOOM</option>
                            <option value="2">Google Meet</option>
                        </select>
                    </div>
                    <div class="form-group"> 
                        <label for="">Link</label>
                        <input type="text" name="link" id="link2" class="form-control" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>