<div class="row">
    <div class="col-md-8">
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
                    <i class="fa fa-plus"></i>
                    Tambah
                </a>
                <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_perusahaan/<?php echo $id_p; ?>">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sholat</th>
                            <th>Waktu Awal</th>
                            <th>Waktu Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->enterprise_model->list_sholat($id_p);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_sholat; ?></td>
                                <td><?php echo $dt->waktu_awal; ?></td>
                                <td><?php echo $dt->waktu_akhir; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- hapus -->
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_sholat/<?php echo $dt->id; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- Modal -->
<script type="text/javascript">
$(document).ready(function () {
    //Timepicker
    $('#awal').timepicker({
      showInputs: false,
      showMeridian: false,
      showSeconds: true,
    });
    $('#akhir').timepicker({
      showInputs: false,
      showMeridian: false,
      showSeconds: true,
    });
});
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/perusahaan/edit_sholat",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id').val(data.id);
            $('#nama').val(data.nama_sholat);
            $('#awal').val(data.waktu_awal);
            $('#akhir').val(data.waktu_akhir);
        }
    });
}
</script>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $header; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_sholat" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Sholat</label>
                        <input type="text" name="nama" id="nama" class="form-control" required="required">
                        <input type="hidden" name="id_perusahaan" value="<?php echo $id_p; ?>">
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label>Waktu Awal</label>
                            <div class="input-group">
                                <input type="text" id="awal" name="awal" class="form-control" required="required">
                                <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                    </div>
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label>Waktu Akhir</label>
                            <div class="input-group">
                                <input type="text" id="akhir" name="akhir" class="form-control" required="required">
                                <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>