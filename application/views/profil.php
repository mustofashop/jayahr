<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?php 
                    $id     = $this->session->userdata('id_karyawan');
                    $data   = $this->master_model->get_user($id);
                    $foto   = $data->row()->foto_64;
                    $nama   = $data->row()->nama_lengkap;
                    $telpon = $data->row()->no_telepon;
                    if($foto == '' || empty($foto) || $foto == NULL){
                ?>
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/dist/img/avatar.png" alt="User profile picture">
                <?php }else{ ?>
                    <img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,<?php echo $foto;?>" alt="User profile picture">
                <?php } ?>
                    <h3 class="profile-username text-center"><?php echo $nama; ?></h3>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- end col md 6 -->
    <div class="col-md-9">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab">Setting Profil</a></li>
                <li><a href="#password" data-toggle="tab">Setting Password</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="settings">
                    <form class="form-horizontal" action="<?php echo base_url(); ?>profil/simpan" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" value="<?php echo $nama; ?>" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon" class="col-sm-2 control-label">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="no_telepon" placeholder="no_telepon" value="<?php echo $telpon; ?>" required="required">
                            </div>
                        </div>
                        <div>
                            <label for="image" class="col-sm-2 control-label" style="margin-left:-11px;">Foto Profil</label>
                            <div class="col-md-10">
                                <input type="file" name="image">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn bg-olive btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="password">
                    <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>profil/simpan_password">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Konfirmasi Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" placeholder="Konfirmasi" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn bg-olive btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>
    <!-- end col md 6 -->
</div>