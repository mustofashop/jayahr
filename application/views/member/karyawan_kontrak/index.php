<script type="text/javascript">
    $(document).ready(function() {
        //pilih perusahaan
        $('#perusahaan').change(function() {
            var id = $("#perusahaan").val();
            if (id == "") {
                $("#lokasi").empty();
                $("#bagian").empty();
            } else {
                $.ajax({
                    url: "<?php echo site_url(); ?>Enterprise/karyawan/list_lokasi",
                    type: "POST",
                    data: "id=" + id,
                    cahce: false,
                    dataType: 'json',
                    success: function(response) {
                        $("#lokasi").empty();
                        $("#lokasi").append('<option value="">-- Semua --</option>');
                        $("#bagian").append('<option value="">-- Semua --</option>');
                        $.each(response, function(value, key) {
                            $("#lokasi").append('<option value=' + key.id_lokasi + '>' + key.nama_lokasi + '</option>');
                        })
                    }
                });
            }
        });
        //pilih lokasi
        $('#lokasi').change(function() {
            var id = $("#lokasi").val();
            if (id == "") {
                $("#bagian").empty();
                $("#bagian").append('<option value="">-- Semua --</option>');
            } else {
                $.ajax({
                    url: "<?php echo site_url(); ?>Enterprise/karyawan/list_bagian",
                    type: "POST",
                    data: "id=" + id,
                    cahce: false,
                    dataType: 'json',
                    success: function(response) {
                        $("#bagian").empty();
                        $("#bagian").append('<option value="">-- Semua --</option>');
                        $.each(response, function(value, key) {
                            $("#bagian").append('<option value=' + key.id_bagian + '>' + key.nama_bagian + '</option>');
                        })
                    }
                });
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <!-- <div class="box-header">
            
            </div> -->
            <form role="form" method="GET" action="<?php echo base_url(); ?>Pengaturan_pkk/list_karyawan">
                <div class="box-body">
                    <!-- jenis -->
                    <div class="form-group">
                        <label for="">Jenis Karyawan</label>
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="3">Kontrak</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn bg-green btn-success btn-flat-margin"><i class="fa fa-search"></i>
                        Lihat Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>