<script type="text/javascript">
function Edit1(ID){
    var id	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo base_url(); ?>level_e/edit_master_level",
        data	: "id="+id,
        dataType: "json",
        success	: function(data){
            $('#id_level_e').val(data.id_level_e);
            $('#kode_level_e').val(data.kode_level_e);
            $('#nama_level_e').val(data.nama_level_e);
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
        <?php if($this->session->flashdata('msg_error')): ?>
            <div class="alert alert-danger alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_error'); ?>
            </div>
        <?php endif; ?>  
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List Level</h3><br>
                <a data-toggle="modal" data-target="#add" class="btn btn-app margin"><i class="fa fa-plus"></i> Tambah Level</a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode Level</th>
                            <th>Nama Level</th>
                            <th>List Aksi</th>
                            <th>Menu Utama</th>
                            <th>Isi Menu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            $no     = 1;
                            $data   = $this->level_e_model->list_level_aksi();
                            foreach ($data->result() as $dt) {
                        ?>
                        <tr>
                            <td><?php echo $dt->kode_level_e; ?></td>
                            <td><?php echo $dt->nama_level_e; ?></td>
                            <td><?php echo $dt->aksi; ?></td>
                            <td>
                                <?php
                                    $menu_utama_g   = $this->level_e_model->list_menu_utama_g($dt->kode_level_e);
                                    foreach($menu_utama_g->result() as $mug){
                                ?>
                                    <?php echo $mug->nama_parent; ?>
                                <?php
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $isi_menu_g     = $this->level_e_model->list_isi_menu_g($dt->kode_level_e);
                                    foreach($isi_menu_g->result() as $img){
                                ?>
                                    <?php echo $img->nama_menu; ?>
                                <?php
                                    }
                                ?>
                            </td>
                            <td>
                                <!-- edit -->
                                <a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Edit1('<?php echo $dt->id_level_e;?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <!-- edit aksi -->
                                <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>level_e/level_aksi/<?php echo $dt->kode_level_e; ?>">
                                    Aksi
                                </a>
                                <!-- menu utama -->
                                <a class="btn bg-blue btn-flat" href="<?php echo base_url() ?>level_e/level_menu/<?php echo $dt->kode_level_e; ?>">
                                    Menu
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    <!-- end col md 6 -->
    <div class="col-md-4">
        <?php if($this->session->flashdata('msg2')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg2'); ?>
            </div>
        <?php endif; ?>  
        <div class="box">
            
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>List Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php  
                            $no     = 1;
                            $data   = $this->level_e_model->list_level_p();
                            foreach ($data->result() as $dt) {
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dt->nama_level; ?></td>
                            <td>
                                <a href="<?php echo base_url(); ?>level_e/hapus_mapping_level/<?php echo $dt->id_perusahaan; ?>" class="btn bg-red btn-flat" title="Hapus Semua Level" onClick="return confirm('Anda yakin ingin menghapus seluruh level data ini?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a href="<?php echo base_url(); ?>level_e/edit_mapping_level/<?php echo $dt->id_perusahaan; ?>" class="btn btn-flat bg-blue" title="Edit Level">
                                    <i class="fa fa-pencil"></i>
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
<!-- modal1 add -->
<div class="modal fade" id="add">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>level_e/simpan_master_level" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kode Level</label>
                        <input type="hidden" name="id_level_e">
                        <input type="number" name="kode_level_e" class="form-control" min="1" max="100" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Level</label>
                        <input type="text" name="nama_level_e" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Aksi | Bisa pilih beberapa</label>
                        <select name="aksi[]" class="form-control select2" multiple="multiple" required="required" style="width:100%;">
                            <option value="1">Tambah Data</option>
                            <option value="2">Lihat Data</option>
                            <option value="3">Edit Data</option>
                            <option value="4">Hapus Data</option>
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
</div>
<!-- end modal1 add -->
<!-- modal2 -->
<div class="modal fade" id="modal2">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>level_e/simpan_mapping_level" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Perusahaan</label>
                        <select name="perusahaan" id="perusahaan" class="form-control select2" style="width:100%;">
                            <?php
                                $p = $this->level_e_model->list_perusahaan();
                                foreach($p->result() as $dt){
                            ?>
                                <option value="<?php echo $dt->id_perusahaan; ?>"><?php echo $dt->nama_perusahaan; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Level *bisa klik beberapa</label>
                        <select name="level[]" class="form-control select2" multiple="multiple" required="required" style="width:100%;">
                            <?php
                                $l = $this->level_e_model->list_level();
                                foreach($l->result() as $dt2){
                            ?>
                                <option value="<?php echo $dt2->kode_level_e; ?>"><?php echo $dt2->kode_level_e ?> | <?php echo $dt2->nama_level_e; ?></option>
                            <?php
                                }
                            ?>
                        </select>
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
<!-- end modal2 -->
<!-- modal1 -->
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>level_e/simpan_master_level" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_level_e" id="id_level_e">
                    <div class="form-group">
                        <label for="">Kode Level</label>
                        <input type="number" name="kode_level_e" id="kode_level_e" class="form-control" required="required" min="1" max="50">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Level</label>
                        <input type="text" name="nama_level_e" id="nama_level_e" class="form-control" required="required">
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>                           
    </div>
</div>
<!-- end modal -->