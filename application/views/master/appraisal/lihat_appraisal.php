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
            <a class="btn btn-app" href="<?php echo base_url(); ?>m_appraisal/list_karyawan?kategori=<?php echo $kategori; ?>">
				<i class="fa fa-arrow-left"></i>
				Kembali
			</a>
			<a class="btn btn-app" data-toggle="modal" data-target="#tambah" title="Tambah Appraisal">
                <i class="fa fa-plus"></i>
                Tambah Data
            </a>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Performance Year</th>
                    <th>KPI/PA</th>
                    <th>KBI</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->master_model->list_appraisal($nrp);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $dt->tahun; ?></td>
                        <td><?php echo $dt->kpi_pa; ?></td>
                        <td><?php echo $dt->kbi; ?></td>
                        <td><?php echo $dt->catatan; ?></td>
                        <td>
                            <!-- edit -->
								<a class="btn bg-olive btn-flat" data-target="#edit" onclick="javascript:Edit('<?php echo $dt->id_trn_appraisal;?>')" data-toggle="modal" title="Edit <?php echo $dt->tahun; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <!-- delete -->
                                <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>m_appraisal/hapus_appraisal/<?php echo $dt->id_trn_appraisal; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus <?php echo $dt->tahun; ?>">
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
            url		: "<?php echo site_url(); ?>/m_appraisal/edit_appraisal",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_trn_appraisal').val(data.id_trn_appraisal);
                $('#tahun').val(data.tahun);
                $('#kpi_pa').val(data.kpi_pa);
                $('#kbi').val(data.kbi);
                $('#catatan').val(data.catatan);
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
            <form method="POST" action="<?php echo base_url(); ?>m_appraisal/simpan_appraisal/<?php echo $nrp ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Performance Year</label>
                        <input type="text" name="tahun" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">KPI/PA</label>
                        <input type="text" name="kpi_pa" class="form-control" >
                    </div>
					<div class="form-group">
                        <label for="">KBI</label>
                        <input type="text" name="kbi" class="form-control" >
                    </div>
					<div class="form-group">
                        <label for="">Catatan</label>
                        <input type="text" name="catatan" class="form-control" >
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
            <form method="POST" action="<?php echo base_url(); ?>m_appraisal/simpan_edit_appraisal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_trn_appraisal" id="id_trn_appraisal">
                    <div class="form-group">
                        <label for="">Performance Year</label>
                        <input type="text" name="tahun" id="tahun" class="form-control" required="required">
                    </div>
					<div class="form-group">
                        <label for="">KPI/PA</label>
                        <input type="text" name="kpi_pa" id="kpi_pa" class="form-control">
                    </div>
					<div class="form-group">
                        <label for="">KBI</label>
                        <input type="text" name="kbi" id="kbi" class="form-control" >
                    </div>
					<div class="form-group">
                        <label for="">Catatan</label>
                        <input type="text" name="catatan" id="catatan" class="form-control" >
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

