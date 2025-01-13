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
            <div class="box-body">
                <form action="<?php echo base_url(); ?>menu/get_menu_sekolah">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sekolah</label>
                        <select class="form-control select2" style="width: 100%;" name="sekolah" id="sekolah" required="required">
                            <?php 
                                foreach ($sekolah->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="check" class="btn bg-maroon btn-flat margin">Lihat Data</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>