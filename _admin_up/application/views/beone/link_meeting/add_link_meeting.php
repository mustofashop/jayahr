<script>
$(document).ready(function(){
    $('#jenis').change(function () {
        var j   = $("#jenis").val();
        var fs  = document.getElementById('formsekolah');
        var fk  = document.getElementById('formkelas');
        if(j == 1){
            fs.style.display    = "block";
            fk.style.display    = "none";
        }else if(j == 2){
            fs.style.display    = "none";
            fk.style.display    = "block";
        }else{
            fs.style.display    = "none";
            fk.style.display    = "none";
        }
    });
    $('#sekolah2').change(function(){ 
        var sekolah     = $("#sekolah2").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>beone/list_kelas",
            type        : "POST",
            data        : "sekolah="+sekolah,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#kelas").empty();
                $("#kelas").append('<option value="">-- Pilih --</option>');
                $.each(response, function(value, key) {
                    $("#kelas").append('<option value='+key.kode_kelas+'>'+key.nama_kelas+'</option>');
                })
            }
        });

        $.ajax({
            url         : "<?php echo site_url(); ?>beone/list_kelas",
            type        : "POST",
            data        : "sekolah="+sekolah,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#kelas2").empty();
                $("#kelas2").append('<option value="">-- Pilih --</option>');
                $.each(response, function(value, key) {
                    $("#kelas2").append('<option value='+key.kode_kelas+'>'+key.nama_kelas+'</option>');
                })
            }
        });
    });
    $(".add-more").click(function(){ 
        var html = $(".copy").html();
        $(".form_meeting").after(html);
        $("#kelas2").select2();
        $("#sekolah2").attr("required","required");
        $("#kelas2").attr("required","required");
        $("#jenis2").attr("required","required");
        $("#link2").attr("required","required");
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".control-group").remove();
        $("#sekolah2").removeAttr("required","required");
        $("#kelas2").removeAttr("required","required");
        $("#jenis2").removeAttr("required","required");
        $("#link2").removeAttr("required","required");
    });
});
</script>
<style type="text/css">
   #formsekolah {
        display: none;
   }
   #formkelas {
        display: none;
   }
</style>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-4">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label for="">Jenis Link</label>
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="1">Per Sekolah</option>
                        <option value="2">Per Kelas</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4" id="formsekolah">
        <div class="box">
            <div class="box-header"> 
                <h3 class="box-title">Sekolah</h3>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_link_sekolah"> 
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Sekolah</label>
                        <select class="form-control select2" name="sekolah" id="sekolah" style="width: 100%;" required="required">
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
                        <input type="hidden" name="id_link_meeting_sekolah">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Link</label>
                        <select name="jenis_link" class="form-control" required="required">
                            <option value="">-- Pilih --</option>
                            <option value="1">ZOOM</option>
                            <option value="2">Google Meet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Link Meeting</label>
                        <input type="text" name="link" class="form-control" required="required">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-8" id="formkelas">
        <div class="box">
            <div class="box-header"> 
                <h3 class="box-title">Kelas</h3>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_link_kelas"> 
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Sekolah</label>
                        <select class="form-control select2" name="sekolah" id="sekolah2" style="width: 100%;" required="required">
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
                    <div class="form_meeting">
                        <div class="row control-group">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Kelas</label>
                                    <select class="form-control select2" name="kelas[]" id="kelas" style="width: 100%;" required="required">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Jenis Aplikasi</label>
                                    <select name="jenis[]" id="jenis" class="form-control" required="required">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Zoom</option>
                                        <option value="2">Google Meet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Link</label>
                                    <input type="text" name="link[]" id="link" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tambah</label>
                                    <br>
                                    <button type="button" class="btn bg-blue waves-effect add-more">
                                        <i class="material-icons">add</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form meeting close -->
                    <!-- clone form -->
                    <div class="copy hide">
                        <div class="row control-group">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Kelas</label>
                                    <select class="form-control" name="kelas[]" id="kelas2" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Jenis Aplikasi</label>
                                    <select name="jenis[]" id="jenis2" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Zoom</option>
                                        <option value="2">Google Meet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Link</label>
                                    <input type="text" name="link[]" id="link2" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Hapus</label>
                                    <br>
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