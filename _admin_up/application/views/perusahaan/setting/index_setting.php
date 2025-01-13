<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>perusahaan/master_perusahaan" title="Kembali">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="box-body">
        <form method="POST" action="<?php echo base_url(); ?>perusahaan/save_setting">
            <input type="hidden" name="id_perusahaan" value="<?php echo $id_p; ?>">
            <div class="row">
                <div class="col-md-6">
                <?php if($this->session->flashdata('msg1')): ?>
                    <div class="alert alert-success alert-dismissible" id="success-alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        <?php echo $this->session->flashdata('msg1'); ?>
                    </div>
                <?php endif; ?>
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Laporan OM / IT</h4>
                            <br>
                            <a class="btn btn-app" data-toggle="modal" data-target="#omit" title="Tambah Bagian">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </a>
                        </div>
                        <div class="box-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no     = 1;
                                        $data1  = $this->enterprise_model->list_om_it($id_p);
                                        foreach($data1->result() as $dt1){
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $dt1->nama_lengkap; ?></td>
                                            <td>
                                                <a class="btn bg-red btn-flat" href="<?php echo base_url() ?>perusahaan/hapus_omit/<?php echo $dt1->id_om_it; ?>/<?php echo $id_p; ?>"  onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus <?php echo $dt1->nama_lengkap; ?>">
                                                    <i class="fa fa-trash"></i>
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
        </form>
    </div>
</div>
<!-- modal omit -->
<div class="modal fade" id="omit">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_setting_omit" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Om IT</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_perusahaan" value="<?php echo $id_p; ?>">
                    <select class="form-control select2" name="karyawan[]" multiple="multiple" style="width: 100%;" required="required">
                        <?php
                            $kar = $this->enterprise_model->list_karyawan_omit($id_p); 
                            foreach ($kar->result() as $k) {
                        ?>
                            <option value="<?php echo $k->id_karyawan; ?>"><?php echo $k->nama_lengkap; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>