 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <!-- Topbar Navbar -->
     <ul class="navbar-nav ml-auto">



         <!-- Nav Item - User Information -->
         <li class="nav-item">
             <a href="<?= base_url('user') ?>" class="nav-link">
                 <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['name'] ?></span>
                 <img class="img-profile rounded-circle" src="<?= base_url('images/profile/') . $user['image'] ?>" width="30px" height="30px">
             </a>
         </li>
         <li class="nav-item">
             <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                 <span class="mr-2 d-none d-lg-inline text-gray-600">Logout</span>
                 <i class="fas fa-sign-out-alt"></i>
             </a>

         </li>

     </ul>
 </nav>
 <!-- /.navbar -->