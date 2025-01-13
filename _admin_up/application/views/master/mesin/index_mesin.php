<script type="text/javascript">
$(document).ready(function(){
    $("#tambah").click(function(){
		$('#id_mesin').val('');
        $('#sekolah').val('');
        $('#sn').val('');
        $('#lokasi').val('');
    });
});
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/master/edit_mesin",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#kategori').val(data.kategori);
            var s   = document.getElementById('s');
            var p   = document.getElementById('p');
            if(data.kategori == '1'){
                $('#sekolah').val(data.id_sekolah);
                $("#sekolah").attr("required","required");
                $("#perusahaan").removeAttr("required");
                s.style.display     = "block";
                p.style.display     = "none";
            }else{
                $('#perusahaan').val(data.id_perusahaan);
                $("#perusahaan").attr("required","required");
                $("#sekolah").removeAttr("required");
                s.style.display     = "none";
                p.style.display     = "block";
            }
            $('#id_mesin').val(data.id_mesin);
            $('#sn').val(data.sn);
            $('#lokasi').val(data.lokasi);
		}
	});
}
</script>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a id="tambah" data-toggle="modal" data-target="#add" class="btn bg-blue btn-flat margin">Tambah</a>
        <a data-toggle="modal" data-target="#excel" class="btn bg-green btn-flat margin">Import Data Excel</a>
    </div>
    <div class="box-body">
        <form id="checkform">
            <label>List Menu</label>
            <table id="isi" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>SN</th>
                        <th>Pelanggan</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $no     = 1;
                        foreach ($data->result() as $dt) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <?php if($dt->kategori == '1'){ ?>
                            <td>Sekolah</td>
                        <?php }else{ ?>
                            <td>Perusahaan</td>
                        <?php } ?>
                        <td><?php echo $dt->sn_mesin; ?></td>
                        <td><?php echo $dt->nama_pelanggan; ?></td>
                        <td><?php echo $dt->lokasi; ?></td>
                        <td>
                            <a class="btn bg-olive btn-flat" href="#add" onclick="javascript:Edit('<?php echo $dt->id_mesin;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>master/delete_mesin/<?php echo $dt->id_mesin; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script type="text/javascript">
$(document).ready(function(){
    $('#kategori').change(function () {
        var k   = $("#kategori").val();
        var s   = document.getElementById('s');
        var p   = document.getElementById('p');
        if(k == '1'){
            $("#sekolah").attr("required","required");
            $("#perusahaan").removeAttr("required");
            s.style.display     = "block";
            p.style.display     = "none";
        }else{
            $("#perusahaan").attr("required","required");
            $("#sekolah").removeAttr("required");
            s.style.display     = "none";
            p.style.display     = "block";
        }
    });
});
</script>
<style type="text/css">
   #p {
        display: none;
   }
   #s{
        display: none;
   }
</style>
<div class="modal fade" id="add">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/save_mesin">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required="required">
                            <option value="">-- PILIH --</option>
                            <option value="1">Sekolah</option>
                            <option value="2">Perusahaan</option>
                        </select>
                    </div>
                    <div class="form-group" id="s">
                        <label for="exampleInputEmail1">Sekolah</label>
                        <input type="hidden" name="id_mesin" id="id_mesin">
                        <select class="form-control" name="sekolah" id="sekolah" style="width: 100%;">
                            <option value="">-- Pilih Sekolah --</option>
                            <?php 
                                $data = $this->sischool_model->get_sekolah();
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" id="p">
                        <label for="">Perusahaan</label>
                        <select name="perusahaan" id="perusahaan" class="form-control">
                            <option value="">-- Pilih Perusahaan --</option>
                            <?php 
                                $data = $this->exim_model->list_perusahaan_postgresql();
                                foreach ($data->result() as $p) {
                            ?>
                                    <option value="<?php echo $p->id_perusahaan; ?>"><?php echo $p->nama_perusahaan; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">SN</label>
                        <input type="text" class="form-control" id="sn" name="sn" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /.box -->
<div class="modal fade" id="excel">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/upload_mesin" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="import">Upload Mesin</label>
                        <div class="col-md-12">
                            <?php echo form_upload('file_excel');?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>                           
    </div>
</div>