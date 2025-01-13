<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>chat_api">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <a class="btn btn-app" id="add" data-toggle="modal" data-target="#modal">
            <i class="fa fa-plus"></i> 
            Tambah Data
        </a>
    </div>
    <div class="box-body">
        <!-- custom tab -->
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="tab" href="#home">Aktif</a></li>
            <li><a data-toggle="tab" href="#menu1">Tidak Aktif / Expired</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Kode</th>
                            <th>Token</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Expired</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no     = 1;
                            $status = 0;
                            $data   = $this->chat_api_model->list_transaksi($status);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama; ?></td>
                                <td><?php echo $dt->kode_pelanggan; ?></td>
                                <td><?php echo $dt->token_pelanggan; ?></td>
                                <td><?php echo $dt->mulai; ?></td>
                                <td><?php echo $dt->selesai; ?></td>
                                <td><?php echo $dt->expired; ?></td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn bg-olive btn-flat" href="#modal" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- delete -->
                                    <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>chat_api/tidak_aktif_transaksi/<?php echo $dt->id; ?>" onClick="return confirm('Anda yakin ingin non aktif data ini?')" title="Hapus">
                                        <i class="fa fa-times"></i>
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
            <div id="menu1" class="tab-pane fade">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Kode</th>
                            <th>Token</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no     = 1;
                            $status = 1;
                            $data   = $this->chat_api_model->list_transaksi($status);
                            foreach($data->result() as $dt){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama; ?></td>
                                <td><?php echo $dt->kode_pelanggan; ?></td>
                                <td><?php echo $dt->token_pelanggan; ?></td>
                                <td><?php echo $dt->mulai; ?></td>
                                <td><?php echo $dt->selesai; ?></td>
                                <td><?php echo $dt->expired; ?></td>
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
<script type="text/javascript">
$(document).ready(function(){
    $('#tanggal').daterangepicker({ 
        locale: {
            format: 'YYYY-MM-DD'
        } 
    });
    $(".date-picker").datepicker( {
		format: "yyyy-mm-dd",
        autoclose: true
    });
});
function Edit(ID){
    var id	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo base_url(); ?>chat_api/edit_transaksi",
        data	: "id="+id,
        dataType: "json",
        success	: function(data){
            $('#id').val(data.id);
            $('#pelanggan').val(data.id_pelanggan);
            $('#kode').val(data.kode);
            $('#tanggal').val(data.tanggal);
            $('#expired').val(data.expired);
        }
    });
}
</script>
<!-- modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>chat_api/simpan_transaksi">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id">
                                <label for="">Pelanggan</label>
                                <select name="pelanggan" id="pelanggan" class="form-control select2" style="width:100%;" required="required">
                                    <option value="">-- Pilih --</option>
                                    <?php 
                                        $pelanggan = $this->chat_api_model->list_pelanggan2();
                                        foreach($pelanggan->result() as $pel){
                                    ?>
                                        <option value="<?php echo $pel->id ?>"><?php echo $pel->nama; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kode</label>
                                <select name="kode" id="kode" class="form-control" required="required">
                                    <option value="">-- Pilih --</option>
                                    <?php
                                        $kode   = $this->chat_api_model->list_akun2();
                                        foreach($kode->result() as $kd){
                                    ?>
                                        <option value="<?php echo $kd->kode_akun; ?>"><?php echo $kd->kode_akun; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal Mulai - Selesai</label>
                                <input type="text" name="tanggal" id="tanggal" class="form-control pull-right"  required="required" autocomplete="off" placeholder="Tahun-Bulan-Hari"/>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Expired</label>
                                <input type="text" name="expired" id="expired" class="form-control date-picker"  data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="Tahun-Bulan-Hari">
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