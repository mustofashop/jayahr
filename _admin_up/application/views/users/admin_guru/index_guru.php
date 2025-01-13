<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg_p')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_p'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h4>Pilih Sekolah</h4>
            </div>
            <!-- /.box-header -->
            <form action="<?php echo base_url(); ?>users/list_guru">
                <div class="box-body">
                    <div class="form-group">
                        <select class="form-control select2" name="sekolah" id="sekolah" required="required" style="width: 100%;">
                            <?php 
                                $data = $this->sischool_model->get_sekolah();
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="input-group">
                        <button type="submit" class="btn bg-green btn-success btn-flat-margin"><i class="fa fa-search"></i>
                            Lihat Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box parent menu -->
    </div>
</div>