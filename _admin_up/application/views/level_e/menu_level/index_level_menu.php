<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Menu Utama</h3><br>
                <a class="btn btn-app btn-margin" data-toggle="modal" data-target="#modal-menu1" title="Tambah Menu Utama">
                    <i class="fa fa-plus"></i>
                    Tambah Menu Utama
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>Menu Utama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $data = $this->level_e_model->list_menu_utama($kode_l);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $dt->nama_parent; ?></td>
                                <td>
                                    <a class="btn btn-flat bg-red" href="<?php echo base_url(); ?>level_e/hapus_menu_utama/<?php echo $dt->id_parent_level; ?>/<?php echo $dt->id_menu_parent; ?>/<?php echo $kode_l; ?>" title="Hapus <?php echo $dt->nama_parent; ?>" onClick="return confirm('Anda yakin ingin menghapus seluruh Menu <?php echo $dt->nama_parent; ?> ini?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg1')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg1'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Isi Menu</h3><br>
                <a class="btn btn-app btn-margin" data-toggle="modal" data-target="#modal-menu2" title="Tambah Isi Menu">
                    <i class="fa fa-plus"></i>
                    Tambah Isi
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>Menu Utama</th>
                            <th>Isi Menu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $data1 = $this->level_e_model->list_isi_menu($kode_l);
                            foreach($data1->result() as $dt1){
                        ?>
                            <tr>
                                <td><?php echo $dt1->nama_parent; ?></td>
                                <td><?php echo $dt1->nama_menu; ?></td>
                                <td>
                                    <a class="btn btn-flat bg-red" href="<?php echo base_url(); ?>level_e/hapus_isi_menu/<?php echo $dt1->id_menu_level; ?>" title="Hapus <?php echo $dt1->nama_menu; ?>" onClick="return confirm('Anda yakin ingin menghapus Menu <?php echo $dt1->nama_menu; ?> ini?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- modal menu1 -->
<div class="modal fade" id="modal-menu1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>level_e/simpan_menu_utama" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Tambah Menu Utama</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Menu Utama | Bisa pilih beberapa</label>
                        <input type="hidden" name="kode_level" value="<?php echo $kode_l; ?>">
                        <select name="menu1[]" multiple="multiple" required="required" class="form-control select2" style="width:100%;">
                            <?php
                                $data = $this->level_e_model->list_menu_utama_kode($kode_l);
                                foreach($data->result() as $dt1){
                            ?>
                                <option value="<?php echo $dt1->id_menu_parent; ?>"><?php echo $dt1->nama_parent; ?></option>
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
            <!-- /.modal-content -->
        </form>                           
    </div>
</div>
<!-- end modal menu1 -->
<!-- modal menu 2 -->
<div class="modal fade" id="modal-menu2">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>level_e/simpan_isi_menu" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Tambah Isi Menu</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kode_level" id="kode_level" value="<?php echo $kode_l; ?>">
                    <div class="form-group">
                        <label for="">Menu Utama | Isi Menu <i><b>*Bisa Pilih beberapa</b></i></label>
                        <select name="menu2[]" class="form-control select2" style="width:100%;" multiple="multiple" required="required">
                            <?php
                                $menu1  = $this->level_e_model->list_isi_menu_ne($kode_l);
                                foreach($menu1->result() as $m1){
                            ?>
                                <option value="<?php echo $m1->id_menu; ?>"><?php echo $m1->nama_parent ?> | <?php echo $m1->nama_menu; ?></option>
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
            <!-- /.modal-content -->
        </form>                           
    </div>
</div>
<!-- end modal menu2 -->