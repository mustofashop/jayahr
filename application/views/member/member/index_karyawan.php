<div class="row">
    <div class="col-md-6">
        <div class="box">
            <form role="form" method="GET" action="<?php echo base_url(); ?>data_karyawan/list_karyawan">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="1">Karyawan Tetap</option>
                            <option value="2">Karyawan Borongan</option>
                            <option value="3">Karyawan Kontrak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <select name="lokasi" class="form-control">
                            <option value="0">-- Semua Lokasi --</option>
                            <?php
                                $id_p   = $this->session->userdata('id_perusahaan');
                                $lokasi = $this->master_model->list_lokasi($id_p);
                                foreach($lokasi->result() as $l){
                            ?>
                                <option value="<?php echo $l->id_lokasi; ?>"><?php echo $l->nama_lokasi; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-flat bg-green">
                        <i class="fa fa-paper-plane"></i>
                        Lihat Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>