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
                            <th>Nama Penerbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->beone_model->list_penerbit();
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_penerbit; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>beone/delete_penerbit/<?php echo $dt->id; ?>" title="delete" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
<script type="text/javascript">
function Edit(ID){
	var id	    = ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_penerbit",
		data	: "id="+id,
		dataType: "json",
		success	: function(data){
            $('#id').val(data.id);
            $('#nama').val(data.nama_penerbit);
		}
	});
}
</script>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_penerbit">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Penerbit</label>
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