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
    <div class="box-body">
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Karyawan</td>
                            <td>NRP</td>
                            <td>Unit</td>
                            <td>Ceklis</td>
                            <td>Nilai(Angka)</td>
                            <td>Kriteria Nilai</td>
                            <td>Cetak Penilaian Ke</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no     = '1';
                        $status = '0'; //0 = available, 1 = resign, 2 = phk, 3 = hapus 
                        //jenis (1 = karyawan tetap, 2 = project, 3 kontrak)
                        $data   = $this->master_model->list_user_pkk();
                        foreach ($data->result() as $dt) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $dt->nama_lengkap; ?></td>
                                <td><?php echo $dt->nip; ?></td>
                                <td><?php echo $dt->department; ?></td>
                                <td>4/4</td>
                                <td>82,4</td>
                                <td>B</td>
                                <td>
                                    <div class="button-group">
                                        <button class="circle-btn" onclick="cetakPenilaian(1, '<?php echo $dt->nama_lengkap; ?>')">1</button>
                                        <button class="circle-btn" onclick="cetakPenilaian(2, '<?php echo $dt->nama_lengkap; ?>')">2</button>
                                        <button class="circle-btn" onclick="cetakPenilaian(3, '<?php echo $dt->nama_lengkap; ?>')">3</button>
                                        <button class="circle-btn" onclick="cetakSemua('<?php echo $dt->nama_lengkap; ?>')">All</button>
                                    </div>
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
<style>
    .circle-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #000;
        background-color: #f0f0f0;
        color: #000;
        font-weight: bold;
        cursor: pointer;
    }

    .circle-btn:hover {
        background-color: #dcdcdc;
    }

    .button-group {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
</style>
<script>
    function cetakPenilaian(nomor, nama) {
        alert(`Cetak penilaian ke-${nomor} untuk ${nama}`);
    }

    function cetakSemua(nama) {
        alert(`Cetak semua penilaian untuk ${nama}`);
    }
</script>