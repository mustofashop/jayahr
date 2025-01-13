<script type="text/javascript">
function Edit1(ID){
    var id	= ID;	
    $.ajax({
        type	: "POST",
        url		: "<?php echo base_url(); ?>menu_e/edit_isi_menu",
        data	: "id="+id,
        dataType: "json",
        success	: function(data){
            $('#id_menu').val(data.id_menu);
            $('#nama_menu').val(data.nama_menu);
            $('#link').val(data.link);
            $('#urutan').val(data.urutan);
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
        <a data-toggle="modal" data-target="#modal1" class="btn btn-app margin"><i class="fa fa-plus"></i> Tambah Isi Menu</a>
        <a class="btn btn-app" href="<?php echo base_url() ?>menu_e">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="box-body">
        <!-- isi menu -->
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Link</th>
                    <th>Urutan</th>
                    <!-- <th>Level</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no     = 1;
                    $data1  = $this->menu_e_model->list_isi_menu($id_m_p);
                    foreach ($data1->result() as $dt1) {
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt1->nama_menu; ?></td>
                        <td><?php echo $dt1->link; ?></td>
                        <td><?php echo $dt1->urutan; ?></td>
                        <!-- <td>
                            <?php
                                $l = $this->menu_e_model->list_level_isi($dt1->id_menu);
                                foreach($l->result() as $lvl){
                            ?>
                                <?php echo $lvl->nama_level; ?>
                            <?php
                                }
                            ?>
                        </td> -->
                        <td>
                            <!-- edit -->
                            <a class="btn bg-olive btn-flat" href="#modal1" onclick="javascript:Edit1('<?php echo $dt1->id_menu;?>')" data-toggle="modal" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!-- level -->
                            <!-- <a class="btn bg-blue btn-flat" href="<?php echo base_url() ?>menu_e/level_isi_menu/<?php echo $dt1->id_menu; ?>">
                                <i class="fa fa-plus"></i>
                                Level Isi Menu
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
<!-- modal isi menu -->
<div class="modal fade" id="modal1">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>menu_e/simpan_isi" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> | Menu Utama</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_menu" id="id_menu">
                    <input type="hidden" name="id_menu_parent" value="<?php echo $id_m_p; ?>">
                    <div class="form-group">
                        <label for="">Nama Menu</label>
                        <input type="text" class="form-control" name="nama_menu" id="nama_menu" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Link Menu</label>
                        <input type="text" class="form-control" name="link" id="link" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Urutan</label>
                        <input type="number" class="form-control" name="urutan" id="urutan" min="1" required="required">
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
<!-- end modal isi menu -->