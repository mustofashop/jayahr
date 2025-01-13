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
        <a class="btn btn-app" href="<?php echo base_url(); ?>int_assessment">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        
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
                            <th>Assessment</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $id_p   = $this->session->userdata('id_perusahaan');
                            $no     = 1;
                            $status = 0;
                            $nrp    = $this->session->userdata('nrp');
                            $data_1 = $this->master_model->list_member($nrp);
                            foreach($data_1->result() as $dt1){
								
							$cek_finass = $this->master_model->cek_sent_inass($tahun,$dt1->nip);
							
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->nip; ?></td>
                                <td><?php echo $dt1->nama_lengkap; ?></td>
                                <td><?php echo $dt1->status_jaya; ?></td>
                                <td><?php
									if($cek_finass->num_rows() > 0){
										echo 'Sudah Diisi';
									}
									else{
										echo 'Belum Diisi';
									} ?></td>
                                <td>
                                    <!-- lihat -->
									<?php if($cek_finass->num_rows() > 0){ ?>
                                    <a class="btn btn-flat bg-green" href="<?php echo base_url(); ?>int_assessment/lihat_inass/<?php echo $dt1->nip; ?>/<?php echo $tahun; ?>" title="Lihat <?php echo $dt1->nama_lengkap; ?>">
                                            <i class="fa fa-search"></i>
                                    </a>
									<?php } ?>
									
                                    <!-- tambah -->
									<?php if($cek_finass->num_rows() <= 0){ ?>
                                    <a class="btn btn-flat bg-blue" href="<?php echo base_url(); ?>int_assessment/tambah_inass/<?php echo $dt1->nip; ?>/<?php echo $tahun; ?>" title="Isi IDP <?php echo $dt1->nama_lengkap; ?>">
                                            <i class="fa fa-plus"></i>
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
    </div>
</div>