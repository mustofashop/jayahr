<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo $nama; ?></h3>
    </div>
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab">Shift</a></li>
                <li><a href="#password" data-toggle="tab">Hari</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="settings">
                    <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus"></i> Tambah Shift</a>
                    <table id="isi" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Shift</td>
                                <td>Hapus</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($shift->result() as $dt){ ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <?php if($dt->id_shift == '1'){ ?>
                                        <td>Pagi</td>
                                    <?php }else{ ?>
                                        <td>Siang</td>
                                    <?php } ?>
                                    <td><a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_shift/<?php echo $dt->id_trans_shift; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                    </a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="password">
                    <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal2"><i class="fa fa-plus"></i> Tambah Hari</a>
                    <table id="table" class="table table-bordered table-striped" style="width:100%;">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Hari</td>
                                <td>Hapus</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($hari->result() as $dt){ ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <?php if($dt->id_hari == '1'){ ?>
                                        <td>Senin</td>
                                    <?php }elseif($dt->id_hari == '2'){ ?>
                                        <td>Selasa</td>
                                    <?php }elseif($dt->id_hari == '3'){ ?>
                                        <td>Rabu</td>
                                    <?php }elseif($dt->id_hari == '4'){ ?>
                                        <td>Kamis</td>
                                    <?php }elseif($dt->id_hari == '5'){ ?>
                                        <td>Jumat</td>
                                    <?php }else{ ?>
                                        <td>Sabtu</td>
                                    <?php } ?>
                                    <td><a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_hari/<?php echo $dt->id_trans_hari; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                    </a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
</div>
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_shift" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Shift | <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Shift</label>
                        <input type="hidden" name="ids1" value="<?php echo $id_sekolah; ?>">
                        <select class="form-control select2" name="shift[]" multiple="multiple" id="shift" style="width: 100%;" required="required">
                            <option value="1">Pagi</option>
                            <option value="2">Siang</option>
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
<!-- /.modal -->
<div class="modal fade" id="modal2">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_hari" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Hari | <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Hari</label>
                        <input type="hidden" name="ids2" value="<?php echo $id_sekolah; ?>">
                        <select class="form-control select2" multiple="multiple" name="hari[]" style="width: 100%;" id="hari" required="required">
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
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
<!-- /.modal -->