<script type="text/javascript">
    $(document).ready(function(){
        $('#sekolah').change(function(){ 
            var id=$(this).val();
            $.ajax({
                url : "<?php echo site_url('beone/get_guru_bp');?>",
                method : "POST",
                data : {id: id},
                async : true,
                dataType : 'json',
                success: function(data){
                        
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id_user_sekolah+'>'+data[i].nama_lengkap+'</option>';
                    }
                    $('#guru').html(html);

                }
            });
            return false;
        });
    });
</script>
<?php if($this->session->flashdata('msg_input')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_input'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" id="tambah" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Guru</a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Sekolah</td>
                    <td>Nama Guru</td>
                    <td>No Telepon</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = '1';
                    foreach($data->result() as $dt){ ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dt->nama_sekolah; ?></td>
                            <td><?php echo $dt->nama_lengkap; ?></td>
                            <td><?php echo $dt->no_telepon; ?></td>
                            <td>
                                <!-- edit -->
                                <a class="btn bg-yellow btn-flat" href="<?php echo base_url(); ?>beone/delete_flag_bp/<?php echo $dt->id_user_sekolah; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>beone/simpan_guru_bp" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Sekolah</label>
                        <select name="sekolah" id="sekolah" class="form-control select2" style="width:100%;" required="required">
                            <option value="">-- Pilih Sekolah --</option>
                            <?php foreach($sekolah->result() as $sk){ ?>
                                <option value="<?php echo $sk->id_sekolah; ?>"><?php echo $sk->nama_sekolah; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Guru</label>
                        <select name="guru[]" id="guru" class="form-control select2" multiple="multiple" style="width:100%;" required="required">
            
                        </select>
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