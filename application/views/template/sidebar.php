<aside class="main-sidebar bg-gradient-dark elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="<?= base_url('images/icon/thumbs/favicon.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"  width="30" height="30">
        <span class="brand-text font-weight-light ml-2" >PT. RTJ</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-3 pb-3 mb-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <!-- Melakukan Query Menu ambil dari database menu sesuai role -->
                <?php
                $role_id = $this->session->userdata('role_id');
                $queryMenu = "SELECT tbl_user_menu.id, menu
                        FROM tbl_user_menu JOIN tbl_user_access_menu
                        ON tbl_user_menu.id = tbl_user_access_menu.menu_id
                    WHERE tbl_user_access_menu.role_id = $role_id 
                    ORDER BY tbl_user_access_menu.menu_id ASC";

                $menu = $this->db->query($queryMenu)->result_array();
                ?>

                <!-- LOOPING MENU -->
                <?php foreach ($menu as $m) : ?>
                    <?= $m['menu'] ?>

                    <!-- LOOPING SUBMENU -->
                    <?php
                    $menuID = $m['id'];
                    $querySubMenu = "SELECT *
                        FROM tbl_user_sub_menu
                        JOIN tbl_user_menu ON tbl_user_sub_menu.menu_id = tbl_user_menu.id
                    WHERE tbl_user_sub_menu.menu_id = $menuID
                    AND tbl_user_sub_menu.is_active = 1";

                    $submenu = $this->db->query($querySubMenu)->result_array();

                    ?>

                    <?php foreach ($submenu as $sm) : ?>

                        <?php if ($title == $sm['title']) : ?>
                            <!-- Nav Item - Dashboard -->
                            <li class="nav-item active mb-2">
                            <?php else : ?>
                            <li class="nav-item mb-3">
                            <?php endif ?>
                            <a class="nav-link" href="<?= base_url($sm['url']) ?>">
                                <i class="<?= $sm['icon'] ?>"></i>
                                <span><?= $sm['title'] ?></span></a>
                            </li>
                        <?php endforeach ?>


                    <?php endforeach; ?>
                    <li class="nav-item mb-2">
                        <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>