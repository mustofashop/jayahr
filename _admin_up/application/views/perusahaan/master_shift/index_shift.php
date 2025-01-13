<script type="text/javascript">
$(document).ready(function () {
    //Timepicker
    $('.timePicker').timepicker({
      showInputs: false,
      showMeridian: false
    });

});
    function Edit(ID){
        var cari	= ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/perusahaan/edit_shift",
            data	: "cari="+cari,
            dataType: "json",
            success	: function(data){
                $('#id_shift').val(data.id_shift);
                $('#nama_shift').val(data.nama_shift);
                $('#jam_masuk').val(data.jam_masuk);
                $('#jam_keluar').val(data.jam_keluar);
                $('#jam_telat').val(data.jam_telat);
                $('#jam_setengah_hari').val(data.jam_setengah_hari);
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
        <h3 class="box-title">List Shift</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/tambah_shift/<?php echo $id_p; ?>">
                <i class="fa fa-plus"></i> Tambah Shift
            </a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <td>No</td>
                    <td style="width:50px;">Nama Shift</td>
                    <td style="width:50px;">Jenis</td>
                    <td style="width:50px;">Kategori</td>
                    <td style="width:50px;">Hari</td>
                    <td style="width:140px;">Jam</td>
                    <td style="width:50px;">Lokasi</td>
                    <td style="width:50px;">Bagian</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = 1;
                    $dt = $this->enterprise_model->list_shift($id_p);
                    foreach ($dt->result() as $shift) {
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $shift->nama_shift; ?></td>
                        <td><?php echo $shift->jenis; ?></td>
                        <td><?php echo $shift->kategori; ?></td>
                        <td>
                            <?php
                                $list_hari = $this->enterprise_model->list_shift_hari($shift->id_shift);
                                if($list_hari->num_rows() > 0){
                                    echo $list_hari->row()->nama_hari;
                                }
                            ?>
                        </td>
                        <td>
                            <?php if($shift->jenis_shift == '1'){ ?>
                                Jam Masuk : <?php echo $shift->jam_masuk; ?><br>
                                Jam Keluar: <?php echo $shift->jam_keluar ?><br>
                                Telat     : <?php echo $shift->jam_telat; ?><br>
                                Setengah Hari : <?php echo $shift->jam_setengah_hari; ?>
                            <?php }else{ ?>
                                -
                            <?php } ?>
                        </td>
                        <?php if($shift->id_kategori == '1'){ //lokasi ?>
                            <td>
                                <?php
                                    $list_lokasi = $this->enterprise_model->list_shift_lokasi($shift->id_shift);
                                    echo $list_lokasi->row()->nama_lokasi;
                                ?>
                            </td>
                            <td></td>
                        <?php }elseif($shift->id_kategori == '3'){ //bagian ?>
                            <td></td>
                            <td>
                                <?php
                                    $list_bagian = $this->enterprise_model->list_shift_bagian($shift->id_shift);
                                    echo $list_bagian->row()->nama_bagian;
                                ?>
                            </td>
                        <?php }elseif($shift->id_kategori == '4'){ //semua ?>
                            <td></td>
                            <td></td>
                        <?php } ?>
                        <td>
                            <!-- edit1 -->
                            <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $shift->id_shift;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- sub shift -->
                            <?php if($shift->jenis_shift == '2'){ ?>
                                <!-- shift -->
                                <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>perusahaan/detail_shift/<?php echo $shift->id_shift; ?>/<?php echo $id_p; ?>" title="Detail Shift">
                                    <i class="fa fa-plus"></i>
                                </a>
                            <?php } ?>
                            <!-- edit2 -->
                            <?php if($shift->id_kategori == '1'){ //lokasi ?>
                                <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/edit_shift_lokasi/<?php echo $shift->id_shift; ?>/<?php echo $id_p; ?>" title="Edit Lokasi">
                                    Edit Lokasi
                                </a>
                            <?php }elseif($shift->id_kategori == '3'){ //sublokasi ?>
                                <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/edit_shift_bagian/<?php echo $shift->id_shift; ?>/<?php echo $id_p; ?>" title="Edit Bagian">
                                    Edit Bagian
                                </a>
                            <?php }elseif($shift->id_kategori == '4'){ //bagian ?>
                                
                            <?php } ?>
                            <!-- edit3 -->
                            <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/edit_shift_hari/<?php echo $shift->id_shift; ?>/<?php echo $id_p; ?>" title="Edit Hari">
                                Edit Hari
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_shift/<?php echo $shift->id_shift; ?>/<?php echo $shift->id_kategori; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- modal edit -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/simpan_edit_shift" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_shift" id="id_shift">
                    <div class="form-group">
                        <label for="">Nama Shift</label>
                        <input type="text" name="nama_shift" id="nama_shift" class="form-control" required="required">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- time Picker -->
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Jam Masuk</label>
                                    <div class="input-group">
                                        <input type="text" name="jam_masuk" id="jam_masuk" class="form-control timePicker" required="required">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- time Picker -->
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Jam Keluar</label>
                                    <div class="input-group">
                                        <input type="text" name="jam_keluar" id="jam_keluar" class="form-control timePicker" required="required">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- time Picker -->
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Jam Telat</label>
                                    <div class="input-group">
                                        <input type="text" name="jam_telat" id="jam_telat" class="form-control timePicker" required="required">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- time Picker -->
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Jam Setengah Hari</label>
                                    <div class="input-group">
                                        <input type="text" name="jam_setengah_hari" id="jam_setengah_hari" class="form-control timePicker" required="required">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
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