<script type="text/javascript">
$(document).ready(function () {
    //Timepicker
    $('#timePicker').timepicker({
      showInputs: false,
      showMeridian: false
    });
});
function Latlong(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_latlong_sekolah",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_s').val(data.id_sekolah);
            $('#nama_s').val(data.nama_sekolah);
            $('#latitude').val(data.latitude);
            $('#longitude').val(data.longitude);
            $('#jarak').val(data.jarak);
		}
	});
}
function Jam(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_latlong_sekolah",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_sklh').val(data.id_sekolah);
            $('#nama_sklh').val(data.nama_sekolah);
            $('#timePicker').val(data.jam_masuk);
		}
	});
}
$(function () {
    $('#tbl').DataTable()
});
</script>
<div class="row">
    <div class="col-md-4">
    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
        <div class="box">
            <div class="box-header">
            <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah Sekolah</a>
            </div>
            <form method="GET" action="<?php echo base_url(); ?>sekolah/get_data_sekolah">
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
<div class="row">
    <div class="col-md-7">
        <?php if($this->session->flashdata('msg_latlong')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_latlong'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Latitude, Longitude & Jarak Absensi</h3>                  
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Sekolah</td>
                            <td>Latitude</td>
                            <td>Longitude</td>
                            <td>Jarak Absensi</td>
                            <td>Edit</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = '1';
                            foreach($latlong->result() as $dt){ ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_sekolah; ?></td>
                                <td><?php echo $dt->latitude; ?></td>
                                <td><?php echo $dt->longitude; ?></td>
                                <td><?php echo $dt->jarak_absensi; ?></td>
                                <td><a class="btn bg-olive btn-flat" href="#latlong" onclick="javascript:Latlong('<?php echo $dt->id_sekolah;?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a></td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <?php if($this->session->flashdata('msg_jam')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_jam'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                Jam Masuk Sekolah
            </div>
            <div class="box-body">
                <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Sekolah</td>
                            <td>Masuk</td>
                            <td>Edit</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = '1';
                            foreach($jam_sklh->result() as $dt){ ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_sekolah; ?></td>
                                <td><?php echo $dt->jam_masuk; ?></td>
                                <td><a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>sekolah/add_jam_sekolah/<?php echo $dt->id_sekolah; ?>" title="Jam Sekolah">
                                    <i class="fa fa-search"></i>
                                </a></td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_sekolah" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Sekolah</label>
                        <input type="text" class="form-control" id="nama" name="nama" required="required">
                        <input type="hidden" name="id" id="ids">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Sekolah</label>
                        <select name="jenis" id="jenis" class="form-control" required="required">
                            <option value="">-- Pilih --</option>
                            <option value="0">TK</option>
                            <option value="1">SD</option>
                            <option value="2">SMP</option>
                            <option value="3">SMA</option>
                            <option value="4">SMK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IP Sekolah</label>
                        <input type="text" class="form-control" id="ip" name="ip" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Sekolah</label>
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                    <div>
                        <label for="image">Logo Sekolah</label>
                        <div class="col-md-12">
                            <input type="file" name="image">
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
<div class="modal fade" id="latlong">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_latlong_sekolah" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Sekolah</label>
                        <input type="text" class="form-control" id="nama_s" name="nama_s" readonly>
                        <input type="hidden" name="id_s" id="id_s">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jarak Absensi</label>
                        <input type="text" class="form-control" id="jarak" name="jarak" required="required">
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