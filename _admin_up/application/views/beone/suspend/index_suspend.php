<script type="text/javascript">
$(document).ready(function(){
    $('#sekolah').change(function(){ 
        get_nama_kelas();
    });
    function get_nama_kelas() {
        var sekolah     = $("#sekolah").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>beone/list_kelas",
            type        : "POST",
            data        : "sekolah="+sekolah,
            cahce       : false,
            dataType    : 'json',
            success     : function(response){
                $("#kelas").empty();
                $("#kelas").append('<option value="">-- Pilih --</option>');
                $("#kelas").append('<option value="0">-- Semua --</option>');
				$.each(response, function(value, key) {
					$("#kelas").append('<option value='+key.kode_kelas+'>'+key.nama_kelas+'</option>');
				})
            }
        });
    }
});
</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <form role="form" method="GET" action="<?php echo base_url() ?>beone/list_suspend_murid">
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
                    <div class="form-group">
                        <label for="">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control" required="required">
                            
                        </select>
                    </div>
                    <div class="box-footer">
                        <div class="input-group">
                            <button type="submit"class="btn bg-green btn-success btn-flat-margin"><i class="fa fa-search"></i>
                                Lihat Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>