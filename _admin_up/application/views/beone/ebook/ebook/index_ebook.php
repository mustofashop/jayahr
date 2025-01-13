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
                    <th>Mata Pelajaran</th>
                    <th>Tingkat Sekolah</th>
                    <th>Kelas</th>
                    <th>Penerbit</th>
                    <th>Judul</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    $data   = $this->beone_model->list_ebook();
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama_matpel; ?></td>
                        <td><?php echo $dt->tingkat_sekolah; ?></td>
                        <td><?php echo $dt->kelas; ?></td>
                        <td><?php echo $dt->nama_penerbit; ?></td>
                        <td><?php echo $dt->judul; ?></td>
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- delete -->
                            <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>beone/delete_ebook/<?php echo $dt->id; ?>" title="delete" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
<script>
$(document).ready(function(){
    $("#foto").change(function() {
        viewImg(this);
    });
    $('#jenis').change(function () {
        var jenis  =   $("#jenis").val();
        if(jenis == 1){
            $("#kelas").empty();
            $("#kelas").append('<option value="">-- Pilih --</option>');
            for (let i = 1; i <= 6; i++) {
                $("#kelas").append('<option value="'+i+'">'+i+'</option>');
            }
        }else{
            $("#kelas").empty();
            $("#kelas").append('<option value="">-- Pilih --</option>');
            for (let i = 1; i <= 3; i++) {
                $("#kelas").append('<option value="'+i+'">'+i+'</option>');
            }
        }

        var j  = document.getElementById('j');
        if(jenis == 3){
            j.style.display     = "block";
            $("#jurusan").empty();
            $("#jurusan").append('<option value="">-- Pilih --</option>');
            $("#jurusan").append('<option value="IPA">IPA</option>');
            $("#jurusan").append('<option value="IPS">IPS</option>');
            $("#jurusan").Attr("required",'required');
        }else if(jenis == 4){
            j.style.display     = "block";
            $("#jurusan").empty();
            <?php
                $jurusan        = $this->beone_model->list_jurusan();
                foreach($jurusan->result() as $j){
            ?>
                $("#jurusan").append('<option value="<?php echo $j->id; ?>"><?php echo $j->nama_jurusan; ?></option>');
            <?php
                }
            ?>
            $("#jurusan").Attr("required",'required');
        }else{
            j.style.display     = "none";
        }
    });
});
function viewImg(input){
    var xs  = document.getElementById('t_foto');
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            $("#t_foto").removeAttr("src");
            $("#t_foto").attr("src", e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        xs.style.display = "block";
    }else{
        xs.style.display = "none";
        $("#t_foto").removeAttr("src");
    }
}
function Edit(ID) {
    var id      = ID;
    $.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/beone/edit_ebook",
		data	: "id="+id,
		dataType: "json",
		success	: function(data){
            $("#foto").removeAttr("required",'');
            $('#id').val(data.id);
            $('#keterangan').val(data.keterangan);
            $('#penerbit').val(data.id_penerbit);
            $('#matpel').val(data.id_matpel);
            $('#jenis').val(data.jenis_sekolah);
            $('#judul').val(data.judul);
            $('#size').val(data.size);
            $('#url').val(data.url);
            $("#t_foto").attr("src", data.cover);
            //end cover
            if(data.jenis_sekolah == 1){
                $("#kelas").empty();
                $("#kelas").append('<option value="">-- Pilih --</option>');
                for (let i = 1; i <= 6; i++) {
                    $("#kelas").append('<option value="'+i+'">'+i+'</option>');
                }
            }else{
                $("#kelas").empty();
                $("#kelas").append('<option value="">-- Pilih --</option>');
                for (let i = 1; i <= 3; i++) {
                    $("#kelas").append('<option value="'+i+'">'+i+'</option>');
                }
            }
            $('#kelas').val(data.kelas);
            
            var j  = document.getElementById('j');
            if(data.jenis_sekolah == 3){
                j.style.display     = "block";
                $("#jurusan").empty();
                $("#jurusan").append('<option value="">-- Pilih --</option>');
                $("#jurusan").append('<option value="IPA">IPA</option>');
                $("#jurusan").append('<option value="IPS">IPS</option>');
                $('#jurusan').val(data.jurusan_sma);
                $("#jurusan").Attr("required",'required');
            }else if(data.jenis_sekolah == 4){
                j.style.display     = "block";
                $("#jurusan").empty();
                <?php
                    $jurusan        = $this->beone_model->list_jurusan();
                    foreach($jurusan->result() as $j){
                ?>
                    $("#jurusan").append('<option value="<?php echo $j->id; ?>"><?php echo $j->nama_jurusan; ?></option>');
                <?php
                    }
                ?>
                $('#jurusan').val(data.jurusan_smk);
                $("#jurusan").Attr("required",'required');
            }else{
                j.style.display     = "none";
            }
		}
	});
}
</script>
<style type="text/css">
   #j {
        display: none;
   }
</style>
<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_ebook" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="">
                                <label for="">Cover Buku</label>
                                <img class="img-responsive" style="width:300px;" id="t_foto" alt="Cover Buku">
                                <br>
                                <input type="file" name="image" id="foto" accept="image/*" required="required">
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Penerbit</label>
                                <select name="penerbit" id="penerbit" class="form-control select2" style="width:100%" required="required">
                                    <option value="">-- Pilih --</option>
                                    <?php
                                        $penerbit = $this->beone_model->list_penerbit();
                                        foreach($penerbit->result() as $p){
                                    ?>
                                        <option value="<?php echo $p->id; ?>"><?php echo $p->nama_penerbit; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Mata Pelajaran</label>
                                <select name="matpel" id="matpel" class="form-control select2" required="required" style="width:100%;">
                                    <option value="">-- Pilih --</option>
                                    <?php 
                                        $matpel = $this->beone_model->list_matpel();
                                        foreach($matpel->result() as $m){
                                    ?>
                                        <option value="<?php echo $m->id_matpel; ?>"><?php echo $m->nama_matpel; ?></option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Sekolah</label>
                                <select name="jenis" id="jenis" class="form-control" required="required">
                                    <option value="">-- Pilih --</option>
                                    <!-- <option value="0">TK</option> -->
                                    <option value="1">SD</option>
                                    <option value="2">SMP</option>
                                    <option value="3">SMA</option>
                                    <option value="4">SMK</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kelas</label>
                                <select name="kelas" id="kelas" class="form-control" required="required">
                                
                                </select>
                            </div>
                            <div class="form-group" id="j">
                                <label for="">Jurusan</label>
                                <select name="jurusan" id="jurusan" class="form-control select2" style="width:100%;">
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Judul Ebook</label>
                                <input type="text" name="judul" id="judul" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">URL PDF</label>
                                <input type="url" name="url" id="url" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Size (MB)</label>
                                <input type="number" min='0' name="size" id="size" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10"></textarea>
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