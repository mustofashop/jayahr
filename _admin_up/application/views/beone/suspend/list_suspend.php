<script type="text/javascript">
$(document).ready(function(){
    $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        if(checkbox.length > 0){
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url     :"<?php echo base_url(); ?>beone/suspend_all",
                method  :"POST",
                data    :{checkbox_value:checkbox_value},
                success :function()
                {
                    location.reload();  
                }
            });
        }else{
            var alert = '<div class="alert alert-warning alert-dismissible" id="danger-alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-exclamation"></i> Alert!</h4>Tidak ada data dipilih</div>';
            $('#alert').html(alert);
            $("#alert").fadeTo(2000, 500).slideUp(500, function() {
                $("#alert").slideUp(500);
                location.reload();  
            });   
        }
    });
});
</script>
<div id="alert"></div>
<?php if($this->session->flashdata('msg_input')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_input'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-body">
        <!-- list murid -->
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Murid</td>
                    <td>Kelas</td>
                    <td>Status Suspend</td>
                    <td>Aksi</td>
                    <td>
                        <a type="button" id="delete_all" class="btn bg-red btn-flat">
                            <i class="fa fa-times"></i>
                            Suspend
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = '1';
                    $data   = $this->beone_model->list_murid_suspend($kelas);
                    foreach($data->result() as $dt){ ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $dt->nama_murid; ?></td>
                            <td><?php echo $dt->nama_kelas; ?></td>
                            <td><?php echo $dt->status_suspend; ?></td>
                            <td>
                                <!-- edit status suspend -->
                                <?php 
                                    if($dt->suspend == '0'){
                                ?>
                                        <a class="btn bg-red btn-flat" href="<?php echo base_url(); ?>beone/suspend_murid/<?php echo $dt->id_murid; ?>/1" onClick="return confirm('Anda yakin ingin mensuspend <?php echo $dt->nama_murid ?>?')" title="Suspend">
                                            <i class="fa fa-times"></i>
                                        </a>
                                <?php
                                    }else{
                                ?>
                                        <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>beone/suspend_murid/<?php echo $dt->id_murid; ?>/0" onClick="return confirm('Anda yakin ingin tidak suspend <?php echo $dt->nama_murid ?>?')" title="Tidak Suspend">
                                            <i class="fa fa-check"></i>
                                        </a>
                                <?php
                                    }
                                ?>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="delete_checkbox" value="<?php echo $dt->id_murid; ?>">
                                    </label>
                                </div>
                            </td>
                        </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>