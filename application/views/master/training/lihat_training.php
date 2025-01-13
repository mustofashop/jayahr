<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('msg_error')): ?>
    <div class="alert alert-danger alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
            <a class="btn btn-app" href="<?php echo base_url(); ?>m_training/list_karyawan?kategori=<?php echo $kategori; ?>">
				<i class="fa fa-arrow-left"></i>
				Kembali
			</a>
			<a class="btn btn-app" data-toggle="modal" data-target="#tambah" title="Tambah Assessment">
                <i class="fa fa-plus"></i>
                Tambah Data
            </a>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Training Course</th>
                    <th>Training Topic</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->master_model->list_training($nrp);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $dt->training_course; ?></td>
                        <td><?php echo $dt->training_topic; ?></td>
                        <td><?php echo $dt->start_date; ?></td>
                        <td><?php echo $dt->end_date; ?></td>
                        <td>
                            <!-- edit -->
								<a class="btn bg-olive btn-flat" data-target="#edit" onclick="javascript:Edit('<?php echo $dt->id_trn_training;?>')" data-toggle="modal" title="Edit <?php echo $dt->training_course; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <!-- delete -->
                                <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>m_training/hapus_training/<?php echo $dt->id_trn_training; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus <?php echo $dt->training_course; ?>">
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
<script type="text/javascript">
    $(document).ready(function() {
        $(".add_field_button").click(function(){ 
            var html = $(".copy").html();
            $(".real").after(html);
        });
        $("body").on("click",".remove_field_button",function(){ 
            $(this).parents(".control-group").remove();
        });
    });
    function Edit(ID){
        var id  = ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/m_training/edit_training",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_trn_training').val(data.id_trn_training);
                $('#training_course').val(data.training_course);
                $('#training_topic').val(data.training_topic);
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
            }
        });
    }
</script>
<!-- Modal tambah -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?> | Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url(); ?>m_training/simpan_training/<?php echo $nrp ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Training Course</label>
                        <input type="text" name="training_course" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Training Topic</label>
                        <input type="text" name="training_topic" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Start Date (YYYY-MM-DD)</label>
                        <input type="text" name="start_date" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">End Date (YYYY-MM-DD)</label>
                        <input type="text" name="end_date" class="form-control" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal edit -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?> | Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url(); ?>m_training/simpan_edit_training" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_trn_training" id="id_trn_training">
                    <div class="form-group">
                        <label for="">Training Course</label>
                        <input type="text" name="training_course" id="training_course" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Testing Date</label>
                        <input type="text" name="training_topic" id="training_topic" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Start Date (YYYY-MM-DD)</label>
                        <input type="text" name="start_date" id="start_date" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">End Date (YYYY-MM-DD)</label>
                        <input type="text" name="end_date" id="end_date" class="form-control" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

