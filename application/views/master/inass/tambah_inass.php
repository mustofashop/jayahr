<?php if ($this->session->flashdata('msg')) : ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('msg_error')) : ?>
    <div class="alert alert-danger alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-times"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <form action="<?php echo base_url(); ?>int_assessment/simpan_inass" role="form" method="POST" id="form" enctype="multipart/form-data">
        <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
        <input type="hidden" name="nrp" value="<?php echo $nrp; ?>">
        <div class="box-header">
            <a class="btn btn-app" href="<?php echo base_url(); ?>int_assessment/list_inass?tahun=<?php echo $tahun; ?>">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>
            <button name="simpan" class="btn btn-app" type="submit">
                <i class="fa fa-floppy-o"></i>
                Simpan
            </button>
        </div>
        <!-- disini -->
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            Personality Values</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="box">
                            <label style="color:red"><b>Integritas (bersikap jujur, menjunjung tinggi etika dan moral)</b></label>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 1;
                                        $data   = $this->master_model->list_tanya_inass3($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass3_' . $dt->id_iass_3, '1', (isset($_SESSION['selected_inass11' . $no]) && $_SESSION['selected_inass11' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass3_' . $dt->id_iass_3, '2', (isset($_SESSION['selected_inass11' . $no]) && $_SESSION['selected_inass11' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass3_' . $dt->id_iass_3, '3', (isset($_SESSION['selected_inass11' . $no]) && $_SESSION['selected_inass11' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass3_' . $dt->id_iass_3, '4', (isset($_SESSION['selected_inass11' . $no]) && $_SESSION['selected_inass11' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <label style="color:red"><b>Adil</b></label>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 2;
                                        $data   = $this->master_model->list_tanya_inass3($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass3_' . $dt->id_iass_3, '1', (isset($_SESSION['selected_inass10' . $no]) && $_SESSION['selected_inass10' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass3_' . $dt->id_iass_3, '2', (isset($_SESSION['selected_inass10' . $no]) && $_SESSION['selected_inass10' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass3_' . $dt->id_iass_3, '3', (isset($_SESSION['selected_inass10' . $no]) && $_SESSION['selected_inass10' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass3_' . $dt->id_iass_3, '4', (isset($_SESSION['selected_inass10' . $no]) && $_SESSION['selected_inass10' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <label style="color:red"><b>Komit</b></label>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 3;
                                        $data   = $this->master_model->list_tanya_inass3($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass3_' . $dt->id_iass_3, '1', (isset($_SESSION['selected_inass9' . $no]) && $_SESSION['selected_inass9' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass3_' . $dt->id_iass_3, '2', (isset($_SESSION['selected_inass9' . $no]) && $_SESSION['selected_inass9' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass3_' . $dt->id_iass_3, '3', (isset($_SESSION['selected_inass9' . $no]) && $_SESSION['selected_inass9' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass3_' . $dt->id_iass_3, '4', (isset($_SESSION['selected_inass9' . $no]) && $_SESSION['selected_inass9' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <label style="color:red"><b>Dorongan Berprestasi</b></label>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 4;
                                        $data   = $this->master_model->list_tanya_inass3($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass3_' . $dt->id_iass_3, '1', (isset($_SESSION['selected_inass8' . $no]) && $_SESSION['selected_inass8' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass3_' . $dt->id_iass_3, '2', (isset($_SESSION['selected_inass8' . $no]) && $_SESSION['selected_inass8' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass3_' . $dt->id_iass_3, '3', (isset($_SESSION['selected_inass8' . $no]) && $_SESSION['selected_inass8' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass3_' . $dt->id_iass_3, '4', (isset($_SESSION['selected_inass8' . $no]) && $_SESSION['selected_inass8' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <label style="color:red"><b>Intrapreneurship</b></label>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 5;
                                        $data   = $this->master_model->list_tanya_inass3($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass3_' . $dt->id_iass_3, '1', (isset($_SESSION['selected_inass7' . $no]) && $_SESSION['selected_inass7' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass3_' . $dt->id_iass_3, '2', (isset($_SESSION['selected_inass7' . $no]) && $_SESSION['selected_inass7' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass3_' . $dt->id_iass_3, '3', (isset($_SESSION['selected_inass7' . $no]) && $_SESSION['selected_inass7' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass3_' . $dt->id_iass_3, '4', (isset($_SESSION['selected_inass7' . $no]) && $_SESSION['selected_inass7' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            Knowledge Technical Skills To Support Business</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 2;
                                        $data   = $this->master_model->list_tanya_inass2($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass2_' . $dt->id_iass_2, '1', (isset($_SESSION['selected_inass6' . $no]) && $_SESSION['selected_inass6' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass2_' . $dt->id_iass_2, '2', (isset($_SESSION['selected_inass6' . $no]) && $_SESSION['selected_inass6' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass2_' . $dt->id_iass_2, '3', (isset($_SESSION['selected_inass6' . $no]) && $_SESSION['selected_inass6' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass2_' . $dt->id_iass_2, '4', (isset($_SESSION['selected_inass6' . $no]) && $_SESSION['selected_inass6' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            Team Work (EQ)</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 3;
                                        $data   = $this->master_model->list_tanya_inass2($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass2_' . $dt->id_iass_2, '1', (isset($_SESSION['selected_inass5' . $no]) && $_SESSION['selected_inass5' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass2_' . $dt->id_iass_2, '2', (isset($_SESSION['selected_inass5' . $no]) && $_SESSION['selected_inass5' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass2_' . $dt->id_iass_2, '3', (isset($_SESSION['selected_inass5' . $no]) && $_SESSION['selected_inass5' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass2_' . $dt->id_iass_2, '4', (isset($_SESSION['selected_inass5' . $no]) && $_SESSION['selected_inass5' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                            Management Skill</a>
                    </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 4;
                                        $data   = $this->master_model->list_tanya_inass2($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass2_' . $dt->id_iass_2, '1', (isset($_SESSION['selected_inass4' . $no]) && $_SESSION['selected_inass4' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass2_' . $dt->id_iass_2, '2', (isset($_SESSION['selected_inass4' . $no]) && $_SESSION['selected_inass4' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass2_' . $dt->id_iass_2, '3', (isset($_SESSION['selected_inass4' . $no]) && $_SESSION['selected_inass4' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass2_' . $dt->id_iass_2, '4', (isset($_SESSION['selected_inass4' . $no]) && $_SESSION['selected_inass4' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                            Leadership</a>
                    </h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 5;
                                        $data   = $this->master_model->list_tanya_inass2($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass2_' . $dt->id_iass_2, '1', (isset($_SESSION['selected_inass3' . $no]) && $_SESSION['selected_inass3' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass2_' . $dt->id_iass_2, '2', (isset($_SESSION['selected_inass3' . $no]) && $_SESSION['selected_inass3' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass2_' . $dt->id_iass_2, '3', (isset($_SESSION['selected_inass3' . $no]) && $_SESSION['selected_inass3' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass2_' . $dt->id_iass_2, '4', (isset($_SESSION['selected_inass3' . $no]) && $_SESSION['selected_inass3' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                            Shareholders Value Creation</a>
                    </h4>
                </div>
                <div id="collapse6" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = 1;
                                        $id_iassx = 6;
                                        $data   = $this->master_model->list_tanya_inass2($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass2_' . $dt->id_iass_2, '1', (isset($_SESSION['selected_inass2' . $no]) && $_SESSION['selected_inass2' . $no] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass2_' . $dt->id_iass_2, '2', (isset($_SESSION['selected_inass2' . $no]) && $_SESSION['selected_inass2' . $no] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass2_' . $dt->id_iass_2, '3', (isset($_SESSION['selected_inass2' . $no]) && $_SESSION['selected_inass2' . $no] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass2_' . $dt->id_iass_2, '4', (isset($_SESSION['selected_inass2' . $no]) && $_SESSION['selected_inass2' . $no] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                                <?php $no++; ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                            Energy</a>
                    </h4>
                </div>
                <div id="collapse7" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = '1';
                                        $id_iassx = 7;
                                        $data   = $this->master_model->list_tanya_inass1($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass1_' . $dt->id_iass; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass1_' . $dt->id_iass; ?>" id="<?php echo 'iass1_' . $dt->id_iass; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass1_' . $dt->id_iass, '1', (isset($_SESSION['selected_inass1']) && $_SESSION['selected_inass1'] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass1_' . $dt->id_iass, '2', (isset($_SESSION['selected_inass1']) && $_SESSION['selected_inass1'] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass1_' . $dt->id_iass, '3', (isset($_SESSION['selected_inass1']) && $_SESSION['selected_inass1'] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass1_' . $dt->id_iass, '4', (isset($_SESSION['selected_inass1']) && $_SESSION['selected_inass1'] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
                            Judgment</a>
                    </h4>
                </div>
                <div id="collapse8" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php
                                        $no     = '1';
                                        $id_iassx = 8;
                                        $data   = $this->master_model->list_tanya_inass1($id_iassx);
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass1_' . $dt->id_iass; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass1_' . $dt->id_iass; ?>" id="<?php echo 'iass1_' . $dt->id_iass; ?>" class="form-control" oninvalid="this.setCustomValidity('Data tidak boleh kosong, harap melengkapi penilaian yang belum dipilih !')" oninput="this.setCustomValidity('')">
                                                    <option value="">--Pilih Penilaian--</option>
                                                    <option value="1" <?php echo set_select('iass1_' . $dt->id_iass, '1', (isset($_SESSION['selected_inass']) && $_SESSION['selected_inass'] == '1')); ?>>1 (Kurang)</option>
                                                    <option value="2" <?php echo set_select('iass1_' . $dt->id_iass, '2', (isset($_SESSION['selected_inass']) && $_SESSION['selected_inass'] == '2')); ?>>2 (Cukup)</option>
                                                    <option value="3" <?php echo set_select('iass1_' . $dt->id_iass, '3', (isset($_SESSION['selected_inass']) && $_SESSION['selected_inass'] == '3')); ?>>3 (Baik)</option>
                                                    <option value="4" <?php echo set_select('iass1_' . $dt->id_iass, '4', (isset($_SESSION['selected_inass']) && $_SESSION['selected_inass'] == '4')); ?>>4 (Sangat Baik)</option>
                                                </select>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>