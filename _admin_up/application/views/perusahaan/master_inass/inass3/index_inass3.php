<script type="text/javascript">
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_inass_3",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_iass_2').val(data.id_iass_2);
            $('#id_iass_3').val(data.id_iass_3);
            $('#nama_value').val(data.nama_value);
            $('#desc').val(data.desc);
            $('#urutan').val(data.urutan);
            $('#flag_diisi').val(data.flag_diisi);
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
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modals">
            <i class="fa fa-plus"></i>
            Tambah
        </a>
        <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_inass_2/<?php echo $id_b ?>/<?php echo $id_p; ?>">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <td>Pertanyaan</td>
					<td>Deskripsi</td>
					<td>Diisi?</td>
					<td>Urutan</td>
					<td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    $data   = $this->enterprise_model->list_inass_lvl_3($id_b2);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama_value; ?></td>
						<td><?php echo $dt->desc; ?></td>
						<td><?php echo $dt->flag_diisi; ?></td>
						<td><?php echo $dt->urutan; ?></td>
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->id_iass_3;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- hapus -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_inass_3/<?php echo $dt->id_iass_3; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<div class="modal fade" id="modals">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_bagian_3" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Bagian 3</label>
                        <input type="text" class="form-control" name="nama" id="nama" required="required">
                        <input type="hidden" name="id_bagian_3" id="id_bagian_3">
                        <input type="hidden" name="id_bagian_2" value="<?php echo $id_b2; ?>">
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