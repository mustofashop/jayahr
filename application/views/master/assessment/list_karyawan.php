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
        <a class="btn btn-app" href="<?php echo base_url(); ?>m_assessment">
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
                            $id_p   = $this->session->userdata('id_perusahaan');
                            $no     = 1;
                            $status = 0;
                            $data_1 = $this->master_model->list_karyawan($kategori,$id_p,$status);
                            foreach($data_1->result() as $dt1){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->nip; ?></td>
								<td><?php echo $dt1->nama_lengkap; ?></td>
                                <td><?php echo $dt1->department; ?></td>
                                <td><?php echo $dt1->job_grade; ?></td>
                                <td>
                                    <a class="btn btn-flat bg-blue" href="<?php echo base_url(); ?>m_assessment/lihat_assessment/<?php echo $dt1->id_karyawan; ?>/<?php echo $kategori; ?>" title="Lihat <?php echo $dt1->nama_lengkap; ?>">
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