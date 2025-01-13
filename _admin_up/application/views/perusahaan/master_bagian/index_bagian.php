<script type="text/javascript">
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_bagian",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_bagian').val(data.id_bagian);
            $('#nama_bagian').val(data.nama_bagian);
            $('#absen_o').val(data.flag_absen_online);
            $('#id_karyawan').val(data.id_karyawan);
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
<div class="box">
    <div class="box-header">
        <h3 class="box-title">List Bagian / Unit Kerja <?php echo $nama; ?></h3>
        <div class="box-tools pull-right">
            <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                <i class="fa fa-plus"></i> Tambah Bagian / Unit Kerja
            </a>
        </div>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>ID Bagian / Unit Kerja</td>
                    <td>Nama Bagian / Unit Kerja</td>
                    <td style="width:100px;">Lokasi</td>
                    
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';
                    $data   = $this->enterprise_model->get_bagian($id_p);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->id_bagian; ?></td>
                        <td><?php echo $dt->nama_bagian; ?></td>
                        <td><?php echo $dt->lokasi; ?></td>
                        
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#edit" onclick="javascript:Edit('<?php echo $dt->id_bagian;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            
                            <!-- edit lokasi -->
                            <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/edit_lokasi_bagian/<?php echo $dt->id_bagian; ?>/<?php echo $id_p; ?>" title="Edit Lokasi">
                                Edit Lokasi
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_bagian/<?php echo $dt->id_bagian; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_edit_bagian">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Bagian</label>
                        <input type="text" name="nama_bagian" id="nama_bagian" class="form-control" required="required">
                        <input type="hidden" name="id_bagian" id="id_bagian">
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
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_bagian" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Bagian / Unit Kerja</label>
                        <input type="text" name="bagian" class="form-control" required="required">
                        <input type="hidden" name="id_perusahaan" value="<?php echo $id_p; ?>">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi (Bisa pilih beberapa)</label>
                        <select class="form-control select2" name="lokasi[]" multiple="multiple" id="lokasi" style="width: 100%;" required="required">
                            <?php
                                $lokasi = $this->enterprise_model->get_lokasi($id_p); 
                                foreach ($lokasi->result() as $k) {
                            ?>
                                <option value="<?php echo $k->id_lokasi; ?>"><?php echo $k->nama_lokasi; ?></option>
                            <?php
                                }
                            ?>
                        </select>
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