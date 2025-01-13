<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('msg_error')): ?>
    <div class="alert alert-danger alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
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
            url		: "<?php echo site_url(); ?>/shift/edit_shift",
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
    function Edit2(ID){
        var id      = ID;
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/shift/edit_shift2",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id_shift2').val(data.id_shift);
                $('#nama_shift2').val(data.nama_shift);
            }
        });
    }
</script>
<div class="box">
    <div class="box-header">
        <?php if($aksi1 == '1'){ ?>
            <a class="btn btn-app" href="<?php echo base_url(); ?>shift/tambah_shift" title="Tambah Shift">
                <i class="fa fa-plus"></i>
                Tambah Data
            </a>
        <?php } ?>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th style="width:50px;">Nama Shift</th>
                    <th style="width:50px;">Jenis</th>
                    <th style="width:50px;">Kategori</th>
                    <th style="width:50px;">Hari</th>
                    <th style="width:140px;">Jam</th>
                    <th style="width:50px;">Lokasi</th>
                    <th style="width:50px;">Bagian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $id_p   = $this->session->userdata('id_perusahaan');
                    $no     = 1;
                    $data   = $this->master_model->list_shift($id_p);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama_shift; ?></td>
                        <td><?php echo $dt->jenis; ?></td>
                        <td><?php echo $dt->kategori; ?></td>
                        <td>
                            <?php
                                $list_hari = $this->master_model->list_shift_hari($dt->id_shift);
                                if($list_hari->num_rows() > 0){
                                    echo $list_hari->row()->nama_hari;
                                }
                            ?>
                        </td>
                        <td>
                            <?php if($dt->jenis_shift == '1'){ ?>
                                Jam Masuk : <?php echo $dt->jam_masuk; ?><br>
                                Jam Keluar: <?php echo $dt->jam_keluar ?><br>
                                Telat     : <?php echo $dt->jam_telat; ?><br>
                                Setengah Hari : <?php echo $dt->jam_setengah_hari; ?>
                            <?php }else{ ?>
                                -
                            <?php } ?>
                        </td>
                        <?php if($dt->id_kategori == '1'){ //lokasi ?>
                            <td>
                                <?php
                                    $list_lokasi = $this->master_model->list_shift_lokasi($dt->id_shift);
                                    echo $list_lokasi->row()->nama_lokasi;
                                ?>
                            </td>
                            <td></td>
                        <?php }elseif($dt->id_kategori == '3'){ //bagian ?>
                            <td></td>
                            <td>
                                <?php
                                    $list_bagian = $this->master_model->list_shift_bagian($dt->id_shift);
                                    echo $list_bagian->row()->nama_bagian;
                                ?>
                            </td>
                        <?php }elseif($dt->id_kategori == '4'){ //semua ?>
                            <td></td>
                            <td></td>
                        <?php } ?>
                        <td>
                            <!-- edit -->
                            <?php if($aksi3 == '3'){ ?>
                                <?php if($dt->jenis_shift == '1'){ ?>
                                    <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id_shift;?>')" data-toggle="modal" title="Edit <?php echo $dt->nama_shift; ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                <?php }else{ ?>
                                    <a class="btn bg-olive btn-flat" href="#modal2" onclick="javascript:Edit2('<?php echo $dt->id_shift;?>')" data-toggle="modal" title="Edit <?php echo $dt->nama_shift; ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                <?php } ?>
                                <?php if($dt->id_kategori == '1'){ //lokasi ?>
                                    <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>shift/edit_lokasi/<?php echo $dt->id_shift; ?>" title="Edit Lokasi">
                                        Edit Lokasi
                                    </a>
                                <?php }elseif($dt->id_kategori == '3'){ //sublokasi ?>
                                    <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>shift/edit_bagian/<?php echo $dt->id_shift; ?>" title="Edit Bagian">
                                        Edit Bagian
                                    </a>
                                <?php }elseif($dt->id_kategori == '4'){ //bagian ?>
                                    
                                <?php } ?>
                                <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>shift/edit_hari/<?php echo $dt->id_shift; ?>" title="Edit Hari">
                                    Edit Hari
                                </a>
                            <?php } ?>
                            <!-- sub shift -->
                            <?php if($dt->jenis_shift == '2'){ ?>
                                <!-- shift -->
                                <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>shift/detail_shift/<?php echo $dt->id_shift; ?>" title="Detail Shift">
                                    <i class="fa fa-plus"></i>
                                </a>
                            <?php } ?>
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
<!-- modal edit 2 -->
<div class="modal fade" id="modal2">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>shift/simpan_edit_shift2" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_shift" id="id_shift2">
                    <div class="form-group">
                        <label for="">Nama Shift</label>
                        <input type="text" name="nama_shift" id="nama_shift2" class="form-control" required="required">
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
<!-- end modal 2 -->
<!-- modal edit 1-->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>shift/simpan_edit_shift" enctype="multipart/form-data">
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
<!-- end modal 1 -->