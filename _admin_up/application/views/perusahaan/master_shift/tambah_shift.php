<script type="text/javascript">
$(document).ready(function () {
    //Timepicker
    $('.timePicker').timepicker({
      showInputs: false,
      showMeridian: false
    });
    $('#jenis').change(function(){
        var j   = $("#jenis").val();
        var fj  = document.getElementById('formjam');
        var fm  = document.getElementById('masuk');
        var fk  = document.getElementById('keluar');
        var ft  = document.getElementById('telat');
        var fsh = document.getElementById('setengah_hari');
        if(j == 1){
            //non shift
            $("#masuk").attr("required","required");
            $("#keluar").attr("required","required");
            $("#telat").attr("required","required");
            $("#setengah_hari").attr("required","required");
            fj.style.display    = "block";
        }else{
            //shift
            $("#masuk").removeAttr("required");
            $("#keluar").removeAttr("required");
            $("#telat").removeAttr("required");
            $("#setengah_hari").removeAttr("required");
            fj.style.display    = "none";
        }
    });
    $('#kategori').change(function () {
        var k   = $("#kategori").val();
        var fl  = document.getElementById('formlokasi');
        var fsl = document.getElementById('formsublokasi');
        var fb  = document.getElementById('formbagian');
        if(k == 1){
            $("#formlokasi").attr("required","required");
            $("#formsublokasi").removeAttr("required");
            $("#formbagian").removeAttr("required");
            fl.style.display    = "block";
            fsl.style.display   = "none";
            fb.style.display    = "none";
        }else if(k == 2){
            $("#formlokasi").removeAttr("required","required");
            $("#formsublokasi").attr("required");
            $("#formbagian").removeAttr("required");
            fl.style.display    = "none";
            fsl.style.display   = "block";
            fb.style.display    = "none";
        }else if(k == 3){
            $("#formlokasi").removeAttr("required","required");
            $("#formsublokasi").removeAttr("required");
            $("#formbagian").attr("required");
            fl.style.display    = "none";
            fsl.style.display   = "none";
            fb.style.display    = "block";
        }else{
            $("#formlokasi").removeAttr("required","required");
            $("#formsublokasi").removeAttr("required");
            $("#formbagian").removeAttr("required");
            fl.style.display    = "none";
            fsl.style.display   = "none";
            fb.style.display    = "none";
        }
    });
});
</script>
<style type="text/css">
    #formjam{
        display: none;
    }
    #formlokasi {
        display: none;
    }
    #formsublokasi {
        display: none;
    }
    #formbagian {
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
<div class="box">
    <div class="box-header">
        <div class="box-tools pull-right">
            <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_shift/<?php echo $id_p; ?>">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_shift" enctype="multipart/form-data">
            <button type="submit" class="btn bg-red btn-success"><i class="fa fa-save"></i> Simpan</button>
            <div class="row">
            <input type="hidden" name="id_perusahaan" value="<?php echo $id_p; ?>">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control" required="required"> 
                            <option value="">-- Pilih --</option>
                            <option value="1">Non Shift</option>
                            <option value="2">Shift</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Shift</label>
                        <input type="text" name="nama_shift" id="nama_shift" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Hari <i>*Bisa pilih beberapa</i></label>
                        <select class="form-control select2" multiple="multiple" name="hari[]" style="width: 100%;" id="hari" required="required">
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                            <option value="7">Minggu</option>
                        </select>
                    </div>
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
                            <!-- time Picker -->
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
                <!-- end left col 6 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required="required">
                            <option value="">-- Pilih --</option>
                            <option value="4">Semua</option>
                            <option value="1">Lokasi</option>
                            <option value="3">Bagian</option>
                        </select>
                    </div>
                    <!-- lokasi -->
                    <div id="formlokasi">
                        <div class="form-group">
                            <label for="">Lokasi <i>*Bisa pilih beberapa</i></label>
                            <select name="lokasi[]" id="lokasi" class="form-control select2" style="width:100%;" multiple="multiple">
                                <option value="">-- Pilih --</option>
                                <?php
                                    $lokasi = $this->enterprise_model->get_lokasi($id_p);
                                    foreach ($lokasi->result() as $l) {
                                ?>
                                        <option value="<?php echo $l->id_lokasi; ?>"><?php echo $l->nama_lokasi; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- sub lokasi -->
                    <div id="formsublokasi">
                        <div class="form-group">
                            <label for="">Sub Lokasi <i>*Bisa pilih beberapa</i></label>
                            <select name="sublokasi[]" id="sublokasi" class="form-control select2" style="width:100%;" multiple="multiple">
                                <option value="">-- Pilih --</option>
                                <?php
                                    $sublokasi  = $this->enterprise_model->list_sub_lokasi2($id_p);
                                    foreach ($sublokasi->result() as $sl) {
                                ?>
                                        <option value="<?php echo $sl->id_sub_lokasi; ?>"><?php echo $sl->nama; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- bagian -->
                    <div id="formbagian">
                        <div class="form-group">
                            <label for="">Bagian <i>*Bisa pilih beberapa</i></label>
                            <select name="bagian[]" id="bagian" class="form-control select2" style="width:100%;" multiple="multiple">
                                <option value="">-- Pilih --</option>
                                <?php
                                    $bagian  = $this->enterprise_model->list_bagian2($id_p);
                                    foreach ($bagian->result() as $b) {
                                ?>
                                        <option value="<?php echo $b->id_bagian; ?>"><?php echo $b->nama_bagian; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- end right col 6 -->
            </div>
        </form>
    </div>
</div>