<script type="text/javascript">
$(document).ready(function(){
    $("#add").click(function(){
		$('#name_m').val('');
        $('#m_link').val('');
    });
});
function editMenu(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/menu/edit_menu",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_m').val(data.id_menu);
            $('#kategori').val(data.id_parent);
            $('#name_m').val(data.nama_menu);
            $('#m_link').val(data.link);
            $('#urutan_m').val(data.urutan);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-12">
        <?php if($this->session->flashdata('msg_p')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_p'); ?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('msg_m')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_m'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h4>Isi Menu Utama</h4>
                <a class="btn btn-app" id="add" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="isi" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Parent</th>
                            <th>Nama Menu</th>
                            <th>Link</th>
                            <th>Urutan</th>
                            <th>Level</th>
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
                            <td><?php echo $dt->nama_parent; ?></td>
                            <td><?php echo $dt->nama_menu; ?></td>
                            <td><?php echo $dt->link; ?></td>
                            <td><?php echo $dt->urutan; ?></td>
                            <?php 
                                $list_level = $this->sischool_model->get_nama_level_isi_menu($dt->id_menu);
                                foreach($list_level->result() as $lvl){
                            ?>
                                <td><?php echo $lvl->level; ?></td>
                                <?php } ?>
                            <td>
                                <a class="btn bg-olive btn-flat" href="#modal-default" onclick="javascript:editMenu('<?php echo $dt->id_menu;?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>menu/delete_menu/<?php echo $dt->id_menu; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>menu/add_level_isi_menu/<?php echo $dt->id_menu; ?>" title="Tambah Level">
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
    </div>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu/save_menu">
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
                                <label for="exampleInputEmail1">Kategori</label>
                                <select class="form-control" name="kategori" id="kategori" required="required">
                                    <?php 
                                        $data = $this->sischool_model->get_parent_menu();
                                        foreach ($data->result() as $dt) {
                                        ?>
                                            <option value="<?php echo $dt->id_parent; ?>"><?php echo $dt->nama_parent; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Menu</label>
                                <input type="hidden" name="id_m" id="id_m">
                                <input type="text" class="form-control" id="name_m" name="name_m" required="required">
                            </div>            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link</label>
                                <input type="text" class="form-control" id="m_link" name="link_m" required="required" style="text-transform: lowercase">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Urutan</label>
                                <input type="number" class="form-control" name="urutan_m" id="urutan_m" required="required">
                            </div>                  
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
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->