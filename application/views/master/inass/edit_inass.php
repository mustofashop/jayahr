<?php if ($this->session->flashdata('msg')) : ?>
	<div class="alert alert-success alert-dismissible" id="success-alert">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Alert!</h4>
		<?php echo $this->session->flashdata('msg'); ?>
	</div>
<?php endif; ?>
<div class="box">
	<?php
	//$data_karyawan = $this->master_model->detail_karyawan_full($id_k); 
	//foreach($data_karyawan->result() as $dt){
	?>

	<form role="form" method="POST" action="<?php echo base_url(); ?>int_assessment/simpan_inass" enctype="multipart/form-data">
		<input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
		<input type="hidden" name="nrp" value="<?php echo $nrp; ?>">
		<div class="box-header">
			<a class="btn btn-app" href="<?php echo base_url(); ?>int_assessment/list_inass?tahun=<?php echo $tahun; ?>">
				<i class="fa fa-arrow-left"></i>
				Kembali
			</a>
			<button class="btn btn-app" type="submit">
				<i class="fa fa-floppy-o"></i>
				Simpan
			</button>
		</div>
		<!--sini -->
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
							Personality Values</a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="box">
							<label style="color:red"><b>Integritas (bersikap jujur, menjunjung tinggi etika dan moral)</b></label>
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 1;
										$data   = $this->master_model->list_tanya_inass3($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control">
													<?php
													$b  		= $this->master_model->cek_jwb_inass3($nrp, $tahun, $dt->id_iass_3, $atasan);
													$isi     	= $b->row()->isi_inass3;
													?>
													<?php if ($isi == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="box">
							<label style="color:red"><b>Adil</b></label>
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 2;
										$data   = $this->master_model->list_tanya_inass3($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control">
													<?php
													$b  		= $this->master_model->cek_jwb_inass3($nrp, $tahun, $dt->id_iass_3, $atasan);
													$isi     	= $b->row()->isi_inass3;
													?>
													<?php if ($isi == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
						<div class="box">
							<label style="color:red"><b>Komit</b></label>
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 3;
										$data   = $this->master_model->list_tanya_inass3($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control">
													<?php
													$b  		= $this->master_model->cek_jwb_inass3($nrp, $tahun, $dt->id_iass_3, $atasan);
													$isi     	= $b->row()->isi_inass3;
													?>
													<?php if ($isi == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
						<div class="box">
							<label style="color:red"><b>Dorongan Berprestasi</b></label>
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 4;
										$data   = $this->master_model->list_tanya_inass3($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control">
													<?php
													$b  		= $this->master_model->cek_jwb_inass3($nrp, $tahun, $dt->id_iass_3, $atasan);
													$isi     	= $b->row()->isi_inass3;
													?>
													<?php if ($isi == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
						<div class="box">
							<label style="color:red"><b>Intrapreneurship</b></label>
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 5;
										$data   = $this->master_model->list_tanya_inass3($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass3_' . $dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass3_' . $dt->id_iass_3; ?>" id="<?php echo 'iass3_' . $dt->id_iass_3; ?>" class="form-control">
													<?php
													$b  		= $this->master_model->cek_jwb_inass3($nrp, $tahun, $dt->id_iass_3, $atasan);
													$isi     	= $b->row()->isi_inass3;
													?>
													<?php if ($isi == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
							Knowledge Technical Skills To Support Business</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="box">
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 2;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control">
													<?php
													$b2			= $this->master_model->cek_jwb_inass2($nrp, $tahun, $dt->id_iass_2, $atasan);
													$isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if ($isi2 == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
							Team Work (EQ)</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="box">
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 3;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control">
													<?php
													$b2			= $this->master_model->cek_jwb_inass2($nrp, $tahun, $dt->id_iass_2, $atasan);
													$isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if ($isi2 == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
							Management Skill</a>
					</h4>
				</div>
				<div id="collapse4" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="box">
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 4;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control">
													<?php
													$b2			= $this->master_model->cek_jwb_inass2($nrp, $tahun, $dt->id_iass_2, $atasan);
													$isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if ($isi2 == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
							Leadership</a>
					</h4>
				</div>
				<div id="collapse5" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="box">
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 5;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control">
													<?php
													$b2			= $this->master_model->cek_jwb_inass2($nrp, $tahun, $dt->id_iass_2, $atasan);
													$isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if ($isi2 == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
							Shareholders Value Creation</a>
					</h4>
				</div>
				<div id="collapse6" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="box">
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 6;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass2_' . $dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass2_' . $dt->id_iass_2; ?>" id="<?php echo 'iass2_' . $dt->id_iass_2; ?>" class="form-control">
													<?php
													$b2			= $this->master_model->cek_jwb_inass2($nrp, $tahun, $dt->id_iass_2, $atasan);
													$isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if ($isi2 == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi2 == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
							Energy</a>
					</h4>
				</div>
				<div id="collapse7" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="box">
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 7;
										$data   = $this->master_model->list_tanya_inass1($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass1_' . $dt->id_iass; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass1_' . $dt->id_iass; ?>" id="<?php echo 'iass1_' . $dt->id_iass; ?>" class="form-control">
													<?php
													$b7			= $this->master_model->cek_jwb_inass($nrp, $tahun, $dt->id_iass, $atasan);
													$isi7     	= $b7->row()->isi_inass;
													?>
													<?php if ($isi7 == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi7 == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi7 == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
							Judgment</a>
					</h4>
				</div>
				<div id="collapse8" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="box">
							<div class="box-body">
								<div class="row">
									<div class="col-md-10">
										<?php
										$no     = '1';
										$id_iassx = 8;
										$data   = $this->master_model->list_tanya_inass1($id_iassx);
										foreach ($data->result() as $dt) {
										?>
											<div class="form-group">
												<label style="color:black" for="<?php echo 'iass1_' . $dt->id_iass; ?>"><?php echo $dt->nama_value; ?></label>
												<select name="<?php echo 'iass1_' . $dt->id_iass; ?>" id="<?php echo 'iass1_' . $dt->id_iass; ?>" class="form-control">
													<?php
													$b8			= $this->master_model->cek_jwb_inass($nrp, $tahun, $dt->id_iass, $atasan);
													$isi8     	= $b8->row()->isi_inass;
													?>
													<?php if ($isi8 == 1) { ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi8 == 2) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } elseif ($isi8 == 3) { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php } else { ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4" selected="selected">4 (Sangat Baik)</option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>
</div>