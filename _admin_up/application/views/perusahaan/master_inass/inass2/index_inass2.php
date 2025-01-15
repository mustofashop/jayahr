<script type="text/javascript">
    function Edit(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/perusahaan/edit_inass_2",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_iass').val(data.id_iass);
                $('#id_iass_2').val(data.id_iass_2);
                $('#nama_value').val(data.nama_value);
                $('#desc').val(data.desc);
                $('#urutan').val(data.urutan);
                $('#flag_diisi').val(data.flag_diisi);
            }
        });
    }
</script>
<div class="row">
    <div class="col-md-12">
        <?php if ($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_inass/<?php echo $id_p; ?>">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                    <i class="fa fa-plus"></i>
                    Tambah
                </a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
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
                        $data   = $this->enterprise_model->list_inass_lvl_2($id_iass);
                        foreach ($data->result() as $dt) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_value; ?></td>
                                <td><?php echo $dt->desc; ?></td>
                                <td><?php echo $dt->flag_diisi; ?></td>
                                <td><?php echo $dt->urutan; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id_iass_2; ?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- bagian level 3 -->
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>perusahaan/master_inass_3/<?php echo $dt->id_iass_2 ?>/<?php echo $id_iass; ?>/<?php echo $id_p; ?>" title="Level 3">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <!-- hapus -->
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_inass_2/<?php echo $dt->id_iass_2; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
</div>
<!-- modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_bagian_2" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pertanyaan</label>
                        <input type="text" class="form-control" name="nama_value" id="nama_value" required="required">
                        <input type="hidden" name="id_iass_2" id="id_iass_2">
                        <input type="hidden" name="id_iass" value="<?php echo $id_iass; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <input type="text" name="desc" id="desc" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Diisi?</label>
                        <input type="text" name="flag_diisi" id="flag_diisi" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Urutan</label>
                        <input type="text" name="urutan" id="urutan" class="form-control" required="required">
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