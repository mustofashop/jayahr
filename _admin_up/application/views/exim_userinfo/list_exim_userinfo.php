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
                //bagian / kode kelas
                if($id2 == "" || empty($id2)){
                    $link_id2 = '0';
                }else{
                    $link_id2 = $id2;
                }

                //userid
                if($id3 == "" || empty($id3)){
                    $link_id3 = '0';
                }else{
                    $link_id3 = $id3;
                }
            ?>
            <a class="btn btn-app" href="<?php echo base_url(); ?>exim_userinfo/import_ke_postgre/<?php echo $kategori; ?>/<?php echo $id1; ?>/<?php echo $link_id2; ?>/<?php echo $link_id3; ?>">
                <i class="fa fa-upload"></i> Import Ke PostgreSql
            </a>
            <a class="btn btn-app" href="<?php echo base_url(); ?>exim_userinfo/check_data_postgre/<?php echo $kategori; ?>/<?php echo $id1; ?>/<?php echo $link_id2; ?>/<?php echo $link_id3; ?>" target="_blank">
                <i class="fa fa-search"></i> Check Data PostgreSql
            </a>
        </div>
        <h3 class="box-title"></h3>
    </div>
    <!-- end box header -->
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Userid</td>
                    <td>Badgenumber</td>
                    <td>SN</td>
                    <td>Nama</td>
                    <?php if($kategori == '1'){ ?>
                        <!-- perusahaan -->
                        <td>Lokasi</td>
                        <td>Bagian</td>
                    <?php }elseif($kategori == '2'){ ?>
                        <!-- murid -->
                        <td>Kelas</td>
                    <?php }else{ ?>
                        <!-- guru -->
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = '1';

                    //$id1; //id_perusahaan / id_sekolah
                    //$id2; //id_bagian / id_kelas
                    //$id3; //userid

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
                        if($kategori == '1'){
                            $userid = "AND b.userid = '$id3'";
                        }else{
                            $userid = "AND b.badgenumber = '$id3'";
                        }
                    }
                    $data   = $this->exim_model->list_userinfo_mysql($kategori,$id1,$bagian,$userid);
                    foreach($data->result() as $dt){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->userid; ?></td>
                        <td><?php echo $dt->badgenumber; ?></td>
                        <td><?php echo $dt->sn; ?></td>
                        <?php if($kategori == '1'){ ?>
                            <!-- perusahaan -->
                            <td><?php echo $dt->nama_karyawan; ?></td>
                            <td><?php echo $dt->nama_lokasi; ?></td>
                            <td><?php echo $dt->nama_bagian; ?></td>
                        <?php }elseif($kategori == '2'){ ?>
                            <!-- murid -->
                            <td><?php echo $dt->nama; ?></td>
                            <td><?php echo $dt->nama_kelas; ?></td>
                        <?php }else{ ?>
                            <!-- guru -->
                            <td><?php echo $dt->nama; ?></td>
                        <?php } ?>
                    </tr>
                <?php
                    $no++;
                    }
                ?>
            </tbody>
        </table>        
    </div>
</div>