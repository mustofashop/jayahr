<script type="text/javascript">
    function Edit(ID) {
        var id = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Enterprise/karyawan/edit_karyawan",
            data: "id=" + id,
            dataType: "json",
            success: function(data) {
                $('#id_karyawan').val(data.id_karyawan);
                $('#nip').val(data.nip);
                $('#nama_lengkap').val(data.nama_lengkap);
                $('#badgenumber').val(data.badgenumber);
                $('#userid').val(data.userid);
                $('#no_telepon').val(data.no_telepon);
                $('#status').val(data.status);
            }
        });
    }
</script>
<?php if ($this->session->flashdata('msg')) : ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('msg_error')) : ?>
    <div class="alert alert-danger alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>Enterprise/karyawan/master_karyawan">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <!-- upload karyawan -->
        <a data-toggle="modal" data-target="#excel" class="btn bg-green btn-flat margin">Import Karyawan (Excel)</a>

        <a class="btn bg-red btn-flat margin" href="<?php echo base_url(); ?>Enterprise/karyawan/download_data_karyawan/<?php echo $perusahaan ?>/<?php echo $lokasi ?>/<?php echo $bagian; ?>/<?php echo $jenis; ?>">
            <i class="fa fa-download"></i>
            Download data
        </a>
        <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>Enterprise/karyawan/download_data_karyawan_pdf/<?php echo $perusahaan ?>/<?php echo $lokasi ?>/<?php echo $bagian; ?>/<?php echo $jenis; ?>">
            <i class="fa fa-download"></i>
            Download data
        </a>
        <?php
        if ($jenis == '3') {
            $stat_jy = 'Kontrak'; ?>
            <a class="btn bg-primary btn-flat margin" href="<?php echo site_url('Enterprise/karyawan/sample_kontrak') ?>">
                <i class="fa fa-download"></i>
                Sample Import Kontrak (excel)
            </a>
        <?php } else {
            $stat_jy = 'Tetap'; ?>
            <a class="btn bg-primary btn-flat margin" href="<?php echo site_url('Enterprise/karyawan/sample_kartap') ?>">
                <i class="fa fa-download"></i>
                Sample Import Kartap (excel)
            </a>
        <?php }
        ?>
    </div>
    <div class="box-body">
        <!-- custom tab -->
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="tab" href="#home">Available</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>NRP</td>
                            <td>Nama Karyawan</td>
                            <td>Unit</td>
                            <td>Job Grade</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = '1';
                        $status = '0'; //0 = available, 1 = resign, 2 = phk, 3 = hapus 
                        //jenis (1 = karyawan tetap, 2 = project, 3 kontrak)
                        $data   = $this->enterprise_model->list_karyawan($perusahaan, $lokasi, $bagian, $status, $jenis);
                        foreach ($data->result() as $dt) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->department; ?></td>
                                <td><?php echo $dt->job_grade; ?></td>
                                <td>
                                    <!-- edit -->
                                    <!--
									<a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id_karyawan; ?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
									-->
                                    <!-- view -->
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>Enterprise/karyawan/view_karyawan/<?php echo $dt->id_karyawan; ?>" title="View Data">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <!-- userid -->
                                    <!--<a class="btn bg-navy btn-flat" href="<?php echo base_url(); ?>Enterprise/karyawan/userid_karyawan/<?php echo $dt->badgenumber; ?>" onClick="return confirm('Update Userid <?php echo $dt->nama_lengkap; ?> ?')" title="Update Userid">
                                        <i class="fa fa-user"></i>
                                    </a>
									-->
                                    <!-- reset password -->
                                    <!--<a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>Enterprise/karyawan/reset_password/<?php echo $dt->id_karyawan; ?>" onClick="return confirm('Anda yakin ingin mereset password <?php echo $dt->nama_lengkap; ?> ?')" title="Reset Password (1234)">
                                        <i class="fa fa-key"></i>
                                    </a>
									-->
                                    <!-- delete -->
                                    <!--
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>Enterprise/karyawan/delete_karyawan/<?php echo $dt->id_karyawan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
									-->
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
<!-- modal upload excel -->
<div class="modal fade" id="excel">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>Enterprise/karyawan/upload_karyawan" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="import">Upload Karyawan</label>
                        <div class="col-md-12">
                            <input type="file" id="file_excel" name="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required="required">
                            <!-- 
                                jenis = 1 karyawan tetap
                                jenis = 2 rombongan / magang 
                            -->
                            <input type="hidden" name="jenis" value="<?php echo $jenis; ?>">
                            <input type="hidden" name="perusahaan" value="<?php echo $perusahaan; ?>">
                        </div>
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
</div>
<!-- modal edit -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>Enterprise/karyawan/simpan_karyawan" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama Karyawan</label>
                                <input type="hidden" name="id_karyawan" id="id_karyawan">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">NRP</label>
                                <input type="text" name="nip" id="nip" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Userid</label>
                                <input type="text" name="userid" id="userid" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Badgenumber</label>
                                <input type="text" name="badgenumber" id="badgenumber" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">No Telepon</label>
                                <input type="number" name="no_telepon" id="no_telepon" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0">Available</option>
                                    <option value="1">Resign</option>
                                    <option value="2">PHK</option>
                                </select>
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