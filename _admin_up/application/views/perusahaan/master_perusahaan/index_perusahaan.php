<script type="text/javascript">
    function Edit(ID){
        var cari	= ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/perusahaan/edit_perusahaan",
            data	: "cari="+cari,
            dataType: "json",
            success	: function(data){
                $('#id_perusahaan').val(data.id_perusahaan);
                $('#nama_perusahaan').val(data.nama_perusahaan);
                $('#ip_perusahaan').val(data.ip_perusahaan);
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
                <h3 class="box-title">List Perusahan</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal">
                        <i class="fa fa-plus"></i> Tambah Perusahaan
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Perusahaan</td>
                            <td>IP</td>
                            <td>Logo</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no         = 1;
                            $perusahaan = $this->enterprise_model->get_perusahaan();
                            foreach($perusahaan->result() as $p){
                        ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $p->nama_perusahaan; ?></td>
                                    <td><?php echo $p->ip_perusahaan; ?></td>
                                    <?php
                                        if($p->flag_logo == '0'){
                                    ?>
                                            <td><img src="<?php echo base_url(); ?>assets/logo/enterprise.png" class="img-fluid" alt="Responsive image" style="max-width:159px;"></td>
                                    <?php
                                        }else{
                                    ?>
                                            <td><img src="<?php echo $p->file; ?>" class="img-fluid" alt="Responsive image" style="max-width:159px;"></td>
                                    <?php
                                        }
                                    ?>
                                    <td>
                                        <!-- edit -->
                                        <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $p->id_perusahaan;?>')" data-toggle="modal" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <!-- setting -->
                                        <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>perusahaan/setting/<?php echo $p->id_perusahaan; ?>" title="Setting">
                                            <i class="fa fa-cog"></i>
                                            Setting
                                        </a>
                                        <!-- lokasi -->
                                        <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/master_lokasi/<?php echo $p->id_perusahaan; ?>" title="Lokasi / Cabang">
                                            Lokasi
                                        </a>
                                        <!-- bagian -->
                                        <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/master_bagian/<?php echo $p->id_perusahaan; ?>" title="Bagian / Unit Kerja">
                                            Bagian / Unit Kerja
                                        </a>
                                        <!-- shift -->
                                        <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/master_shift/<?php echo $p->id_perusahaan; ?>" title="Shift">
                                            Shift / Non Shift
                                        </a>
                                        <!-- jabatan -->
                                        <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/master_jabatan/<?php echo $p->id_perusahaan; ?>" title="Jabatan">
                                            Jabatan
                                        </a>
                                        <!-- golongan -->
                                        <a class="btn bg-olive btn-flat" href="<?php echo base_url(); ?>perusahaan/master_golongan/<?php echo $p->id_perusahaan; ?>" title="Golongan">
                                            Golongan
                                        </a>
                                        <!-- sholat -->
                                        <a class="btn bg-green btn-flat" href="<?php echo base_url(); ?>perusahaan/master_sholat/<?php echo $p->id_perusahaan; ?>" title="Sholat">
                                            Sholat
                                        </a>
                                        <!-- delete -->
                                        <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>perusahaan/delete_perusahaan/<?php echo $p->id_perusahaan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/save_perusahaan" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama perusahaan</label>
                        <input type="text" class="form-control" id="nama_perusahaan" name="nama" required="required">
                        <input type="hidden" name="id" id="id_perusahaan">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IP perusahaan</label>
                        <input type="text" class="form-control" id="ip_perusahaan" name="ip" required="required">
                    </div>
                    <div>
                        <label for="image">Logo perusahaan</label>
                        <div class="col-md-12">
                            <input type="file" name="image">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>