<div class="box">
    <div class="box-body">
        <table class="table table-bordered table-striped tabeldinamis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Masuk</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Terlambat</th>
                    <th>SPPD</th>
                    <th>Koreksi Absen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no     = 1;
                    foreach($data->result() as $k){
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $k->nip; ?></td>
                        <td><?php echo $k->nama_lengkap; ?></td>
                        <td>
                            <?php 
                                $hadir  = $this->laporan_model->jumlah_hadir($k->id_karyawan,$tgl_awal,$tgl_akhir);
                                echo $hadir->row()->jumlah_hadir;
                            ?>
                        </td>
                        <td>
                            <?php 
                                $izin  = $this->laporan_model->jumlah_izin($k->id_karyawan,$tgl_awal,$tgl_akhir);
                                echo $izin->row()->jumlah_izin;
                            ?>
                        </td>
                        <td>
                            <?php 
                                $sakit  = $this->laporan_model->jumlah_sakit($k->id_karyawan,$tgl_awal,$tgl_akhir);
                                echo $sakit->row()->jumlah_sakit;
                            ?>
                        </td>
                        <td>
                            <?php 
                                $telat  = $this->laporan_model->jumlah_telat($k->id_karyawan,$tgl_awal,$tgl_akhir);
                                echo $telat->row()->jumlah_telat;
                            ?>
                        </td>
                        <td>
                            <?php 
                                $sppd  = $this->laporan_model->jumlah_sppd($k->id_karyawan,$tgl_awal,$tgl_akhir);
                                echo $sppd->row()->jumlah_sppd;
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url(); ?>kehadiran/koreksi_absen/<?php echo $k->id_karyawan; ?>/<?php echo $tgl_awal ?>/<?php echo $tgl_akhir; ?>" class="btn btn-flat bg-blue" title="Koreksi Absen <?php echo $k->nama_lengkap; ?>">
                                <i class="fa fa-pencil"></i>
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