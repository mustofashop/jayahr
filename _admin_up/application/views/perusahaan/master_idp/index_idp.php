<script type="text/javascript">
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_idp",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_idp').val(data.id_idp);
            $('#nama_value').val(data.nama_value);
            $('#urutan').val(data.urutan);
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
        <h3 class="box-title">List Pertanyaan IDP</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                <i class="fa fa-plus"></i> Tambah Pertanyaan
            </a>
        </div>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Pertanyaan</td>
                    <td>Urutan</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->enterprise_model->get_idp();
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama_value; ?></td>
                        <td><?php echo $dt->urutan; ?></td>
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#edit" onclick="javascript:Edit('<?php echo $dt->id_idp;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_idp/<?php echo $dt->id_idp; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_edit_idp">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pertanyaan</label>
                        <input type="text" name="nama_value" id="nama_value" class="form-control" required="required">
                        <input type="hidden" name="id_idp" id="id_idp">
                    </div>
					<div class="form-group">
                        <label for="">Urutan</label>
                        <input type="text" name="urutan" id="urutan" class="form-control" required="required">
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
<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_idp" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    
					<div class="form-group">
                        <label for="">Pertanyaan</label>
                        <input type="text" name="nama_value" id="nama_value" class="form-control" required="required">
                        <input type="hidden" name="id_perusahaan" value="<?php echo $id_p; ?>">
                    </div>
					<div class="form-group">
                        <label for="">Urutan</label>
                        <input type="text" name="urutan" id="urutan" class="form-control" required="required">
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