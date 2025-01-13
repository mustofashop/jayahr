<script>
    $(document).ready(function() {
        $(".date-picker").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });

    function goBack() {
        window.history.back();
    }
</script>
<?php if ($this->session->flashdata('msg')) : ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<form method="POST" action="<?php echo base_url(); ?>Enterprise/karyawan/simpan_detail_karyawan" enctype="multipart/form-data">
    <div class="box">
        <div class="box-header">
            <a class="btn btn-app" onclick="goBack()">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-app">
                <i class="fa fa-save"></i> Simpan
            </button>
        </div>
        <div class="box-body">
            <!-- custom tab -->
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="tab" href="#home">Profil</a></li>
                <!--
				<li><a data-toggle="tab" href="#menu1">No. ID</a></li>
                <li><a data-toggle="tab" href="#menu2">Keluarga</a></li>
                <li><a data-toggle="tab" href="#menu3">Seragam</a></li>
                <li><a data-toggle="tab" href="#menu4">Bank</a></li>
                <li><a data-toggle="tab" href="#menu5">Riwayat Kontrak</a></li> 
				-->
            </ul>
            <div class="tab-content">
                <!-- data -->
                <?php
                $data   = $this->enterprise_model->detail_karyawan_full($id_k);
                foreach ($data->result() as $data_k) {
                ?>
                    <!-- profil -->
                    <div id="home" class="tab-pane fade in active">
                        <input type="hidden" name="id_karyawan" id="id_karyawan" value="<?php echo $id_k; ?>">
                        <!-- row -->
                        <div class="row">
                            <div class="col-md-4">
                                <!-- foto -->
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <?php
                                        if (empty($data_k->foto_64)) {
                                        ?>
                                            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/dist/img/default-avatar.png" alt="Default Pic">
                                        <?php
                                        } else {
                                        ?>
                                            <img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,<?php echo $data_k->foto_64; ?>" alt="User Pic">
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="box-footer">
                                        <input type="file" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- left side -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status Karyawan</label>
                                            <select name="status" id="status" class="form-control" required="required">
                                                <?php if ($data_k->status == '0') { ?>
                                                    <option value="0" selected="selected">Available</option>
                                                    <option value="1">Resign</option>
                                                    <option value="2">PHK</option>
                                                <?php } elseif ($data_k->status == '1') { ?>
                                                    <option value="0">Available</option>
                                                    <option value="1" selected="selected">Resign</option>
                                                    <option value="2">PHK</option>
                                                <?php } else { ?>
                                                    <option value="0">Available</option>
                                                    <option value="1">Resign</option>
                                                    <option value="2" selected="selected">PHK</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">NRP</label>
                                            <input type="text" name="nip" id="nip" class="form-control" required="required" value="<?php echo $data_k->nip; ?>">
                                        </div>
                                    </div>
                                    <!-- end left side -->
                                    <!-- right side -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Hire</label>
                                            <input type="text" name="tanggal_hire" id="tanggal_hire" class="form-control date-picker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="Tahun-Bulan-Hari" value="<?php echo $data_k->tgl_hire; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tanggal Permanen</label>
                                            <input type="text" name="tanggal_permanen" id="tanggal_permanen" class="form-control date-picker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="Tahun-Bulan-Hari" value="<?php echo $data_k->tgl_permanen; ?>" />
                                        </div>
                                    </div>
                                    <!-- end right side -->
                                </div>
                                <!-- end row -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required="required" value="<?php echo $data_k->nama_lengkap; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                <?php if ($data_k->jenis_kelamin == "M" || $data_k->jenis_kelamin == 'm' || $data_k->jenis_kelamin == 'L' || $data_k->jenis_kelamin == 'l') { ?>
                                                    <option value="M" selected="selected">Laki - Laki</option>
                                                    <option value="F">Perempuan</option>
                                                <?php } elseif ($data_k->jenis_kelamin == "F" || $data_k->jenis_kelamin == 'f' || $data_k->jenis_kelamin == 'P' || $data_k->jenis_kelamin == 'p') { ?>
                                                    <option value="M">Laki - Laki</option>
                                                    <option value="F" selected="selected">Perempuan</option>
                                                <?php } else { ?>
                                                    <option value="M">Laki - Laki</option>
                                                    <option value="F">Perempuan</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- row lokasi uk -->
                                <!--
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Lokasi</label>
                                            <select name="lokasi" id="lokasi" class="form-control" required="required">
                                                <?php
                                                //$lokasi = $this->enterprise_model->list_lokasi($data_k->id_perusahaan);
                                                //foreach ($lokasi->result() as $lok) {
                                                ?>
                                                        <option value="<?php //echo $lok->id_lokasi; 
                                                                        ?>" <?php //echo $lok->id_lokasi == $data_k->id_lokasi ? ' selected="selected"' : '';
                                                                            ?>><?php //echo $lok->nama_lokasi; 
                                                                                ?></option>
                                                <?php
                                                //}
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Bagian / UK</label>
                                            <select name="bagian" id="bagian" class="form-control" required="required">
                                                <?php
                                                //$bagian = $this->enterprise_model->list_bagian2($data_k->id_perusahaan);
                                                //foreach ($bagian->result() as $bag) {
                                                ?>
                                                    <option value="<?php //echo $bag->id_bagian; 
                                                                    ?>" <?php //echo $bag->id_bagian == $data_k->id_bagian ? ' selected="selected"' : '';
                                                                        ?>><?php //echo $bag->nama_bagian; 
                                                                            ?></option>
                                                <?php
                                                //}
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								-->
                                <!-- end row lokasi uk -->
                                <!-- row ttl -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="<?php echo $data_k->tempat_lahir; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Tanggal Lahir</label>
                                            <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control date-picker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="Tahun-Bulan-Hari" value="<?php echo $data_k->tgl_lahir; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <!-- end row ttl -->
                                <!-- row jk , status pernikahan dan pendidikan -->

                                <!-- end row jk , status pernikahan dan pendidikan -->
                                <!-- row alamat, domisili dan kode pos -->

                                <!-- end row alamat, domisili dan kode pos -->
                                <!-- row kelurahan dan kecamatan -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Department</label>
                                            <input type="text" name="department" id="department" class="form-control" value="<?php echo $data_k->department; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Job Grade</label>
                                            <input type="text" name="job_grade" id="job_grade" class="form-control" value="<?php echo $data_k->job_grade; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row kelurahan dan kecamatan -->
                                <!-- row kota dan provinsi -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Job Title</label>
                                            <input type="text" name="job_title" id="job_title" class="form-control" value="<?php echo $data_k->job_title; ?>">
                                        </div>
                                    </div>

                                </div>
                                <!-- end row kota dan provinsi -->
                                <!-- row telepon dan wa -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">SPV 1</label>
                                            <input type="number" name="spv1" id="spv1" class="form-control" value="<?php echo $data_k->spv1; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">SPV 2</label>
                                            <input type="number" name="spv2" id="spv2" class="form-control" value="<?php echo $data_k->spv2; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">SPV 3</label>
                                            <input type="number" name="spv3" id="spv3" class="form-control" value="<?php echo $data_k->spv3; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row telepon dan wa -->
                                <!-- row email dan gol darah -->

                                <!-- end row email dan gol darah -->
                            </div>
                        </div>
                    </div>
                    <!-- end profil -->
                    <!-- no id -->

                    <!-- end no id -->
                    <!-- keluarga -->

                    <!-- end keluarga -->
                    <!-- seragam -->

                    <!-- end seragam -->
                    <!-- bank -->

                    <!-- end bank -->
                    <!-- riwayat kontrak -->
                    <!-- <div id="menu5" class="tab-pane fade">

                    </div> -->
                    <!-- end riwayat kontrak -->
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</form>