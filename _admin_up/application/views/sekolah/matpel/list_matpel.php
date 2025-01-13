<script type="text/javascript">
function confirm_delete() {
  return confirm('Anda yakin ingin menghapus data ini?');
}
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_matpel",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_matpel').val(data.id_matpel);
            $('#nama').val(data.nama);
            $('#singkatan').val(data.singkatan);
            $('#icon').val(data.icon);
		}
	});
}
$(document).ready(function(){
    get_matpel();
    function get_matpel() {
        var sekolah	    = $('#id_sekolah').val();
        $.ajax({
            type        : 'GET',
            url         : '<?php echo base_url()?>sekolah/data_icon_matpel',
            data	    : "sekolah="+sekolah,
            async       : true,
            dataType    : 'json',
            success     : function(data){
                var html = '';
                var i;
                var no  = '1';
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                            '<td>'+no+'</td>'+
                            '<td>'+data[i].nama_matpel+'</td>'+
                            '<td>'+data[i].nama_icon+'</td>'+
                            '<td>'+
                                '<a href="#modal-default"class="btn bg-olive btn-flat" onclick="javascript:Edit('+data[i].id_matpel+')" data-toggle="modal" title="Edit"><i class="fa fa-pencil"></i></a>'+' '+
                                '<a href="<?php echo base_url(); ?>sekolah/delete_matpel/'+data[i].id_matpel+'" id="btn_hapus" class="btn bg-yellow btn-flat" onClick="return confirm_delete()" title="Hapus"><i class="fa fa-trash"></i></a>'+
                            '</td>'+
                            '</tr>'+
                    no++;
                }
                $('#show_data').html(html);
            }
        });
    }
    //Simpan
    $('#btn_simpan').on('click',function(){
        var sekolah     = $('#sekolah').val();
        var id_matpel   = $('#id_matpel').val();
        var nama        = $('#nama').val();
        var singkatan   = $('#singkatan').val();
        var icon        = $('#icon').val();
        var xs          = document.getElementById('alt');
        $.ajax({
            type        : "POST",
            url         : "<?php echo base_url('sekolah/simpan_matpel')?>",
            dataType    : "JSON",
            data        : {sekolah:sekolah, id_matpel:id_matpel, nama:nama, singkatan:singkatan, icon:icon},
            success: function(data){
                $('[name="nama"]').val("");
                $('[name="singkatan"]').val("");
                $('#modal-default').modal('hide');
                xs.style.display = "block";
                $("#alt").fadeTo(2000, 500).slideUp(500, function() {
                    $("#alt").slideUp(500);
                });
                get_matpel();
            }
        });
        return false;
    });
});
</script>
<style type="text/css">
   .divalt {
        display: none;
   }
</style>
<div class="divalt" id="alt">
    <div class="alert alert-success alert-dismissible" id="success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        Data berhasil disimpan
    </div>
</div>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Data</a>
    </div>
    <div class="box-body">
        <input type="hidden" id="id_sekolah" value="<?php echo $sekolah; ?>">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Matpel</td>
                    <td>Icon</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody id="show_data">
                
            </tbody>
        </table>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" id="add">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bab">Nama Matpel</label>
                        <input type="hidden" id="sekolah" value="<?php echo $sekolah; ?>">
                        <input type="hidden" id="id_matpel" name="id_matpel">
                        <input type="text" name="nama" id="nama" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Singkatan</label>
                        <input type="text" name="singkatan" id="singkatan" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="bab">Nama Icon</label>
                        <select class="form-control select2" name="icon" id="icon" style="width: 100%;" required="required">
                            <option value="">-- Pilih Icon --</option>
                            <?php 
                                foreach ($icon->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_icon; ?>"><?php echo $dt->nama_icon; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_simpan" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->