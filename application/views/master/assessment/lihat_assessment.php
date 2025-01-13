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
            <a class="btn btn-app" href="<?php echo base_url(); ?>m_assessment/list_karyawan?kategori=<?php echo $kategori; ?>">
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
                    <th>Subject</th>
                    <th>Testing Date</th>
                    <th>Institution</th>
                    <th>Score</th>
                    <th>Result Description</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->master_model->list_assessment($nrp);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $dt->subject; ?></td>
                        <td><?php echo $dt->testing_date; ?></td>
                        <td><?php echo $dt->institution; ?></td>
                        <td><?php echo $dt->institution_score; ?></td>
                        <td><?php echo $dt->result_description; ?></td>
                        <td>
                            <!-- edit -->
								<a class="btn bg-olive btn-flat" data-target="#edit" onclick="javascript:Edit('<?php echo $dt->id_job_assessment;?>')" data-toggle="modal" title="Edit <?php echo $dt->subject; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <!-- delete -->
                                <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>m_assessment/hapus_assessment/<?php echo $dt->id_job_assessment; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus <?php echo $dt->subject; ?>">
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
            url		: "<?php echo site_url(); ?>/m_assessment/edit_assessment",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_job_assessment').val(data.id_job_assessment);
                $('#subject').val(data.subject);
                $('#testing_date').val(data.testing_date);
                $('#institution').val(data.institution);
                $('#institution_score').val(data.institution_score);
                $('#result_description').val(data.result_description);
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
            <form method="POST" action="<?php echo base_url(); ?>m_assessment/simpan_assessment/<?php echo $nrp ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" name="subject" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Testing Date (YYYY-MM-DD)</label>
                        <input type="text" name="testing_date" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Institution</label>
                        <input type="text" name="institution" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Score</label>
                        <input type="text" name="institution_score" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Result Description</label>
                        <input type="text" name="result_description" class="form-control"">
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
            <form method="POST" action="<?php echo base_url(); ?>m_assessment/simpan_edit_assessment" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_job_assessment" id="id_job_assessment">
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Testing Date</label>
                        <input type="text" name="testing_date" id="testing_date" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Institution</label>
                        <input type="text" name="institution" id="institution" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Score</label>
                        <input type="text" name="institution_score" id="institution_score" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Result Description</label>
                        <input type="text" name="result_description" id="result_description" class="form-control">
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

