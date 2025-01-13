<script type="text/javascript">
function Edit(ID){
    var cari	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/bagian/edit_bagian_3",
        data	: "cari="+cari,
        dataType: "json",
        success	: function(data){
            $('#id_bagian_3').val(data.id_bagian_3);
            $('#nama').val(data.nama_bagian);
            $('#absen').val(data.flag_absen_online);
            $('#leader').val(data.id_karyawan);
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
                <a class="btn btn-app" href="<?php echo base_url(); ?>bagian/bagian_2/<?php echo $id_bagian ?>">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
                <?php if($aksi1 == '1'){ ?>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                    <i class="fa fa-plus"></i>
                    Tambah
                </a>
                <?php } ?>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bagian Level 3</th>
                            <th>Leader</th>
                            <th>Absen Online</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data   = $this->master_model->list_bagian_lvl_3($id_bagian2);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_bagian_3; ?></td>
                                <td>
                                    <?php
                                        $lead   = $this->master_model->nama_leader3($dt->id_bagian_3);
                                        foreach($lead->result() as $ld){
                                            echo $ld->nama_lengkap;
                                        }
                                    ?>
                                </td>
                                <td><?php echo $dt->absen_online; ?></td>
                                <td>
                                    <!-- edit -->
                                    <?php if($aksi3 == '3'){ ?>
                                        <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id_bagian_3;?>')" data-toggle="modal" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    <?php } ?>
                                    <!-- bagian level 4 -->
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>bagian/bagian_4/<?php echo $dt->id_bagian_3 ?>/<?php echo $id_bagian2; ?>/<?php echo $id_bagian; ?>" title="Bagian Level 4 <?php echo $dt->nama_bagian_3; ?>">
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
<!-- modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>bagian/simpan_bagian3" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Bagian 3</label>
                        <input type="text" class="form-control" name="nama" id="nama" required="required" autocomplete="off">
                        <input type="hidden" name="id_bagian_3" id="id_bagian_3">
                        <input type="hidden" name="id_bagian_2" value="<?php echo $id_bagian2; ?>">
                    </div>
                    <div class="form-group">
                        <label for="leader">Leader</label>
                        <select name="leader" id="leader" class="form-control select2" required="required" style="width: 100%;">
                            <?php
                                $id_p   = $this->session->userdata('id_perusahaan');
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
                        <select name="absen" id="absen" class="form-control">
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
<!-- end modal -->