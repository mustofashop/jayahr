<div class="box">
    <a class="btn bg-green btn-flat margin" href="<?php echo base_url(); ?>Pengaturan_pkk/download_data_pkk/">
        <i class="fa fa-download"></i>
        Download data
    </a>
    <div class="box-body">
        <!-- custom tab -->
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <!-- available -->
                <table class="table table-bordered table-striped tabeldinamis">
                    <thead>
                        <tr>
                            <td rowspan="2">No</td>
                            <td rowspan="2">NRP</td>
                            <td rowspan="2">Nama Karyawan</td>
                            <td rowspan="2">Submit</td>
                            <td colspan="3" class="text-center">Ceklis</td>
                        </tr>
                        <tr>
                            <td>SPV 1</td>
                            <td>SPV 2</td>
                            <td>Karyawan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Karyawan Manual -->
                        <tr>
                            <td>1</td>
                            <td>12345</td>
                            <td>John Doe</td>
                            <td>
                                <button type="button" class="btn btn-primary">Submit</button>
                            </td>
                            <td><input type="checkbox" name="spv1_12345"></td>
                            <td><input type="checkbox" name="spv2_12345"></td>
                            <td><input type="checkbox" name="karyawan_12345"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>