<script type="text/javascript">
$(function() {
    $(".date-picker").datepicker( {
        format: "yyyy-mm",
        viewMode: "months", 
        minViewMode: "months"
    });
});
$(document).ready(function(){
    $("#add").click(function(){
		$('#id_iuran').val('');
        $('#jenis').val('');
        $('#nama_iuran').val('');
        $('#jumlah_iuran').val('');
    });
    $('#sekolah_input').change(function(){ 
        get_nama_iuran();
    });
    //nama iuran 
    function get_nama_iuran(){
        var sekolah     =   $("#sekolah_input").val();
        $.ajax({
            url         : "<?php echo site_url(); ?>sekolah/get_nama_iuran",
            type        : "POST",
            data        : "sekolah="+sekolah,
            cahce       : false,
            dataType    : 'json',
            success     : function(data){
                var html = '';
                var i;
                for(i = 0; i < data.length; i++){
                    html += '<option value='+data[i].id_iuran+'>'+data[i].nama_iuran+'</option>';
                }
                $('#iuran').html(html);
            }
        });
    }
});
function editIuran(ID){
	var cari	= ID;	
	$.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>/sekolah/edit_iuran",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
            $('#id_iuran').val(data.id_iuran);
            $('#sekolah').val(data.id_sekolah);
            $('#jenis').val(data.jenis);
            $('#nama_iuran').val(data.nama_iuran);
            $('#jumlah_iuran').val(data.jumlah);
		}
	});
}
</script>
<div class="row">
    <!-- list iuran -->
    <div class="col-md-7">
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3>List Iuran</h3>
                <a class="btn btn-app" id="add" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
            <div class="box-body">
                <table id="isi" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sekolah</th>
                            <th>Nama Iuran</th>
                            <th>Jumlah</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            $no     = 1;
                            foreach ($list_iuran->result() as $dt) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $dt->nama_sekolah; ?></td>
                            <td><?php echo $dt->nama_iuran; ?></td>
                            <td><?php echo $dt->jumlah; ?></td>
                            <td><?php echo $dt->jenis; ?></td>
                            <td>
                                <a class="btn bg-olive btn-flat" href="#modal-default" onclick="javascript:editIuran('<?php echo $dt->id_iuran;?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_iuran/<?php echo $dt->id_iuran; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- proses keuangan -->
    <div class="col-md-5">
        <?php if($this->session->flashdata('msg_error')): ?>
            <div class="alert alert-danger alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg_error'); ?>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-header">
                <h3>Transaksi Keuangan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-app" data-toggle="modal" data-target="#modal-input"><i class="fa fa-pencil"></i> Transaksi Input</a>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-app" data-toggle="modal" data-target="#modal-upload"><i class="fa fa-file-excel-o"></i> Transaksi Upload</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_iuran">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">List iuran</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="id_iuran" name="id_iuran">
                        <label for="exampleInputEmail1">Sekolah</label>
                        <select class="form-control" name="sekolah" id="sekolah" required="required">
                            <option value="#">-- Pilih Sekolah --</option>
                            <?php 
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Iuran</label>
                        <select name="jenis" id="jenis" class="form-control" required="required">
                            <option value="">-- Pilih --</option>
                            <option value="1">SPP</option>
                            <option value="2">Lain - Lain</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Iuran</label>
                        <input type="text" class="form-control" name="nama_iuran" id="nama_iuran" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah Iuran</label>
                        <input type="text" class="form-control" name="jumlah_iuran" id="jumlah_iuran" required="required">
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
<script type="text/javascript">		
    var rupiah = document.getElementById('jumlah_iuran');
    rupiah.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value);
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
<!-- transaksi input -->
<div class="modal fade" id="modal-input">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="GET" action="<?php echo base_url(); ?>sekolah/get_transaksi_iuran_input">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Transaksi Input</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sekolah</label>
                        <select class="form-control select2" name="sekolah_input" id="sekolah_input" style="width: 100%;" required="required">
                            <option value="#">-- Pilih Sekolah --</option>
                            <?php 
                                foreach ($data->result() as $dt) {
                                ?>
                                    <option value="<?php echo $dt->id_sekolah; ?>"><?php echo $dt->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="guru">Nama Iuran</label>
                        <select name="iuran" id="iuran" class="form-control select2" style="width: 100%;">
                        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bulan</label>
                        <input type="text" name="bulan" id="bulan" class="form-control date-picker"  data-date-format="yyyy-mm" required="required" autocomplete="off" placeholder="Tahun-Bulan"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->