<form role="form" method="POST" action="<?php echo base_url(); ?>Trans_pkk/save_set_pkk" enctype="multipart/form-data">
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
                                    <!-- <input type="hidden" name="id_trans_pkk" value="<?php echo $dt->id_trans_pkk; ?>"> -->
                                    <input type="hidden" name="id_periode" value="<?php echo $dt->id_periode; ?>">
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
                    $data = $this->master_model->list_jenis_form();
                    if ($data->num_rows() > 0) {
                        foreach ($data->result() as $dt) { ?>
                            <tr>
                                <td><?php echo $dt->nama_value; ?></td>
                                <td></td>
                                <td>
                                    <input type="radio" name="id_jenis_form" value="<?php echo $dt->id_jenis_form; ?>">
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