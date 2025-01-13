<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> Menu | <i>Menu Per Perusahaan</i></h3>
            </div>
            <form role="form" method="get" action="<?php echo base_url(); ?>setting_menu_e/list_menu">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Perusahaan</label>
                        <select name="perusahaan" class="form-control select2" required="required">
                            <option value="">-- Pilih --</option>
                            <?php
                                $data = $this->menu_e_model->list_perusahaan();
                                foreach($data->result() as $dt){
                            ?>
                                <option value="<?php echo $dt->id_perusahaan; ?>"><?php echo $dt->nama_perusahaan; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn bg-green btn-flat"><i class="fa fa-search"></i>
                        Lihat Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg_error')): ?>
            <div class="alert alert-danger alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_error'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> User | <i>Menu Per User</i></h3>
            </div>
            <form role="form" method="get" action="<?php echo base_url(); ?>setting_menu_e/list_user">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Perusahaan</label>
                        <select name="perusahaan" id="perusahaan" class="form-control select2" required="required">
                            <option value="">-- Pilih --</option>
                            <?php
                                $data = $this->menu_e_model->list_perusahaan();
                                foreach($data->result() as $dt){
                            ?>
                                <option value="<?php echo $dt->id_perusahaan; ?>"><?php echo $dt->nama_perusahaan; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn bg-green btn-flat"><i class="fa fa-search"></i>
                        Lihat Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>