<script type="text/javascript">

</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <!-- <div class="box-header">
            
            </div> -->
            <form role="form" method="GET" action="<?php echo base_url(); ?>Slip/entry">
                <div class="box-body">
                    <!-- jenis -->
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="bulan" id="bulan" class="form-control date-picker" data-date-format="yyyy-mm" required autocomplete="off" placeholder="Bulan-Tahun" />
                        </div>
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
<script type="text/javascript">
    $(function() {
        $(".date-picker").datepicker({
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });
    });
</script>