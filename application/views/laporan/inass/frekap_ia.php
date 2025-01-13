<script type="text/javascript">

</script>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <!-- <div class="box-header">
            
            </div> -->
            <form role="form" method="GET" action="<?php echo base_url(); ?>int_assessment/rekap_ia">
                <div class="box-body">
                    <!-- jenis -->
                    <div class="form-group">
                        <label for="">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="2024">2024</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Unit</label>
                        <select name="unit" class="form-control select2" livesearch="true" id="unit">
                            <?php
                            if ($this->session->userdata('level') == '1') {
                                foreach ($unit2->result() as $l) {
                            ?>
                                    <option value="<?php echo $l->id_bagian; ?>"><?php echo $l->nama_bagian; ?> </option>
                                <?php
                                }
                            } else { ?>
                                <option value="0">-- Pilih Unit --</option>
                                <?php foreach ($unit->result() as $l) {
                                ?>
                                    <option value="<?php echo $l->id_bagian; ?>"><?php echo $l->nama_bagian; ?> </option>
                            <?php
                                }
                            }
                            ?>
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