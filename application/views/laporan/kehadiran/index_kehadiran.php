<script type="text/javascript">
$(document).ready(function(){
    //Date range picker
    $('#tanggal').daterangepicker({ 
        locale: {
            format: 'DD-MM-YYYY'
        } 
    })
    $('#lokasi').change(function(){ 
        get_nama_bagian();
    });
    $('#bagian').change(function(){
        get_nama_karyawan();
    });
    function get_nama_bagian() {
        var id          = $("#lokasi").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>kontrak_kerja/list_bagian_lokasi",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#bagian").empty();
                $("#bagian").append('<option value="0">-- Semua Bagian --</option>');
				$.each(response, function(value, key) {
					$("#bagian").append('<option value='+key.id_bagian+'>'+key.nama_bagian+'</option>');
				})
            }
        });

        $.ajax({
            url         : "<?php echo site_url(); ?>kontrak_kerja/list_karyawan_lokasi",
            type        : "POST",
            data        : "id="+id,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#karyawan").empty();
                $("#karyawan").append('<option value="0">-- Semua Karyawan --</option>');
				$.each(response, function(value, key) {
					$("#karyawan").append('<option value='+key.id_karyawan+'>'+key.nama_lengkap+'</option>');
				})
            }
        });        
    }
    function get_nama_karyawan(){
        var id          = $("#bagian").val();
        var ka          = $("#kategori").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>kehadiran/list_karyawan",
            type        : "POST",
            data        : "id="+id+"&kat="+ka,
            cahce       : false,
            dataType    : "json",
            success     : function(response){
                $("#karyawan").empty();
                $("#karyawan").append('<option value="0">-- Semua Karyawan --</option>');
				$.each(response, function(value, key) {
					$("#karyawan").append('<option value='+key.id_karyawan+'>'+key.nama_lengkap+'</option>');
				})
            }
        });
    }
    $("#lihat").click(function(){
        var kategori    = $("#kategori").val();
        var tanggal     = $("#tanggal").val();
        var lokasi      = $("#lokasi").val();
        var bagian      = $("#bagian").val();
        var karyawan    = $("#karyawan").val();
        $.ajax({
            type	: 'POST',
            url		: "<?php echo site_url(); ?>/kehadiran/lihat_data",
            data	: "kategori="+kategori+"&tanggal="+tanggal+"&lokasi="+lokasi+"&bagian="+bagian+"&karyawan="+karyawan,
            cache	: false,
            success	: function(data){
                $("#view_detail").html(data);				
            }
        });
    });
    $("#resume_pdf").click(function(){
        let kategori    = $("#kategori").val();
        let tanggal     = $("#tanggal").val();
        let lokasi      = $("#lokasi").val();
        let bagian      = $("#bagian").val();
        let karyawan    = $("#karyawan").val();
        window.location = "<?php echo site_url(); ?>/kehadiran/resume_pdf?kategori="+kategori+"&tanggal="+tanggal+"&lokasi="+lokasi+"&bagian="+bagian+"&karyawan="+karyawan;
	});
    $("#resume_excel").click(function(){
        let kategori    = $("#kategori").val();
        let tanggal     = $("#tanggal").val();
        let lokasi      = $("#lokasi").val();
        let bagian      = $("#bagian").val();
        let karyawan    = $("#karyawan").val();
        window.location = "<?php echo site_url(); ?>/kehadiran/resume_excel?kategori="+kategori+"&tanggal="+tanggal+"&lokasi="+lokasi+"&bagian="+bagian+"&karyawan="+karyawan;
	});
    $("#detail_pdf").click(function(){
        let kategori    = $("#kategori").val();
        let tanggal     = $("#tanggal").val();
        let lokasi      = $("#lokasi").val();
        let bagian      = $("#bagian").val();
        let karyawan    = $("#karyawan").val();
        window.location = "<?php echo site_url(); ?>/kehadiran/detail_pdf?kategori="+kategori+"&tanggal="+tanggal+"&lokasi="+lokasi+"&bagian="+bagian+"&karyawan="+karyawan;
	});
    $("#detail_excel").click(function(){
        let kategori    = $("#kategori").val();
        let tanggal     = $("#tanggal").val();
        let lokasi      = $("#lokasi").val();
        let bagian      = $("#bagian").val();
        let karyawan    = $("#karyawan").val();
        window.location = "<?php echo site_url(); ?>/kehadiran/detail_excel?kategori="+kategori+"&tanggal="+tanggal+"&lokasi="+lokasi+"&bagian="+bagian+"&karyawan="+karyawan;
	});
});
</script>
<div class="row">
    <?php if($this->session->flashdata('msg_error')): ?>
        <div class="alert alert-danger alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg_error'); ?>
        </div>
    <?php endif; ?>
    <div class="col-md-8">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <form id="lap-karyawan">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="1">Karyawan Tetap</option>
                                    <option value="2">Karyawan Borongan</option>
                                    <option value="3">Karyawan Kontrak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="text" name="tanggal" id="tanggal" class="form-control pull-right"  required="required" autocomplete="off" placeholder="Hari-Bulan-Tahun"/>
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi</label>
                                <select name="lokasi" id="lokasi" class="form-control select2" width="100%">
                                    <option value="0">-- Semua Lokasi --</option>
                                    <?php
                                        $id_p   = $this->session->userdata('id_perusahaan');
                                        $lokasi = $this->master_model->list_lokasi($id_p);
                                        foreach($lokasi->result() as $l){
                                    ?>
                                        <option value="<?php echo $l->id_lokasi; ?>"><?php echo $l->nama_lokasi; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Bagian / Unit Kerja</label>
                                <select name="bagian" id="bagian" class="form-control select2" width="100%">
                                    <option value="0">-- Semua Bagian --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Karyawan</label>
                                <select name="karyawan" id="karyawan" class="form-control select2" width="100%">
                                    <option value="0">-- Semua Karyawan --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <button type="button" id="lihat" class="btn btn-flat bg-blue" style="width:100%;"><i class="fa fa-table"></i> Lihat Data</button>
                            <button type="button" id="resume_pdf" class="btn btn-flat bg-red" style="width:100%;"><i class="fa fa-file-pdf-o"></i> Cetak Resume (PDF)</button>
                            <button type="button" id="resume_excel" class="btn btn-flat bg-green" style="width:100%;"><i class="fa fa-file-excel-o"></i> Cetak Resume (Excel)</button>
                            <button type="button" id="detail_pdf" class="btn btn-flat bg-red" style="width:100%;"><i class="fa fa-file-pdf-o"></i> Cetak Detail (PDF)</button>
                            <button type="button" id="detail_excel" class="btn btn-flat bg-green" style="width:100%;"><i class="fa fa-file-excel-o"></i> Cetak Detail (Excel)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="view_detail"></div>