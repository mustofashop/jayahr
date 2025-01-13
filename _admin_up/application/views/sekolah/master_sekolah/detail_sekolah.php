<script type="text/javascript">
function Edit(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_sekolah",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#ids').val(data.id_sekolah);
            $('#kode').val(data.kode_sekolah);
            $('#nama').val(data.nama_sekolah);
            $('#ip').val(data.ip_sekolah);
            $('#jenis').val(data.jenis_sekolah);
		}
	});
}
</script>
<div class="row">
    <div class="col-md-4">
         <div class="box">
            <div class="box-header">
                <h3 class="box-title">Logo</h3>
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
         <!-- end box -->
    </div>
    <div class="col-md-8">
    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Sekolah</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>ID Sekolah</td>
                                    <td>Kode Sekolah</td>
                                    <td>Nama Sekolah</td>
                                    <td>IP Sekolah</td>
                                    <td>Edit</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data->result() as $dt){ ?>
                                    <tr>
                                        <td><?php echo $dt->id_sekolah; ?></td>
                                        <td><?php echo $dt->kode_sekolah; ?></td>
                                        <td><?php echo $dt->nama_sekolah; ?></td>
                                        <td><?php echo $dt->ip_sekolah; ?></td>
                                        <td><a class="btn bg-olive btn-flat" href="#modals" onclick="javascript:Edit('<?php echo $dt->id_sekolah;?>')" data-toggle="modal" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-block btn-social bg-maroon" href="<?php echo base_url(); ?>sekolah/shift_hari/<?php echo $id_sekolah; ?>" title="Shift">
                            <i class="fa fa-plus"></i>
                            Tambah Shift & Hari
                            <div class="ripple-container"></div>
                        </a>
                        <a class="btn btn-block btn-social btn-bitbucket" href="<?php echo base_url(); ?>sekolah/kelas/<?php echo $id_sekolah; ?>" title="Kelas">
                            <i class="fa fa-plus"></i>
                            Kelas
                            <div class="ripple-container"></div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-block btn-social bg-green" href="#upload-murid" data-toggle="modal" title="Upload Murid">
                            <i class="fa fa-file-excel-o"></i>
                            Upload Murid
                            <div class="ripple-container"></div>
                        </a>
                        <a class="btn btn-block btn-social bg-green" href="#upload-guru" data-toggle="modal" title="Upload Guru">
                            <i class="fa fa-file-excel-o"></i>
                            Upload Guru
                            <div class="ripple-container"></div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-block btn-social bg-green" href="#upload-jam" data-toggle="modal" title="Upload Jam Sekolah">
                            <i class="fa fa-file-excel-o"></i>
                            Upload Jam <br> Sekolah
                            <div class="ripple-container"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php if($this->session->flashdata('msg_settings')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
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
                $yayasan    = $data_set->row()->id_yayasan;
                $wa         = $data_set->row()->use_wa;
                $selfie     = $data_set->row()->selfie_allowed;
                $sppd       = $data_set->row()->sppd_allowed;
                $selisih    = $data_set->row()->selisih_jam;
                $lap_detail = $data_set->row()->format_laporan_detail;
                $task       = $data_set->row()->task_keuangan;
                $beone      = $data_set->row()->beone;
                $format_21  = $data_set->row()->lap_21_format;
                $menu_blokir    = $data_set->row()->menu_blokir_siswa;
                $menu_refresh   = $data_set->row()->menu_refresh_absen;
            ?>
            <form action="<?php echo base_url(); ?>sekolah/save_settings" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Yayasan</label>
                                <input type="hidden" name="sekolah" id="sekolah" value="<?php echo $id_sekolah; ?>">
                                <select name="yayasan" id="yayasan" class="form-control">
                                    <option value="0">-- Pilih --</option>
                                    <?php foreach ($data_yys->result() as $dy) { ?>
                                        <option value="<?php echo $dy->id_user_sekolah; ?>" <?php if($dy->id_user_sekolah==$yayasan){echo "selected";}?> ><?php echo $dy->nama_lengkap; ?></option>
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
                        </div>
                        <div class="col-md-4">
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
                            <div class="form-group">
                                <label for="exampleInputEmail1">Selisih Jam</label>
                                <select name="selisih" id="selisih" class="form-control">
                                    <?php if($selisih == '4'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="4" selected="selected">4 Jam</option>
                                        <option value="5">5 Jam</option>
                                    <?php }elseif($selisih == '5'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="4">4 Jam</option>
                                        <option value="5" selected="selected">5 Jam</option>
                                    <?php }else{ ?>
                                        <option value="" selected="selected">-- Pilih --</option>
                                        <option value="4">4 Jam</option>
                                        <option value="5">5 Jam</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Format Laporan (Detail)</label>
                                <select name="laporan" id="laporan" class="form-control">
                                    <?php if($sppd == '1'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="0">Portrait</option>
                                        <option value="1" selected="selected">Landscape</option>
                                    <?php }elseif($sppd == '0'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="0" selected="selected">Portrait</option>
                                        <option value="1">Landscape</option>
                                    <?php }else{ ?>
                                        <option value="" selected="selected">-- Pilih --</option>
                                        <option value="0">Portrait</option>
                                        <option value="1">Landscape</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Task Keuangan (Upload)</label>
                                <select name="task" id="task" class="form-control">
                                    <?php if($task == '1'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" selected="selected">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php }elseif($task == '0'){ ?>
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
                                <label for="exampleInputEmail1">BeOne (Menu)</label>
                                <select name="beone" id="beone" class="form-control">
                                    <?php if($beone == '1'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" selected="selected">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php }elseif($beone == '0'){ ?>
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
                            <!-- format laporan 21-20 -->
                            <div class="form-group">
                                <label for="">Format Laporan Kehadiran Guru (Mobile) 21-20</label>
                                <select name="format_21" id="format_21" class="form-control">
                                    <?php if($format_21 == '0'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0" selected="selected">Tidak Aktif</option>
                                    <?php }elseif($format_21 == '1'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" selected="selected">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php }else{ ?>
                                        <option value="" selected="selected">-- Pilih --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- end col md 4 -->
                        <!-- menu pengaturan -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Menu Pengaturan <b>Suspend Siswa</b> Level = Admin, TU</label>
                                <select name="suspend_siswa" id="suspend_siswa" class="form-control">
                                    <?php if($menu_blokir == '0'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0" selected="selected">Tidak Aktif</option>
                                    <?php }elseif($menu_blokir == '1'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" selected="selected">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php }else{ ?>
                                        <option value="" selected="selected">-- Pilih --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Menu Pengaturan <b>Refresh Absen</b> Level = Admin, TU</label>
                                <select name="refresh_absen" id="refresh_absen" class="form-control">
                                    <?php if($menu_refresh == '0'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0" selected="selected">Tidak Aktif</option>
                                    <?php }elseif($menu_refresh == '1'){ ?>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" selected="selected">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php }else{ ?>
                                        <option value="" selected="selected">-- Pilih --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- end menu pengaturan -->
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn bg-blue btn-flat">Simpan</button>
                </div>
            </form>
         </div>
    </div>
</div>
<div class="modal fade" id="modals">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_sekolah" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Sekolah</label>
                        <input type="text" class="form-control" id="nama" name="nama" required="required">
                        <input type="hidden" name="id" id="ids">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Sekolah</label>
                        <select name="jenis" id="jenis" class="form-control" required="required">
                            <option value="">-- Pilih --</option>
                            <option value="0">TK</option>
                            <option value="1">SD</option>
                            <option value="2">SMP</option>
                            <option value="3">SMA</option>
                            <option value="4">SMK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IP Sekolah</label>
                        <input type="text" class="form-control" id="ip" name="ip" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Sekolah</label>
                        <input type="text" class="form-control" id="kode" name="kode">
                    </div>
                    <div>
                        <label for="image">Logo Sekolah</label>
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
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/upload_murid" enctype="multipart/form-data">
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
                                <input type="hidden" name="sekolah" value="<?php echo $id_sekolah; ?>">
                                <a class="btn btn-block btn-social bg-blue" href="<?php echo site_url('..\assets\excel\template-data-murid-terbaru.xls');?>" download class="btn btn-default">
                                <i class="fa fa-download"></i>Download</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="exampleInputEmail1">Upload File Excel Data Murid Baru</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" id="file_excel" name="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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
<!-- modal guru -->
<div class="modal fade" id="upload-guru">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/upload_guru" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Upload Guru</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Template Upload Guru</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="sekolah" value="<?php echo $id_sekolah; ?>">
                                <a class="btn btn-block btn-social bg-blue" href="<?php echo site_url('..\assets\excel\sample_upload_guru.xlsx');?>" download class="btn btn-default">
                                <i class="fa fa-download"></i>Download</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="exampleInputEmail1">Upload File Excel Data Guru Baru</label>
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
<!-- modal jam sekolah -->
<div class="modal fade" id="upload-jam">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/upload_jam_sekolah" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Upload Jam Sekolah</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Template Upload Jam Sekolah</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="s" value="<?php echo $id_sekolah; ?>">
                                <a class="btn btn-block btn-social bg-blue" href="<?php echo site_url('..\assets\excel\template_jam_sekolah.xlsx');?>" download class="btn btn-default">
                                <i class="fa fa-download"></i>Download</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="exampleInputEmail1">Upload File Excel Data Jam Sekolah Baru</label>
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