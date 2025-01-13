<script type="text/javascript">
function Edit(ID){
	var idt	    = ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_mapping_ekskul",
		data	: "idt="+idt,
		dataType: "json",
		success	: function(data){
            $('#id_t_ekskul').val(data.id_t_ekskul);
            $('#id_ekskul').val(data.id_ekskul);
            $('#id_guru').val(data.id_guru);
		}
	});
}
</script>
<?php if($this->session->flashdata('msg_input')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_input'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>beone/beone_mapping_ekskul"><i class="fa fa-chevron-left"></i> Kembali</a>
        <a class="btn btn-app" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Mapping Guru Ekskul</a>
        <a class="btn btn-app" data-toggle="modal" data-target="#modal-ineks"><i class="fa fa-plus"></i> Mapping Guru Internal / Eksternal</a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Guru</td>
                    <td>Nama Ekskul</td>
                    <td>Internal / Eksternal</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = '1';
                    foreach($data->result() as $dt){ ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dt->nama_lengkap; ?></td>
                            <td><?php echo $dt->nama_ekskul; ?></td>
                            <?php if($dt->flag_ekskul == '1'){ ?>
                                <td>Internal</td>
                            <?php }elseif($dt->flag_ekskul == '2'){ ?>
                                <td>Eksternal</td>
                            <?php }else{ ?>
                                <td>Belum disetting</td>
                            <?php } ?>
                            <td>
                                <!-- edit -->
                                <a class="btn bg-olive btn-flat" href="#modal-edit" onclick="javascript:Edit('<?php echo $dt->id_t_ekskul;?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>beone/delete_mapping_ekskul/<?php echo $dt->id_t_ekskul; ?>/<?php echo $dt->id_user_sekolah; ?>" title="delete" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="modal-ineks">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_mapping_in_eks" enctype="multipart/form-data">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="modal-title"><?php echo $header; ?></h4>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-default collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">?</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    Untuk Mapping Jenis Guru Ekskul
                                    <br>
                                    - Internal
                                    <br>
                                        Menu web BeOne : Semuanya
                                    <br>
                                    - Eksternal
                                    <br>
                                        Menu web BeOne : Ekskul
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
                <div class="modal-body pre-scrollable">
                    <div class="row" id="ineks">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Guru</label>
                                    <div class="form-line">
                                        <select class="form-control select2" name="guru[]" style="width: 100%;" required="required">
                                            <option value="#">-- Pilih Guru --</option>
                                            <?php 
                                                foreach ($guru->result() as $dt) {
                                                ?>
                                                    <option value="<?php echo $dt->id_user_sekolah; ?>"><?php echo $dt->nama_lengkap; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Internal / Eksternal</label>
                                    <select name="ineks[]" class="form-control" required="required">
                                        <option value="1">Internal</option>
                                        <option value="2">Eksternal</option>
                                    </select>
                                </div>
                            </div>
                            <button class="add_form btn bg-blue btn-flat" type="button" style="margin-top:55px;">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_edit_mapping_ekskul" enctype="multipart/form-data">
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
                            <input type="hidden" name="id_t_ekskul" id="id_t_ekskul">
                            <div class="form-group">
                                <label for="">Guru</label>
                                <select class="form-control select2" name="id_guru" id="id_guru" style="width: 100%;" required="required">
                                    <?php 
                                        foreach ($guru->result() as $dt) {
                                        ?>
                                            <option value="<?php echo $dt->id_user_sekolah; ?>"><?php echo $dt->nama_lengkap; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Ekskul</label>
                                <select class="form-control select2" name="id_ekskul" id="id_ekskul" style="width: 100%;" required="required" placeholder="Pilih Ekskul">
                                    <?php 
                                        foreach ($ekskul->result() as $dt) {
                                        ?>
                                            <option value="<?php echo $dt->id_ekskul; ?>"><?php echo $dt->nama_ekskul; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_mapping_ekskul" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body pre-scrollable">
                    <div class="row clearfix" id="formperusahaan">
                        <div class="col-sm-12">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="">Guru</label>
                                    <div class="form-line">
                                        <select class="form-control select2" name="guru[]" style="width: 100%;" required="required">
                                            <option value="#">-- Pilih Guru --</option>
                                            <?php 
                                                foreach ($guru->result() as $dt) {
                                                ?>
                                                    <option value="<?php echo $dt->id_user_sekolah; ?>"><?php echo $dt->nama_lengkap; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="">Ekskul</label>
                                    <div class="form-line">
                                        <select class="form-control select2" name="ekskul[]" style="width: 100%;" required="required" placeholder="Pilih Ekskul">
                                            <?php 
                                                foreach ($ekskul->result() as $dt) {
                                                ?>
                                                    <option value="<?php echo $dt->id_ekskul; ?>"><?php echo $dt->nama_ekskul; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="add_field_button btn bg-blue btn-flat" type="button" style="margin-top:55px;">
                                <i class="fa fa-plus"></i>
                            </button>
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
<script type="text/javascript">
    //mapping internal / eksternal guru
    var max_input       = 100;
    var form_awal       = $("#ineks");
    var tombol_tambah   = $(".add_form");
    var no = 1;
    $(tombol_tambah).click(function (a) {
       a.preventDefault();
       if(no <= max_input){
           no++;
           $(form_awal).append('<div class="col-sm-12"><div class="col-sm-5"><div class="form-group"><label for="">Guru</label><div class="form-line"><select class="form-control guru" name="guru[]" style="width: 100%;" required="required"><option value="#">-- Pilih Guru --</option><?php foreach ($guru->result() as $dt) { ?><option value="<?php echo $dt->id_user_sekolah; ?>"><?php echo $dt->nama_lengkap; ?></option><?php } ?></select></div></div></div><div class="col-sm-5"><div class="form-group"><label for="">Internal / Eksternal</label><div class="form-line"><select class="form-control" name="ineks[]" style="width: 100%;" required="required" placeholder="Pilih Ekskul"><option value="1">Internal</option><option value="2">Eksternal</option></select></div></div></div><button class="delete_form btn bg-red btn-flat" type="button" style="margin-top:55px;"><i class="fa fa-times"></i></button></div>');
           $(".guru").select2();
       } 
    });
    $(form_awal).on("click",".delete_form", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})

    //mapping ekskul guru
    var max_fields      = 100; //maximum input boxes allowed
	var wrapper   		= $("#formperusahaan"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x <= max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="col-sm-12"><div class="col-sm-5"><div class="form-group"><label for="">Guru</label><div class="form-line"><select class="form-control guru" name="guru[]" style="width: 100%;" required="required"><option value="#">-- Pilih Guru --</option><?php foreach ($guru->result() as $dt) { ?><option value="<?php echo $dt->id_user_sekolah; ?>"><?php echo $dt->nama_lengkap; ?></option><?php } ?></select></div></div></div><div class="col-sm-5"><div class="form-group"><label for="">Ekskul</label><div class="form-line"><select class="form-control ekskul" name="ekskul[]" style="width: 100%;" required="required" placeholder="Pilih Ekskul"><?php foreach ($ekskul->result() as $dt) { ?><option value="<?php echo $dt->id_ekskul; ?>"><?php echo $dt->nama_ekskul; ?></option><?php } ?></select></div></div></div><button class="remove_field btn bg-red btn-flat" type="button" style="margin-top:55px;"><i class="fa fa-times"></i></button></div>'); //add input box
            $(".guru").select2();
            $(".ekskul").select2();
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
</script>