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
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="<?= base_url('images/profile/' . $user['image']) ?>" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center"><?= $user['name'] ?></h3>
                                <a href="<?= base_url('user/edit/' . $user['id']) ?>" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
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
                                <strong><i class="fas fa-user-tie"></i></i>Jabatan</strong>

                                <p class="text-muted">
                                    <?= $user['jabatan'] ?>
                                </p>

                                <hr>
                                <strong><i class="fas fa-user-check"></i>Status Kepegawaian</strong>

                                <p class="text-muted">
                                    <?= $user['status'] ?>
                                </p>

                                <hr>

                                <strong><i class="fas fa-envelope"></i> Email </strong>

                                <p class="text-muted"><?= $user['email'] ?></p>

                                <hr>

                                <strong><i class="fas fa-mobile-alt"></i>Nomor Telepon</strong>

                                <p class="text-muted">
                                    <?= $user['phone'] ?>
                                </p>

                                <hr>
                                <strong><i class="fas fa-user-graduate"></i> Pendidikan</strong>

                                <p class="text-muted">
                                    <?= $user['pendidikan'] ?>
                                </p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Tempat Tinggal</strong>

                                <p class="text-muted"><?= $user['alamat'] ?></p>

                                <hr>

                                <strong><i class="far fa-file-alt mr-1"></i> Tempat Tanggal Lahir </strong>

                                <p class="text-muted"><?= $user['ttl'] ?></p>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>