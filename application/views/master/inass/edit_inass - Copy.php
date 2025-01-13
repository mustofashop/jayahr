<?php if($this->session->flashdata('msg')): ?>
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
            <div class="box-body">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" href="#home">Personality Values</a></li>
					<li><a data-toggle="tab" href="#menu1">Knowledge Technical Skills To Support Business</a></li>
					<li><a data-toggle="tab" href="#menu2">Team Work (EQ)</a></li>
					<li><a data-toggle="tab" href="#menu3">Management Skill</a></li>
					<li><a data-toggle="tab" href="#menu4">Leadership </a></li>
					<li><a data-toggle="tab" href="#menu5">Shareholders Value Creation </a></li>
					<li><a data-toggle="tab" href="#menu6">Energy </a></li>
					<li><a data-toggle="tab" href="#menu7">Judgment </a></li>
                </ul>
                <div class="tab-content">
					<div id="home" class="tab-pane fade in active">
                    <div class="box">
                        <label style="color:red"><b>Integritas  (bersikap jujur, menjunjung tinggi etika dan moral)</b></label>
						<div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 1;
										$data   = $this->master_model->list_tanya_inass3($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_'.$dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control">
                                                    <?php 
                                                    $b  		= $this->master_model->cek_jwb_inass3($nrp,$tahun,$dt->id_iass_3);
                                                    $isi     	= $b->row()->isi_inass3;
													?>
													<?php if($isi == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_'.$dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control">
                                                    <?php 
                                                    $b  		= $this->master_model->cek_jwb_inass3($nrp,$tahun,$dt->id_iass_3);
                                                    $isi     	= $b->row()->isi_inass3;
													?>
													<?php if($isi == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_'.$dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control">
                                                    <?php 
                                                    $b  		= $this->master_model->cek_jwb_inass3($nrp,$tahun,$dt->id_iass_3);
                                                    $isi     	= $b->row()->isi_inass3;
													?>
													<?php if($isi == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_'.$dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control">
                                                    <?php 
                                                    $b  		= $this->master_model->cek_jwb_inass3($nrp,$tahun,$dt->id_iass_3);
                                                    $isi     	= $b->row()->isi_inass3;
													?>
													<?php if($isi == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass3_'.$dt->id_iass_3; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control">
                                                    <?php 
                                                    $b  		= $this->master_model->cek_jwb_inass3($nrp,$tahun,$dt->id_iass_3);
                                                    $isi     	= $b->row()->isi_inass3;
													?>
													<?php if($isi == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 1 -->
                <div id="menu1" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 2;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_'.$dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control">
                                                    <?php 
                                                    $b2			= $this->master_model->cek_jwb_inass2($nrp,$tahun,$dt->id_iass_2);
                                                    $isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if($isi2 == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 2 -->
                <div id="menu2" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 3;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_'.$dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control">
                                                    <?php 
                                                    $b2			= $this->master_model->cek_jwb_inass2($nrp,$tahun,$dt->id_iass_2);
                                                    $isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if($isi2 == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 3 -->
                <div id="menu3" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 4;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_'.$dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control">
                                                    <?php 
                                                    $b2			= $this->master_model->cek_jwb_inass2($nrp,$tahun,$dt->id_iass_2);
                                                    $isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if($isi2 == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 4 -->
                <div id="menu4" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 5;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_'.$dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control">
                                                    <?php 
                                                    $b2			= $this->master_model->cek_jwb_inass2($nrp,$tahun,$dt->id_iass_2);
                                                    $isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if($isi2 == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 5 -->
				<div id="menu5" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 6;
										$data   = $this->master_model->list_tanya_inass2($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass2_'.$dt->id_iass_2; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control">
                                                    <?php 
                                                    $b2			= $this->master_model->cek_jwb_inass2($nrp,$tahun,$dt->id_iass_2);
                                                    $isi2     	= $b2->row()->isi_inass2;
													?>
													<?php if($isi2 == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi2 == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 6 -->
				<div id="menu6" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 7;
										$data   = $this->master_model->list_tanya_inass1($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass1_'.$dt->id_iass; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass1_'.$dt->id_iass; ?>" id="<?php echo 'iass1_'.$dt->id_iass; ?>" class="form-control">
                                                    $b3			= $this->master_model->cek_jwb_inass($nrp,$tahun,$dt->id_iass);
                                                    $isi3     	= $b3->row()->isi_inass;
													?>
													<?php if($isi3 == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi3 == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi3 == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 7 -->
				<div id="menu7" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 8;
										$data   = $this->master_model->list_tanya_inass1($id_iassx);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
                                                <label style="color:black" for="<?php echo 'iass1_'.$dt->id_iass; ?>"><?php echo $dt->nama_value; ?></label>
                                                <select name="<?php echo 'iass1_'.$dt->id_iass; ?>" id="<?php echo 'iass1_'.$dt->id_iass; ?>" class="form-control">
                                                    $b3			= $this->master_model->cek_jwb_inass($nrp,$tahun,$dt->id_iass);
                                                    $isi3     	= $b3->row()->isi_inass;
													?>
													<?php if($isi3 == 1){ ?>
														<option value="1" selected="selected">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi3 == 2){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2" selected="selected">2 (Cukup)</option>
														<option value="3">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }elseif($isi3 == 3){ ?>
														<option value="1">1 (Kurang)</option>
														<option value="2">2 (Cukup)</option>
														<option value="3" selected="selected">3 (Baik)</option>
														<option value="4">4 (Sangat Baik)</option>
													<?php }else{ ?>
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
                <!-- end 8 -->
            </div>
        </div>
    </form>
</div>