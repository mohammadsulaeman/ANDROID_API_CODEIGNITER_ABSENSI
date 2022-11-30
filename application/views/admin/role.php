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
                <?php form_error('menu', '<div class="alert alert-danger" role="alert">!
        </div>') ?>

                <?= $this->session->flashdata('message') ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title ?></h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 60px;">
                                    <div class="input-group-append">
                                        <a href="<?= base_url('admin/addrole/') ?>" class="btn btn-primary">
                                            Tambah
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
                                        <th>Role Access</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($roleMenu as $r) : ?>
                                        <tr>
                                            <th scope="row"><?= $i ?></th>
                                            <td><?= $r->role ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/roleaccess/') . $r->id ?>" class="badge bg-success">Access</a>
                                                <a href="<?= base_url('admin/edit/') . $r->id ?>" class="badge bg-success">Edit</a>
                                                <a href="<?= base_url('admin/delete/') . $r->id ?>" class="badge bg-danger">Delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++ ?>
                                    <?php endforeach ?>
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