<script type="text/javascript">
$(document).ready(function(){
    $("#lihat").click(function(){
        cari_data();
    });
	
    function cari_data(){
        var nama        = $("#nama").val();
        var badgenumber = $("#badgenumber").val();
        if(nama == "#"){
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>/master/get_data_userinfo",
                data    : "badgenumber="+badgenumber,
                cache   : false,
                success : function(data){
                    $("#view_detail").html(data);
                }
            });
        }else if(badgenumber == ""){
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>/master/get_data_userinfo",
                data    : "nama="+nama,
                cache   : false,
                success : function(data){
                    $("#view_detail").html(data);
                }
            });
        }else{
            alert("Silahkan Pilih Salah Satu")
        }
    }
});
</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <form id="my-form" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <select class="form-control select2" name="nama" id="nama" style="width: 100%;">
                            <option value="#">-- Pilih Nama --</option>
                            <?php 
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->userid; ?>"><?php echo $dt->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ID Mesin / Badgenumber *Optional</label>
                        <input type="text" class="form-control" id="badgenumber" name="badgenumber">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="input-group">
                        <button type="button" id="lihat" class="btn bg-green btn-success btn-flat-margin"><i class="fa fa-search"></i>
                            Lihat Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="view_detail"></div>