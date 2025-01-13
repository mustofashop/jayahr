<div class="row">
    <div class="col-md-6">
        <div class="box">
            <form role="form" method="GET" action="<?php echo base_url(); ?>int_assessment/list_inass">
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Pilih Tahun Penilaian</label>
                        <select name="tahun" class="form-control">
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
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