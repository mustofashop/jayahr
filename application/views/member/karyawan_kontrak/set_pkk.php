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
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
<form role="form" method="POST" action="<?php echo base_url(); ?>Trans_pkk/save_set_pkk" enctype="multipart/form-data">
    <div class="box">
        <div class="box-header">
            <button class="btn btn-app" title="Kembali" onclick="history.back(); return false;">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </button>
        </div>
        <div class="box">
            <div class="box-body">
                <!-- Periode Penilaian -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Periode Penilaian</th>
                            <th>Nama Value</th>
                            <th style="width: 200px;">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $this->master_model->set_pkk();
                        if ($data->num_rows() > 0) {
                            foreach ($data->result() as $dt) { ?>
                                <tr>
                                    <td><?php echo $dt->periode_tahun; ?></td>
                                    <td><?php echo $dt->nama_value; ?></td>
                                    <td>
                                        <input type="radio" name="id_p_periode" value="<?php echo $dt->id_p_periode; ?>">
                                        <input type="hidden" name="id_periode" value="<?php echo $dt->id_periode; ?>">
                                        <input type="hidden" name="flag_penilaian[<?php echo $dt->id_p_periode; ?>]" value="<?php echo $dt->flag_penilaian; ?>">
                                        <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3" style="text-align: center;">Tidak ada data tersedia</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


                <!-- Jenis Form -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 500px;">Jenis Form</th>
                            <th></th>
                            <th style="width: 200px;">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data2 = $this->master_model->list_jenis_form();
                        if ($data->num_rows() > 0) {
                            foreach ($data2->result() as $dt2) { ?>
                                <tr>
                                    <td><?php echo $dt2->nama_value; ?></td>
                                    <td></td>
                                    <td>
                                        <input type="radio" name="id_jenis_form" value="<?php echo $dt2->id_jenis_form; ?>">
                                        <input type="hidden" name="flag_jenis_form" value="<?php echo $dt2->flag_jenis_form; ?>">
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3" style="text-align: center;">Tidak ada data tersedia</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- Tombol Submit -->
                <div class="form-group text-right" style="margin-top: 20px;">
                    <button type="submit" class="btn bg-green btn-success btn-flat-margin">Submit</button>
                </div>
            </div>
        </div>
</form>