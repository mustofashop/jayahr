<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>chat_api">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <a class="btn btn-app" id="add" data-toggle="modal" data-target="#modal">
            <i class="fa fa-plus"></i> 
            Tambah Data
        </a>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Deskripsi</th>
                    <th>Nama PIC</th>
                    <th>No HP PIC</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    $data   = $this->chat_api_model->list_pelanggan();
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama; ?></td>
                        <td><?php echo $dt->deskripsi; ?></td>
                        <td><?php echo $dt->nama_pic; ?></td>
                        <td><?php echo $dt->no_hp_pic; ?></td>
                        <td><?php echo $dt->catatan; ?></td>
                        <td>
                             <!-- edit -->
                             <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>chat_api/hapus_pelanggan/<?php echo $dt->id; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<script type="text/javascript">
function Edit(ID){
    var id	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo base_url(); ?>chat_api/edit_pelanggan",
        data	: "id="+id,
        dataType: "json",
        success	: function(data){
            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#deskripsi').val(data.deskripsi);
            $('#nama_pic').val(data.nama_pic);
            $('#no_pic').val(data.no_hp_pic);
            $('#catatan').val(data.catatan);
        }
    });
}
</script>
<!-- modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>chat_api/simpan_pelanggan">
            <div class="modal-content">
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
                                <label for="">Nama Pelanggan</label>
                                <input type="text" class="form-control" name="nama" id="nama" required="required" autocomplete="off">
                                <input type="hidden" name="id" id="id">
                            </div>
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama PIC</label>
                                <input type="text" class="form-control" name="nama_pic" id="nama_pic" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">No HP PIC</label>
                                <input type="number" min="0" class="form-control" name="no_pic" id="no_pic" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">Catatan</label>
                                <input type="text" class="form-control" name="catatan" id="catatan">
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