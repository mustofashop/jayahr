<div class="box">
    
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>int_assessment/list_inass?tahun=<?php echo $tahun; ?>">
                <i class="fa fa-arrow-left"></i>
                Kembali
        </a>
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
                        <label style="color:red">Integritas  (bersikap jujur, menjunjung tinggi etika dan moral)</label>
						<div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 1;
										$data   = $this->master_model->list_isi_inass3($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass3==1){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass3==2){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass3==3){
												echo '3 (Baik)';
											}elseif($dt->isi_inass3==4){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
									<?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="box">
                        <label style="color:red">Adil</label>
						<div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 2;
										$data   = $this->master_model->list_isi_inass3($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass3 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass3 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass3 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass3 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
									<?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="box">
                        <label style="color:red">Komit</label>
						<div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 3;
										$data   = $this->master_model->list_isi_inass3($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass3 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass3 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass3 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass3 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
									<?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="box">
                        <label style="color:red">Dorongan Berprestasi</label>
						<div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 4;
										$data   = $this->master_model->list_isi_inass3($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass3 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass3 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass3 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass3 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
									<?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="box">
                        <label style="color:red">Intrapreneurship</label>
						<div class="box-body"> 
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
										$no     = '1';
										$id_iassx = 5;
										$data   = $this->master_model->list_isi_inass3($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass3_'.$dt->id_iass_3; ?>" id="<?php echo 'iass3_'.$dt->id_iass_3; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass3 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass3 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass3 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass3 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
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
										$data   = $this->master_model->list_isi_inass2($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass2 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass2 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass2 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass2 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
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
										$data   = $this->master_model->list_isi_inass2($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass2 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass2 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass2 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass2 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
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
										$data   = $this->master_model->list_isi_inass2($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass2 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass2 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass2 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass2 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
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
										$data   = $this->master_model->list_isi_inass2($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass2 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass2 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass2 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass2 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
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
										$data   = $this->master_model->list_isi_inass2($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass2_'.$dt->id_iass_2; ?>" id="<?php echo 'iass2_'.$dt->id_iass_2; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass2 == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass2 == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass2 == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass2 == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
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
										$data   = $this->master_model->list_isi_inass($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass_'.$dt->id_iass; ?>" id="<?php echo 'iass_'.$dt->id_iass; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
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
										$data   = $this->master_model->list_isi_inass($id_iassx ,$nrp,$tahun);
										foreach($data->result() as $dt){
									?>
									<div class="form-group">
										<label style="color:black" for=""><?php echo $dt->nama_value; ?></label>
										<input type="text" align="left" name="<?php echo 'iass_'.$dt->id_iass; ?>" id="<?php echo 'iass_'.$dt->id_iass; ?>" class="form-control" 
										value="
										<?php if($dt->isi_inass == '1'){
												echo '1 (Kurang)';
											}elseif($dt->isi_inass == '2'){
												echo '2 (Cukup)';
											}elseif($dt->isi_inass == '3'){
												echo '3 (Baik)';
											}elseif($dt->isi_inass == '4'){
												echo '4 (Sangat Baik)';
										} 
										
										?>"></div>
									<?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end 8 -->
            </div>
    </div>
    
</div>