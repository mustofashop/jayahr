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
            <a class="btn btn-app" href="<?php echo base_url(); ?>m_education/list_karyawan?kategori=<?php echo $kategori; ?>">
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
                    <th>Level</th>
                    <th>Name</th>
                    <th>Major</th>
                    <th>Period</th>
                    <th>City</th>
                    <th>GPA</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->master_model->list_education($nrp);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $dt->level; ?></td>
                        <td><?php echo $dt->name; ?></td>
                        <td><?php echo $dt->major; ?></td>
                        <td><?php echo $dt->period; ?></td>
                        <td><?php echo $dt->city; ?></td>
                        <td><?php echo $dt->gpa; ?></td>
                        <td>
                            <!-- edit -->
								<a class="btn bg-olive btn-flat" data-target="#edit" onclick="javascript:Edit('<?php echo $dt->id_trans_education;?>')" data-toggle="modal" title="Edit <?php echo $dt->level; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <!-- delete -->
                                <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>m_education/hapus_education/<?php echo $dt->id_trans_education; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus <?php echo $dt->level; ?>">
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
            url		: "<?php echo site_url(); ?>/m_education/edit_education",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_trans_education').val(data.id_trans_education);
                $('#level').val(data.level);
                $('#name').val(data.name);
                $('#major').val(data.major);
                $('#period').val(data.period);
                $('#city').val(data.city);
                $('#gpa').val(data.gpa);
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
            <form method="POST" action="<?php echo base_url(); ?>m_education/simpan_education/<?php echo $nrp ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Level</label>
                        <input type="text" name="level" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Major</label>
                        <input type="text" name="major" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Period</label>
                        <input type="text" name="period" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">City</label>
                        <input type="text" name="city" class="form-control"">
                    </div>
					<div class="form-group">
                        <label for="">GPA</label>
                        <input type="text" name="gpa" class="form-control"">
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
            <form method="POST" action="<?php echo base_url(); ?>m_education/simpan_edit_education" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_trans_education" id="id_trans_education">
                    <div class="form-group">
                        <label for="">Level</label>
                        <input type="text" name="level" id="level" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Major</label>
                        <input type="text" name="major" id="major" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">Period</label>
                        <input type="text" name="period" id="period" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">City</label>
                        <input type="text" name="city" id="city" class="form-control">
                    </div>
					<div class="form-group">
                        <label for="">GPA</label>
                        <input type="text" name="city" id="gpa" class="form-control">
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

