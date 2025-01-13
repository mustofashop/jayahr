<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" id="add" data-toggle="modal" data-target="#modal-default">
            <i class="fa fa-plus"></i> 
            Tambah Data
        </a>
        <a class="btn btn-app" href="<?php echo base_url(); ?>chat_api/pelanggan">
            <i class="fa fa-users"></i>
            Pelanggan
        </a>
        <a class="btn btn-app" href="<?php echo base_url(); ?>chat_api/transaksi">
            <i class="fa fa-pencil-square-o"></i>
            Transaksi
        </a>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Akun</th>
                    <th>URL</th>
                    <th>Token</th>
                    <th>No WA</th>
                    <th>Expired</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    $data   = $this->chat_api_model->list_akun();
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->kode_akun; ?></td>
                        <td><?php echo $dt->url_chat; ?></td>
                        <td><?php echo $dt->token; ?></td>
                        <td><?php echo $dt->no_wa; ?></td>
                        <?php 
                        if(date("d-m-Y") > $dt->expired){
                            $warna = 'green';
                        }else{
                            $warna = 'red';
                        } 
                        ?>
                        <td style="color:<?php echo $warna; ?>"><?php echo $dt->expired ?></td>
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#modal-default" onclick="javascript:Edit('<?php echo $dt->id;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- delete -->
                            <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>chat_api/hapus/<?php echo $dt->id; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
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
<script type="text/javascript">
function Edit(ID){
    var id	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo base_url(); ?>chat_api/edit",
        data	: "id="+id,
        dataType: "json",
        success	: function(data){
            $('#id').val(data.id);
            $('#kode').val(data.kode);
            $('#url').val(data.url);
            $('#token').val(data.token);
            $('#no_wa').val(data.no_wa);
        }
    });
}
</script>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>chat_api/simpan">
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
                                <label for="">Kode Akun</label>
                                <input type="text" class="form-control" name="kode" id="kode" required="required" autocomplete="off">
                                <input type="hidden" name="id" id="id">
                            </div>
                            <div class="form-group">
                                <label for="">URL</label>
                                <input type="url" class="form-control" name="url" id="url" required="required" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Token</label>
                                <input type="text" class="form-control" name="token" id="token" required="required" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">No WA</label>
                                <input type="number" min="0" class="form-control" name="no_wa" id="no_wa" required="required" autocomplete="off">
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