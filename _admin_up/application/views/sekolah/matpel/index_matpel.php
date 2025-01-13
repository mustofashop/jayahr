<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
            
            </div>
            <form method="GET" action="<?php echo base_url(); ?>sekolah/get_list_icon_matpel">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sekolah</label>
                        <select class="form-control select2" name="sekolah" id="sekolah" style="width: 100%;" required="required">
                            <option value="#">-- Pilih Sekolah --</option>
                            <?php 
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="input-group">
                        <button type="submit"class="btn bg-green btn-success btn-flat-margin"><i class="fa fa-search"></i>
                            Lihat Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>