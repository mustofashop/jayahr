<script type="text/javascript">
    function Tahun_a(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/perusahaan/edit_periode_penilaian",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_p_periode').val(data.id_p_periode);
                $('#nama_value').val(data.nama_value);
            }
        });
    }
</script>
<div class="row">
    <div class="col-md-7">
        <?php if ($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_periode/<?php echo $id_p; ?>">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Value</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = 1;
                        $data   = $this->enterprise_model->list_penilaian($id_periode);
                        foreach ($data->result() as $dt) { ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_value; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Tahun_a('<?php echo $dt->id_p_periode; ?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- hapus -->
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_periode_penilaian/<?php echo $dt->id_p_periode; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
</div>
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_periode_penilaian" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Value</label>
                        <input type="text" name="nama_value" id="nama_value" class="form-control" required="required">
                        <input type="hidden" name="id_p_periode" id="id_p_periode">
                        <input type="hidden" name="id_periode" value="<?php echo $id_periode; ?>">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Penilaian Keberapa</label>
                        <select name="flag_penilaian" id="flag_penilaian" class="form-control">
                            <option value=""> -- Penilaian Ke -- </option>
                            <option value="1"> Penilaian Ke 1 </option>
                            <option value="2"> Penilaian Ke 2 </option>
                            <option value="3"> Penilaian Ke 3 </option>
                        </select>
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