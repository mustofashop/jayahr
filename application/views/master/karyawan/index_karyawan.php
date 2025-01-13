<div class="row">
    <div class="col-md-6">
        <div class="box">
            <form role="form" method="GET" action="<?php echo base_url(); ?>data_karyawan/list_karyawan">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="1">Karyawan Tetap</option>
                            <option value="3">Karyawan Kontrak</option>
                        </select>
                    </div>
                    
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-flat bg-green">
                        <i class="fa fa-paper-plane"></i>
                        Lihat Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>