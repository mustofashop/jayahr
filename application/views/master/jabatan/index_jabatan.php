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
        <?php if($aksi1 == '1'){ ?>
            <a class="btn btn-app" data-toggle="modal" data-target="#tambah" title="Tambah Jabatan">
                <i class="fa fa-plus"></i>
                Tambah Data
            </a>
        <?php } ?>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $id_p   = $this->session->userdata('id_perusahaan');
                    $no     = '1';
                    $data   = $this->master_model->list_jabatan($id_p);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $dt->nama_jabatan; ?></td>
                        <td>
                            <!-- edit -->
                            <?php if($aksi3 == '3'){ ?>
                                <a class="btn bg-olive btn-flat" data-target="#edit" onclick="javascript:Edit('<?php echo $dt->id_jabatan;?>')" data-toggle="modal" title="Edit <?php echo $dt->nama_jabatan; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <?php } ?>
                            <!-- delete -->
                            <?php if($aksi4 == '4'){ ?>
                                <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>jabatan/hapus_jabatan/<?php echo $dt->id_jabatan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus <?php echo $dt->nama_jabatan; ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
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
<script type="text/javascript">
    $(document).ready(function() {
        $(".add_field_button").click(function(){ 
            var html = $(".copy").html();
            $(".real").after(html);
        });
        $("body").on("click",".remove_field_button",function(){ 
            $(this).parents(".control-group").remove();
        });
    });
    function Edit(ID){
        var id  = ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/jabatan/edit_jabatan",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_jabatan').val(data.id_jabatan);
                $('#nama_jabatan').val(data.nama_jabatan);
            }
        });
    }
</script>
<!-- Modal tambah -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?> | Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url(); ?>jabatan/simpan_jabatan" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row real">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nama"></label>
                                <input type="text" name="nama_jabatan[]" class="form-control" required="required" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="add_field_button btn bg-blue btn-flat" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="copy hide">
                        <div class="row control-group">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama"></label>
                                    <input type="text" name="nama_jabatan[]" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button class="remove_field_button btn bg-red btn-flat" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
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
<!-- modal edit -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?> | Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url(); ?>jabatan/simpan_edit_jabatan" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_jabatan" id="id_jabatan">
                    <div class="form-group">
                        <label for="">Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required="required">
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

