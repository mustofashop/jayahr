<script type="text/javascript">
function Edit(ID){
    var id	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_sub_lokasi",
        data	: "id="+id,
        dataType: "json",
        success	: function(data){
            $('#id_sub_lokasi').val(data.id_sub_lokasi);
            $('#nama').val(data.nama_sub_lokasi);
            $('#latitude').val(data.latitude_sub);
            $('#longitude').val(data.longitude_sub);
            $('#jarak').val(data.jarak_sub);
            $('#sn').val(data.sn);
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
            <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                <i class="fa fa-plus"></i> Tambah Sub Lokasi
            </a>
        </div>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>ID Sub Lokasi</td>
                    <td>Nama Sub Lokasi</td>
                    <td>Latitude</td>
                    <td>Longitude</td>
                    <td>Jarak</td>
                    <td>SN</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->enterprise_model->list_sub_lokasi($id_lokasi);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->id_sub_lokasi; ?></td>
                        <td><?php echo $dt->nama_sub_lokasi; ?></td>
                        <td><?php echo $dt->latitude_sub; ?></td>
                        <td><?php echo $dt->longitude_sub; ?></td>
                        <td><?php echo $dt->jarak_sub; ?></td>
                        <td><?php echo $dt->sn; ?></td>
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id_sub_lokasi;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_sub_lokasi/<?php echo $dt->id_sub_lokasi; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_sub_lokasi" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="lok">
                        <div class="control-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Lokasi</label>
                                        <input type="text" name="nama_sub" id="nama" class="form-control" required="required">
                                        <input type="hidden" name="id_lokasi" value="<?php echo $id_lokasi; ?>">
                                        <input type="hidden" name="id_sub_lokasi" id="id_sub_lokasi">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Latitude</label>
                                        <input type="text" name="latitude_sub" id="latitude" class="form-control" required="required">
                                    </div>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Longitude</label>
                                        <input type="text" name="longitude_sub" id="longitude" class="form-control" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jarak</label>
                                        <input type="number" name="jarak_sub" id="jarak" class="form-control" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="">SN</label>
                                        <input type="text" name="sn" id="sn" class="form-control" required="required">
                                    </div>
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
        </form>
    </div>
</div>