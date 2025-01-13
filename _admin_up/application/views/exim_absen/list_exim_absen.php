<?php if($this->session->flashdata('msg1')): ?>
    <div class="alert alert-danger alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg1'); ?>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <div class="box-tools pull-right">
            <?php 
                if($id2 == "" || empty($id2)){
                    $link_id2 = '0';
                }else{
                    $link_id2 = $id2;
                }

                if($id3 == "" || empty($id3)){
                    $link_id3 = '0';
                }else{
                    $link_id3 = $id3;
                }
            ?>
            <a class="btn btn-app" href="<?php echo base_url(); ?>exim_absen/import_ke_postgre/<?php echo $kategori; ?>/<?php echo $tanggal1; ?>/<?php echo $tanggal2; ?>/<?php echo $id1; ?>/<?php echo $link_id2; ?>/<?php echo $link_id3; ?>">
                <i class="fa fa-upload"></i> Import Ke PostgreSql
            </a>
            <a class="btn btn-app" href="<?php echo base_url(); ?>exim_absen/check_data_postgre/<?php echo $kategori; ?>/<?php echo $tanggal; ?>/<?php echo $tanggal2; ?>/<?php echo $id1; ?>/<?php echo $link_id2; ?>/<?php echo $link_id3; ?>" target="_blank">
                <i class="fa fa-search"></i> Check Data PostgreSql
            </a>
        </div>
        <h3 class="box-title">List Absen (Mysql)</h3>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <?php if($kategori == '1'){ ?>
                        <th>No</th>
                        <th>Userid</th>
                        <th>Nama</th>
                        <th>Checktime</th>
                        <th>Checktype</th>
                    <?php }else{ ?>
                        <td>No</td>
                        <td>Userid</td>
                        <td>Nama</td>
                        <td>Tanggal</td>
                        <td>Masuk</td>
                        <td>Keluar</td>
                        <td>Status</td>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';

                    // $id1; //id_perusahaan / id_sekolah
                    // $id2; //id_bagian / id_kelas
                    // $id3; //userid

                    if($kategori == '1'){
                        if($id2 == "" || empty($id2)){
                            $bagian     = "";
                        }else{
                            $bagian     = "AND b.id_bagian = '$id2'";
                        }
                    }elseif($kategori == '2'){
                        if($id2 == "" || empty($id2)){
                            $bagian     = "";
                        }else{
                            $bagian     = "AND b.kode_kelas = '$id2'";
                        }
                    }else{
                        $bagian = "";
                    }

                    if($id3 == "" || empty($id3)){
                        $userid     = "";
                    }else{
                        $userid     = "AND a.userid = '$id3'";
                    }
                    $data   = $this->exim_model->list_absen_mysql($tanggal1,$tanggal2,$kategori,$id1,$bagian,$userid);
                    foreach($data->result() as $dt){
                ?>
                    <?php if($kategori == '1'){ ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->userid; ?></td>
                        <td><?php echo $dt->name; ?></td>
                        <td><?php echo $dt->checktime; ?></td>
                        <td><?php echo $dt->checktype; ?></td>
                    </tr>
                    <?php }else{ ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->userid; ?></td>
                        <td><?php echo $dt->name; ?></td>
                        <td><?php echo $dt->tgl; ?></td>
                        <td><?php echo $dt->masuk; ?></td>
                        <td><?php echo $dt->keluar; ?></td>
                        <td><?php echo $dt->status; ?></td>
                    </tr>
                    <?php } ?>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>