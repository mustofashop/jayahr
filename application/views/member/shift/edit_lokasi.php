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
                <a class="btn btn-app" href="<?php echo base_url(); ?>shift">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                    <i class="fa fa-plus"></i> Tambah Lokasi
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Lokasi</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no         = '1';
                            $list_lokasi= $this->master_model->list_lokasi_shift($id_shift);
                            foreach($list_lokasi->result() as $ll){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $ll->nama_lokasi; ?></td>
                                <td>
                                    <!-- delete -->
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>shift/delete_lokasi/<?php echo $ll->id_shift; ?>/<?php echo $ll->id_lokasi; ?>" onClick="return confirm('Anda yakin ingin menghapus <?php echo $ll->nama_lokasi; ?>?')" title="Hapus <?php echo $ll->nama_lokasi; ?>">
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>shift/simpan_lokasi" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <input type="hidden" name="id_shift" value="<?php echo $id_shift; ?>">
                        <select class="form-control select2" multiple="multiple" name="lokasi[]" style="width: 100%;" id="lokasi" required="required">
                            <?php
                                $id_p               = $this->session->userdata('id_perusahaan');
                                $list_shift_lokasi  = $this->master_model->list_lokasi_shift_check($id_shift,$id_p);
                                foreach($list_shift_lokasi->result() as $lsl){
                            ?>
                                    <option value="<?php echo $lsl->id_lokasi; ?>"><?php echo $lsl->nama_lokasi; ?></option>
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