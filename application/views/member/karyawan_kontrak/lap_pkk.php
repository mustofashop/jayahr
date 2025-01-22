<div class="row">
    <div class="col-md-6">
        <div class="box">
            <!-- <div class="box-header">
            
            </div> -->
            <form role="form" method="GET" action="<?php echo base_url(); ?>Pengaturan_pkk/laporan_penilaian_kontrak">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Karyawan</label>
                        <select name="karyawan" class="form-control select2" required="required" style="width:100%;">
                            <option value="">-- Pilih Karyawan Kontrak --</option>
                            <?php
                            $nrp         = $this->session->userdata('nrp');
                            $k  = $this->master_model->list_member_pkk($nrp);
                            foreach ($k->result() as $dk) {
                            ?>
                                <option value="<?php echo $dk->id_karyawan; ?>"><?php echo $dk->nama_lengkap; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn bg-green btn-success btn-flat-margin"><i class="fa fa-search"></i>
                        Lihat Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>