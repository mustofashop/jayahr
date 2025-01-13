<script type="text/javascript">
$(document).ready(function () {
    //Timepicker
    $('.timePicker').timepicker({
      showInputs: false,
      showMeridian: false
    });
});
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_detail_shift",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_shift_detail').val(data.id_shift_detail);
            $('#shift_ke').val(data.shift_ke);
            $('#kode_shift').val(data.kode_shift);
            $('#masuk').val(data.jam_masuk);
            $('#keluar').val(data.jam_keluar);
            $('#telat').val(data.jam_telat);
            $('#setengah_hari').val(data.setengah_hari);
        }
    });
}
</script>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <div class="box-tools pull-right">
            <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                <i class="fa fa-plus"></i> Tambah Detail Shift
            </a>
            <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_shift/<?php echo $id_p; ?>">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Kode Shift</td>
                    <td>Shift Ke</td>
                    <td>Jam</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->enterprise_model->list_detail_shift($id_shift);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->kode_shift; ?></td>
                        <td><?php echo $dt->shift_ke; ?></td>
                        <td>
                            Jam Masuk : <?php echo $dt->jam_masuk; ?><br>
                            Jam Keluar: <?php echo $dt->jam_keluar ?><br>
                            Telat     : <?php echo $dt->jam_telat; ?><br>
                            Setengah Hari : <?php echo $dt->jam_setengah_hari; ?>
                        </td>
                        <td>
                            <!-- update -->
                            <a class="btn bg-green btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id_shift_detail;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_detail_shift/<?php echo $dt->id_shift_detail; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/simpan_detail_shift" enctype="multipart/form-data">
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
                                <label for="">Kode Shift</label>
                                <input type="hidden" name="id_shift" value="<?php echo $id_shift; ?>">
                                <input type="hidden" name="id_shift_detail" id="id_shift_detail">
                                <input type="text" class="form-control" name="kode_shift" id="kode_shift" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Shift Ke</label>
                                <input type="number" class="form-control" name="shift_ke" id="shift_ke" required="required" min="1" max="10">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row" id="formjam">
                                <div class="col-md-6">
                                    <!-- time Picker -->
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Masuk</label>
                                            <div class="input-group">
                                                <input type="text" name="masuk" id="masuk" class="form-control timePicker">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- time Picker -->
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Telat</label>
                                            <div class="input-group">
                                                <input type="text" name="telat" id="telat" class="form-control timePicker">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- time Picker -->
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Keluar</label>
                                            <div class="input-group">
                                                <input type="text" name="keluar" id="keluar" class="form-control timePicker">
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
                                            <label>Setengah Hari</label>
                                            <div class="input-group">
                                                <input type="text" name="setengah_hari" id="setengah_hari" class="form-control timePicker">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>