<script type="text/javascript">
$(document).ready(function () {
    //Timepicker
    $('#masuk').timepicker({
      showInputs: false,
      showMeridian: false,
      showSeconds: true,
    });
    $('#keluar').timepicker({
      showInputs: false,
      showMeridian: false,
      showSeconds: true,
    });
    $(".date-picker").datepicker( {
		format: "yyyy-mm-dd"
	});
});
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/master/edit_do",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#ids').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#userid').val(data.userid);
            $('#masuk').val(data.masuk);
            $('#keluar').val(data.keluar);
            $('#status').val(data.status);
		}
	});
}
</script>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class='box-header'>
        <h3><?php echo $nama; ?> | <?php echo $bulans; ?></h3> 
        <a class="btn btn-app" id="excel" data-toggle="modal" data-target="#modal-excel"><i class="fa fa-file-excel-o"></i> Upload Excel (PopUp)</a>
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modals"><i class="fa fa-plus"></i> Tambah (PopUp)</a>
        <a class="btn btn-app" href="<?php echo base_url(); ?>master/delete_do_all/<?php echo $bulan; ?>/<?php echo $userid; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus"><i class="fa fa-trash"></i>Hapus Semua</a>
    </div>
    <div class="box-body">
        <table id="isi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Userid</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    foreach ($data->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $dt->tgl; ?></td>
                    <td><?php echo $dt->userid; ?></td>
                    <td><?php echo $dt->masuk; ?></td>
                    <td><?php echo $dt->keluar; ?></td>
                    <td><?php echo $dt->status; ?></td>
                    <td><a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>master/delete_do/<?php echo $dt->id; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modals">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/save_do">
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
                            <div class="form-group">
                                <label for="exampleInputEmail1">Userid</label>
                                <input type="text" class="form-control" id="userid" name="userid" value="<?php echo $userid; ?>" readonly>
                                <input type="hidden" name="nama" id="nama" value="<?php echo $nama; ?>">
                                <input type="hidden" name="nip" id="nip" value="<?php echo $nip; ?>">
                                <input type="hidden" name="id" id="ids">
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" name="tanggal" id="tanggal" class="form-control date-picker"  data-date-format="yyyy-mm-dd" required="required" autocomplete="off" placeholder="Tanggal"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Masuk</label>
                                    <div class="input-group">
                                        <input type="text" id="masuk" name="masuk" class="form-control" required="required">
                                        <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Keluar</label>
                                    <div class="input-group">
                                        <input type="text" id="keluar" name="keluar" class="form-control" required="required">
                                        <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Status</label>
                                <select name="status" id="status" class="form-control" required="required">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Tidak Hadir">Tidak Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                </select>
                            </div>
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
<div class="modal fade" id="modal-excel">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/upload_do" enctype="multipart/form-data">
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
                            <div class="form-group">
                                <a href="<?php echo site_url('..\assets\excel\sample_daily_office_school.xlsx');?>" download class="btn btn-app" style="width:100%;">
                                        <i class="fa fa-download"></i> Sample excel
                                    </a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="import">Upload Daily Office</label>
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
</div>