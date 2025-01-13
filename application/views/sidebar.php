<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <?php 
            $ids        = $this->session->userdata('id_karyawan');
            $get_user   = $this->master_model->get_user($ids);
            //echo $this->db->last_query();
            $foto       = $get_user->row()->foto_64;
            $name       = $get_user->row()->nama_lengkap;
            if($foto == '' || empty($foto) || $foto == NULL){
        ?>
                <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image">
            <?php }else{ ?>
                <img src="data:image/jpeg;base64,<?php echo $foto;?>" class="img-circle" alt="User Image">
            <?php } ?>
    </div>
    <div class="pull-left info">
        <p><?php echo $name; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        <br>
        <a href="">
            <?php 
                date_default_timezone_set('Asia/Jakarta');
            ?>
            <i class="fa fa-calendar"></i>
            <?php
                echo $this->master_model->hari_ini(date('w')).", ".$this->master_model->tgl_indo(date('Y-m-d'));
            ?>
        </a>
    </div>
</div>
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li <?php if($this->uri->segment(1)=="dashboard"){ echo 'class="active"'; } ?>>
        <a href="<?php echo base_url(); ?>dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <!-- menu dinamis -->
    <?php
        $id_perusahaan  = $this->session->userdata('id_perusahaan');
        $id_karyawan    = $this->session->userdata('id_karyawan');
        //parent menu
        $parent_menu    = $this->master_model->list_menu_parent($id_perusahaan,$id_karyawan);
        foreach($parent_menu->result() as $pm){
            //isi menu
            $isi_menu   = $this->master_model->list_isi_menu($pm->id_menu_parent,$id_karyawan,$id_perusahaan);
    ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-<?php echo $pm->logo; ?>"></i>
                    <span><?php echo $pm->nama_parent; ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php foreach($isi_menu->result() as $isi){ ?>
                        <li <?php if($this->uri->segment(1)==$isi->link){ echo 'class="active"'; } ?>><a href="<?php echo base_url(); ?><?php echo $isi->link ?>"><i class="fa fa-circle-o"></i><?php echo $isi->nama_menu ?></a></li>
                    <?php } ?>
                </ul>
                <input type="hidden" name="uri" id="uri" value="<?php echo base_url($this->uri->segment(1)); ?>">
            </li>
    <?php
        }
    ?>
</ul>
<script type="text/javascript">
$(document).ready(function () {
    var url = $('#uri').val();
    // for treeview
    $('ul.treeview-menu a').filter(function() {
    return this.href == url;
    }).closest('.treeview').addClass('active');
});
</script>