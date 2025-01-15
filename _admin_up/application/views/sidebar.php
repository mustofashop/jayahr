<?php
if ($class == 'dashboard') {
    $dashboard  = 'active';
    $menu       = '';
    $users      = '';
    $master     = '';
    $perusahaan = '';
} elseif ($class == 'menu') {
    $dashboard  = '';
    $menu       = 'active';
    $users      = '';
    $master     = '';
    $perusahaan = '';
} elseif ($class == 'users') {
    $dashboard  = '';
    $menu       = '';
    $users      = 'active';
    $master     = '';
    $perusahaan = '';
} elseif ($class == 'master') {
    $dashboard  = '';
    $menu       = '';
    $users      = '';
    $master     = 'active';
    $perusahaan = '';
} elseif ($class == 'perusahaan') {
    $dashboard  = '';
    $menu       = '';
    $users      = '';
    $master     = '';
    $perusahaan = 'active';
} else {
    $dashboard  = '';
    $menu       = '';
    $users      = '';
    $master     = '';
    $perusahaan = '';
}
?>

<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <?php
        $ids        = $this->session->userdata('id');
        $get_user   = $this->master_model->get_user($ids);
        //echo $this->db->last_query();
        $foto       = $get_user->row()->foto;
        $name       = $get_user->row()->nama_lengkap;
        if ($foto == '' || empty($foto) || $foto == NULL) {
        ?>
            <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image">
        <?php } else { ?>
            <img src="data:image/jpeg;base64,<?php echo $foto; ?>" class="img-circle" alt="User Image">
        <?php } ?>
    </div>
    <div class="pull-left info">
        <p><?php echo $name; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        <br>
        <?php
        date_default_timezone_set('Asia/Jakarta');
        ?>
        <i class="fa fa-calendar"></i>
        <?php
        echo $this->master_model->hari_ini(date('w')) . ", " . $this->master_model->tgl_indo(date('Y-m-d'));
        ?>
    </div>
</div>
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <!-- <li class="header">MAIN NAVIGATION</li> -->
    <li class="<?php echo $dashboard; ?>">
        <a href="<?php echo base_url(); ?>dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>





    <li <?php if ($this->uri->segment(1) == "menu_e" || $this->uri->segment(1) == "setting_menu_e" || $this->uri->segment(1) == "level_e") {
            echo 'class="treeview active"';
        } else {
            echo 'class="treeview"';
        } ?>>
        <a href="#">
            <i class="fa fa-gear"></i> <span>Menu</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li <?php if ($this->uri->segment(1) == "menu_e") {
                    echo 'class="active"';
                } ?>>
                <a href="<?php echo base_url(); ?>menu_e"><i class="fa fa-circle-o"></i> Master Menu</a>
            </li>
            <li <?php if ($this->uri->segment(1) == "level_e") {
                    echo 'class="active"';
                } ?>>
                <a href="<?php echo base_url(); ?>level_e"><i class="fa fa-circle-o"></i> Master & Setting Level</a>
            </li>
            <li <?php if ($this->uri->segment(1) == "setting_menu_e") {
                    echo 'class="active"';
                } ?>>
                <a href="<?php echo base_url(); ?>setting_menu_e/list_user?perusahaan=12"><i class="fa fa-circle-o"></i> User Menu</a>
            </li>
        </ul>
    </li>
    <li <?php if ($this->uri->segment(2) == "login_user" || $this->uri->segment(2) == "list_user_karyawan") {
            echo 'class="treeview active"';
        } else {
            echo 'class="treeview"';
        } ?>>
        <a href="#">
            <i class="fa fa-users"></i> <span>Login</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li <?php if ($this->uri->segment(2) == "list_user_karyawan?perusahaan=12" || $this->uri->segment(2) == "list_user_karyawan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>users_k/list_user_karyawan?perusahaan=12"><i class="fa fa-circle-o"></i> Login User</a></li>
        </ul>
    </li>
    <li <?php if ($this->uri->segment(1) == "perusahaan" || $this->uri->segment(2) == "karyawan" || $this->uri->segment(2) == "libur") {
            echo 'class="treeview active"';
        } else {
            echo 'class="treeview"';
        } ?>>
        <a href="#">
            <i class="fa fa-building-o"></i> <span>Master</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li <?php if ($this->uri->segment(2) == "karyawan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>Enterprise/karyawan/master_karyawan">
                    <i class="fa fa-circle-o"></i> Karyawan</a>
            </li>
            <li <?php if ($this->uri->segment(2) == "perusahaan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>perusahaan/master_lokasi/12">
                    <i class="fa fa-circle-o"></i> Lokasi</a>
            </li>
            <li <?php if ($this->uri->segment(2) == "perusahaan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>perusahaan/master_bagian/12">
                    <i class="fa fa-circle-o"></i> Departmen</a>
            </li>
            <li <?php if ($this->uri->segment(2) == "perusahaan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>perusahaan/master_jabatan/12">
                    <i class="fa fa-circle-o"></i> Jabatan</a>
            </li>
            <li <?php if ($this->uri->segment(2) == "perusahaan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>perusahaan/master_inass/12">
                    <i class="fa fa-circle-o"></i> Internal Assesment</a>
            </li>
            <li <?php if ($this->uri->segment(2) == "perusahaan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>perusahaan/master_idp/12">
                    <i class="fa fa-circle-o"></i> People Review (IDP)</a>
            </li>
            <li <?php if ($this->uri->segment(2) == "perusahaan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>perusahaan/master_periode/12">
                    <i class="fa fa-circle-o"></i> Periode</a>
            </li>
            <li <?php if ($this->uri->segment(2) == "perusahaan") {
                    echo 'class="active"';
                } ?>><a href="<?php echo base_url(); ?>perusahaan/master_jenis_form/12">
                    <i class="fa fa-circle-o"></i>Jenis Form</a>
            </li>
        </ul>
    </li>
    <input type="hidden" name="uri" id="uri" value="<?php echo base_url($this->uri->segment(1)); ?>">
</ul>
<script type="text/javascript">
    $(document).ready(function() {
        var url = $('#uri').val();
        // for treeview
        $('ul.treeview-menu a').filter(function() {
            return this.href == url;
        }).closest('.treeview').addClass('active');
    });
</script>