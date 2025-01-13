<script type="text/javascript">
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_bagian_4",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_bagian_4').val(data.id_bagian_4);
            $('#nama').val(data.nama_bagian);
            $('#absen').val(data.flag_absen_online);
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
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal4">
            <i class="fa fa-plus"></i>
            Tambah
        </a>
        <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_bagian_3/<?php echo $id_b2; ?>/<?php echo $id_b ?>/<?php echo $id_p; ?>">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Bagian Lvl 4</th>
                    <th>Nama Bagian</th>
                    <th>Leader</th>
                    <th>Absen Online</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    $data   = $this->enterprise_model->list_bagian_lvl_4($id_b3);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->id_bagian_4; ?></td>
                        <td><?php echo $dt->nama_bagian_4; ?></td>
                        <td>
                            <?php
                                $lead   = $this->enterprise_model->nama_leader4($dt->id_bagian_4);
                                foreach($lead->result() as $ld){
                                    echo $ld->nama_lengkap;
                                }
                            ?>
                        </td>
                        <td><?php echo $dt->absen_online; ?></td>
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#modal4" onclick="javascript:Edit('<?php echo $dt->id_bagian_4;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- hapus -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_bagian_4/<?php echo $dt->id_bagian_4; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- modal -->
<div class="modal fade" id="modal4">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_bagian_4" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Bagian 4</label>
                        <input type="text" class="form-control" name="nama" id="nama" required="required">
                        <input type="hidden" name="id_bagian_4" id="id_bagian_4">
                        <input type="hidden" name="id_bagian_3" value="<?php echo $id_b3; ?>">
                    </div>
                    <div class="form-group">
                        <label for="id_karyawan">Leader</label>
                        <select name="leader" id="id_karyawan" class="form-control select2" required="required" style="width: 100%;">
                            <option value="0">-- Pilih --</option>
                            <?php
                                $leader = $this->enterprise_model->list_leader($id_p);
                                foreach($leader->result() as $l){
                            ?>
                                <option value="<?php echo $l->id_karyawan; ?>"><?php echo $l->nama_lengkap; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Absen Online</label>
                        <select name="absen" id="absen" class="form-control">
                            <option value="0">Tidak Aktif</option>
                            <option value="1">Aktif</option>
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
<!-- end modal -->