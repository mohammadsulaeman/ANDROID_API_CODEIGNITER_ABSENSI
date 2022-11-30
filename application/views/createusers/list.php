<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?= $this->session->flashdata('message') ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title ?></h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100px;">
                                    <div class="input-group-append">
                                        <a href="<?= base_url('Create_Users/add') ?>" class="btn btn-primary">
                                            Tambah Users
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 100%;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($createusers as $createusers) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <img src="<?php echo base_url('images/profile/' . $createusers->image) ?>" class="img-thumbnail rounded" height="80" width="80">
                                            </td>
                                            <td><?= $createusers->name ?></td>
                                            <td><?= $createusers->email ?></td>
                                            <td>
                                                <a href="<?= base_url('Create_Users/forgetpass/')?>" class="badge badge-success">Lupa Password</a>
                                                <a href="<?= base_url('Create_Users/edit/') . $createusers->id ?>" class="badge badge-success">Edit</a>
                                                <a href="<?= base_url('Create_Users/delete/') . $createusers->id ?>" class="badge badge-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->