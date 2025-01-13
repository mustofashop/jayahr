<script type="text/javascript">
    $(function() {
        $(".date-picker").datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
        });
    });
$(document).ready(function(){
    $('#jenis').change(function(){
        $('#sekolah').val(''); 
    }); 
    $('#sekolah').change(function(){ 
        var id      = $("#sekolah").val();
        var jenis   = $("#jenis").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>master/get_nama_edit_gmt",
            type        : "POST",
            data        : "id="+id+"&jenis="+jenis,
            cahce       : false,
            dataType    : 'json',
            success     : function(data){
                var html = '';
                var i;
                for(i = 0; i < data.length; i++){
                    html += '<option value='+data[i].userid+'>'+data[i].nama+'</option>';
                }
                $('#nama').html(html);
            }
        });
    }); 
});
</script>
<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg_error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_error'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <form method="GET" action="<?php echo base_url(); ?>master/get_data_edit_gmt">
                <div class="box-body">
                    <div class="form-group">
                        <label for="jenis">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control" required="required">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="1">Guru</option>
                            <option value="2">Murid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sekolah</label>
                        <select class="form-control select2" name="sekolah" id="sekolah" style="width: 100%;" required="required">
                            <option value="#">-- Pilih Sekolah --</option>
                            <?php 
                                foreach ($sekolah->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="murid">Nama</label>
                        <select name="nama" id="nama" class="form-control select2" style="width: 100%;">
                        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bulan</label>
                        <input type="text" name="bulan" id="bulan" class="form-control date-picker"  data-date-format="yyyy-mm" required="required" autocomplete="off" placeholder="Tahun-Bulan"/>
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