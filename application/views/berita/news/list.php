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

                <?= $this->session->flashdata('sukses') ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title ?></h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 60px;">
                                    <div class="input-group-append">
                                        <a href="<?= base_url('News/add') ?>" class="btn btn-primary">
                                            Tambah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 100%;">
                            <div class="card-tools mt-3 ml-2">
                                <form action="<?= base_url('News/searchdata') ?>" method="POST" class="input-group" style="width: 350px;">
                                    <input type="text" class="form-control" placeholder="Search Data news" name="keyword">

                                    <div class="input-group-append">
                                        <input type="submit" name="submit">
                                        </input>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-head-fixed text-nowrap mt-2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gambar</th>
                                        <th>Judul News</th>
                                        <th>Deskripsi News</th>
                                        <th>Tanggal Post</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($news as $news) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <img src="<?php echo base_url('images/news/' . $news->gambar) ?>" class="img-thumbnail rounded" height="80" width="80">
                                            </td>
                                            <td><?= $news->judul_news ?></td>
                                            <td class="card card-body shadow-none bg-transparent overflow-auto" height="180">
                                                <p class="text-justify"><?= $news->deskripsi ?></p>
                                            </td>
                                            <td><?= date('d F Y', strtotime($news->tanggal_post)) ?></td>
                                            <td>
                                                <a href="<?= base_url('News/edit/') . $news->id_news?>" class="badge badge-success">Edit</a>
                                                <a href="<?= base_url('News/delete/') . $news->id_news ?>" class="badge badge-danger">Delete</a>
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