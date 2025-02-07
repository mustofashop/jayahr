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
                            <th style="width: 200px;"></th>
                            <th></th>
                            <th style="width: 200px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil data dari model
                        $data = $this->master_model->set_pkk();
                        $trans_pkk = $this->master_model->get_trans_pkk($idp_nrp);

                        // Simpan semua id_p_periode yang sudah ada dalam array
                        $selected_id_p_periode = array_column($trans_pkk, 'id_p_periode');

                        if ($data->num_rows() > 0) {
                            $rows = $data->result();
                            $first_row = reset($rows);
                        ?>
                            <tr>
                                <td rowspan="<?php echo count($rows); ?>"><strong>Periode Penilaian</strong></td>
                                <td><?php echo $first_row->nama_value; ?></td>
                                <td>
                                    <input type="radio" name="id_p_periode_visible" value="<?php echo $first_row->id_p_periode; ?>"
                                        <?php echo in_array($first_row->id_p_periode, $selected_id_p_periode) ? 'checked disabled' : ''; ?>>

                                    <!-- Hidden input agar nilai tetap dikirim meskipun radio button disabled -->
                                    <?php if (in_array($first_row->id_p_periode, $selected_id_p_periode)) { ?>
                                        <input type="hidden" name="id_p_periode" value="<?php echo $first_row->id_p_periode; ?>">
                                    <?php } ?>

                                    <input type="hidden" name="id_periode" value="<?php echo $first_row->id_periode; ?>">
                                    <input type="hidden" name="flag_penilaian[<?php echo $first_row->id_p_periode; ?>]" value="<?php echo $first_row->flag_penilaian; ?>">
                                    <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">
                                </td>
                            </tr>
                            <?php foreach (array_slice($rows, 1) as $dt) { ?>
                                <tr>
                                    <td><?php echo $dt->nama_value; ?></td>
                                    <td>
                                        <input type="radio" name="id_p_periode" value="<?php echo $dt->id_p_periode; ?>"
                                            <?php echo in_array($dt->id_p_periode, $selected_id_p_periode) ? 'checked disabled' : ''; ?>>
                                        <input type="hidden" name="id_periode" value="<?php echo $dt->id_periode; ?>">
                                        <input type="hidden" name="flag_penilaian[<?php echo $dt->id_p_periode; ?>]" value="<?php echo $dt->flag_penilaian; ?>">
                                        <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
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
                            <th style="width: 200px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data2 = $this->master_model->list_jenis_form();
                        if ($data2->num_rows() > 0) {
                            // Ambil nilai jenis form yang sudah tersimpan
                            // $selected_id_jenis_form = isset($trans_pkk['flag_jenis_form']) ? $trans_pkk['flag_jenis_form'] : null;

                            foreach ($data2->result() as $dt2) { ?>
                                <tr>
                                    <td><?php echo $dt2->nama_value; ?></td>
                                    <td></td>
                                    <td>
                                        <input type="radio" name="id_jenis_form" value="<?php echo $dt2->id_jenis_form; ?>">
                                        <input type="hidden" name="flag_jenis_form[<?php echo $dt2->id_jenis_form; ?>]" value="<?php echo $dt2->flag_jenis_form; ?>">
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