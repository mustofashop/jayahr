<script type="text/javascript">
$(document).ready(function(){
    $("#tambah").click(function(){
		$('#name').val('');
        $('#id').val('');
    });
    $("input#link_p").on({
        keydown: function(e) {
            if (e.which === 32)
            return false;
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });
});
function editParent(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/menu/edit_parent",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_p').val(data.id_parent);
            $('#nama_p').val(data.nama_parent);
            $('#link_p').val(data.link_parent);
            $('#logo_p').val(data.logo);
            $('#urutan_p').val(data.urutan);
		}
	});
}
</script>
<div class="box">
    <div class="box-header">
        <h4>Kategori Menu</h4>
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-parent"><i class="fa fa-plus"></i> Tambah Data</a>
        <!-- <div class="box-tools pull-right">
            <button>test</button>
        </div> -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Parent</th>
                <th>Link Parent</th>
                <th>Logo</th>
                <th>Level</th>
                <th>Urutan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php  
                $no     = 1;
                foreach ($data_p->result() as $dt) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $dt->nama_parent; ?></td>
                <td><?php echo $dt->link_parent; ?></td>
                <td><?php echo $dt->logo; ?></td>
                <td><?php echo $dt->level; ?></td>
                <td><?php echo $dt->urutan; ?></td>
                <td>
                    <a class="btn bg-olive btn-flat" href="#modal-parent-edit" onclick="javascript:editParent('<?php echo $dt->id_parent;?>')" data-toggle="modal" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>menu/add_level_menu/<?php echo $dt->id_parent; ?>" title="Tambah Level">
                            <i class="fa fa-plus"></i>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box parent menu -->
<div class="modal fade" id="modal-parent">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu/save_kategori">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama_p" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link Kategori</label>
                                <input type="text" class="form-control" name="link_p" required="required" style="text-transform: lowercase">
                            </div>         
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Logo | <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank"><i>cek logo disini</i></a></label>
                                <input type="text" class="form-control" name="logo_p" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Urutan</label>
                                <input type="number" class="form-control" name="urutan_p" required="required">
                            </div>        
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Level <i>*Bisa Klik Beberapa Level</i></label>
                        <select class="form-control select2" name="level[]" id="level" multiple="multiple" data-placeholder="Pilih Menu" required="required" style="width: 100%;">
                            <option value="0">Admin Sekolah</option>
                            <option value="1">Yayasan</option>
                            <option value="2">Kepsek</option>
                            <option value="3">Guru</option>
                            <option value="4">TU</option>
                            <option value="5">BP</option>
                            <option value="6">Walas</option>
                        </select>
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
<div class="modal fade" id="modal-parent-edit">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu/save_kategori">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Kategori</label>
                        <input type="hidden" name="id_p" id="id_p">
                        <input type="text" class="form-control" id="nama_p" name="nama_p" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Link Kategori</label>
                        <input type="text" class="form-control" id="link_p" name="link_p" required="required" style="text-transform: lowercase">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Logo | <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank"><i>cek logo disini</i></a></label>
                        <input type="text" class="form-control" id="logo_p" name="logo_p" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Urutan</label>
                        <input type="number" class="form-control" id="urutan_p" name="urutan_p" required="required">
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