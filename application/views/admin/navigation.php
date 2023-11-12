<?php
$user_level_id = $this->session->userdata('user_level_id');
if ($user_level_id == 1)
  $link_dashboard = base_url('dashboard');
elseif ($user_level_id == 3)
  $link_dashboard = base_url('dashboard/instansi/' . decode($this->session->userdata('instansi_id')) . '/' . url_title($this->session->userdata('instansi_name')));
else
  $link_dashboard = base_url('presensi/v_pegawai/' . decode($this->session->userdata('pegawai_id')) . '/' . url_title($this->session->userdata('user_full_name')));
?>
<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <li>
    <a href="<?php echo $link_dashboard; ?>">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
  </li>
  <?php


  if ($user_level_id == 1)
    $menu = $this->Menu_model->get_list_menu();
  else
    $menu = $this->User_akses_model->get_menu($user_level_id);

  if ($menu->num_rows() > 0) {
    foreach ($menu->result() as $row_menu) {
      $menu_id = $row_menu->menu_id;
      if ($user_level_id == 1)
        $submenu = $this->Menu_sub_model->get_sub_menu($menu_id);
      else
        $submenu = $this->User_akses_model->get_menu_sub($menu_id, $user_level_id);

  ?>
      <li class="treeview">
        <a href="<?php echo base_url() . $row_menu->menu_link; ?>">
          <i class="<?php echo $row_menu->menu_class; ?>"></i>
          <span><?php echo $row_menu->menu_name; ?></span>
          <span class="pull-right-container">
            <span class="fa fa-angle-left pull-right"></span>
          </span>
        </a>
        <?php
        if ($submenu->num_rows() > 0) {
          foreach ($submenu->result() as $row_submenu) {
        ?>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url() . $row_submenu->menu_sub_link; ?>"><i class="fa fa-circle-o"></i> <?php echo $row_submenu->menu_sub_name; ?></a></li>
            </ul>
        <?php
          }
        }
        ?>
      </li>
  <?php
    }
  }
  ?>
</ul>