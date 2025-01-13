<script type="text/javascript">
$(document).ready(function () {
    //Timepicker
    $('#timePicker').timepicker({
      showInputs: false,
      showMeridian: false
    });
    $(".add-more").click(function(){ 
        var html = $(".copy").html();
        $(".formjam").after(html);
        $('#timePicker2').timepicker({
            showInputs: false,
            showMeridian: false
        });
    });
    $('.timePicker3').timepicker({
      showInputs: false,
      showMeridian: false
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".control-group").remove();
    });
});
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_jam_sekolah",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_jam_sekolah').val(data.id_jam_sekolah);
            $("#kls").attr("value",data.nama_kelas);
            $('#j').val(data.jam_masuk);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List Kelas</h3>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Kelas</td>
                            <td>Jam Masuk</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->sischool_model->list_jam_masuk($id_sekolah);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_kelas; ?></td>
                                <td><?php echo $dt->jam_masuk; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->id_jam_sekolah;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_jam_sekolah/<?php echo $dt->id_jam_sekolah; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
    </div>
    <div class="modal fade" id="modals">
        <div class="modal-dialog">
            <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_edit_jam_sekolah" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><?php echo $header; ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kelas</label>
                            <input type="hidden" name="id_jam_sekolah" id="id_jam_sekolah">
                            <input type="text" class="form-control" name="kls" id="kls" readonly>
                        </div>
                        <!-- time Picker -->
                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label>Masuk</label>
                                <div class="input-group">
                                    <input type="text" id="j" name="jam" class="form-control timePicker3">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
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
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg_jam1')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_jam1'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Tambah Data</h3>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_jammasuk_sekolah" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="formjam">
                        <div class="row control-group">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id_sekolah" id="id_sekolah" value="<?php echo $id_sekolah; ?>">
                                    <label for="">Kelas</label>
                                    <select name="kelas[]" id="kelas" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <?php
                                            $kelas  = $this->sischool_model->get_kelas($id_sekolah);
                                            foreach($kelas->result() as $k){
                                        ?>
                                                <option value="<?php echo $k->kode_kelas; ?>"><?php echo $k->nama_kelas; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- time Picker -->
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Masuk</label>
                                        <div class="input-group">
                                            <input type="text" id="timePicker" name="jam[]" class="form-control">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Add</label>
                                    <button type="button" class="btn bg-blue waves-effect add-more">
                                        <i class="material-icons">add</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- clone -->
                    <div class="copy hide">
                        <div class="row control-group">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id_sekolah" id="id_sekolah" value="<?php echo $id_sekolah; ?>">
                                    <label for="">Kelas</label>
                                    <select name="kelas[]" id="kelas" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <?php
                                            $kelas  = $this->sischool_model->get_kelas($id_sekolah);
                                            foreach($kelas->result() as $k){
                                        ?>
                                                <option value="<?php echo $k->kode_kelas; ?>"><?php echo $k->nama_kelas; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- time Picker -->
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Masuk</label>
                                        <div class="input-group">
                                            <input type="text" id="timePicker2" name="jam[]" class="form-control">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Remove</label>
                                    <button type="button" class="btn bg-red waves-effect remove">
                                        <i class="material-icons">close</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>