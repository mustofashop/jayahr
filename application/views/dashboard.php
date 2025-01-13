<div class="row">
    <div class="col-md-3">
        <?php if ($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <?php
        $id_p   = $this->session->userdata('id_perusahaan');
        ?>

    </div>
</div>
<div class="row row-horizon">
    <!-- IDP -->
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title">IDP</h4>
            </div>
            <div class="box-body">
                <?php
                $nrp    = $this->session->userdata('nrp');
                $jml_karyawan = $this->master_model->list_member($nrp)->num_rows();
                ?>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $jml_karyawan; ?>
                        </h3>
                        <p>Jumlah Sub Ordinate</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <?php
                        $nrp    = $this->session->userdata('nrp');
                        $jml_sudah_idp = $this->master_model->list_member_sudah_idp($nrp)->num_rows();
                        ?>
                        <h3><?php echo $jml_sudah_idp; ?></h3>
                        <p>Sudah Isi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thermometer-half"></i>
                    </div>
                </div>
                <div class="small-box bg-gray">
                    <div class="inner">

                        <h3><?php echo $jml_karyawan - $jml_sudah_idp; ?></h3>
                        <p>Belum Isi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title">Internal Assessment</h4>
            </div>
            <div class="box-body">
                <?php
                $nrp    = $this->session->userdata('nrp');
                $jml_karyawan = $this->master_model->list_member($nrp)->num_rows();
                ?>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $jml_karyawan; ?>
                        </h3>
                        <p>Jumlah Sub Ordinate</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <?php
                        $nrp    = $this->session->userdata('nrp');
                        $jml_sudah_idp = $this->master_model->list_member_sudah_inass($nrp)->num_rows();
                        ?>
                        <h3><?php echo $jml_sudah_idp; ?></h3>
                        <p>Sudah Isi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thermometer-half"></i>
                    </div>
                </div>
                <div class="small-box bg-gray">
                    <div class="inner">

                        <h3><?php echo $jml_karyawan - $jml_sudah_idp; ?></h3>
                        <p>Belum Isi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h4 class="box-title">Penilaian Karyawan Kontrak</h4>
            </div>
            <div class="box-body">
                <?php
                $nrp    = $this->session->userdata('nrp');
                $jml_karyawan = $this->master_model->list_member($nrp)->num_rows();
                ?>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $jml_karyawan; ?>
                        </h3>
                        <p>Jumlah Sub Ordinate</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <?php
                        $nrp    = $this->session->userdata('nrp');
                        $jml_sudah_idp = $this->master_model->list_member_sudah_inass($nrp)->num_rows();
                        ?>
                        <h3><?php echo $jml_sudah_idp; ?></h3>
                        <p>Sudah Isi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thermometer-half"></i>
                    </div>
                </div>
                <div class="small-box bg-gray">
                    <div class="inner">

                        <h3><?php echo $jml_karyawan - $jml_sudah_idp; ?></h3>
                        <p>Belum Isi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="small-box bg-gray">
                    <div class="inner">

                        <h3><?php echo $jml_karyawan - $jml_sudah_idp; ?></h3>
                        <p>Feed Back Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>