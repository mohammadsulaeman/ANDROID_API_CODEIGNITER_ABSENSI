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
                <div class="col-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title ?></h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 130px;">
                                    <div class="input-group-append">
                                        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Add New SubMenu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 350px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Menu</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($subMenu as $sm) : ?>
                                        <tr>
                                            <th scope="row"><?= $i ?></th>
                                            <td><?= $sm['title'] ?></td>
                                            <td><?= $sm['menu'] ?></td>
                                            <td><?= $sm['url'] ?></td>
                                            <td><?= $sm['icon'] ?></td>
                                            <td><?= $sm['is_active'] ?></td>
                                            <td>
                                                <a href="<?= base_url('menu/editsubmenu/') . $sm['id'] ?>" class="badge bg-success">Edit</a>
                                                <a href="<?= base_url('menu/deletesubmenu/') . $sm['id'] ?>" class="badge bg-danger">Delete</a>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New SubMenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu') ?>" method="POST">
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form group">
                            <label>Menu</label>
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">Select Menu</option>
                                <?php foreach ($menu as $m) : ?>
                                    <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>ICON</label>
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="div form-group">
                            <div class="div form-check">
                                <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                                <label for="is_active" class="form-check-label">Actiive?</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>