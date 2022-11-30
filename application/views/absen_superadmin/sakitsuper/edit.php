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
                        <a href="<?= base_url('Sakit_Super') ?>" class="btn btn-primary active" aria-current="page">Kembali</a>
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
                            echo form_open_multipart(base_url('Sakit_Super/edit/' . $sakit->sakit_id), 'class="form form-vertical"');
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nama </label>
                                        <input type="text" class="form-control" name="sakit_nama" placeholder="Nama " value="<?= $sakit->sakit_nama ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Status :</label>
                                        <select name="sakit_status" class="form-control">
                                            <option value="Tetap">Karyawan Tetap</option>
                                            <option value="Kontrak">Karyawan Kontrak</option>
                                            <option value="Magang" <?php if ($sakit->sakit_status == "Magang") {
                                                                        echo "selected";
                                                                    } ?>>Magang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Upload Foto Terbaru</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="sakit_bukti" />
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Foto Saat Ini: </label><br>
                                        <img src="<?php echo base_url('images/sakit/' . $sakit->sakit_bukti) ?>" class="img-thumbnail rounded" height="80" width="80">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tanggal </label>
                                        <input type="text" class="form-control" name="sakit_tanggal" placeholder="Tanggal " value="<?= $sakit->sakit_tanggal ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Waktu </label>
                                        <input type="text" class="form-control" name="sakit_waktu" placeholder="Waktu " value="<?= $sakit->sakit_waktu ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <textarea name="sakit_lokasi" id="ckeditor" rows="5" class="form-control" placeholder="Lokasi" required><?= $sakit->sakit_lokasi ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="sakit_keterangan" id="ckeditor" rows="5" class="form-control" placeholder="Lokasi" required><?= $sakit->sakit_keterangan ?></textarea>
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