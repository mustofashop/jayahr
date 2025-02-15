<script type="text/javascript">
    function Tahun_a(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/perusahaan/edit_periode",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_per').val(data.id_periode);
                $('#tahun_p').val(data.periode_tahun);
            }
        });
    }
</script>
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
                    <td>Periode Tahun</td>
                    <td>Status</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = '1';
                foreach ($data->result() as $dt) { ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->periode_tahun; ?></td>
                        <?php if ($dt->status == '0') { ?>
                            <td>Aktif</td>
                        <?php } else { ?>
                            <td>Tidak Aktif</td>
                        <?php } ?>
                        <td><!-- status -->
                            <?php if ($dt->status == '0') { ?>
                                <a type="button" href="<?php echo site_url(); ?>/Perusahaan/hapus/<?php echo $dt->id_periode; ?>" onClick="return confirm('Anda yakin ingin menonaktifkan Periode ini?')" class="btn bg-yellow btn-danger btn-circle waves-effect waves-circle waves-float" title="Tidak Aktifkan Data">
                                    <i class="material-icons">clear</i>
                                </a>
                            <?php } else { ?>
                                <a type="button" href="<?php echo site_url(); ?>/Perusahaan/aktif/<?php echo $dt->id_periode; ?>" onClick="return confirm('Anda yakin ingin mengaktifkan Periode ini?')" class="btn bg-yellow btn-primary btn-circle waves-effect waves-circle waves-float" title="Aktifkan Data">
                                    <i class="material-icons">check</i>
                                </a>
                            <?php } ?>
                            </a>
                            <a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Tahun_a('<?php echo $dt->id_periode; ?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- bagian level 2 -->
                            <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>perusahaan/master_periode_penilaian/<?php echo $dt->id_periode; ?>/<?php echo $id_p; ?>" title="Level 2">
                                <i class="fa fa-plus"></i>
                            </a>
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_periode/<?php echo $dt->id_periode; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_periode" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Periode Tahun</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Periode Tahun</label>
                        <input type="hidden" name="id_per" id="id_per">
                        <input type="text" name="tahun_p" id="tahun_p" class="form-control" required="required">
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