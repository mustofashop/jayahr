<script type="text/javascript">
$(document).ready(function(){
    //pilih perusahaan
    $('#perusahaan').change(function () {
        var id          = $("#perusahaan").val();
        if(id == ""){
            $("#lokasi").empty();
            $("#bagian").empty();
        }else{
            $.ajax({
                url         : "<?php echo site_url(); ?>Enterprise/karyawan/list_lokasi",
                type        : "POST",
                data        : "id="+id,
                cahce       : false,
                dataType    : 'json',
                success     : function(response){
                    $("#lokasi").empty();
                    $("#lokasi").append('<option value="">-- Semua --</option>');
                    $("#bagian").append('<option value="">-- Semua --</option>');
                    $.each(response, function(value, key) {
                        $("#lokasi").append('<option value='+key.id_lokasi+'>'+key.nama_lokasi+'</option>');
                    })
                }
            });
        }
    });
    //pilih lokasi
    $('#lokasi').change(function () {
        var id      = $("#lokasi").val();
        if(id == ""){
            $("#bagian").empty();
            $("#bagian").append('<option value="">-- Semua --</option>');
        }else{
            $.ajax({
                url         : "<?php echo site_url(); ?>Enterprise/karyawan/list_bagian",
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
        }
    });
});
</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <form role="form" method="GET" action="<?php echo base_url(); ?>users_k/list_user_karyawan">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Perusahaan</label>
                        <select name="perusahaan" id="perusahaan" class="form-control select2" required="required">
                            <option value="">-- Pilih --</option>
                            <?php 
                                $p  = $this->exim_model->list_perusahaan_postgresql();
                                foreach ($p->result() as $dt) {
                            ?>
                                    <option value="<?php echo $dt->id_perusahaan; ?>"><?php echo $dt->nama_perusahaan; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <!-- lokasi -->
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <select class="form-control select2" name="lokasi" id="lokasi" style="width:100%;">
                        
                        </select>
                    </div>
                    <!-- bagian -->
                    <div class="form-group">
                        <label for="">Bagian</label>
                        <select class="form-control select2" name="bagian" id="bagian" style="width:100%;">
                        
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit"class="btn bg-green btn-success btn-flat-margin"><i class="fa fa-search"></i>
                        Lihat Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>