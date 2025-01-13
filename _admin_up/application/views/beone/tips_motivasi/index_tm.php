<script type="text/javascript">
function confirm_delete() {
  return confirm('Anda yakin ingin menghapus data ini?');
}
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_kategori_tips_motivasi",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_kategori').val(data.id_kategori);
            $('#nama').val(data.nama);
		}
	});
}
$(document).ready(function(){
    list_kategori();
    function list_kategori() {
        $.ajax({
            type        : 'GET',
            url         : '<?php echo base_url()?>beone/list_kategori_tips_motivasi',
            async       : true,
            dataType    : 'json',
            success     : function(data){
                var html = '';
                var i;
                var no  = '1';
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                            '<td>'+no+'</td>'+
                            '<td>'+data[i].nama_kategori+'</td>'+
                            '<td>'+
                                '<a href="#modal-default"class="btn bg-olive btn-flat" onclick="javascript:Edit('+data[i].id_kategori+')" data-toggle="modal" title="Edit"><i class="fa fa-pencil"></i></a>'+' '+
                                '<a href="<?php echo base_url(); ?>beone/delete_kategori/'+data[i].id_kategori+'" id="btn_hapus" class="btn bg-yellow btn-flat" onClick="return confirm_delete()" title="Hapus"><i class="fa fa-trash"></i></a>'+
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
        var id_kategori = $('#id_kategori').val();
        var nama        = $('#nama').val();
        var xs          = document.getElementById('alt');
        $.ajax({
            type        : "POST",
            url         : "<?php echo base_url('beone/simpan_kategori')?>",
            dataType    : "JSON",
            data        : {id_kategori:id_kategori, nama:nama},
            success: function(data){
                $('[name="nama"]').val("");
                $('#modal-default').modal('hide');
                xs.style.display = "block";
                $("#alt").fadeTo(2000, 500).slideUp(500, function() {
                    $("#alt").slideUp(500);
                });
                list_kategori();
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
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Kategori</a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Kategori</td>
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
                        <label for="bab">Nama Kategori</label>
                        <input type="hidden" id="id_kategori" name="id_kategori">
                        <input type="text" name="nama" id="nama" class="form-control" required="required">
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