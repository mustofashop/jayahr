
<div class="row">
        <div class="col-md-12">
        <?php if($this->session->flashdata('msg3')): ?>
            <div class="alert alert-success alert-dismissible" id="success-alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo $this->session->flashdata('msg3'); ?>
            </div>
        <?php endif; ?>
            <!-- transaksi -->
            <div class="box">
                <div class="box-header">
                    <h1 class="box-title">Selamat Datang Administrator</h1>
                   
                        <!-- #######  HEY, I AM THE SOURCE EDITOR! #########-->
							<h1 style="color: #5e9ca0;">&nbsp;</h1>
							<h2 style="color: #2e6c80;">Pilih menu di samping untuk keperluan administrasi.</h2>
							
							<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
							<p>&nbsp;</p>
							<p><strong>Hati-hati dalam mengubah / menghapus data yang ada! </strong><br /><strong>Semangat!</strong></p>
							<p><strong>&nbsp;</strong></p>
                    
                </div>
                
                
            </div>
            <!-- end box -->
        </div>
    </div>
    <!-- end version app mobile -->