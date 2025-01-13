<script type="text/javascript">
$(document).ready(function(){
    $(".add-more").click(function(){ 
        var html = $(".copy").html();
        $(".form1").after(html);
        $("#nama_jurusan").attr("required","required");
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".control-group").remove();
        $("#nama_jurusan").removeAttr("required","required");
    });
});
function Edit(ID){
	var id	    = ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_jurusan",
		data	: "id="+id,
		dataType: "json",
		success	: function(data){
            $('#id').val(data.id);
            $('#nama').val(data.nama_jurusan);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-8">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->beone_model->list_jurusan();
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_jurusan; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal-edit" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>beone/delete_jurusan/<?php echo $dt->id; ?>" title="delete" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $no++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_edit_jurusan">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Jurusan</label>
                        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required="required">
                        <input type="hidden" name="id" id="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_jurusan">
                <div class="modal-body">
                    <!-- form real -->
                    <div class="form1">
                        <div class="row control-group">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Nama Jurusan</label>
                                    <input type="text" class="form-control" name="nama_jurusan[]" required="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tambah</label>
                                    <br>
                                    <button type="button" class="btn bg-blue waves-effect add-more">
                                        <i class="material-icons">add</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form clone -->
                    <div class="copy hide">
                        <div class="row control-group">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Nama Jurusan</label>
                                    <input type="text" class="form-control" name="nama_jurusan[]" id="nama_jurusan">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Hapus</label>
                                    <br>
                                    <button type="button" class="btn bg-red waves-effect remove">
                                        <i class="material-icons">close</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>