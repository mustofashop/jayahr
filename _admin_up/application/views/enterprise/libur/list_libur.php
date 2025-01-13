<div class="row">
    <div class="col-md-6">
        <script type="text/javascript">
            function Edit2(ID){
                var id_libur= ID;	
                $.ajax({
                    type	: "POST",
                    url		: "<?php echo site_url(); ?>Enterprise/libur/edit_libur_perusahaan",
                    data	: "id_libur="+id_libur,
                    dataType: "json",
                    success	: function(data){
                        $('#id_libur_perusahaan').val(data.id_libur_perusahaan);
                        $('#keterangan_perusahaan').val(data.keterangan);
                        $('#tanggal_perusahaan').val(data.tanggal);
                    }
                });
            }
        </script>
        <div class="box">
            <?php if($this->session->flashdata('msg2')): ?>
                <div class="alert alert-success alert-dismissible" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg2'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('msg_delete2')): ?>
                <div class="alert alert-danger alert-dismissible" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg_delete2'); ?>
                </div>
            <?php endif; ?>
            <div class="box-header">
                <h3 class="box-title">Perusahaan</h3>
                <br>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-tambah-perusahaan"><i class="fa fa-plus"></i>Tambah Data</a>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-upload-perusahaan"><i class="fa fa-file-excel-o"></i>Import / Export</a>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = '1';
                            $data   = $this->enterprise_model->list_libur_perusahaan($id_p);
                            foreach ($data->result() as $lbs) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $lbs->keterangan; ?></td>
                                <td><?php echo $lbs->tanggal; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal-edit-2" onclick="javascript:Edit2('<?php echo $lbs->id_libur_perusahaan;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- delete -->
                                    <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>Enterprise/libur/delete_libur_perusahaan/<?php echo $lbs->id_libur_perusahaan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
    <div class="col-md-6">
        <script type="text/javascript">
            function Edit1(ID){
                var id_libur= ID;	
                $.ajax({
                    type	: "POST",
                    url		: "<?php echo site_url(); ?>/master/edit_libur_nasional",
                    data	: "id_libur="+id_libur,
                    dataType: "json",
                    success	: function(data){
                        $('#id_libur_nasional').val(data.id_libur_nasional);
                        $('#keterangan').val(data.keterangan);
                        $('#tanggal').val(data.tanggal);
                    }
                });
            }
        </script>
        <div class="box">
            <?php if($this->session->flashdata('msg1')): ?>
                <div class="alert alert-success alert-dismissible" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg1'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('msg_delete1')): ?>
                <div class="alert alert-danger alert-dismissible" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg_delete1'); ?>
                </div>
            <?php endif; ?>
            <div class="box-header">
                <h3 class="box-title">Nasional</h3>
                <br>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i>Tambah Data</a>
                <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-upload"><i class="fa fa-file-excel-o"></i>Import / Export</a>
            </div>
            <div class="box-body">
                <table id="isi" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = '1';
                            $data   = $this->master_model->list_libur_nasional();
                            foreach ($data->result() as $lbn) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $lbn->keterangan; ?></td>
                                <td><?php echo $lbn->tanggal; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal-edit-1" onclick="javascript:Edit1('<?php echo $lbn->id_libur_nasional;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- delete -->
                                    <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>master/delete_libur_nasional/<?php echo $lbn->id_libur_nasional; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<!-- libur perusahaan -->
<div class="modal fade" id="modal-tambah-perusahaan">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>Enterprise/libur/simpan_libur_perusahaan">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Libur perusahaan | Tambah</h4>
                </div>
                <div class="modal-body pre-scrollable">
                    <div class="row clearfix after-add-more">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan Libur" required="required"/>
                                <input type="hidden" name="perusahaan" value="<?php echo $id_p; ?>">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" class="form-control date-picker1" name="tanggal[]" placeholder="Tanggal" required="required" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button class="add_field_button btn bg-blue btn-flat" type="button">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="copy hide">
                        <div class="control-group row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan Libur"/>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control date-picker2" name="tanggal[]" placeholder="Tanggal" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button class="remove_field_button btn bg-red btn-flat" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
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
<div class="modal fade" id="modal-edit-2">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>Enterprise/libur/simpan_edit_libur_perusahaan">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Libur perusahaan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keterangan">Keterangan Libur</label>
                                <input type="hidden" name="id_libur_perusahaan" id="id_libur_perusahaan">
                                <input type="text" class="form-control" name="keterangan" id="keterangan_perusahaan" placeholder="Keterangan Libur" required="required"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" class="form-control date-picker-edit1" name="tanggal" id="tanggal_perusahaan" placeholder="Tanggal" required="required" autocomplete="off">
                            </div>
                        </div>
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
<div class="modal fade" id="modal-upload-perusahaan">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php echo $header; ?> | Libur perusahaan</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 for="">Import</h4>
                        <form role="form" method="POST" action="<?php echo base_url() ?>Enterprise/libur/import_libur_perusahaan" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <label for="exampleInputEmail1">Upload File Excel Libur perusahaan</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="perusahaan" value="<?php echo $id_p; ?>">
                                                <?php echo form_upload('file_excel');?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn bg-olive btn-flat">
                                            <i class="icon fa fa-upload"></i>
                                            Upload
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h4 for="">Export</h4>
                        <form role="form" method="GET" action="<?php echo base_url() ?>Enterprise/libur/export_libur_perusahaan">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <input type="hidden" name="perusahaan" value="<?php echo $id_p; ?>">
                                        <select name="tahun" id="tahun" class="form-control" required="required">
                                            <option value="">-- Pilih Tahun --</option>
                                            <?php 
                                                $tahun  = $this->master_model->list_tahun_libur_sekolah();
                                                foreach ($tahun->result() as $thn) { 
                                            ?>
                                                <option value="<?php echo $thn->tahun; ?>"><?php echo $thn->tahun; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn bg-olive btn-flat">Export</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- libur nasional -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/simpan_libur_nasional">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Libur Nasional</h4>
                </div>
                <div class="modal-body pre-scrollable">
                    <div class="row clearfix after-add-more">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan Libur" required="required"/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" class="form-control date-picker1" name="tanggal[]" placeholder="Tanggal" required="required" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button class="add_field_button btn bg-blue btn-flat" type="button">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="copy hide">
                        <div class="control-group row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan Libur"/>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control date-picker2" name="tanggal[]" placeholder="Tanggal" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button class="remove_field_button btn bg-red btn-flat" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
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
<script type="text/javascript">
    $(function() {
        $(".date-picker1").datepicker( {
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $(".date-picker-edit1").datepicker( {
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });
    $(document).ready(function() {
        $(".add_field_button").click(function(){ 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
            $(".date-picker2").datepicker( {
                format: "yyyy-mm-dd",
                autoclose: true
            });
        });
        $("body").on("click",".remove_field_button",function(){ 
            $(this).parents(".control-group").remove();
        });
    });
</script>
<div class="modal fade" id="modal-edit-1">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>master/simpan_edit_libur_nasional">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Libur Nasional</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keterangan">Keterangan Libur</label>
                                <input type="hidden" name="id_libur_nasional" id="id_libur_nasional">
                                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan Libur" required="required"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" class="form-control date-picker-edit1" name="tanggal" id="tanggal" placeholder="Tanggal" required="required" autocomplete="off">
                            </div>
                        </div>
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
<div class="modal fade" id="modal-upload">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php echo $header; ?> | Libur Nasional</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 for="">Import</h4>
                        <form role="form" method="POST" action="<?php echo base_url() ?>master/import_libur_nasional" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <label for="exampleInputEmail1">Upload File Excel Libur Nasional</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php echo form_upload('file_excel');?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn bg-olive btn-flat">
                                            <i class="icon fa fa-upload"></i>
                                            Upload
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h4 for="">Export</h4>
                        <form role="form" method="GET" action="<?php echo base_url() ?>master/export_libur_nasional">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control" required="required">
                                            <option value="">-- Pilih Tahun --</option>
                                            <?php 
                                                $tahun  = $this->master_model->list_tahun_libur_nasional();
                                                foreach ($tahun->result() as $thn) { 
                                            ?>
                                                <option value="<?php echo $thn->tahun; ?>"><?php echo $thn->tahun; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn bg-olive btn-flat">Export</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>