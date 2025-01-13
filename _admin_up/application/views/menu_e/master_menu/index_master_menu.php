<script type="text/javascript">
function Edit1(ID){
    var id	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo base_url(); ?>menu_e/edit_menu_utama",
        data	: "id="+id,
        dataType: "json",
        success	: function(data){
            $('#id_menu_parent').val(data.id_menu_parent);
            $('#nama_parent').val(data.nama_parent);
            $('#link_parent').val(data.link_parent);
            $('#logo').val(data.logo);
            $('#urutan_parent').val(data.urutan);
        }
    });
}
</script>
<div class="box">
    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
    <div class="box-header">
        <a data-toggle="modal" data-target="#modal1" class="btn btn-app margin"><i class="fa fa-plus"></i> Tambah Menu Utama</a>
    </div>
    <div class="box-body">
        <!-- menu utama -->
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu Utama</th>
                    <th>Link</th>
                    <th>Logo</th>
                    <th>Urutan</th>
                    <!-- <th>Level</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no     = 1;
                    $data1  = $this->menu_e_model->list_menu_utama();
                    foreach ($data1->result() as $dt1) {
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt1->nama_parent; ?></td>
                        <td><?php echo $dt1->link_parent; ?></td>
                        <td><?php echo $dt1->logo; ?></td>
                        <td><?php echo $dt1->urutan; ?></td>
                        <!-- <td>
                        <?php
                            $l = $this->menu_e_model->list_level_parent($dt1->id_menu_parent);
                            foreach($l->result() as $lvl){
                        ?>
                            <?php echo $lvl->nama_level; ?>
                        <?php
                            }
                        ?>
                        </td> -->
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Edit1('<?php echo $dt1->id_menu_parent;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- isi menu utama -->
                            <a class="btn bg-blue btn-flat" href="<?php echo base_url() ?>menu_e/isi_menu_e/<?php echo $dt1->id_menu_parent; ?>">
                                <i class="fa fa-plus"></i>
                                Isi Menu Utama
                            </a>
                            <!-- level -->
                            <!-- <a class="btn bg-blue btn-flat" href="<?php echo base_url() ?>menu_e/level_menu_utama/<?php echo $dt1->id_menu_parent; ?>">
                                <i class="fa fa-plus"></i>
                                Level Menu Utama
                            </a> -->
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
<!-- modal menu utama -->
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu_e/simpan_menu_utama" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Menu Utama</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_menu_parent" id="id_menu_parent">
                    <div class="form-group">
                        <label for="">Nama Menu Utama</label>
                        <input type="text" class="form-control" name="nama_parent" id="nama_parent" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Link Menu Utama</label>
                        <input type="text" class="form-control" name="link_parent" id="link_parent" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Logo Menu Utama | <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank"><i>cek logo disini</i></a></label>
                        <input type="text" class="form-control" name="logo" id="logo" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Urutan</label>
                        <input type="number" class="form-control" name="urutan_parent" id="urutan_parent" min="1" required="required">
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
</div>
<!-- end modal menu utama -->