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
        
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
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
                            <th>Tanggal Permanen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $no     = 1;
                            $status = 0;
							$nrp    = $this->session->userdata('nrp');
                            $data_1 = $this->master_model->list_member($nrp);
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
                                <td><?php echo $dt1->tgl_permanen; ?></td>
                                <td>
                                    <a class="btn btn-flat bg-gray" href="<?php echo base_url(); ?>data_karyawan/lihat_karyawan/<?php echo $dt1->id_karyawan; ?>" title="Lihat <?php echo $dt1->nama_lengkap; ?>">
									<i class="fa fa-search"></i>
									</a>
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