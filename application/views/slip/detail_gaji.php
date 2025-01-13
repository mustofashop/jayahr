<?php if ($this->session->flashdata('msg')) : ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <?php
    $data = $this->master_model->detail_slip($data2);
    foreach ($data->result() as $dt) {
    ?>
        <script>
            $(document).ready(function() {
                $('.tanggal').datepicker({
                    autoclose: true
                })
                $("#imginp").change(function() {
                    viewImg(this);
                });

            });

            function viewImg(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#foto").removeAttr("src");
                        $("#foto").attr("src", e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $("#foto").removeAttr("src");
                    <?php if ($dt->foto_file != NULL) { ?>
                        $("#foto").attr("src", '<?php echo base_url(); ?>assets/foto_karyawan/<?php echo $dt->foto_file; ?>');
                    <?php } else { ?>
                        $("#foto").attr("src", '<?php echo base_url(); ?>assets/dist/img/default-avatar.png');
                    <?php } ?>
                }
            }
        </script>
        <form role="form" method="POST" action="<?php echo base_url(); ?>data_karyawan/simpan_karyawan" enctype="multipart/form-data">
            <input type="hidden" name="id_karyawan" value="<?php echo $id_k; ?>">
            <div class="box-header">
                <a class="btn btn-app" href="<?php echo base_url(); ?>data_member/list_member">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>

            </div>
            <div class="box-body">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" href="#home">Profil</a></li>
                    <li><a data-toggle="tab" href="#menu1">Assessment</a></li>
                    <li><a data-toggle="tab" href="#menu2">Appraisal</a></li>
                    <li><a data-toggle="tab" href="#menu3">Training History</a></li>
                    <li><a data-toggle="tab" href="#menu4">Job Experience</a></li>
                    <li><a data-toggle="tab" href="#menu5">Education</a></li>
                    <li><a data-toggle="tab" href="#menu6">Career Transition</a></li>
                    <li><a data-toggle="tab" href="#menu7">Employee Analitic (IDP)</a></li>
                    <li><a data-toggle="tab" href="#menu8">Internal Assessment</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="box-body">
                                        <?php if ($dt->foto_file != NULL) { ?>
                                            <img id="foto" class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/foto_karyawan/<?php echo $dt->foto_file; ?>" alt="Default profile picture">
                                        <?php } else { ?>
                                            <img id="foto" class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/dist/img/default-avatar.png" alt="Default profile picture">
                                        <?php } ?>
                                        <div>
                                            <div class="col-md-10">
                                                <input type="file" name="image" id="imginp" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end foto -->
                            <div class="col-md-8">
                                <div class="box">
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label for="nip">NRP</label>
                                            <input type="text" name="nip" id="nip" class="form-control" placeholder="0" value="<?php echo $dt->nip; ?>" required="required">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama">Nama Lengkap</label>
                                                    <input type="text" name="nama_lengkap" id="nama" class="form-control" required="required" autocomplete="off" value="<?php echo $dt->nama_lengkap; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama">Company</label>
                                                    <input type="text" name="company" id="company" class="form-control" value="<?php echo $dt->company; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="jk">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" id="jk" class="form-control">
                                                        <?php if ($dt->jenis_kelamin == "M" || $dt->jenis_kelamin == 'm' || $dt->jenis_kelamin == 'L' || $dt->jenis_kelamin == 'l') { ?>
                                                            <option value="M" selected="selected">Laki - Laki</option>
                                                            <option value="F">Perempuan</option>
                                                        <?php } elseif ($dt->jenis_kelamin == "F" || $dt->jenis_kelamin == 'f' || $dt->jenis_kelamin == 'P' || $dt->jenis_kelamin == 'p') { ?>
                                                            <option value="M">Laki - Laki</option>
                                                            <option value="F" selected="selected">Perempuan</option>
                                                        <?php } else { ?>
                                                            <option value="M">Laki - Laki</option>
                                                            <option value="F">Perempuan</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tempat_l">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" id="tempat_l" class="form-control" placeholder="-" value="<?php echo $dt->tempat_lahir; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tanggal_l">Tanggal Lahir</label>
                                                    <?php
                                                    $tgl_lahir  = $dt->tgl_lahir;
                                                    if (empty($tgl_lahir)) {
                                                        $tanggal    = '01-01-1990';
                                                    } else {
                                                        $tgl        = substr($tgl_lahir, 8, 2);
                                                        $bln        = substr($tgl_lahir, 5, 2);
                                                        $thn        = substr($tgl_lahir, 0, 4);
                                                        $tanggal    = $tgl . '-' . $bln . '-' . $thn;
                                                    }
                                                    ?>
                                                    <input type="text" class="form-control tanggal" name="tanggal_lahir" id="tanggal_l" placeholder="0001-01-01" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?php echo $tanggal; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Job Title</label>
                                            <input type="text" name="job_title" id="job_title" class="form-control" value="<?php echo $dt->job_title; ?>">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama">Department</label>
                                                    <input type="text" name="department" id="department" class="form-control" value="<?php echo $dt->department; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama">Job Grade</label>
                                                    <input type="text" name="job_grade" id="job_grade" class="form-control" value="<?php echo $dt->job_grade; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">SPV 1</label>
                                                    <input type="number" name="spv1" id="spv1" class="form-control" value="<?php echo $dt->spv1; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">SPV 2</label>
                                                    <input type="number" name="spv2" id="spv2" class="form-control" value="<?php echo $dt->spv2; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">SPV 3</label>
                                                    <input type="number" name="spv3" id="spv3" class="form-control" value="<?php echo $dt->spv3; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end profil -->
                    <div id="menu1" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Subject</td>
                                        <td>Testing Date</td>
                                        <td>Institution</td>
                                        <td>Score</td>
                                        <td>Result Description</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_assessment($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nrp; ?></td>
                                            <td><?php echo $dt1->subject; ?></td>
                                            <td><?php echo $dt1->testing_date; ?></td>
                                            <td><?php echo $dt1->institution; ?></td>
                                            <td><?php echo $dt1->institution_score; ?></td>
                                            <td><?php echo $dt1->result_description; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end no id -->
                    <div id="menu2" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Performance Year</td>
                                        <td>KPI/PA</td>
                                        <td>KBI</td>
                                        <td>Catatan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_appraisal($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nrp; ?></td>
                                            <td><?php echo $dt1->tahun; ?></td>
                                            <td><?php echo $dt1->kpi_pa; ?></td>
                                            <td><?php echo $dt1->kbi; ?></td>
                                            <td><?php echo $dt1->catatan; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end Keluarga -->
                    <div id="menu3" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Training Course</td>
                                        <td>Training Topic</td>
                                        <td>Start Date</td>
                                        <td>End Date</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_training($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nrp; ?></td>
                                            <td><?php echo $dt1->training_course; ?></td>
                                            <td><?php echo $dt1->training_topic; ?></td>
                                            <td><?php echo $dt1->start_date; ?></td>
                                            <td><?php echo $dt1->end_date; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end seragam -->
                    <div id="menu4" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Company Name</td>
                                        <td>Company Location</td>
                                        <td>Position</td>
                                        <td>Employment Period</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_job($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nrp; ?></td>
                                            <td><?php echo $dt1->company_name; ?></td>
                                            <td><?php echo $dt1->company_location; ?></td>
                                            <td><?php echo $dt1->position; ?></td>
                                            <td><?php echo $dt1->employment_period; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end seragam -->
                    <div id="menu5" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Level</td>
                                        <td>Name</td>
                                        <td>Major</td>
                                        <td>Period</td>
                                        <td>City</td>
                                        <td>GPA</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_education($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nrp; ?></td>
                                            <td><?php echo $dt1->level; ?></td>
                                            <td><?php echo $dt1->name; ?></td>
                                            <td><?php echo $dt1->major; ?></td>
                                            <td><?php echo $dt1->period; ?></td>
                                            <td><?php echo $dt1->city; ?></td>
                                            <td><?php echo $dt1->gpa; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end seragam -->
                    <div id="menu6" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Effective Date</td>
                                        <td>Range Year</td>
                                        <td>Position</td>
                                        <td>Organization Unit</td>
                                        <td>Job Grade</td>
                                        <td>Employee Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_career($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nrp; ?></td>
                                            <td><?php echo $dt1->effective_date; ?></td>
                                            <td><?php echo $dt1->range_year; ?></td>
                                            <td><?php echo $dt1->job_title; ?></td>
                                            <td><?php echo $dt1->organization_unit; ?></td>
                                            <td><?php echo $dt1->job_grade; ?></td>
                                            <td><?php echo $dt1->employee_status; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end bank -->
                    <div id="menu7" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Nama Karyawan</td>
                                        <td>Date of Entry</td>
                                        <td>Assessor</td>
                                        <td>Alternative Career Plan</td>
                                        <td>Strength</td>
                                        <td>Areas for Development</td>
                                        <td>Individual Development Plan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_idp($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nrp; ?></td>
                                            <td><?php echo $dt1->nama_karyawan; ?></td>
                                            <td><?php echo $dt1->date_of_enrty; ?></td>
                                            <td><?php echo $dt1->assesor; ?></td>
                                            <?php
                                            $isi1 = $this->master_model->profile_idp_dtl($dt->nip, $dt1->tahun, 1);
                                            $isi2 = $this->master_model->profile_idp_dtl2($dt->nip, $dt1->tahun, 2);
                                            $isi3 = $this->master_model->profile_idp_dtl3($dt->nip, $dt1->tahun, 3);
                                            $isi4 = $this->master_model->profile_idp_dtl4($dt->nip, $dt1->tahun, 4);
                                            ?>
                                            <td> <?php echo $isi1->row()->isi_idp; ?></td>
                                            <td> <?php echo $isi2->row()->isi_idp; ?></td>
                                            <td> <?php echo $isi3->row()->isi_idp; ?></td>
                                            <td> <?php echo $isi4->row()->isi_idp; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end bank -->
                    <div id="menu8" class="tab-pane">
                        <div class="box">
                            <table class="table table-bordered table-striped tabeldinamis">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>NRP</td>
                                        <td>Nama Karyawan</td>
                                        <td>Date of Entry</td>
                                        <td>Assessor</td>
                                        <td>Personality Values</td>
                                        <td>Knowledge Technical Skills to support business</td>
                                        <td>Team Work (EQ)</td>
                                        <td>Management Skill</td>
                                        <td>Leadership</td>
                                        <td>Shareholders Value Creation</td>
                                        <td>Energy</td>
                                        <td>Judgement</td>
                                        <td>Final Score</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_p   = $this->session->userdata('id_perusahaan');
                                    $no     = 1;
                                    $status = 0;
                                    $data_1 = $this->master_model->profile_career($dt->nip);
                                    foreach ($data_1->result() as $dt1) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- end bank -->
                </div>
            </div>
        </form>
    <?php
    }
    ?>
</div>