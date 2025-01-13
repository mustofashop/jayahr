<script type="text/javascript">
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/bagian/edit_bagian",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_bagian').val(data.id_bagian);
            $('#nama_bagian').val(data.nama_bagian);
            $('#absen_o').val(data.flag_absen_online);
            $('#id_karyawan').val(data.id_karyawan);
        }
    });
}
</script>
<div class="row">
    <div class="col-md-12">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
            <?php if($aksi1 == '1'){ ?>
                <a class="btn btn-app" data-toggle="modal" data-target="#tambah" title="Tambah Bagian">
                    <i class="fa fa-plus"></i>
                    Tambah Data
                </a>
            <?php } ?>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Bagian / Unit Kerja</td>
                            <td style="width:100px;">Lokasi</td>
                            <td>Leader</td>
                            <td>Absen Online</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $id_p   = $this->session->userdata('id_perusahaan');
                            $no     = '1';
                            $data   = $this->master_model->list_bagian2($id_p);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_bagian; ?></td>
                                <td><?php echo $dt->lokasi; ?></td>
                                <td>
                                    <?php
                                        $lead   = $this->master_model->nama_leader1($dt->id_bagian);
                                        foreach($lead->result() as $ld){
                                            echo $ld->nama_lengkap;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php if($dt->absen_o == '0'){ ?>
                                        Tidak Aktif
                                    <?php }else{ ?>
                                        Aktif
                                    <?php } ?>
                                </td>
                                <td>
                                    <!-- edit -->
                                    <?php if($aksi3 == '3'){ ?>
                                        <a class="btn bg-olive btn-flat" href="#edit" onclick="javascript:Edit('<?php echo $dt->id_bagian;?>')" data-toggle="modal" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <!-- edit lokasi -->
                                        <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>bagian/edit_lokasi/<?php echo $dt->id_bagian; ?>" title="Edit Lokasi">
                                            Edit Lokasi
                                        </a>
                                    <?php } ?>
                                    <!-- bagian level 2 -->
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>bagian/bagian_2/<?php echo $dt->id_bagian; ?>" title="Bagian Level 2 | <?php echo $dt->nama_bagian; ?>">
                                        <i class="fa fa-plus"></i>
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
<!-- edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>bagian/simpan_edit_bagian">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Bagian</label>
                        <input type="text" name="nama_bagian" id="nama_bagian" class="form-control" required="required">
                        <input type="hidden" name="id_bagian" id="id_bagian">
                    </div>
                    <div class="form-group">
                        <label for="id_karyawan">Leader</label>
                        <select name="leader" id="id_karyawan" class="form-control select2" required="required" style="width: 100%;">
                            <?php
                                $leader = $this->master_model->list_leader($id_p);
                                foreach($leader->result() as $l){
                            ?>
                                <option value="<?php echo $l->id_karyawan; ?>"><?php echo $l->nama_lengkap; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Absen Online</label>
                        <select name="absen_o" id="absen_o" class="form-control">
                            <option value="0">Tidak Aktif</option>
                            <option value="1">Aktif</option>
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
<!-- add -->
<div class="modal fade" id="tambah">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>bagian/simpan_bagian" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Bagian / Unit Kerja</label>
                        <input type="text" name="bagian" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi (Bisa pilih beberapa)</label>
                        <select class="form-control select2" name="lokasi[]" multiple="multiple" id="lokasi" style="width: 100%;" required="required">
                            <?php
                                $lokasi = $this->master_model->list_lokasi($id_p); 
                                foreach ($lokasi->result() as $k) {
                            ?>
                                <option value="<?php echo $k->id_lokasi; ?>"><?php echo $k->nama_lokasi; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="leader">Leader</label>
                        <select name="leader" id="leader" class="form-control select2" required="required" style="width: 100%;">
                            <?php
                                $leader = $this->master_model->list_leader($id_p);
                                foreach($leader->result() as $l){
                            ?>
                                <option value="<?php echo $l->id_karyawan; ?>"><?php echo $l->nama_lengkap; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Absen Online</label>
                        <select name="absen_o" class="form-control">
                            <option value="0">Tidak Aktif</option>
                            <option value="1">Aktif</option>
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