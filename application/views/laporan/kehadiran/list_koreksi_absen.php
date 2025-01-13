<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
    
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    $data   = $this->laporan_model->list_koreksi_absen($id_k,$tgl_awal,$tgl_akhir);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->tanggal; ?></td>
                        <?php if($dt->masuk == '00:00:00'){ ?>
                            <td>-</td>
                        <?php }else{ ?>
                            <td><?php echo $dt->masuk; ?></td>
                        <?php } ?>
                        <?php if($dt->keluar == '00:00:00'){ ?>
                            <td>-</td>
                        <?php }else{ ?>
                            <td><?php echo $dt->keluar; ?></td>
                        <?php } ?>
                        <td><?php echo $dt->jenis; ?></td>
                        <td>
                            <!-- edit -->
                            <?php if($aksi3 == '3'){ ?>
                                <a class="btn btn-flat bg-blue" data-target="#modal" onclick="javascript:Lihat('<?php echo $dt->id;?>')" data-toggle="modal" title="Koreksi Absen <?php echo $dt->tanggal; ?>">
                                    <i class="fa fa-search"></i>
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
<script>
    $(document).ready(function(){
        $('#masuk').timepicker({
            showInputs: false,
            showMeridian: false,
            showSeconds: true,
        });
        $('#keluar').timepicker({
            showInputs: false,
            showMeridian: false,
            showSeconds: true,
        });
    });
    function Lihat(ID){
        let id = ID;
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/kehadiran/edit_absen",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#id').val(data.id);
                $('#tanggal').val(data.tgl);
                $('#masuk').val(data.masuk);
                $('#keluar').val(data.keluar);
                $('#jenis').val(data.jenis);
            }
        });
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Absen</h4>
            </div>
            <form role="form" method="POST" action="<?php echo base_url(); ?>kehadiran/simpan_koreksi" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id">
                                <label for="">Tanggal</label>
                                <input type="text" id="tanggal" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Tidak Hadir">Tidak Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="SPPD">SPPD</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Libur">Libur</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Masuk</label>
                                    <div class="input-group">
                                        <input type="text" id="masuk" name="masuk" class="form-control" required="required">
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
                                    <label>Keluar</label>
                                    <div class="input-group">
                                        <input type="text" id="keluar" name="keluar" class="form-control" required="required">
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
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>