<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-8 mx-auto">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"><?= $title ?></h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <div class="btn-group">
                        <i class="far fa-fw fa-calendar-check"></i>
                        <a href="<?= base_url('Perizinan_Super') ?>" class="btn btn-primary active" aria-current="page">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (isset($error)) {
                                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><div class="alert-body">';
                                echo $error;
                                echo '</div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                            }

                            // Notifikasi error
                            echo validation_errors('<div class="alert alert-warning alert-dismissible fade show" role="alert"><div class="alert-body">', '</div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                            // Notifikasi open
                            echo form_open_multipart(base_url('Perizinan_Super/edit/' . $perizinan->perijinan_id), 'class="form form-vertical"');
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nama </label>
                                        <input type="text" class="form-control" name="perijinan_nama" placeholder="Nama " value="<?= $perizinan->perijinan_nama ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Keterangan </label>
                                        <textarea name="perijinan_keterangan" id="ckeditor" rows="5" class="form-control" placeholder="Keterangan" required><?= $perizinan->perijinan_keterangan ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Status :</label>
                                        <select name="perijinan_status" class="form-control">
                                            <option value="Tetap">Karyawan Tetap</option>
                                            <option value="Kontrak">Karyawan Kontrak</option>
                                            <option value="Magang" <?php if ($perizinan->perijinan_status == "Magang") {
                                                                        echo "selected";
                                                                    } ?>>Magang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Persetujuan :</label>
                                        <select name="reponse_kepala" class="form-control">
                                            <option value="setuju">DiSetujui</option>
                                            <option value="tolak" <?php if ($perizinan->reponse_kepala == "tolak") {
                                                                        echo "selected";
                                                                    } ?>>Di Tolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nama Kepala Bidang </label>
                                        <input type="text" class="form-control" name="nama_kepala" placeholder="Nama " value="<?= $perizinan->nama_kepala ?>" required />
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Upload Foto Berita Terbaru</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="perijinan_bukti" />
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Foto Berita Saat Ini: </label><br>
                                        <img src="<?php echo base_url('images/perijinan/' . $perizinan->perijinan_bukti) ?>" class="img-thumbnail rounded" height="80" width="80">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tanggal </label>
                                        <input type="text" class="form-control" name="perijinan_tanggal" placeholder="Tanggal " value="<?= $perizinan->perijinan_tanggal ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Waktu </label>
                                        <input type="text" class="form-control" name="perijinan_waktu" placeholder="Waktu " value="<?= $perizinan->perijinan_waktu ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <textarea name="perijinan_lokasi" id="ckeditor" rows="5" class="form-control" placeholder="Lokasi" required><?= $perizinan->perijinan_lokasi ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="submit" class="btn btn-primary mr-1">Submit</button>
                                    <button type="reset" name="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>