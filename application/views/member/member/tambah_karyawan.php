<script>
$(document).ready(function() {
    $('.tanggal').datepicker({
      autoclose: true
    })
    $("#imginp").change(function() {
    viewImg(this);
    });
    //pilih lokasi
    $('#lokasi').change(function () {
        var id_lokasi   = $("#lokasi").val();
        if(id_lokasi == ""){
            $("#bagian").empty();
        }else{
            $.ajax({
                url         : "<?php echo site_url(); ?>data_karyawan/list_bagian",
                type        : "POST",
                data        : "id="+id_lokasi,
                cahce       : false,
                dataType    : 'json',
                success     : function(response){
                    $("#bagian").empty();
                    $.each(response, function(value, key) {
                        $("#bagian").append('<option value='+key.id_bagian+'>'+key.nama_bagian+'</option>');
                    })
                }
            });
        }
    });
});
function viewImg(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            $("#foto").removeAttr("src");
            $("#foto").attr("src", e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }else{
        $("#foto").removeAttr("src");
        $("#foto").attr("src", '<?php echo base_url(); ?>assets/dist/img/default-avatar.png');
    }
}
</script>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <form role="form" method="POST" action="<?php echo base_url(); ?>data_karyawan/simpan_karyawan" enctype="multipart/form-data">
        <input type="hidden" name="id_karyawan">
        <input type="hidden" name="kategori" value="<?php echo $kategori; ?>">
        <div class="box-header">
            <a class="btn btn-app" href="<?php echo base_url(); ?>data_karyawan/list_karyawan?kategori=<?php echo $kategori; ?>&lokasi=<?php echo $lokasi; ?>">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>
            <button class="btn btn-app" type="submit">
                <i class="fa fa-floppy-o"></i>
                Simpan
            </button>
        </div>
        <div class="box-body">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="tab" href="#home">Profil</a></li>
                <li><a data-toggle="tab" href="#menu1">No. ID</a></li>
                <li><a data-toggle="tab" href="#menu2">Keluarga</a></li>
                <li><a data-toggle="tab" href="#menu3">Seragam</a></li>
                <li><a data-toggle="tab" href="#menu4">Bank</a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-body">
                                    <img id="foto" class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/dist/img/default-avatar.png" alt="Default profile picture">
                                    <div>
                                        <div class="col-md-10">
                                            <input type="file" name="image" id="imginp" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end foto -->
                        <div class="col-md-8">
                            <div class="box">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" name="nip" id="nip" class="form-control" placeholder="0" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="badgenumber">ID Mesin</label>
                                        <input type="number" name="badgenumber" id="badgenumber" class="form-control" min="0" required="required" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" id="nama" class="form-control" required="required" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasi">Lokasi</label>
                                        <select name="lokasi" id="lokasi" class="form-control select2" width="100%" required="required">
                                            <option value="">-- Pilih --</option>
                                            <?php
                                                $l  = $this->master_model->list_lokasi($this->session->userdata('id_perusahaan'));
                                                foreach($l->result() as $dt1){
                                            ?>
                                                <option value="<?php echo $dt1->id_lokasi; ?>"><?php echo $dt1->nama_lokasi; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="bagian">Unit Kerja / Bagian</label>
                                        <select name="bagian" id="bagian" class="form-control select2" width="100%" required="required">
                                        
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tempat_l">Tempat Lahir</label>
                                                <input type="text" name="tempat_lahir" id="tempat_l" class="form-control" placeholder="-">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal_l">Tanggal Lahir</label>
                                                <input type="text" class="form-control tanggal" name="tanggal_lahir" id="tanggal_l" data-date-format="dd-mm-yyyy" autocomplete="off" placeholder="0001-01-01">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jk">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" id="jk" class="form-control">
                                                    <option value="M">Laki - Laki</option>
                                                    <option value="F">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="sp">Status Pernikahan</label>
                                                <select name="status_nikah" id="sp" class="form-control">
                                                    <option value="Lajang">Lajang</option>
                                                    <option value="Menikah">Menikah</option>
                                                    <option value="Cerai">Cerai</option>
                                                    <option value="Janda/Duda">Janda / Duda (Pasangan Meninggal)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pendidikan">Pendidikan</label>
                                                <select name="pendidikan" id="pendidikan" class="form-control">
                                                    <option value="sd">SD</option>
                                                    <option value="smp">SMP</option>
                                                    <option value="sma">SMA / SMK / MA</option>
                                                    <option value="s1">S1</option>
                                                    <option value="s2">S2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="domisili">Domisili</label>
                                                <textarea name="domisili" id="domisili" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kodepos">Kode Pos</label>
                                                <input type="number" name="kode_pos" id="kodepos" class="form-control" min="1">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kelurahan">Kelurahan</label>
                                                <input type="text" name="kelurahan" id="kelurahan" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kecamatan">Kecamatan</label>
                                                <input type="text" name="kecamatan" id="kecamatan" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kota">Kota / Kabupaten</label>
                                                <input type="text" name="kota" id="kota" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="provinsi">Provinsi</label>
                                                <input type="text" name="provinsi" id="provinsi" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telepon">No. Telepon</label>
                                                <input type="number" name="telepon" id="telepon" class="form-control" required="required" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="wa">No. WA</label>
                                                <input type="number" name="wa" id="wa" class="form-control" required="required" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="darah">Gol. Darah</label>
                                                <input type="text" name="gol_darah" id="darah" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end profil -->
                <div id="menu1" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="npwp">NPWP</label>
                                        <input type="text" name="npwp" id="npwp" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="ktp">NIK E-KTP</label>
                                        <input type="text" name="ktp" id="ktp" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bpjsk">No. BPJS Kesehatan</label>
                                        <input type="text" name="bpjsk" id="bpjsk" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="bpjstk">No. BPJS TK</label>
                                        <input type="text" name="bpjstk" id="bpjstk" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end no id -->
                <div id="menu2" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="namaayah">Nama Ayah</label>
                                        <input type="text" name="nama_ayah" id="namaayah" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="namaibu">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" id="namaibu" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="namapasangan">Nama Pasangan</label>
                                        <input type="text" name="nama_pasangan" id="namapasangan" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anak1">Nama Anak 1</label>
                                        <input type="text" name="nama_anak1" id="anak1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anak2">Nama Anak 2</label>
                                        <input type="text" name="nama_anak2" id="anak2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anak3">Nama Anak 3</label>
                                        <input type="text" name="nama_anak3" id="anak3" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nokeluarga">No. HP Keluarga (yang bisa dihubungi)</label>
                                        <input type="text" name="no_keluarga" id="nokeluarga" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="alamat1">Alamat Ortu / Anak</label>
                                        <textarea name="alamat_anak" id="alamat1" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="alamat2">Alamat Pasangan</label>
                                        <textarea name="alamat_pasangan" id="alamat2" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Keluarga -->
                <div id="menu3" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ukuran1">Ukuran Baju</label>
                                        <input type="text" name="ukuran_baju" id="ukuran1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ukuran2">Ukuran Celana</label>
                                        <input type="text" name="ukuran_celana" id="ukuran2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ukuran3">Ukuran Sepatu</label>
                                        <input type="text" name="ukuran_sepatu" id="ukuran3" class="form-control">
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- end seragam -->
                <div id="menu4" class="tab-pane fade">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank">Nama Bank</label>
                                        <input type="text" name="nama_bank" id="bank" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rekening">No. Rekening</label>
                                        <input type="text" name="no_rekening" id="rekening" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end bank -->
            </div>
        </div>
    </form>
</div>