<div style="width: 100%; border: 2px solid black; padding: 20px; font-family: Arial, sans-serif; font-size: 14px;">
    <h2 style="text-align: center; font-weight: bold;">LAPORAN PENILAIAN PRESTASI KERJA</h2>
    <h4 style="text-align: center; font-weight: bold;">KARYAWAN KONTRAK KELOMPOK I - II</h4>

    <!-- Tabel Data Karyawan -->
    <table border="1" style="width: 50%; border-collapse: collapse; margin-top: 30px; margin-bottom: 20px;">
        <tr>
            <th colspan="2" style="text-align: center; padding: 8px; font-size: 16px;">KARYAWAN YANG DINILAI</th>
        </tr>
        <tr>
            <td style="width: 40%; padding: 10px;">Nama</td>
            <?php
            $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
            ?>
            <td style="padding: 10px;"><?php echo isset($row->nama_lengkap) ? $row->nama_lengkap : 'Nilai Belum Di Isi !'; ?></td>
        </tr>
        <tr>
            <td style="padding: 10px;">Jabatan</td>
            <?php
            $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
            ?>
            <td style="padding: 10px;"><?php echo isset($row->job_grade) ? $row->job_grade : 'Nilai Belum Di Isi !'; ?></td>
        </tr>
        <tr>
            <td style="padding: 10px;">Tanggal Masuk</td>
            <?php
            $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
            ?>
            <td style="padding: 10px;"><?php echo isset($row->tgl_hire) ? $row->tgl_hire : 'Nilai Belum Di Isi !'; ?></td>
        </tr>
    </table>

    <table border="2" style="width: 50%; border-collapse: collapse; ">
        <tr>
            <th colspan="2" style="text-align: center;  padding: 5px; font-size: 16px;">NAMA PENILAI</th>
        </tr>
        <tr>
            <td style="width: 40%; padding: 4px;">Atasan Langsung :</td>
            <?php
            $row = $data->row(); // Ambil baris pertama dari hasil query
            ?>
            <td style="padding: 4px;"><?php echo isset($row->spv1_nama) ? $row->spv1_nama : 'Nilai Belum Di Isi !'; ?></td>
        </tr>
        <tr>
            <td style="width: 40%; padding: 4px;">Atasan Tidak Langsung :</td>
            <?php
            $row = $data->row(); // Ambil baris pertama dari hasil query
            ?>
            <td style="padding: 4px;"><?php echo isset($row->spv2_nama) ? $row->spv2_nama : 'Nilai Belum Di Isi !'; ?></td>
        </tr>
        <tr>
            <td style="width: 40%; padding: 4px;">Unit :</td>
            <?php
            $row = $data_pkk->row(); // Ambil baris pertama dari hasil query
            ?>
            <td style="padding: 4px;"><?php echo isset($row->department) ? $row->department : 'Nilai Belum Di Isi !'; ?></td>
        </tr>
        <tr>
            <td style="width: 40%; padding: 4px;">Periode Penilaian :</td>
            <?php
            $row = $data->row(); // Ambil baris pertama dari hasil query
            ?>
            <td style="padding: 4px;"><?php echo isset($row->flag_penilaian) ? $row->flag_penilaian : 'Nilai Belum Di Isi !'; ?></td>
        </tr>
    </table>
    <!-- Tambahkan ini untuk memastikan bagian baru dimulai di halaman berikutnya -->
    <div style="page-break-before: always;"></div>

    <table border="2" style="width: 100%; border-collapse: collapse; page-break-inside: avoid;">
        <!-- Tabel lainnya di sini -->
    </table>
</div>

<style>
    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        table {
            page-break-inside: avoid;
        }

        div {
            page-break-inside: avoid;
        }
    }
</style>


<!-- Tabel Penilaian -->
<table border="2" style="width: 100%; border-collapse: collapse; margin: 15px auto; margin-bottom: 5px;">
    <tr style="font-weight: bold; background-color: #f2f2f2;">
        <th style="text-align: center;">No</th>
        <th style="width: 50%; text-align: center; padding: 5px;">Aspek Yang Dinilai</th>
        <th style="width: 10%; text-align: center; padding: 5px;">Atasan Langsung</th>
        <th style="width: 10%; text-align: center; padding: 5px;">Nilai Atasan Langsung</th>
        <th style="width: 10%; text-align: center; padding: 5px;">Atasan Tidak Langsung</th>
        <th style="width: 10%; text-align: center; padding: 5px;">Nilai Atasan Tidak Langsung</th>
    </tr>
    <?php
    $no = 1; // Inisialisasi nomor
    foreach ($penilaian->result() as $row): ?>
        <tr>
            <td style="text-align: center;"><?php echo $no; ?></td> <!-- Kolom Nomor -->
            <td style="padding: 4px;"><?php echo $row->aspek_dinilai; ?></td>
            <td style="padding: 4px; text-align: center;"><?php echo $row->isi_nilai_atasan_langsung; ?></td>
            <td style="padding: 4px; text-align: center;"><?php echo number_format($row->nilai_atasan_langsung, 1); ?></td>
            <td style="padding: 4px; text-align: center;"><?php echo $row->isi_nilai_atasan_tidak_langsung; ?></td>
            <td style="padding: 4px; text-align: center;"><?php echo number_format($row->nilai_atasan_tidak_langsung, 1); ?></td>
        </tr>
    <?php
        $no++; // Increment nomor
    endforeach; ?>
    <tfoot>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <td></td> <!-- Kosong untuk kolom nomor -->
            <td style="padding: 4px; text-align: left;"><b>Total</b></td>
            <td colspan="2" style="padding: 4px; text-align: center;">
                <?php
                echo isset($row->total_nilai_atasan_langsung)
                    ? number_format($row->total_nilai_atasan_langsung, 1)
                    : '0.0';
                ?>
            </td>
            <td colspan="2" style="padding: 4px; text-align: center;">
                <?php
                echo isset($row->total_nilai_atasan_tidak_langsung)
                    ? number_format($row->total_nilai_atasan_tidak_langsung, 1)
                    : '0.0';
                ?>
            </td>
        </tr>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <td></td> <!-- Kosong untuk kolom nomor -->
            <td style="padding: 4px; text-align: left;"><b>Hasil Akhir :</b></td>
            <?php
            // Menghitung Hasil Akhir dengan validasi
            $hasil_akhir = (isset($row->total_nilai_atasan_langsung) && isset($row->total_nilai_atasan_tidak_langsung))
                ? ($row->total_nilai_atasan_langsung * 0.6) + ($row->total_nilai_atasan_tidak_langsung * 0.4)
                : 0.0;
            ?>
            <td colspan="4" style="padding: 4px; text-align: center;"><?php echo number_format($hasil_akhir, 1); ?></td>
        </tr>
    </tfoot>

</table>
<table border="2" style="width: 50%; border-collapse: collapse; margin-bottom: 15px;">
    <tr style="font-weight: bold;  background-color: #f2f2f2; text-align: center;">
        <td style="padding: 5px;">Kriteria</td>
        <td style="padding: 5px;">Nilai</td>
        <td style="padding: 5px;">Keterangan</td>
    </tr>
    <tr style="text-align: center;">
        <td style="font-weight: bold; padding: 3px;">A</td>
        <td style="padding: 3px;">90 s.d. 100</td>
        <td style="padding: 3px;">Istimewa</td>
    </tr>
    <tr style="text-align: center;">
        <td style="font-weight: bold; padding: 3px;">B</td>
        <td style="padding: 3px;">80 s.d. 89</td>
        <td style="padding: 3px;">Baik</td>
    </tr>
    <tr style="text-align: center;">
        <td style="font-weight: bold; padding: 3px;">C</td>
        <td style="padding: 3px;">60 s.d. 79</td>
        <td style="padding: 3px;">Cukup</td>
    </tr>
    <tr style="text-align: center;">
        <td style="font-weight: bold; padding: 3px;">D</td>
        <td style="padding: 3px;">40 s.d. 59</td>
        <td style="padding: 3px;">Kurang</td>
    </tr>
</table>

<table border="2" style="width: 100%; border-collapse: collapse; margin: 10px auto;">
    <tr>
        <td style="padding: 5px;">
            <strong>Aspek-aspek Tambahan </strong>
            (mohon diuraikan bila ada) :

            <div style="margin-bottom: 15px;">
                <strong>Atasan Langsung:</strong>
                <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                    <?php echo !empty($row->text_tambahan_atasan_langsung) ? $row->text_tambahan_atasan_langsung : '&nbsp;'; ?>
                </div>
                <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                    &nbsp; <!-- Garis tambahan kosong -->
                </div>
                <strong>Atasan Tidak Langsung:</strong>
                <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                    <?php echo !empty($row->text_tambahan_atasan_tidak_langsung) ? $row->text_tambahan_atasan_tidak_langsung : '&nbsp;'; ?>
                </div>
                <div style="width: 100%; border-top: 1px solid black; margin-top: 10px; padding-top: 5px;">
                    &nbsp; <!-- Garis tambahan kosong -->
                </div>
            </div>
        </td>
    </tr>
</table>

</div>