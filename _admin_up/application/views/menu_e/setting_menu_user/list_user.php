<div class="box">
    
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Level Login</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no     = 1;
                    $data   = $this->menu_e_model->list_user_login($id_p);
                    foreach ($data->result() as $dt) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $dt->nama_lengkap; ?></td>
                    <td><?php echo $dt->nama_level; ?></td>
                    <td>
                        <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>setting_menu_e/setting_menu_u/<?php echo $dt->id_karyawan; ?>/<?php echo $id_p; ?>" title="Setting Menu User <?php echo $dt->nama_lengkap; ?>">
                            <i class="fa fa-plus"></i>
                            Setting Menu
                        </a>
                        <!-- <a class="btn bg-maroon btn-flat" href="<?php echo base_url(); ?>setting_menu_e/delete_user/<?php echo $dt->id_karyawan; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a> -->
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>  
    </div>
</div>