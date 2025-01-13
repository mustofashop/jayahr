<script type="text/javascript">
$(function() {
    $(".date-picker").datepicker( {
		format: "yyyy-mm",
		viewMode: "months", 
        minViewMode: "months"
	});
});
</script>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-default"><i class="fa fa-file-excel-o"></i>Upload Data</a>
            </div>
            <form method="GET" action="<?php echo base_url(); ?>master/get_checkinout_adms">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <select class="form-control select2" name="nama" id="nama" style="width: 100%;" required="required">
                            <option value="#">-- Pilih Nama --</option>
                            <?php 
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->userid; ?>"><?php echo $dt->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bulan</label>
                        <input type="text" name="bulan" id="bulan" class="form-control date-picker"  data-date-format="yyyy-mm" required="required" autocomplete="off" placeholder="Tahun-Bulan"/>
                    </div>
                </div>
                <!-- /.box-body -->
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
<!-- modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/upload_all_excel" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="form-group">
                                <a href="<?php echo site_url('..\assets\excel\sample_adms.xlsx');?>" download class="btn btn-app" style="width:100%;">
                                        <i class="fa fa-download"></i> Sample excel
                                    </a>
                            </div> -->
                        </div>
                    </div>
                    <div>
                        <label for="import">Upload Checkinout Adms</label>
                        <div class="col-md-12">
                            <?php echo form_upload('file_excel');?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->