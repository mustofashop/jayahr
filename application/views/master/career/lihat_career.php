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
            <a class="btn btn-app" href="<?php echo base_url(); ?>m_career/list_karyawan?kategori=<?php echo $kategori; ?>">
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
                    <th>Effective Date</th>
                    <th>Range Year</th>
                    <th>Job Title</th>
                    <th>Organization Unit</th>
                    <th>Job Grade</th>
                    <th>Employee Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->master_model->list_career($nrp);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $dt->effective_date; ?></td>
                        <td><?php echo $dt->range_year; ?></td>
                        <td><?php echo $dt->job_title; ?></td>
                        <td><?php echo $dt->organization_unit; ?></td>
                        <td><?php echo $dt->job_grade; ?></td>
                        <td><?php echo $dt->employee_status; ?></td>
                        <td>
                            <!-- edit -->
								<a class="btn bg-olive btn-flat" data-target="#edit" onclick="javascript:Edit('<?php echo $dt->id_trans_career;?>')" data-toggle="modal" title="Edit <?php echo $dt->effective_date; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <!-- delete -->
                                <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>m_career/hapus_career/<?php echo $dt->id_trans_career; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus <?php echo $dt->effective_date; ?>">
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
            url		: "<?php echo site_url(); ?>/m_career/edit_career",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_trans_career').val(data.id_trans_career);
                $('#effective_date').val(data.effective_date);
                $('#range_year').val(data.range_year);
                $('#job_title').val(data.job_title);
                $('#organization_unit').val(data.organization_unit);
                $('#job_grade').val(data.job_grade);
                $('#employee_status').val(data.employee_status);
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
            <form method="POST" action="<?php echo base_url(); ?>m_career/simpan_career/<?php echo $nrp ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Effective Date (YYYY-MM-DD)</label>
                        <input type="text" name="effective_date" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Range Year</label>
                        <input type="text" name="range_year" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Job Title</label>
                        <input type="text" name="job_title" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Organization Unit</label>
                        <input type="text" name="organization_unit" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Job Grade</label>
                        <input type="text" name="job_grade" class="form-control"">
                    </div>
					<div class="form-group">
                        <label for="">Employee Status</label>
                        <input type="text" name="employee_status" class="form-control"">
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
            <form method="POST" action="<?php echo base_url(); ?>m_career/simpan_edit_career" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" range_year="id_trans_career" id="id_trans_career">
                    <div class="form-group">
                        <label for="">Effective Date (YYYY-MM-DD)</label>
                        <input type="text" range_year="effective_date" id="effective_date" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Range Year</label>
                        <input type="text" range_year="range_year" id="range_year" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Job Title</label>
                        <input type="text" range_year="job_title" id="job_title" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Organization Unit</label>
                        <input type="text" range_year="organization_unit" id="organization_unit" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Job Grade</label>
                        <input type="text" range_year="job_grade" id="job_grade" class="form-control">
                    </div>
					<div class="form-group">
                        <label for="">Employee Status</label>
                        <input type="text" range_year="job_grade" id="employee_status" class="form-control">
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

