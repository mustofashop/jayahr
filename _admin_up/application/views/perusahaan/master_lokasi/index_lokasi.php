<script type="text/javascript">
$(document).ready(function(){
    $(".add-more").click(function(){ 
        var html = $(".copy").html();
        $(".lok").after(html);
        $("#idk").select2();
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".control-group").remove();
    });
});
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_lokasi",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_lokasi').val(data.id_lokasi);
            $('#nama_lokasi').val(data.nama_lokasi);
            $('#kode_lokasi').val(data.kode_lokasi);
            $('#karyawan').val(data.id_karyawan);
        }
    });
}
</script>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List Lokasi <?php echo $nama; ?></h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                        <i class="fa fa-plus"></i> Tambah Lokasi
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>ID Lokasi</td>
                            <td>Nama Lokasi</td>
                            <td>Kode Lokasi</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = '1';
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->id_lokasi; ?></td>
                                <td><?php echo $dt->nama_lokasi; ?></td>
                                <td><?php echo $dt->kode_lokasi; ?></td>
                                
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#edit" onclick="javascript:Edit('<?php echo $dt->id_lokasi;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- sub lokasi -->
                                    <!-- <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>perusahaan/sub_lokasi/<?php echo $dt->id_lokasi; ?>" title="Sub Lokasi">
                                        <i class="fa fa-plus"></i>
                                    </a>
									-->
                                    <!-- delete -->
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_lokasi/<?php echo $dt->id_lokasi; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
    <div class="col-md-6">
    
    </div>
</div>
<!-- edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_edit_lokasi">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Edit</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Lokasi</label>
                        <input type="hidden" name="id_lokasi" id="id_lokasi">
                        <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Kode Lokasi</label>
                        <input type="text" name="kode_lokasi" id="kode_lokasi" class="form-control" required="required">
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
<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_lokasi" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="lok">
                        <div class="control-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Nama Lokasi</label>
                                        <input type="text" name="nama[]" id="nama" class="form-control" required="required">
                                        <input type="hidden" name="id_perusahaan" value="<?php echo $id_p; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Kode Lokasi</label>
                                        <input type="text" name="kode[]" class="form-control" required="required">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <button type="button" class="btn bg-blue waves-effect add-more">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <!-- clone -->
                    <div class="copy hide">
                        <div class="control-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Nama Lokasi</label>
                                        <input type="text" name="nama[]" id="nama2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Kode Lokasi</label>
                                        <input type="text" name="kode[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Nama Leader</label>
                                        <select class="form-control" style="width:100%;" name="karyawan[]" id="idk">
                                            <?php
                                                $karyawan   = $this->enterprise_model->list_leader($id_p);
                                                foreach($karyawan->result() as $k){
                                            ?>
                                                <option value="<?php echo $k->id_karyawan; ?>"><?php echo $k->nama_lengkap; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn bg-red waves-effect remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
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