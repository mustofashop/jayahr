<script type="text/javascript">
    function Tahun_a(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/perusahaan/edit_penilaian_3_7_form_a",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_form_a').val(data.id_form_a);
                $('#nama_value').val(data.nama_value);
                $('#description').val(data.description);
            }
        });
    }
</script>
<div class="col-md-9">
    <?php if ($this->session->flashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
    <div class="box">
        <div class="box-header">
            <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <div class="box-body">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Value</td>
                        <td>Deskripsi</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = '1';
                    foreach ($data->result() as $dt) { ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dt->nama_value; ?></td>
                            <td><?php echo $dt->description; ?></td>
                            <td><a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Tahun_a('<?php echo $dt->id_form_a; ?>')" data-toggle="modal">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <!-- bagian level 2
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>perusahaan/master_penilaian_3_7_form_a/<?php echo $dt->id_form_a; ?>/<?php echo $id_p; ?>">
                                        <i class="fa fa-plus"></i>
                                    </a> -->
                                <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_penilaian_3_7_form_a/<?php echo $dt->id_form_a; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_penilaian_3_7_form_a" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Nama Value</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Value</label>
                        <input type="hidden" name="id_form_a" id="id_form_a">
                        <input type="text" name="nama_value" id="nama_value" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Deskripsi</label>
                        <input type="text" name="description" id="description" class="form-control" required="required">
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