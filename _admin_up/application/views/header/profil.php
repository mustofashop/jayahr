<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?php 
                    if($foto == '' || empty($foto) || $foto == NULL){
                ?>
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/dist/img/avatar.png" alt="User profile picture">
                <?php }else{ ?>
                    <img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,<?php echo $foto;?>" alt="User profile picture">
                <?php } ?>
                    <h3 class="profile-username text-center"><?php echo $nama; ?></h3>
                    <p class="text-muted text-center">Superadmin</p>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
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
                    <form class="form-horizontal" action="<?php echo base_url(); ?>profil/save_profile" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" value="<?php echo $nama; ?>" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>" required="required">
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
                    <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>/profil/save_password">
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
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->