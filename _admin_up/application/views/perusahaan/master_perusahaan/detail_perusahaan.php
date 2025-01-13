<script type="text/javascript">
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/perusahaan/edit_perusahaan",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#ids').val(data.id_perusahaan);
            $('#nama').val(data.nama_perusahaan);
            $('#ip').val(data.ip_perusahaan);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-4">
         <div class="box">
            <div class="box-header">
                <h3 class="box-title">Logos</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                    
                    </div>
                    <div class="col-md-4">
                        <?php foreach ($data->result() as $dtl) { ?>
                            <?php if($dtl->logo == "" || empty($dtl->logo) || $dtl->logo == NULL){ ?>
                                <img class="editable" src="<?php echo base_url(); ?>assets/img/default-logo.png" alt="default" width="100" height="100">
                            <?php }else{ ?>
                                <img class="editable" src="data:image/jpeg;base64,<?php echo $dtl->logo;?>" alt="logo" width="100" height="100">
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-4">
                    
                    </div>
                </div>
            </div>
         </div>
         <!-- settings -->
         <?php if($this->session->flashdata('msg_settings')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_settings'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Settings</h3>
            </div>
            <?php 
                $yayasan    = $data_set->row()->id_sekolah;
                $wa         = $data_set->row()->use_wa;
                $selfie     = $data_set->row()->selfie_allowed;
                $sppd       = $data_set->row()->sppd_allowed;
                // $selisih    = $data_set->row()->selisih_jam;
                // $lap_detail = $data_set->row()->format_laporan_detail;
            ?>
            <form action="<?php echo base_url(); ?>perusahaan/save_settings" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sekolah (App Manager) *opsional</label>
                        <input type="hidden" name="perusahaan" id="perusahaan" value="<?php echo $id_perusahaan; ?>">
                        <select name="sekolah" id="sekolah" class="form-control">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($data_sklh->result() as $dy) { ?>
                                <option value="<?php echo $dy->id_sekolah; ?>" <?php if($dy->id_sekolah==$id_sklh){echo "selected";}?> ><?php echo $dy->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kirim WhatsApp</label>
                        <select name="wa" id="wa" class="form-control">
                            <?php if($wa == '1'){ ?>
                                <option value="">-- Pilih --</option>
                                <option value="1" selected="selected">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            <?php }elseif($wa == '0'){ ?>
                                <option value="">-- Pilih --</option>
                                <option value="1">Aktif</option>
                                <option value="0" selected="selected">Tidak Aktif</option>
                            <?php }else{ ?>
                                <option value="" selected="selected">-- Pilih --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Absen Selfie</label>
                        <select name="selfie" id="selfie" class="form-control">
                            <?php if($selfie == '1'){ ?>
                                <option value="">-- Pilih --</option>
                                <option value="1" selected="selected">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            <?php }elseif($selfie == '0'){ ?>
                                <option value="">-- Pilih --</option>
                                <option value="1">Aktif</option>
                                <option value="0" selected="selected">Tidak Aktif</option>
                            <?php }else{ ?>
                                <option value="" selected="selected">-- Pilih --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Absen SPPD</label>
                        <select name="sppd" id="sppd" class="form-control">
                            <?php if($sppd == '1'){ ?>
                                <option value="">-- Pilih --</option>
                                <option value="1" selected="selected">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            <?php }elseif($sppd == '0'){ ?>
                                <option value="">-- Pilih --</option>
                                <option value="1">Aktif</option>
                                <option value="0" selected="selected">Tidak Aktif</option>
                            <?php }else{ ?>
                                <option value="" selected="selected">-- Pilih --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn bg-blue btn-flat">Simpan</button>
                </div>
            </form>
         </div>
    </div>
    <div class="col-md-8">
    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Perusahaan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>ID Perusahaan</td>
                                    <td>Nama Perusahaan</td>
                                    <td>IP Perusahaan</td>
                                    <td>Nama Sekolah</td>
                                    <td>Edit</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data->result() as $dt){ ?>
                                    <tr>
                                        <td><?php echo $dt->id_perusahaan; ?></td>
                                        <td><?php echo $dt->nama_perusahaan; ?></td>
                                        <td><?php echo $dt->ip_perusahaan; ?></td>
                                        <td><?php echo $sekolah; ?></td>
                                        <td><a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->id_perusahaan;?>')" data-toggle="modal" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-block btn-social bg-green" href="#upload-murid" data-toggle="modal" title="Edit">
                            <i class="fa fa-file-excel-o"></i>
                            Upload Karyawan
                            <div class="ripple-container"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modals">
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
                        <input type="text" class="form-control" id="nama" name="nama" required="required">
                        <input type="hidden" name="id" id="ids">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IP perusahaan</label>
                        <input type="text" class="form-control" id="ip" name="ip" required="required">
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
<!-- /.modal -->
<!-- modal murid -->
<div class="modal fade" id="upload-murid">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>perusahaan/upload_murid" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Upload Murid</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Template Upload Murid</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="perusahaan" value="<?php echo $id_perusahaan; ?>">
                                <a class="btn btn-block btn-social bg-blue" href="<?php echo site_url('..\assets\excel\template-data-murid-terbaru.xls');?>" download class="btn btn-default">
                                <i class="fa fa-download"></i>Download</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="exampleInputEmail1">Upload File Excel Data Murid Baru</label>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo form_upload('file_excel');?>
                            </div>
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
<!-- /.modal -->