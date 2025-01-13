<script type="text/javascript">
$(document).ready(function(){
    $(".date-picker").datepicker( {
		format: "yyyy-mm",
		viewMode: "months", 
        minViewMode: "months",
        autoclose: true
	});
    //pilih perusahaan
    $('#perusahaan').change(function () {
        var id  =   $("#perusahaan").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_bagian_postgre",
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
            url         : "<?php echo site_url(); ?>exim_absen/get_karyawan_postgre",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#karyawan").empty();
                $("#karyawan").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#karyawan").append('<option value='+key.id_karyawan+'>'+key.nama_lengkap+'</option>');
				})
            }
        });
    });
    //pilih bagian
    $('#bagian').change(function () {
        var id  =   $("#bagian").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_karyawan_bagian_postgre",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#karyawan").empty();
                $("#karyawan").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#karyawan").append('<option value='+key.id_karyawan+'>'+key.nama_lengkap+'</option>');
				})
            }
        });
    });
    //pilih sekolah murid
    $('#sekolah').change(function () {
        var id  =   $("#sekolah").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_kelas_postgre",
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
            url         : "<?php echo site_url(); ?>exim_absen/get_murid_postgre",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#murid").empty();
                $("#murid").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#murid").append('<option value='+key.userid+'>'+key.name+'</option>');
				})
            }
        });
    });
    //pilih kelas
    $('#kelas').change(function () {
        var id  =   $("#kelas").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_murid_kelas_postgre",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#murid").empty();
                $("#murid").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#murid").append('<option value='+key.userid+'>'+key.name+'</option>');
				})
            }
        });
    });
    //pilih sekolah guru
    $('#sekolah_g').change(function () {
        var id  =   $("#sekolah_g").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>exim_absen/get_guru_postgre",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#guru").empty();
                $("#guru").append('<option value="">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#guru").append('<option value='+key.userid+'>'+key.name+'</option>');
				})
            }
        });
    });
     //Date range picker
     $('#tanggal').daterangepicker({ 
        locale: {
            format: 'YYYY-MM-DD'
        } 
    })
});
</script>
<div class="row">
    <div class="col-md-6">
    <?php if($this->session->flashdata('msg1')): ?>
        <div class="alert alert-danger alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg1'); ?>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
        <div class="box">
            <form role="form" method="GET" action="<?php echo base_url(); ?>exim_absen/list_check_data_postgresql" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="text" name="tanggal" id="tanggal" class="form-control pull-right"  required="required" autocomplete="off" placeholder="Tahun-Bulan-Hari"/>
                    </div>
                    <input type="hidden" name="kategori" value="<?php echo $kategori; ?>">
                    <?php
                        if($kategori == '1'){
                            //perusahaan
                    ?>
                        <div class="form-group">
                            <label for="">Perusahaan (Postgre)</label>
                            <select class="form-control select2" name="perusahaan" id="perusahaan" style="width: 100%;">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    $data_p = $this->exim_model->list_perusahaan_postgresql();
                                    foreach($data_p->result() as $dp){
                                ?>
                                        <option value="<?php echo $dp->id_perusahaan; ?>"><?php echo $dp->nama_perusahaan; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">UK / Bagian (Postgre)</label>
                            <select class="form-control select2" name="bagian" id="bagian" style="width: 100%;">
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Karyawan (Postgre)</label>
                            <select class="form-control select2" name="karyawan" id="karyawan" style="width: 100%;">
                                
                            </select>
                        </div>
                    <?php
                        }elseif($kategori == '2'){
                            //sekolah murid
                    ?>
                        <div class="form-group">
                            <label for="">Sekolah (Postgre)</label>
                            <select class="form-control select2" name="sekolah" id="sekolah" style="width: 100%;">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    $data_s = $this->exim_model->list_sekolah_postgresql();
                                    foreach($data_s->result() as $ds){
                                ?>
                                        <option value="<?php echo $ds->id_sekolah; ?>"><?php echo $ds->nama_sekolah; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kelas (Postgre)</label>
                            <select class="form-control select2" name="kelas" id="kelas" style="width: 100%;">
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Murid (Postgre)</label>
                            <select class="form-control select2" name="murid" id="murid" style="width: 100%;">
                                
                            </select>
                        </div>
                    <?php
                        }else{
                            //sekolah guru
                    ?>
                        <div class="form-group">
                            <label for="">Sekolah (Postgre)</label>
                            <select class="form-control select2" name="sekolah_g" id="sekolah_g" style="width: 100%;">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    $data_s = $this->exim_model->list_sekolah_postgresql();
                                    foreach($data_s->result() as $ds){
                                ?>
                                        <option value="<?php echo $ds->id_sekolah; ?>"><?php echo $ds->nama_sekolah; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Guru (Postgre)</label>
                            <select class="form-control select2" name="guru" id="guru" style="width: 100%;">
                                
                            </select>
                        </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Lihat Data</button>
                </div>
            </form>
        </div>
    </div>
</div>