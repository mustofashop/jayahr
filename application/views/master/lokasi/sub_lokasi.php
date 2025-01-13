<script>
    function Edit(ID){
        var id  = ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/lokasi/edit_sub_lokasi",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_sub_lokasi').val(data.id_sub_lokasi);
                $('#nama_sub_lokasi').val(data.nama_sub_lokasi);
                $('#latitude').val(data.latitude_sub);
                $('#longitude').val(data.longitude_sub);
                $('#jarak').val(data.jarak_sub);
                $('#sn').val(data.sn);
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
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" href="<?php echo base_url(); ?>lokasi">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
                <?php if($aksi1 == '1'){ ?>
                <!-- <a class="btn btn-app" data-toggle="modal" data-target="#tambah" title="Tambah Sub Lokasi">
                    <i class="fa fa-plus"></i>
                    Tambah Data
                </a> -->
                <?php } ?>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sub Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Jarak</th>
                            <th>SN</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->master_model->list_sub_lokasi2($id_lokasi);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_sub_lokasi; ?></td>
                                <td><?php echo $dt->latitude_sub; ?></td>
                                <td><?php echo $dt->longitude_sub; ?></td>
                                <td><?php echo $dt->jarak_sub; ?></td>
                                <td><?php echo $dt->sn; ?></td>
                                <td>
                                    <!-- edit -->
                                    <?php if($aksi3 == '3'){ ?>
                                        <!-- <a class="btn bg-olive btn-flat" data-target="#tambah" onclick="javascript:Edit('<?php echo $dt->id_sub_lokasi;?>')" data-toggle="modal" title="Edit <?php echo $dt->nama_sub_lokasi; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </a> -->
                                    <?php } ?>
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
<!-- modal -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url(); ?>lokasi/simpan_sub_lokasi" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama Sub Lokasi</label>
                                <input type="hidden" name="id_lokasi" id="id_lokasi" value="<?php echo $id_lokasi; ?>">
                                <input type="hidden" name="id_sub_lokasi" id="id_sub_lokasi">
                                <input type="text" name="nama_sub_lokasi" id="nama_sub_lokasi" class="form-control" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control" required="required" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jarak</label>
                                <input type="number" name="jarak" id="jarak" class="form-control" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">SN (Serial Number)</label>
                                <input type="text" name="sn" id="sn" class="form-control" required="required" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>