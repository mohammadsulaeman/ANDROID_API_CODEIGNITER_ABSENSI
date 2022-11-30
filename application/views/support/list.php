<!-- Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3">


                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Personal</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?= base_url('images/support/' . $support['photo']) ?>" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= $support['nama'] ?></h3>
                            <p class="text-muted text-center" ><?=$support['pendidikan']?></p>
                            <p class="text-muted text-center"><?= $support['instansi'] ?></p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Biodata Diri</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <strong><i class="fas fa-envelope"></i> Email </strong>

                            <p class="text-muted"><?= $support['email'] ?></p>

                            <hr>

                            <strong><i class="fas fa-mobile-alt"></i> Nomor Telepon </strong>

                            <p class="text-muted">
                                <?= $support['phone'] ?>
                            </p>

                            <hr>
                            <strong><i class="fas fa-user-graduate"></i> Pendidikan </strong>

                            <p class="text-muted">
                                <?= $support['pendidikan'] ?>
                            </p>

                            <hr>

                            <strong><i class="fas fa-user-graduate"></i> Fakultas </strong>

                            <p class="text-muted">
                                <?= $support['fakultas'] ?>
                            </p>

                            <hr>
                            <strong><i class="fas fa-user-graduate"></i> Asal Sekolah </strong>

                            <p class="text-muted">
                                <?= $support['instansi'] ?>
                            </p>

                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Tempat Tinggal</strong>

                            <p class="text-muted"><?= $support['alamat'] ?></p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Tempat Tanggal Lahir </strong>

                            <p class="text-muted"><?= $support['dob'] ?></p>

                            <hr>

                            <strong><i class="fas fa-book-open"></i> Hobi </strong>
                            <p class="text-muted"><?= $support['hobi'] ?></p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">About Aplikasi</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="<?= base_url('images/logo/thumbs/logo.png') ?>" alt="user image">
                                            <span class="username">
                                                <a href="#">Absensi Karyawan</a>
                                            </span>
                                            <span class="description">Version 1.0</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            <?=$support['deskripsi']?>
                                        </p>
                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>