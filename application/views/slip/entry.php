<script type="text/javascript">
    function Edit(ID) {
        var cari = ID;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(); ?>/Slip/edit_gaji",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_slip').val(data.id_slip);
                $('#nama_guru').val(data.nama_guru);
                $('#jabatan').val(data.jabatan);
                $('#nig').val(data.nig);
                $('#gapok').val(data.gapok);
                $('#tpt').val(data.tpt);
                $('#jht').val(data.jht);
                $('#bpjs').val(data.bpjs);
                $('#transport').val(data.transport);
                $('#tahsin').val(data.tahsin);
                $('#ko_bhs').val(data.ko_bhs);
                $('#k_jilid').val(data.k_jilid);
                $('#sat').val(data.sat);
                $('#piket').val(data.piket);
                $('#pengganti_pelajaran').val(data.pengganti_pelajaran);
                $('#eskul').val(data.eskul);
                $('#pembinaan_tahfidz').val(data.pembinaan_tahfidz);
                $('#jht_2').val(data.jht_2);
                $('#bpjs_2').val(data.bpjs_2);
                $('#pinj_yayasan').val(data.pinj_yayasan);
                $('#koperasi').val(data.koperasi);
                $('#pinj_koperasi').val(data.pinj_koperasi);
                $('#pph').val(data.pph);
                $('#qurban').val(data.qurban);
                $('#dll').val(data.dll);
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
<?php if ($this->session->flashdata('msg_error')) : ?>
    <div class="alert alert-danger alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert!</h4>
        <?php echo $this->session->flashdata('msg_error'); ?>
    </div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <a class="btn btn-app" href="<?php echo base_url(); ?>Slip/index">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>
        <!-- upload karyawan -->
        <a data-toggle="modal" data-target="#excel" class="btn bg-green btn-flat margin">Import Gaji
            <i class="fa fa-download"></i>
        </a>
        <a class="btn bg-red btn-flat margin" href="<?php echo base_url(); ?>Slip/download_data_slip/<?php echo $bulan; ?>" title=" Download Slip Semua Guru Bulan: <?php echo $bulan; ?>">
            <i class="fa fa-download"></i>
            Download Slip
        </a>
        <a class="btn bg-primary btn-flat margin" href="<?php echo site_url('Slip/sample_upload') ?>">
            <i class="fa fa-download"></i>
            Sample Upload Gaji
        </a>
    </div>
    <div class="box-body">
        <!-- custom tab -->
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="tab" href="#home">Available</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Induksi</td>
                            <td>Deduksi</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = '1';
                        $data   = $this->master_model->list_slip_gaji($bulan);
                        foreach ($data->result() as $dt) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td>
                                    <div>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <p style="display: inline-block; margin-right: 10px;"><b>Nama guru : </b> <?php echo $dt->nama_guru; ?></p>
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i>
                                        <p style="display: inline-block; margin-right: 10px;"><b>NIG : </b> <?php echo $dt->nig; ?></p>
                                        <i class="fa fa-id-badge" aria-hidden="true"></i>
                                        <p style="display: inline-block; margin-right: 10px;"> <b>Jabatan : </b> <?php echo "Rp " . number_format($dt->jabatan, 2, ',', '.'); ?></p>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        <p style="display: inline-block; margin-right: 5px;"> <b>JHT: </b><?php echo "Rp " . number_format($dt->jht_2, 2, ',', '.'); ?></p>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        <p style="display: inline-block; margin-right: 5px;"> <b>BPJS: </b><?php echo "Rp " . number_format($dt->bpjs, 2, ',', '.'); ?></p>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn bg-blue btn-flat" href="<?php echo base_url(); ?>Slip/download_data_slip_dtl/<?php echo $dt->id_slip; ?>" title="Download Slip Guru: <?php echo $dt->nama_guru; ?> Bulan: <?php echo $bulan; ?>">
                                        <i class="fa fa-download" aria-hidden="true"></i>

                                    </a>
                                    <a class="btn bg-green btn-flat" href="#edit" onclick="javascript:Edit('<?php echo $dt->id_slip; ?>')" data-toggle="modal" title="Edit">
                                        <i class="fa fa-search" aria-hidden="true"></i>

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
    </div>
</div>
<!-- modal upload excel -->
<div class="modal fade" id="excel">
    <div class="modal-dialog">
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo base_url(); ?>Slip/upload_gaji" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?></h4>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="import">Upload Karyawan</label>
                        <div class="col-md-12">
                            <input type="file" id="file_excel" name="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required="required">
                            <input type="hidden" name="bulan" id="bulan" value="<?php echo $bulan; ?>">
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
</div>
<!-- modal edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <form role="form" method="POST" action="<?php echo base_url(); ?>Slip/simpan_edit_slip">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?php echo $header; ?> <b>INDUKSI</b> </h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_slip" id="id_slip">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Guru</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="nama_guru" id="nama_guru" class="form-control" required="required" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">NIG</label>
                                <input type="text" name="nig" id="nig" class="form-control" required="required" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Gapok</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="gapok" id="gapok" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">TPT</label>
                                <input type="text" name="tpt" id="tpt" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">JHT</label>
                                <input type="text" name="jht" id="jht" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">BPJS</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="bpjs" id="bpjs" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Transport</label>
                                <input type="text" name="transport" id="transport" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tahsin</label>
                                <input type="text" name="tahsin" id="tahsin" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Koordinator Bahasa</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="ko_bhs" id="ko_bhs" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Kenaikan Jilid</label>
                                <input type="text" name="k_jilid" id="k_jilid" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">SAT</label>
                                <input type="text" name="sat" id="sat" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Piket</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="piket" id="piket" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Pengganti Pelajaran</label>
                                <input type="text" name="pengganti_pelajaran" id="pengganti_pelajaran" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Eskul</label>
                                <input type="text" name="eskul" id="eskul" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Pembinaan Tahfidz</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="pembinaan_tahfidz" id="pembinaan_tahfidz" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <h4 class="modal-title"><?php echo $header; ?> <b>DEDUKSI</b> </h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">JHT</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="jht_2" id="jht_2" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">BPJS Kes, Jkm, JKK</label>
                                <input type="text" name="bpjs_2" id="bpjs_2" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Pinjaman Yayasan</label>
                                <input type="text" name="pinj_yayasan" id="pinj_yayasan" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Koperasi</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="koperasi" id="koperasi" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Pinjaman Koperasi</label>
                                <input type="text" name="pinj_koperasi" id="pinj_koperasi" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">PPH-21</label>
                                <input type="text" name="pph" id="pph" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tabungan Qurban</label>
                                <!-- <input type="hidden" name="id_lokasi" id="id_lokasi"> -->
                                <input type="text" name="qurban" id="qurban" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Lain-lain</label>
                                <input type="text" name="dll" id="dll" class="form-control" required="required">
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