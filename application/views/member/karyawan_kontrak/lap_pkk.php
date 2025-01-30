<div class="row">
    <div class="col-md-6">
        <div class="box">
            <!-- <div class="box-header">
            
            </div> -->
            <form role="form" method="GET" action="<?php echo base_url(); ?>Pengaturan_pkk/laporan_penilaian_kontrak">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Karyawan</label>
                        <select name="unit" class="form-control select2" required="required" style="width:100%;">
                            <option value="">-- Pilih Bagian --</option>
                            <?php
                            foreach ($unit->result() as $l) {
                            ?>
                                <option value="<?php echo $l->id_bagian; ?>"><?php echo $l->nama_bagian; ?> </option>
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