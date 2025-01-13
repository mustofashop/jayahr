<div class="row">
    <div class="col-md-6">
        <div class="box">
            <form method="GET" action="<?php echo base_url(); ?>Enterprise/libur/list_libur">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Perusahaan</label>
                        <select name="perusahaan" id="perusahaan" class="form-control select2" required="required">
                            <?php
                                $perusahaan = $this->enterprise_model->list_perusahaan();
                                foreach($perusahaan->result() as $p){
                            ?>
                                <option value="<?php echo $p->id_perusahaan; ?>"><?php echo $p->nama_perusahaan; ?></option>
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