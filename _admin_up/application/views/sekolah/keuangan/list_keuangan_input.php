<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
    
    </div>
    <div class="box-body">
        <table id="isi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Murid</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no     = 1;
                    foreach ($data->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $dt->name; ?></td>
                    <td><?php echo $dt->tgl_bayar; ?></td>
                    <td><?php echo "Rp " . number_format($dt->nilai_trans,2,',','.');?></td>
                    <td>
                        <a class="btn bg-olive btn-flat" href="#modal-default" onclick="javascript:editIuran('<?php echo $dt->id_trans_keuangan;?>')" data-toggle="modal" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>sekolah/delete_transaksi/<?php echo $dt->id_trans_keuangan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $(".date-picker").datepicker( {
            format: "yyyy-mm-dd"
        });
    });
    function editIuran(ID){
        var cari	= ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/sekolah/edit_transaksi_input",
            data	: "cari="+cari,
            dataType: "json",
            success	: function(data){
                $('#id_trans_keuangan').val(data.id_trans_keuangan);
                $('#nilai_trans').val(data.nilai_trans);
                $('#tgl_bayar').val(data.tgl_bayar);
                $('#name').val(data.name);
                $('#nama_iuran').val(data.nama_iuran);
            }
        });
    }
</script>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>sekolah/save_edit_transaksi">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Transaksi</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="id_trans_keuangan" id="id_trans_keuangan">
                            <div class="form-group">
                                <label for="nama">Nama Murid</label>
                                <input type="text" name="name" id="name" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Iuran</label>
                                <input type="text" name="nama_iuran" id="nama_iuran" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Jumlah Bayar</label>
                                <input type="text" name="nilai_trans" id="nilai_trans" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nama">Tanggal Bayar</label>
                                <input type="text" name="tgl_bayar" id="tgl_bayar" class="form-control date-picker"  data-date-format="yyyy-mm-dd" required="required" autocomplete="off"/>
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