<div class="row">
    <div class="col-md-6">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <a class="btn btn-app" href="<?php echo base_url(); ?>bagian">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                    <i class="fa fa-plus"></i> Tambah Lokasi
                </a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Lokasi</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = '1';
                            $data   = $this->master_model->list_lokasi_bagian($id_bagian);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_lokasi; ?></td>
                                <td>
                                    <!-- delete -->
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>bagian/delete_lokasi/<?php echo $dt->id_bagian_detail; ?>" onClick="return confirm('Anda yakin ingin menghapus <?php echo $dt->nama_lokasi; ?>?')" title="Hapus">
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
<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>bagian/simpan_lokasi" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="lokasi">Lokasi (Bisa pilih beberapa)</label>
                        <input type="hidden" name="id_bagian" value="<?php echo $id_bagian; ?>">
                        <select class="form-control select2" name="lokasi[]" multiple="multiple" id="lokasi" style="width: 100%;" required="required">
                            <?php
                                $id_p   = $this->session->userdata('id_perusahaan');
                                $lokasi = $this->master_model->list_lokasi($id_p); 
                                foreach ($lokasi->result() as $k) {
                            ?>
                                <option value="<?php echo $k->id_lokasi; ?>"><?php echo $k->nama_lokasi; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>