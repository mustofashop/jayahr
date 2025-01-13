<script>
    function Edit(ID){
        var id  = ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/lokasi/edit_lokasi",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_lokasi').val(data.id_lokasi);
                $('#nama_lokasi').val(data.nama_lokasi);
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
            <?php if($aksi1 == '1'){ ?>
                <!-- <a class="btn btn-app" data-toggle="modal" data-target="#tambah" title="Tambah Lokasi">
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
                            <th>Nama Lokasi</th>
                            <th>Kode Lokasi</th>
                            <th>Leader</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $id_p   = $this->session->userdata('id_perusahaan');
                            $no     = 1;
                            $data   = $this->master_model->list_lokasi($id_p);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_lokasi; ?></td>
                                <td><?php echo $dt->kode_lokasi; ?></td>
                                <td>
                                    <?php
                                        $leader = $this->master_model->nama_leader_lokasi($dt->id_lokasi);
                                        if($leader->num_rows() > 0){
                                            $nama_leader    = $leader->row()->nama_lengkap;
                                        }else{
                                            $nama_leader    = '-';
                                        }
                                        echo $nama_leader;
                                    ?>
                                </td>
                                <td>
                                     <!-- edit -->
                                    <?php if($aksi3 == '3'){ ?>
                                        <!-- <a class="btn bg-olive btn-flat" data-target="#tambah" onclick="javascript:Edit('<?php echo $dt->id_lokasi;?>')" data-toggle="modal" title="Edit <?php echo $dt->nama_lokasi; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </a> -->
                                    <?php } ?>
                                    <!-- sub lokasi -->
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>lokasi/sub_lokasi/<?php echo $dt->id_lokasi; ?>" title="Sub Lokasi <?php echo $dt->nama_lokasi; ?>">
                                        <i class="fa fa-plus"></i>
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
            <form method="POST" action="<?php echo base_url(); ?>lokasi/simpan_lokasi" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Lokasi</label>
                        <input type="hidden" name="id_lokasi" id="id_lokasi">
                        <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" required="required" autocomplete="off">
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