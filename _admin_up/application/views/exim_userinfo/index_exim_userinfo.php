<script type="text/javascript">
$(document).ready(function(){
    $(".date-picker").datepicker( {
		format: "yyyy-mm",
		viewMode: "months", 
        minViewMode: "months",
        autoclose: true
	});
    $('#kategori').change(function () {
        var k   = $("#kategori").val();
        var fp  = document.getElementById('form_p');
        var fp1 = document.getElementById('form_p1');
        var fs  = document.getElementById('form_s');
        var fs1 = document.getElementById('form_s1');
        var fg  = document.getElementById('form_g');
        var fg1 = document.getElementById('form_g1');
        if(k == 1){
            $("#perusahaan").attr("required","required");
            $("#sekolah_g").removeAttr("required");
            $("#sekolah").removeAttr("required");
            fp.style.display    = "block";
            fp1.style.display   = "block";
            fs.style.display    = "none";
            fs1.style.display   = "none";
            fg.style.display    = "none";
            fg1.style.display   = "none";
        }else if(k == 2){
            $("#sekolah").attr("required","required");
            $("#sekolah_g").removeAttr("required");
            $("#perusahaan").removeAttr("required");
            fs.style.display    = "block";
            fs1.style.display   = "block";
            fp.style.display    = "none";
            fp1.style.display   = "none";
            fg.style.display    = "none";
            fg1.style.display   = "none";
        }else{
            $("#sekolah").removeAttr("required");
            $("#sekolah_g").attr("required","required");
            $("#perusahaan").removeAttr("required");
            fs.style.display    = "none";
            fs1.style.display   = "none";
            fp.style.display    = "none";
            fp1.style.display   = "none";
            fg.style.display    = "block";
            fg1.style.display   = "block";
        }
    });
    //pilih perusahaan
    $('#perusahaan').change(function () {
        var id  =   $("#perusahaan").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_bagian_mysql",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#bagian").empty();
                $("#bagian").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#bagian").append('<option value='+key.id_bagian+'>'+key.nama_bagian+'</option>');
				})
            }
        });

        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_karyawan_mysql",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#karyawan").empty();
                $("#karyawan").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#karyawan").append('<option value='+key.userid+'>'+key.name+'</option>');
				})
            }
        });
    });
    //pilih bagian
    $('#bagian').change(function () {
        var id  =   $("#bagian").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_karyawan_bagian_mysql",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#karyawan").empty();
                $("#karyawan").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#karyawan").append('<option value='+key.userid+'>'+key.name+'</option>');
				})
            }
        });
    });
    //pilih sekolah murid
    $('#sekolah').change(function () {
        var id  =   $("#sekolah").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_kelas_mysql",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#kelas").empty();
                $("#kelas").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#kelas").append('<option value='+key.kode_kelas+'>'+key.nama_kelas+'</option>');
				})
            }
        });

        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_murid_mysql",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#murid").empty();
                $("#murid").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#murid").append('<option value='+key.badgenumber+'>'+key.name+'</option>');
				})
            }
        });
    });
    //pilih kelas
    $('#kelas').change(function () {
        var id  =   $("#kelas").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_murid_kelas_mysql",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#murid").empty();
                $("#murid").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#murid").append('<option value='+key.badgenumber+'>'+key.name+'</option>');
				})
            }
        });
    });
    //pilih sekolah guru
    $('#sekolah_g').change(function () {
        var id  =   $("#sekolah_g").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_guru_mysql",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#guru").empty();
                $("#guru").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#guru").append('<option value='+key.badgenumber+'>'+key.name+'</option>');
				})
            }
        });
    });
});
</script>
<style type="text/css">
   #form_p {
        display: none;
   }
   #form_p1{
        display: none;
   }
   #form_s {
        display: none;
   }
   #form_s1{
        display: none;
   }
   #form_g {
        display: none;
   }
   #form_g1{
        display: none;
   }
</style>
<div class="box">
    <form role="form" method="GET" action="<?php echo base_url(); ?>exim_userinfo/list_userinfo" enctype="multipart/form-data">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required="required">
                            <option value="">-- Pilih --</option>
                            <option value="1">Karyawan</option>
                            <option value="2">Murid</option>
                            <option value="3">Guru</option>
                        </select>
                    </div>
                    <div id="form_p">
                        <div class="form-group">
                            <label for="">Perusahaan (Mysql)</label>
                            <select class="form-control select2" name="perusahaan" id="perusahaan" style="width: 100%;">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    $data_p = $this->exim_model->list_perusahaan_mysql();
                                    foreach($data_p->result() as $dp){
                                ?>
                                        <option value="<?php echo $dp->id_perusahaan; ?>"><?php echo $dp->nama_perusahaan; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="form_s">
                        <div class="form-group">
                            <label for="">Sekolah (Mysql)</label>
                            <select class="form-control select2" name="sekolah" id="sekolah" style="width: 100%;">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    $data_s = $this->exim_model->list_sekolah_mysql();
                                    foreach($data_s->result() as $ds){
                                ?>
                                        <option value="<?php echo $ds->id_sekolah; ?>"><?php echo $ds->nama_sekolah; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="form_g">
                        <div class="form-group">
                            <label for="">Sekolah (Mysql)</label>
                            <select class="form-control select2" name="sekolah_g" id="sekolah_g" style="width: 100%;">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    $data_s = $this->exim_model->list_sekolah_mysql();
                                    foreach($data_s->result() as $ds){
                                ?>
                                        <option value="<?php echo $ds->id_sekolah; ?>"><?php echo $ds->nama_sekolah; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="form_p1">
                        <div class="form-group">
                            <label for="">UK / Bagian (Mysql)</label>
                            <select class="form-control select2" name="bagian" id="bagian" style="width: 100%;">
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Karyawan (Mysql)</label>
                            <select class="form-control select2" name="karyawan" id="karyawan" style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                    <div id="form_s1">
                        <div class="form-group">
                            <label for="">Kelas (Mysql)</label>
                            <select class="form-control select2" name="kelas" id="kelas" style="width: 100%;">
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Murid (Mysql)</label>
                            <select class="form-control select2" name="murid" id="murid" style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                    <div id="form_g1">
                        <div class="form-group">
                            <label for="">Nama Guru (Mysql)</label>
                            <select class="form-control select2" name="guru" id="guru" style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Lihat Data</button>
        </div>
    </form>
</div>