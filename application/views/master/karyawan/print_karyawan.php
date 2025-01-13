<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="icon" href="<?php echo base_url(); ?>assets/img/oase.png" type="image/x-icon">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoice/bootstrap/dist/css/bootstrap.min.css"> -->
	<!-- Font Awesome -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoice/font-awesome/css/font-awesome.min.css"> -->
	<!-- Ionicons -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoice/Ionicons/css/ionicons.min.css"> -->
	<!-- Theme style -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoice/css/AdminLTE.min.css"> -->
	<!-- Material Design -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoice/css/bootstrap-material-design.min.css">
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoice/css/ripples.min.css"> -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/invoice/css/MaterialAdminLTE.min.css"> -->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
	@media print {

		header,
		footer {
			display: none;
		}

		.pagebreak {
			page-break-before: always;
		}
	}

	hr.new2 {
		border-top: 1px dashed black;
		margin-top: 0px;
		margin-bottom: 0px;
	}

	.jarak_bawah_tabel {
		margin-bottom: -2px;
	}

	.table {
		margin-bottom: -3px;
	}

	ul.nb {
		list-style-type: none;
	}

	td {
		font-size: 10px;
	}

	th {
		font-size: 10px;
	}

	li {
		font-size: 10px;
	}

	p {
		font-size: 10px;
	}

	.footer {
		position: absolute;
		bottom: 0;
	}
</style>

<body onload="window.print();">
	<?php
	$data_karyawan = $this->master_model->detail_karyawan_full($id_k);
	foreach ($data_karyawan->result() as $dt) {
	?>

		<div class="wrapper">
			<!-- Main content -->
			<section class="invoice">
				<!-- title row -->
				<div class="row">
					<div class="col-md-3">
						<table class="table">
							<tr>
								<td style="width:30%"><img src="<?php echo base_url('assets/img/oase.png'); ?>" alt="jaya logo" style="width:150px; margin-top:12px;" class="pull-left"></td>
								<td style="width:40%"></td>
								<td style="width:40%">
									<h1 class="pull-right" style="font-size:15px;"><b>Individual Development Plan</b></h1>
								</td>
							</tr>
						</table>
					</div>

					<!-- /.col -->
				</div>
				<!-- info row -->


		</div>
		<div class="row">
			<!-- Deskripsi row -->
			<div class="col-xs-12 table-responsive jarak_bawah_tabel">
				<table class="table">
					<tbody>
						</br>
						<tr>
							<td><b>Personal Information</b></td>
						</tr>
					</tbody>
				</table>
				<hr class="new2">
			</div>
			<!-- /.row -->
		</div>
		<div class="row">
			<div class="col-xs-12 jarak_bawah_tabel">
				<table class="table">
					<thead>
						<tr>
							<td style="width:30%">Name</td>
							<td style="width:50%"><?php echo $dt->nama_lengkap; ?></td>
							<td rowspan="9">
								<?php $foto   = $dt->foto_64;
								if ($foto == '' || empty($foto) || $foto == NULL) { ?>
									<img src="<?php echo base_url('assets/dist/img/avatar.png'); ?>" alt="foto" style="width:155px" class="pull-center">
								<?php } else { ?>
									<img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,<?php echo $foto; ?>" style="width:155px">
								<?php } ?>

							</td>
						</tr>
						<tr>
							<td style="width:30%">NRP</td>
							<td style="width:40%"><?php echo $dt->nip; ?></td>
						</tr>
						<tr>
							<td style="width:30%">Gender</td>
							<td style="width:40%">
								<?php if ($dt->jenis_kelamin == "M" || $dt->jenis_kelamin == 'm' || $dt->jenis_kelamin == 'L' || $dt->jenis_kelamin == 'l') {
									echo 'Pria'; ?>
								<?php } elseif ($dt->jenis_kelamin == "F" || $dt->jenis_kelamin == 'f' || $dt->jenis_kelamin == 'P' || $dt->jenis_kelamin == 'p') {
									echo 'Wanita';
								} ?></td>
						</tr>
						<tr>
							<td style="width:30%">Date of Birth</td>
							<td style="width:40%"><?php echo $dt->tgl_lahir; ?></td>
						</tr>
						<tr>
							<td style="width:30%">Age</td>
							<td style="width:40%">
								<?php
								$thn_ini        = date("Y");
								$umur        = $thn_ini - substr($dt->tgl_lahir, 0, 4);
								echo $umur; ?>
							</td>
						</tr>
						<tr>
							<td style="width:30%">Date of Hire</td>
							<td style="width:40%"><?php echo $dt->tgl_hire; ?></td>
						</tr>
						<tr>
							<td style="width:30%">Employee Status</td>
							<td style="width:40%"><?php echo $dt->status_jaya; ?></td>
						</tr>
						<tr>
							<td style="width:30%">Job Title</td>
							<td style="width:40%"><?php echo $dt->job_title; ?></td>
						</tr>
						<tr>
							<td style="width:30%">Organization Unit</td>
							<td style="width:40%"><?php echo $dt->department; ?></td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		</div>

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Assesment</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
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

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Appraisal</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
			<div class="box">
				<table class="table table-bordered table-striped tabeldinamis">
					<thead>
						<tr>
							<td style="width:10%">No</td>
							<td style="width:20%">NRP</td>
							<td style="width:20%">Performance Year</td>
							<td style="width:10%">KPI/PA</td>
							<td style="width:10%">KBI</td>
							<td style="width:30%">Catatan</td>
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

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Training History</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
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

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Job Experience</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
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

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Internal Assessment</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
			<div class="box">
				<table class="table table-bordered table-striped tabeldinamis">
					<thead>
						<tr>
							<td>No</td>
							<td>NRP</td>
							<td>Name Employed</td>
							<td>Assessment Year</td>
							<td>Assesor</td>
							<td>Score</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$no     = 1;
						$status = 0;
						$id_karyawan    = $this->session->userdata('id_karyawan');
						$tahun 			= '2024';
						$data   		= $this->master_model->list_inass_rekap_score($dt->nip, $tahun)->row();
						$row = ($data->inas3_1 + $data->inas3_2 + $data->inas3_3 + $data->inas3_4 + $data->inas3_5) / 5;
						$row1 = ($row + $data->inas2_2 + $data->inas2_3 + $data->inas2_4 + $data->inas2_5 + $data->inas2_6 + $data->isi_inass1 + $data->isi_inass11) / 8;
						$data_1 		= $this->master_model->profile_inass($dt->nip);
						foreach ($data_1->result() as $dt1) {
						?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo $dt1->nrp; ?></td>
								<td><?php echo $dt1->nama_karyawan; ?></td>
								<td><?php echo $dt1->tahun; ?></td>
								<td><?php echo $dt1->assesor; ?></td>
								<td><?php echo number_format($row1, 2, ',', '.'); ?></td>
							</tr>
						<?php
							$no++;
						}
						?>
					</tbody>
				</table>

			</div>
		</div>

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Education</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
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

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Career Transition History</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
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

		<div class="tab-pane fade in active">
			<div class="row">
				<!-- Deskripsi row -->
				<div class="col-xs-12 table-responsive jarak_bawah_tabel">
					<table class="table">
						<tbody>
							</br>
							<tr>
								<td><b>Employee Analitic (IDP)</b></td>
							</tr>
						</tbody>
					</table>
					<hr class="new2">
				</div>
				<!-- /.row -->
			</div>
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


		</div>
		</div>
	<?php }
	?>
	</section>
	<!-- /.content -->
	</div>

</body>

</html>