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
<div class="box">
    <div class="box-header">
        
        
    </div>
    <div class="box-body">
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="tab" href="#home">Belum Isi</a></li>
            <li><a data-toggle="tab" href="#menu1">Sudah Isi</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
				<!--<a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>lap_idp/download_idp_belum">
					<i class="fa fa-download"></i>
					Download data
				</a>
				-->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NRP</th>
                            <th>Nama Karyawan</th>
                            <th>Status</th>
                            <th>Job Grade</th>
                            <th>Unit Kerja</th>
                            <th>Tanggal Hire</th>
                            <th>SPV 1</th>
                            <th>SPV 2</th>
                            <th>SPV 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $no     = 1;
                            $status = 0;
							$nrp    = $this->session->userdata('nrp');
							$thn = '2023';
                            $data_1 = $this->master_model->list_idp_belum($thn);
                            foreach($data_1->result() as $dt1){
								//$tahun = 2023;
								//$cek_idp = $this->master_model->cek_idp($tahun,$dt1->nip);
								//$cek_fidp = $this->master_model->cek_sent_idp($tahun,$dt1->nip);
								//$cek_finass = $this->master_model->cek_sent_inass($tahun,$dt1->nip);
								
								//$fsent = $cek_fidp->row()->f_sent;
								//$hasil = $cek_idp->row()->hasil;
								//$cek = $cek_idp->row()->cek;
							
						?>
							<tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->nip; ?></td>
                                <td><?php echo $dt1->nama_lengkap; ?></td>
                                <td><?php echo $dt1->status_jaya; ?></td>
                                <td><?php echo $dt1->job_grade; ?></td>
                                <td><?php echo $dt1->department; ?></td>
                                <td><?php echo $dt1->tgl_hire; ?></td>
                                <td><?php echo $dt1->spv1; ?></td>
                                <td><?php echo $dt1->spv2; ?></td>
                                <td><?php echo $dt1->spv3; ?></td>
                            </tr>
                        <?php
                            $no++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
			<!-- end belum isi  -->
			<div id="menu1" class="tab-pane">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NRP</th>
                            <th>Nama Karyawan</th>
                            <th>Status</th>
                            <th>Job Grade</th>
                            <th>Unit Kerja</th>
                            <th>Tanggal Hire</th>
                            <th>SPV 1</th>
                            <th>SPV 2</th>
                            <th>SPV 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $no     = 1;
                            $status = 0;
							$nrp    = $this->session->userdata('nrp');
							$thn = '2023';
                            $data_1 = $this->master_model->list_idp_sudah($thn);
                            foreach($data_1->result() as $dt1){
								//$tahun = 2023;
								//$cek_idp = $this->master_model->cek_idp($tahun,$dt1->nip);
								//$cek_fidp = $this->master_model->cek_sent_idp($tahun,$dt1->nip);
								//$cek_finass = $this->master_model->cek_sent_inass($tahun,$dt1->nip);
								
								//$fsent = $cek_fidp->row()->f_sent;
								//$hasil = $cek_idp->row()->hasil;
								//$cek = $cek_idp->row()->cek;
							
						?>
							<tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->nip; ?></td>
                                <td><?php echo $dt1->nama_lengkap; ?></td>
                                <td><?php echo $dt1->status_jaya; ?></td>
                                <td><?php echo $dt1->job_grade; ?></td>
                                <td><?php echo $dt1->department; ?></td>
                                <td><?php echo $dt1->tgl_hire; ?></td>
                                <td><?php echo $dt1->spv1; ?></td>
                                <td><?php echo $dt1->spv2; ?></td>
                                <td><?php echo $dt1->spv3; ?></td>
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