<script type="text/javascript">
    function Edit(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/people_rev/edit_idp",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_trn_idp').val(data.id_trn_idp);
                $('#isi_idp').val(data.isi_idp);
            }
        });
    }
</script>
<script type="text/javascript">
    function View(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/people_rev/edit_idp",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_trn_idp').val(data.id_trn_idp);
                $('#isi_idp').val(data.isi_idp);
            }
        });
    }
</script>
<script type="text/javascript">
    function Tambah(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/people_rev/tambah_idp",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_idp').val(data.id_idp);
            }
        });
    }
</script>
<?php if ($this->session->flashdata('msg')) : ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>People_rev/index">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="box-body">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Pertanyaan</td>
                    <td>Isi Penilaian</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $no     = 1;
                $data   = $this->master_model->list_tanya_idp();
                foreach ($data->result() as $dt) {
                    $nrp    = $this->session->userdata('nrp');
                    $cek_jwbn_idp = $this->master_model->cek_jawab_idp($idp_tahun, $dt->id_idp, $idp_nrp, $nrp, $atasan);
                    if ($cek_jwbn_idp->num_rows() > 0) {
                        $id_trn_idp = $cek_jwbn_idp->row()->id_trn_idp;
                    } else {
                        $id_trn_idp = '';
                    }

                    $nrp    = $this->session->userdata('nrp');
                    $cek_idp = $this->master_model->cek_idp($idp_tahun, $idp_nrp, $nrp);
                    $cek_fidp = $this->master_model->cek_sent_idp($idp_tahun, $idp_nrp, $nrp);
                    $hasil = $cek_idp->row()->hasil;
                    $cek = $cek_idp->row()->cek;
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $dt->nama_value; ?>
                            <br>
                            <?php echo $dt->desc; ?>
                        </td>
                        <?php if ($cek_jwbn_idp->num_rows() > 0) {
                            $jwb_idp = $cek_jwbn_idp->row()->isi_idp;
                        ?>
                            <td><?php echo $jwb_idp; ?></td>
                        <?php } else { ?>
                            <td></td>
                        <?php } ?>
                        <td>
                            <!-- edit -->
                            <?php if ($cek_jwbn_idp->num_rows() > 0 && $cek_fidp->row()->f_sent == '0') { ?>
                                <a class="btn bg-olive btn-flat" href="#edit" onclick="javascript:Edit('<?php echo $id_trn_idp; ?>')" data-toggle="modal" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <?php } ?>
                            <!-- view -->
                            <?php if ($cek_jwbn_idp->num_rows() > 0 && $cek_fidp->row()->f_sent == '1') { ?>

                            <?php } ?>
                            <!-- add -->
                            <?php if ($cek_jwbn_idp->num_rows() < 1) { ?>
                                <a class="btn bg-blue btn-flat" href="#modal" onclick="javascript:Tambah('<?php echo $dt->id_idp; ?>')" data-toggle="modal" title="Add">
                                    <i class="fa fa-plus"></i>
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
<!-- edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>people_rev/save_edit_idp">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Pertanyaan <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Isi Penilaian</label></br>
                        <textarea id="isi_idp" name="isi_idp" rows="4" cols="70"></textarea>
                        <!-- <input type="text" name="isi_idp" id="isi_idp" class="form-control" required="required"> -->
                        <input type="hidden" name="id_trn_idp" id="id_trn_idp">
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

<!-- add -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>people_rev/save_idp" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah <?php echo $header; ?></h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Isi Penilaian</label></br>
                        <textarea id="isi_idp" name="isi_idp" rows="4" cols="65"></textarea>
                        <!-- <input type="text" name="isi_idp" id="isi_idp" class="form-control" required="required"> -->
                        <input type="hidden" name="id_idp" id="id_idp"">
                        <input type=" hidden" name="tahun" value="<?php echo $idp_tahun; ?>">
                        <input type="hidden" name="nrp" value="<?php echo $idp_nrp; ?>">
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