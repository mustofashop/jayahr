<div class="row">
    <div class="col-md-6">
        <div class="box">
            <?php if($this->session->flashdata('msg')): ?>
                <div class="alert alert-success alert-dismissible" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('msg_error')): ?>
                <div class="alert alert-danger alert-dismissible" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg_error'); ?>
                </div>
            <?php endif; ?>
            <div class="box-header">
                <h4 class="box-title">Libur Perusahaan</h4>
                <br>
                <?php if($aksi1 == '1'){ ?>
                    <a class="btn btn-app" data-toggle="modal" data-target="#tambah" title="Tambah Jabatan">
                        <i class="fa fa-plus"></i>
                        Tambah Data
                    </a>
                <?php } ?>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
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
                            $no     = 1;
                            $id_p   = $this->session->userdata('id_perusahaan');
                            $data1  = $this->master_model->list_libur_perusahaan($id_p);
                            foreach($data1->result() as $dt1){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt1->keterangan; ?></td>
                                <td><?php echo $dt1->tanggal; ?></td>
                                <td>
                                    <!-- edit -->
                                    <?php if($aksi3 == '3'){ ?>
                                        <a class="btn bg-olive btn-flat" data-target="#edit" onclick="javascript:Edit('<?php echo $dt1->id_libur_perusahaan;?>')" data-toggle="modal" title="Edit <?php echo $dt1->keterangan; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    <?php } ?>
                                    <!-- delete -->
                                    <?php if($aksi4 == '4'){ ?>
                                        <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>libur/hapus/<?php echo $dt1->id_libur_perusahaan; ?>" onClick="return confirm('Anda yakin ingin menghapus <?php echo $dt1->keterangan; ?>?')" title="Hapus <?php echo $dt1->keterangan; ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    <?php } ?>
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
        <div class="box">
            <div class="box-header">
                <h4 class="box-title">Libur Nasional</h4>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no     = 1;
                            $data2  = $this->master_model->list_libur_nasional();
                            foreach($data2->result() as $dt2){
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt2->keterangan; ?></td>
                                <td><?php echo $dt2->tanggal; ?></td>
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
    function Edit(ID){
        var id  = ID;	
        $.ajax({
            type	: "POST",
            url		: "<?php echo site_url(); ?>/libur/edit",
            data	: "id="+id,
            dataType: "json",
            success	: function(data){
                $('#e_id').val(data.id_libur_perusahaan);
                $('#e_keterangan').val(data.keterangan);
                $('#e_tanggal').val(data.tanggal);
            }
        });
    }
</script>
<!-- edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>libur/simpan_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Libur perusahaan | Edit</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="hidden" name="id_libur_perusahaan" id="e_id">
                        <input type="text" name="keterangan" id="e_keterangan" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="text" class="form-control date-picker1" name="tanggal" id="e_tanggal" placeholder="Tanggal" required="required" autocomplete="off"/>
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
<!-- tambah -->
<div class="modal fade" id="tambah">
    <div class="modal-dialog modal-lg">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>libur/simpan">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Libur perusahaan | Tambah</h4>
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