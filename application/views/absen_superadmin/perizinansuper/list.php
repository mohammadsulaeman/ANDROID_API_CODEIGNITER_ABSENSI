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
                                <div class="input-group input-group-sm" >

                                    <div class="form-group-append">
                                        <a href="<?= base_url('Perizinan_Super/add') ?>" class="btn btn-primary active" aria-current="page">Tambah</a>
                                        <a href="<?= base_url('Perizinan_Super/export') ?>" class="btn btn-primary active" aria-current="page">Excel</a>
                                        <a href="<?= base_url('Perizinan_Super/cetak') ?>" class="btn btn-primary active">PDF</a>
                                        <a href="<?= base_url('Perizinan_Super/print') ?>" class="btn btn-primary active" >Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 100%;">
                            <div class="card-tools mt-3 ml-2">
                                <form action="<?= base_url('Perizinan_Super/searchdata') ?>" method="POST" class="input-group" style="width: 350px;">
                                    <input type="text" class="form-control" placeholder="Search Data Perizinan" name="keyword" value="<?= set_value('keyword') ?>">

                                    <div class="input-group-append">
                                        <input type="submit" name="submit">
                                        </input>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($perizinan as $perizinan) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <img src="<?php echo base_url('images/perijinan/' . $perizinan->perijinan_bukti) ?>" class="img-thumbnail rounded" height="80" width="80">
                                            </td>
                                            <td><?= $perizinan->perijinan_nama ?></td>
                                            <td> <?= $perizinan->perijinan_keterangan ?></td>
                                            <td><?= $perizinan->perijinan_tanggal ?></td>
                                            <td><?= $perizinan->perijinan_waktu ?></td>
                                            <td ><?= $perizinan->perijinan_lokasi ?>
                                            </td>
                                            <td><?= $perizinan->perijinan_status ?></td>
                                            <td>
                                                <a href="<?= base_url('Perizinan_Super/edit/') . $perizinan->perijinan_id ?>" class="badge badge-success">Edit</a>
                                                <a href="<?= base_url('Perizinan_Super/delete/') . $perizinan->perijinan_id ?>" class="badge badge-danger">Delete</a>
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